from transformers import BertModel, BertTokenizer
import torch
import openai

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
    return embeddings


def generate_document_vector_openai (text, config):
    openai.api_key = config ['openai.api_key']
    response = openai.Completion.create(
        engine="text-embedding-ada-002",
        prompt=text,
        temperature=0,
        max_tokens=768,
        n=1,
    )
    embeddings = response['choices'][0]['text']
    return embeddings


     
