from flask import Flask, request, jsonify
import requests
import openai
import pinecone

# Initialize Flask app
app = Flask(__name__)

# OpenAI GPT-4 API Key
OPENAI_API_KEY = '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'

# Perplexity API Details
PERPLEXITY_API_URL = "https://api.perplexity.ai/chat/completions"
PERPLEXITY_API_KEY = "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"

# Pinecone API Key and Index Name
PINECONE_API_KEY = "9dae8d32-dd02-4e33-b6cf-2f5bf7160a5d"
PINECONE_INDEX_NAME = "canopy--document-uploader"
VECTOR_DIMENSION = 512  # Adjust based on your vector model

# Initialize OpenAI
openai.api_key = OPENAI_API_KEY

# Initialize Pinecone
pinecone.init(api_key=PINECONE_API_KEY, environment='gcp-starter')
if PINECONE_INDEX_NAME not in pinecone.list_indexes():
    pinecone.create_index(PINECONE_INDEX_NAME, dimension=VECTOR_DIMENSION)
index = pinecone.Index(PINECONE_INDEX_NAME)

@app.route('/handle_user_prompt', methods=['POST'])
def handle_user_prompt():
    try:
        prompt = request.json['prompt']
        pinecone_result = search_pinecone(prompt)
        if not pinecone_result:
            perplexity_result = call_perplexity_api(prompt)
            store_in_pinecone(prompt, perplexity_result)
            pinecone_result = perplexity_result
        return jsonify({"result": pinecone_result})
    except Exception as e:
        return jsonify({"error": str(e)})

def convert_to_vector(text):
    try:
        response = openai.Embedding.create(input=text, engine="text-embedding-ada-002")
        vector = response['data'][0]['embedding']
        return vector
    except Exception as e:
        return None

def search_pinecone(prompt):
    vector = convert_to_vector(prompt)
    if vector:
        results = index.query([vector], top_k=1, include_metadata=True)
        output = results.matches[0].metadata
        pinecode_result = output["text"]
        return pinecode_result
    return None

def store_in_pinecone(prompt, response):
    vector = convert_to_vector(response)
    if vector:
        index.upsert(vectors={prompt: vector})

def call_perplexity_api(prompt):
    payload = {
        "model": "mistral-7b-instruct",
        "messages": [{"role": "system", "content": "Include real-world case studies or us and cases for better understanding and Include all relevant information, even if it's lengthy"},{"role": "user", "content": prompt}],
        "max_tokens": 0,
        "temperature": 1,
        "top_p": 1,
        "top_k": 0,
        "stream": False,
        "presence_penalty": 0,
        "frequency_penalty": 1
    }
    headers = {
        "accept": "application/json",
        "content-type": "application/json",
        "authorization": f"Bearer {PERPLEXITY_API_KEY}"
    }

    try:
        response = requests.post(PERPLEXITY_API_URL, json=payload, headers=headers)
        response.raise_for_status()
        return response.json()
    except requests.exceptions.HTTPError as err:
        return str(err)
    except Exception as e:
        return str(e)

if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5000, debug=True)
    #app.run(debug=True, port=5000)
