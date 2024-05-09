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
    <!-- <link rel="stylesheet" href="style.css">  -->

    <!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--Google Fonts-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.3/font/bootstrap-icons.min.css">
    <!--Google Fonts-->
    
</head>
<body>
    
<div class="form-container">
    <form action="" method="post" class="position-absolute top-50 start-50 translate-middle border p-4 rounded-3 shadow-lg">
        <h3 class="text-center">Create an account</h3>

        <div class="mb-3">
        <?php 
            if(isset($error)){
                foreach($error as $error){
                    echo '<span class="error-msg">' .$error. '</span>';
                };
            };
            ?>
        </div>


<div class="mb-3">
        <input type="text" name="firstname" class="form-control" required placeholder="Enter your first name">
        </div>
        
        <div class="mb-3">
        <input type="text" name="lastname" class="form-control" required placeholder="Enter your last name">
        </div>

        <div class="mb-3">
        <input type="email" name="email" class="form-control" required placeholder="Enter your email">
        </div>

        <div class="mb-3">
        <input type="password" name="password" class="form-control" required placeholder="Enter your password">
        </div>

        <div class="mb-3">
        <input type="password" name="cpassword" class="form-control" required placeholder="Confirm password">
</div>


        <div class="mb-3">
        <input type="submit" name="submit" value="Register" class="btn btn-primary">
        </div>
        <p>Already have an account? <a href="login.php">Login now</a></p>
    </form>

    </div>


    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>