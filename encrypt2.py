from cryptography.fernet import Fernet
import sys

# Generate a key for encryption
key = Fernet.generate_key()
cipher = Fernet(key)

# Encrypt the file
def encrypt_file(file_path):
    with open(file_path, 'rb') as f:
        data = f.read()
    encrypted_data = cipher.encrypt(data)
    with open(file_path + '.enc', 'wb') as f:
        f.write(encrypted_data)
    # Store encryption key and encrypted file path in a separate file
    with open('encryption_info.key', 'w') as f:
        f.write(key.decode('utf-8') + '\n')
        f.write(file_path + '.enc')

# Check if the script is being run directly
if __name__ == '__main__':
    if len(sys.argv) != 2:
        print("Usage: python encrypt2.py [file_path]")
        sys.exit(1)
    file_path = sys.argv[1]
    encrypt_file(file_path)
