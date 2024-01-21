from transformers import BertModel, BertTokenizer
import torch
import openai
import tiktoken

#All the vector embedding Models

#Model Name pre-trained BERT Model
#Target file type PDF
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



     
