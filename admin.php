
<?php

@include "config.php";

session_start();

    if(!isset($_SESSION["admin_name"])){
        header("location: login.php");
    }

    if(!isset($_SESSION["admin_surname"]) ){
        header("location: login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- SIDE NAVIGATION MENU-->
<div class="navbar">
        <a href="#" class="active">Dashboard</a>
        <a href="message.php">File Sharing</a>
        <a href="#">Settings</a>
        <a href="logout.php" class="btn">Logout</a>
    </div>

    <h1>Welcome <span><?php echo $_SESSION["admin_name"] . " " . $_SESSION["admin_surname"] ?></span></h1>
  

   
</body>


</html>