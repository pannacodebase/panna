import pinecone
import logging

# Connect to Pinecone

vector_dimension_map = {
    'BERT':768,
    'OPENAI': 1536
}

# Function to store vector in Pinecone

def store_vector_in_pinecone(key, model, filetype, vector, identifier, metadata):
    print ("started storing vector ")
    #pinecone.api_key = key
    pinecone.init(api_key=key, environment='gcp-starter')

    # List all indexes
    indexes = pinecone.list_indexes()
    
    if model not in vector_dimension_map:
        logging.error(f"Unknown Model for Pinecone: {model}")
    PINECONE_INDEX_NAME = model.lower()+"-"+filetype.lower()+"-"+"vector"

    if PINECONE_INDEX_NAME not in indexes:
        pinecone.create_index(PINECONE_INDEX_NAME, dimension=vector_dimension_map[model])
    
    index = pinecone.Index(PINECONE_INDEX_NAME)
    # Index the vector in Pinecone
    try:
        logging.info ("Writing to Pinecone")
        upserts = [(str(identifier), vector,metadata)]
        index.upsert(vectors=upserts)
        return
    except Exception as e:
        logging.error(f"Error storing data in Pinecone: {e}")
    
    return
