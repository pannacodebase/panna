import logging
import psycopg2
from psycopg2 import OperationalError

def connect_to_db (config_data):
    try:
        connection = psycopg2.connect(host= config_data['db_host'], database=config_data['db_name'], user=config_data['db_user'], password=config_data['db_pass'], port = config_data['db_port'])
        logging.info(f"Connected to Postgress DB")
        return connection
    except OperationalError as e:
        return f"Error: Unable to connect to the PostgreSQL database. {e}"

         
def log_to_db(connection,uuid, file_path, status, error_message=None):
    try:
        cursor = connection.cursor()
        logging.info ("Started Writing")
        insert_query = """INSERT INTO file_processing_audit (uuid, file_path, status, error_message) VALUES (%s, %s, %s, %s)"""
        
        cursor.execute(insert_query, (str(uuid), file_path, str(status), str(error_message)))
        connection.commit()
        cursor.close()
        logging.info ("End Writing")

    except Exception as e:
        logging.error(f"Database logging failed: {e}")