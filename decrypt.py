
from cryptography.fernet import Fernet
import sys

def decrypt_file(encrypted_file_path, key, output_file_path):
    cipher = Fernet(key.encode('utf-8'))
    with open(encrypted_file_path, 'rb') as f:
        data = f.read()
    decrypted_data = cipher.decrypt(data)
    with open(output_file_path, 'wb') as f:
        f.write(decrypted_data)

if __name__ == '__main__':
    if len(sys.argv) != 4:
        print("Usage: python decrypt.py [encrypted_file_path] [encryption_key] [output_file_path]")
        sys.exit(1)
    encrypted_file_path = sys.argv[1]
    key = sys.argv[2]
    output_file_path = sys.argv[3]
    decrypt_file(encrypted_file_path, key, output_file_path)
