import os
import logging
import psycopg2
from PyPDF2 import PdfReader
from dotenv import load_dotenv

# Configure logging
logging.basicConfig(filename='file_processing.log', level=logging.INFO, format='%(asctime)s:%(levelname)s:%(message)s')

# Database connection details
DB_HOST = os.getenv("DATABASE_HOST")
DB_NAME = os.getenv("DATABASE_USER")
DB_USER = os.getenv("DATABASE_USER")
DB_PASS = os.getenv("DATABASE_PASSWORD")

def log_to_db(file_path, status, error_message=None):
    try:
        connection = psycopg2.connect(host=DB_HOST, database=DB_NAME, user=DB_USER, password=DB_PASS)
        cursor = connection.cursor()
        insert_query = """INSERT INTO file_processing_audit (file_path, status, error_message) VALUES (%s, %s, %s)"""
        cursor.execute(insert_query, (file_path, status, error_message))
        connection.commit()
        cursor.close()
        connection.close()
    except Exception as e:
        logging.error(f"Database logging failed: {e}")

def process_text_file(file_path):
    try:
        with open(file_path, 'r') as file:
            text = file.read()
        # Further processing can be added here
        log_to_db(file_path, 'Success')
        return text
    except Exception as e:
        logging.error(f"Error processing text file {file_path}: {e}")
        log_to_db(file_path, 'Error', str(e))

def process_pdf_file(file_path):
    try:
        with open(file_path, 'rb') as file:
            pdf = PdfReader(file)
            text = ''
            for page_num in range(len(pdf.pages)):
                text += pdf.pages[page_num].extract_text()
        # Further processing can be added here
        log_to_db(file_path, 'Success')
        print(text)
        return text
    except Exception as e:
        logging.error(f"Error processing PDF file {file_path}: {e}")
        log_to_db(file_path, 'Error', str(e))

def process_audio_video_file(file_path):
    # Placeholder for actual audio/video processing
    try:
        # Implement audio/video processing here
        log_to_db(file_path, 'Success')
    except Exception as e:
        logging.error(f"Error processing audio/video file {file_path}: {e}")
        log_to_db(file_path, 'Error', str(e))

def scan_directory(directory_path):
    print('inside scan directory')
    for root, dirs, files in os.walk(directory_path):
        for file in files:
            file_path = os.path.join(root, file)
            try:
                if file.endswith('.txt'):
                    process_text_file(file_path)
                elif file.endswith('.pdf'):
                    process_pdf_file(file_path)
                elif file.endswith(('.mp3', '.wav', '.mp4', '.avi')):
                    process_audio_video_file(file_path)
                else:
                    logging.info(f"Unsupported file type: {file_path}")
                    log_to_db(file_path, 'Unsupported')
            except Exception as e:
                logging.error(f"Error processing file {file_path}: {e}")
                log_to_db(file_path, 'Error', str(e))

# Example usage
scan_directory('E:\Project Panna\dataset')
