from flask import Flask, request, jsonify
import requests
import openai
import pinecone
import json
import psycopg2
from datetime import datetime
import ssl  # Import the SSL module

# Initialize Flask app
app = Flask(__name__)

# Set the path to your SSL certificate and key files
certfile = r"ssl/pannacertificate.crt"
keyfile = r"ssl/pannaprivatekey.key"


# Enable SSL/TLS for the Flask app
context = ssl.SSLContext(ssl.PROTOCOL_TLSv1_2)
context.load_cert_chain(certfile, keyfile)


# OpenAI GPT-4 API Key
OPENAI_API_KEY = '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'

# Perplexity API Details
PERPLEXITY_API_URL = "https://api.perplexity.ai/chat/completions"
PERPLEXITY_API_KEY = "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"

# Pinecone API Key and Index Name
PINECONE_API_KEY = "9dae8d32-dd02-4e33-b6cf-2f5bf7160a5d"
PINECONE_INDEX_NAME = "canopy--document-uploader"
VECTOR_DIMENSION = 512  # Adjust based on your vector model

#DB Endpoint 
service_url = 'http://localhost:5000/insert_data'  # Change to your service's actual URL


# Initialize OpenAI
openai.api_key = OPENAI_API_KEY

# Initialize Pinecone
pinecone.init(api_key=PINECONE_API_KEY, environment='gcp-starter')
if PINECONE_INDEX_NAME not in pinecone.list_indexes():
    pinecone.create_index(PINECONE_INDEX_NAME, dimension=VECTOR_DIMENSION)
index = pinecone.Index(PINECONE_INDEX_NAME)

# Database connection parameters
db_params = {
    'dbname': 'pannaDB',
    'user': 'postgres',
    'password': 'panna123',
    'host': 'localhost',  # Change to your PostgreSQL server's hostname or IP address
    'port': '5432'        # Change to the port you chose during installation if different
}


@app.route('/handle_user_prompt', methods=['POST'])
def handle_user_prompt():
    try:
        prompt = request.json['prompt']
        pinecone_result = search_pinecone(prompt)
        if not pinecone_result:
            perplexity_result = call_perplexity_api(prompt)
            store_in_pinecone(prompt, perplexity_result)
            pinecone_result = perplexity_result
            print(jsonify({"result": pinecone_result}))

        # Call the function to insert data into the service and print the response
        insert_data_into_service(pinecone_result,prompt)
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
        "messages": [{"role": "system", "content": "Include real-world case studies or us and cases for better understanding and Include all relevant information links, references ,annotations"},{"role": "user", "content": prompt}],
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
        print("call_perplexity_api response:", response)
        return response.json()
    except requests.exceptions.HTTPError as err:
        return str(err)
    except Exception as e:
        return str(e)

def insert_data_into_service(json_data,prompt):
    # Define the URL of your service
    try:
        # Convert your JSON data to a string        
        data = json.dumps(json_data)        
        # Set the headers for the POST request
        headers = {'Content-Type': 'application/json'}
        # Make the POST request to the service
        #response = requests.post(service_url, data=data, headers=headers)
        response = insert_data(data,prompt)
        print(response)
        print("line 113") 
        # Check the response status code
        if "error" in response:
            print("An error occurred:")
            print(response["error"])
        else:
            print("Operation was successful.")

    except Exception as e:
        print(f"Error: {str(e)}")


db_conn_string= "dbname=pannaDB user=postgres password=panna123 host=localhost port=5432"


def insert_data(request,prompt):
    conn = None    
    try:        
        # Connect to the PostgreSQL database        
        conn =  psycopg2.connect(db_conn_string)
        print("line 145",conn)
        #print("159 insert_data conn",conn)        
        cursor = conn.cursor()
        #print("161 insert_data conn",cursor)
        
        # Get JSON data from the request
        json_data = request
        data_dict = json.loads(json_data)                
        # Extract values from the JSON data
        # Extract values
        currentdatetime = datetime.now().strftime('%Y-%m-%d %H:%M:%S')  # Current datetime
        #prompt = json_data["choices"][0]["message"]["content"]
        #print("prompt: {}".format(prompt))
        #prompt = "what is aism"
        user_input = prompt        
        response = data_dict["choices"][0]["message"]["content"]        
        created = data_dict["created"]        
        id_value = data_dict["id"]
        model = data_dict["model"]
        if model in("mistral-7b-instruct",):
            source = "Perplexity"
        else:
            source = "Pinecone"
        obj = data_dict["object"]
        #usage = json.dumps(json_data["usage"])
        completion_tokens = data_dict["usage"]["completion_tokens"]        
        prompt_tokens = data_dict["usage"]["prompt_tokens"]
        total_tokens = data_dict["usage"]["total_tokens"]
        ##############################################################                
        # SQL statement to insert data into the table
        insert_sql = """
            INSERT INTO req_res_audit_v1 (
                currentdatetime,
                prompt,
                response,
                created,
                id,
                model,
                object,                
                completion_tokens,
                prompt_tokens,
                total_tokens,
                source
            )
            VALUES (
                %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s
            )
        """


        # Execute the SQL statement with values
        cursor.execute(insert_sql, (
            currentdatetime,
            user_input,
            response,
            created,
            id_value,
            model,
            obj,
            completion_tokens,
            prompt_tokens,
            total_tokens,
            source
        ))        

        # Commit the changes
        conn.commit()
        return jsonify({"message": "Data inserted successfully!"}), 200

    except (Exception, psycopg2.Error) as error:
        return jsonify({"error": str(error)}), 500

    finally:
        if conn:
            cursor.close()
            conn.close()


if __name__ == "__main__":
    #app.run(host='0.0.0.0', port=5000, debug=True)
    #app.run(debug=True, port=5000)
    app.run(host='0.0.0.0', port=5000, debug=True, ssl_context=context)
