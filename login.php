<?php

@include "config.php";

session_start();

if (isset($_POST["submit"])) {

    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $pass = md5($_POST["password"]);
    

    $select = " SELECT * FROM users WHERE email = '{$email}' && password = '{$pass}' ";
    // $select2 = " SELECT  FROM applications";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_array($result);

        if ($row["role"] == "admin") {

            $_SESSION["admin_name"] = $row["firstname"];
            $_SESSION["admin_surname"] = $row["lastname"];
            $_SESSION["admin_email"] = $row["email"];

            header("Location: admin.php");

        } elseif ($row["role"] == "client") {

            $_SESSION["client_surname"] = $row["lastname"];
            $_SESSION["client_name"] = $row["firstname"];
            $_SESSION["client_email"] = $row["email"];

            header("Location: client.php");

        } 
    }else{
        $error[] = "Incorrect email or Password!";
    }
};
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title>Login Form</title>

    <!-- custom css file link -->
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="form-container">
        <form action="" method="post">
            <h3>Login now</h3>

        <?php 
            if(isset($error)){
                foreach($error as $error){
                    echo '<span class="error-msg">' .$error. '</span>';
                };
            };
            ?>

            <input type="email" name="email" required placeholder="Enter your email">
            <input type="password" name="password" required placeholder="Enter your password">

            <input type="submit" name="submit" value="Login" class="form-btn">
            <p>Don't have an account? <a href="register.php">Register now</a></p>
        </form>

    </div>

</body>

</html>