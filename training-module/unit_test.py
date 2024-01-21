from transformers import BertModel, BertTokenizer
import torch
import openai
import tiktoken
import os
import logging
from dotenv import load_dotenv
from process_file import *
import configparser
import uuid
import argparse
import pinecone
#Run it like this 
# python unit_test.py "Your query"

#First set the environment variable - export ENV=dev
# Configure logging
logging.basicConfig(filename='file_processing.log', level=logging.INFO, format='%(asctime)s:%(funcName)s:%(levelname)s:%(message)s')

# Database connection details
ENV = os.getenv ("ENV")



def read_config(env):
    config = configparser.ConfigParser()
    config.read('config.ini')

    if env in config:
        return dict(config.items(env))
    else:
        raise ValueError(f"Environment '{env}' not found in the configuration file.")


def generate_document_vector_bert (text, config):
# Load pre-trained BERT model and tokenizer
    model_name = 'bert-base-uncased'
    tokenizer = BertTokenizer.from_pretrained(model_name)
    model = BertModel.from_pretrained(model_name)
    tokens = tokenizer(text, return_tensors='pt', truncation=True, padding=True)
    with torch.no_grad():
        output = model(**tokens)
    embeddings = output.last_hidden_state.mean(dim=1).squeeze().numpy()
    serial_vector = embeddings.tolist()
    return serial_vector

     
def generate_document_vector_openai (text, config):

    truncated_token = truncate_text_tokens (text, config ['open_ai_pdf_embedding_encoding'] , int(config ['open_ai_pdf_embedding_ctx_length']) )
    openai.api_key = config ['openai.api_key']
    response = openai.Embedding.create(
        engine= config ['open_ai_pdf_embedding_model'],
        max_tokens= 2000,
        input=truncated_token
         )
    embeddings = response['data'][0]['embedding']
    print (len(embeddings))
    return embeddings

def truncate_text_tokens(text, encoding_name, max_tokens):
    # runcate a string to have `max_tokens` according to the given encoding
    encoding = tiktoken.get_encoding(encoding_name)
    return encoding.encode(text)[:max_tokens]

# Query in pinecone

def query_vector_in_pinecone(key, model, filetype, vector):
    print ("started querying vector ")
    #pinecone.api_key = key
    pinecone.init(api_key=key, environment='gcp-starter')

    # List all indexes
    indexes = pinecone.list_indexes()
    
    if model not in vector_dimension_map:
        logging.error(f"Unknown Model for Pinecone: {model}")
    PINECONE_INDEX_NAME = model.lower()+"-"+filetype.lower()+"-"+"vector"

    if PINECONE_INDEX_NAME not in indexes:
        logging.error(f"Index not found in Pinecone for: {model}")
    
    index = pinecone.Index(PINECONE_INDEX_NAME)


    # Index the vector in Pinecone
    try:
        logging.info ("Querying Pinecone")
        response = index.query(vector=vector, top_k=3, include_metadata=True)
        print ("Result")
        return response
    except Exception as e:
        logging.error(f"Error Querying data in Pinecone: {e}")
    
    return


# Main
if __name__ == "__main__":
    environment = ENV.lower()
    logging.info (f"The environment is:  {environment}")
    parser = argparse.ArgumentParser(description="Give your prompt")
    parser.add_argument('arg1', type=str, help='Your prompt')
    args = parser.parse_args()
    argument1 = args.arg1

    print(f"Argument 1: {argument1}")

    try:
        config_data = read_config(environment)
        vector = ''
        print (config_data ['pdf_model'])
        if config_data ['pdf_model'] == 'BERT':
            vector = generate_document_vector_bert (argument1, config_data)
        else: 
            vector = generate_document_vector_openai (argument1, config_data)
        response = query_vector_in_pinecone(config_data['pinecone_api_key'], config_data['pdf_model'].upper(), "pdf", vector )
        print (response)


    except ValueError as e:
        print(f"Error: {e}")
