<?php
session_start();

@include "config.php";

if (!isset($_SESSION["admin_name"])) {
    header("location: login.php");
    exit(); // Add exit to stop further execution
}

if (!isset($_SESSION["admin_surname"])) {
    header("location: login.php");
    exit(); // Add exit to stop further execution
}

// Fetch list of usernames and emails from the database for clients
$conn = new mysqli("localhost", "root", "", "bwcyber");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT firstname, email FROM users WHERE role = 'client'";
$result = $conn->query($sql);

$usernames = array();
$emails = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $usernames[] = $row["firstname"];
        $emails[] = $row["email"];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- SIDE NAVIGATION MENU-->
    <div class="navbar">
        <a href="admin.php">Dashboard</a>
        <a href="message.php" class="active">File Sharing</a>
        <a href="#">Settings</a>
        <a href="logout.php" class="btn">Logout</a>
    </div>

    <div class="container">
        <h1>File Upload</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="fileToUpload">Choose a file to Send:</label>
            <input type="file" name="fileToUpload" id="fileToUpload" class="file-input"><br>

            <label for="email">Select a user to send to:</label><br>
            <select name="email" id="email">
                <?php for ($i = 0; $i < count($usernames); $i++) { ?>
                    <option value="<?php echo $emails[$i]; ?>"><?php echo $usernames[$i]; ?></option>
                <?php } ?>
            </select><br><br>

            <button type="submit" name="submit" class="upload-btn">Share File</button>
        </form>

    </div>
    <br>

    <div class="container">
        <h1>File Decryption</h1>
        <table>
            <thead>
                <tr>
                    <th>Received Files: </th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch encrypted files associated with the user's email
                $email = $_SESSION["admin_email"];
                $sql = "SELECT file_path FROM encrypted_files WHERE email = ?";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    die('Error preparing statement: ' . $conn->error);
                }
                $stmt->bind_param("s", $email);
                if (!$stmt->execute()) {
                    die('Error executing statement: ' . $stmt->error);
                }
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr><td>' . $row["file_path"] . '</td></tr>';
                    }
                } else {
                    echo '<tr><td>No files found</td></tr>';
                }

                $conn->close();
                ?>
            </tbody>
        </table>
        <br>
        <button onclick="decryptFile()">Decrypt File</button>
    </div>
    <br><br>

    <!-- 
    <div class="container">
        <h1>File Decryption</h1>
        <button onclick="decryptFile()">Decrypt File</button>
    </div> -->
</body>

<script>
    function decryptFile() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "decrypt.php", true);
        xhr.send();
        xhr.onload = function() {
            if (xhr.status == 200) {
                alert("File decrypted successfully!");
            } else {
                alert("Error decrypting file.");
            }
        };
    }
</script>

</html>