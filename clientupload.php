
<?php
session_start();
@include "config.php";

if ($_FILES["fileToUpload"]["error"] == 0) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $output = shell_exec("python encrypt2.py " . $target_file);
        $encryption_info = file_get_contents('encryption_info.key');
        $encryption_info = explode("\n", $encryption_info);
        $key = $encryption_info[0];
        $encrypted_file_path = $encryption_info[1];

        // Get the selected email from the form
        $selected_email = $_POST['email'];

        echo "File is uploaded and encrypted.";
        echo " \n";

        

        // Insert data into the "users" table
        $sql = "INSERT INTO encrypted_files (file_path, encryption_key, email) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $encrypted_file_path, $key, $selected_email);

        if ($stmt->execute()) {
            echo "<p><strong>Saved Successfully</strong></p>";
            header("location: clientmessages.php");
        } else {
            echo "Error inserting data: " . $stmt->error;
        }

        $conn->close();
        $stmt->close();

        // Delete the unencrypted file
        unlink($target_file);

        // Delete the encryption key file
        unlink('encryption_info.key');
        
    } else {
        echo "Error uploading file.";
    }
} else {
    echo "Error: " . $_FILES["fileToUpload"]["error"];
}
?>
