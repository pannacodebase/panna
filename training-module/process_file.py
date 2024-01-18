from models import * 
from pineconedb import * 
from psqldb import *
import logging
from PyPDF2 import PdfReader
import uuid 

def process_text_file(file_path,config_data,connection):
    try:
        with open(file_path, 'r') as file:
            text = file.read()
        # Further processing can be added here
        unique_identifier =  uuid.uuid4()
        log_to_db(connection, unique_identifier, file_path, 'Success')
        return text
    except Exception as e:
        logging.error(f"Error processing text file {file_path}: {e}")
        unique_identifier =  uuid.uuid4()
        log_to_db(connection, unique_identifier, file_path, 'Error', str(e))


def process_pdf_file(file_path,config_data,connection):
    try:
        with open(file_path, 'rb') as file:
            pdf = PdfReader(file)
            text = ''
            for page_num in range(len(pdf.pages)):
                text += pdf.pages[page_num].extract_text()
        # Generate Vector embedding and store in Pinecone
        if len (text) > 0:
            method_name = "generate_document_vector_" + config_data ['pdf_model'].lower()
            method = globals().get(method_name)
            vector = ''
            if method is not None and callable(method):
                vector = method (text,config_data)
            else :
                logging.error(f"Unknown modelling technique")
                return 
            unique_identifier =  uuid.uuid4()
            store_vector_in_pinecone(config_data['pinecone_api_key'], config_data['pdf_model'].upper(),"pdf",vector, unique_identifier,"")
            log_to_db(connection, unique_identifier, file_path, 'Success')
            return
    except Exception as e:
        logging.error(f"Error processing PDF file {file_path}: {e}")
        unique_identifier =  uuid.uuid4()
        log_to_db(connection, unique_identifier, file_path, 'Error', str(e))


def process_audio_video_file(file_path,config_data,connection):
    # Placeholder for actual audio/video processing
    try:
        # Implement audio/video processing here
        unique_identifier =  uuid.uuid4()
        log_to_db(connection, unique_identifier, file_path, 'Success')
    except Exception as e:
        logging.error(f"Error processing audio/video file {file_path}: {e}")
        unique_identifier =  uuid.uuid4()
        log_to_db(connection, unique_identifier, file_path, 'Error', str(e))
