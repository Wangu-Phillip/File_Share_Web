<?php 

@include "config.php";

if(isset($_POST["submit"])){

    $firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
    $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $pass = md5($_POST["password"]);
    $cpass = md5($_POST["cpassword"]);

    $select = " SELECT * FROM users WHERE email = '{$email}' && password = '{$pass}' ";

    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0){

        $error[] = "User already exists!";
        // echo "<script>alert('Email already exists.')</script>";
    } else{

        if($pass != $cpass){
            $error[] = "Password does not match!";
        }else{
            
            $insert = " INSERT INTO users (firstname, lastname, email, password) VALUES ('{$firstname}', '{$lastname}', '{$email}', '{$pass}') ";

            mysqli_query($conn, $insert); // insert data into database
            header("Location: login.php"); // redirect to login page
        }
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
    <title>Create Account</title>

    <!-- custom css file link --> 
    <link rel="stylesheet" href="style.css"> 
    
</head>
<body>
    
<div class="form-container">
    <form action="" method="post">
        <h3>Create an account</h3>

        <?php 
            if(isset($error)){
                foreach($error as $error){
                    echo '<span class="error-msg">' .$error. '</span>';
                };
            };
            ?>

        <input type="text" name="firstname" required placeholder="Enter your first name">
        <input type="text" name="lastname" required placeholder="Enter your last name">
        <input type="email" name="email" required placeholder="Enter your email">
        <input type="password" name="password" required placeholder="Enter your password">
        <input type="password" name="cpassword" required placeholder="Confirm password">

        <input type="submit" name="submit" value="Register" class="form-btn">

        <p>Already have an account? <a href="login.php">Login now</a></p>
    </form>

    </div>

</body>
</html>