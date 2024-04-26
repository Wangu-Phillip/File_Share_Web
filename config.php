<?php

$conn = mysqli_connect("us-cluster-east-01.k8s.cleardb.net", "b101cbed28bf40", "cae46924", "heroku_043e4e0afcd05b6");

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
