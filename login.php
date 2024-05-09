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
    } else {
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


    <!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--Google Fonts-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.3/font/bootstrap-icons.min.css">
    <!--Google Fonts-->

</head>

<body>

    <div class="form-container">
        <form action="" method="post" class="position-absolute top-50 start-50 translate-middle border p-4 rounded-3 shadow-lg">
            <h3 class="text-center">Login now</h3>

            <div class="mb-3">
            <?php
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<span class="error-msg">' . $error . '</span>';
                };
            };
            ?>
</div>
            <div class="mb-3">
                <input type="email" class="form-control" name="email" required placeholder="Enter your email"><br>
                <input type="password" class="form-control" name="password" required placeholder="Enter your password">
            </div>

            <div class="mb-3">
                <input type="submit" class="form-control btn btn-primary" name="submit" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Register now</a></p>
        </form>

    </div>

    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>