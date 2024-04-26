<?php
@include "config.php";

session_start();

if (!isset($_SESSION["client_email"])) {
    header("location: login.php");
}


// Retrieve the encryption key and encrypted file path from the database based on the client's email
$sql = "SELECT encryption_key, file_path FROM encrypted_files WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION["client_email"]);
$stmt->execute();
$stmt->bind_result($key, $encrypted_file_path);

// Fetch the result
$stmt->fetch();


// Specify the output file path for the decrypted file
$output_file_path = 'decrypted_files/' . basename($encrypted_file_path, '.enc');

// Decrypt the file
$output = shell_exec("python decrypt.py " . $encrypted_file_path . " " . $key . " " . $output_file_path);
echo $output;
$stmt->close();
?>
