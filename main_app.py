import streamlit as st
import requests

# Define the API endpoints
SCRAPE_ENDPOINT = "http://localhost:5000/handle_user_prompt"
QA_ENDPOINT = "http://localhost:5000/handle_user_prompt"

# Define the UI layout
st.set_page_config(page_title="Panna Bot", page_icon=":computer:", layout="wide")
st.title("Welcome to Panna Bot!")


# Define input fields
query = st.text_input("Ask me a question")

# Define submit button
if st.button("Submit"):
    # Call the QA endpoint to get the answer
    data = {"prompt": query}
    response = requests.post(QA_ENDPOINT, json=data)
    print(response)
    result = response.json()

    # Display the answer and source URLs
    #st.write("Answer:", result["answer"])
    st.write("Answer:", result)
    #st.write("Source URLs:", result["url_source"])

#