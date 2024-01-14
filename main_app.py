import streamlit as st
import requests

# Define the API endpoints
SCRAPE_ENDPOINT = "http://localhost:5000/handle_user_prompt"
QA_ENDPOINT = "http://localhost:5000/handle_user_prompt"

# Define the UI layout
#st.set_page_config(page_title="Panna Bot", page_icon=":computer:", layout="wide")
#st.title("Welcome to Panna Bot!")

# Set page configuration
st.set_page_config(
    page_title="Autism Parent Support (Paññā)",
    page_icon="🤖",
    layout="wide"
)

# Title and description
st.markdown('<p style="color:green;"><strong>Developed by Autistic Parent for Autistic Parents: Collaborative Support Hub:</strong></p>', unsafe_allow_html=True)
st.markdown("Paññā bot is here to help and support parents of children with autism.")


# Define input fields
query = st.text_input("I'm here to offer information and insights, so feel free to inquire about Autism-related topics")


# Define submit button
if st.button("Submit"):
    # Call the QA endpoint to get the answer
    data = {"prompt": query}
    response = requests.post(QA_ENDPOINT, json=data)
    #print(response)
    #print(response["result"]["choices"][0]["message"]["content"])
   # result_alt= response["result"]["choices"]["message"]["content"]
    result = response.json()
    content_to_print = result["result"]["choices"][0]["message"]["content"]

    # Display the answer and source URLs
    #st.write("Answer:", result["answer"])
    #st.write("Answer:", result)
    #st.write("Answer Bot Response:   ", content_to_print)

    st.markdown('<p style="color:green;"><strong>Paññā Response:</strong></p>', unsafe_allow_html=True)
    st.markdown(content_to_print)
    
    #st.write("Source URLs:", result["url_source"])

#