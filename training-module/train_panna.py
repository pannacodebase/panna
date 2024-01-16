import os
import logging
from dotenv import load_dotenv
from process_file import *
import configparser
import uuid

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


def scan_directory(directory_path, config_data,connection):
    for root, dirs, files in os.walk(directory_path):
        for file in files:
            unique_identifier = uuid.uuid4()
            file_path = os.path.join(root, file)
            try:
                if file.endswith('.txt'):
                    process_text_file(file_path,config_data,connection)
                elif file.endswith('.pdf'):
                    process_pdf_file(file_path,config_data,connection)
                elif file.endswith(('.mp3', '.wav', '.mp4', '.avi')):
                    process_audio_video_file(file_path,config_data,connection)
                else:
                    logging.info(f"Unsupported file type: {file_path}")
                    log_to_db(connection, unique_identifier, file_path, 'Unsupported')
            except Exception as e:
                logging.error(f"Error processing file {file_path}: {e}")
                log_to_db(connection, unique_identifier, file_path, 'Error', str(e))

# Main
if __name__ == "__main__":
    environment = ENV.lower()
    logging.info (f"The environment is:  {environment}")
    try:
        config_data = read_config(environment)
        connection = connect_to_db (config_data)
        if isinstance(connection, str):
            # Handle the error
            logging.error(f"Error in DB connection {connection}")
        else:
            print ("Started Scanning")
            scan_directory('/Users/aaaa/Downloads/Test/', config_data,connection)
            print ("Scanning Completed")
            connection.close()
    except ValueError as e:
        print(f"Error: {e}")


