<?php
session_start(); 

include_once "../includes/functions.php";
include_once "../includes/connection.php";

if(isset($_GET['message'])) {
    $msg = htmlspecialchars($_GET['message']);
    echo '<div class="alert alert-warning alert-dismissible fade show alert-fixed" role="alert">
                '.$msg.'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
}

if(isset($_POST['login'])) { 
    $author_email = mysqli_real_escape_string($conn, $_POST['author_email']);
    $author_password = mysqli_real_escape_string($conn, $_POST['author_password']);
    
    if(empty($author_email) OR empty($author_password)) {
        header("Location: login.php?message=Empty+Fields");
        exit();
    }

    if(!filter_var($author_email, FILTER_VALIDATE_EMAIL)) {
        header("Location: login.php?message=Please+Enter+A+Valid+Email");
        exit();
    } else {
        $sql = "SELECT * FROM `author` WHERE author_email='$author_email'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) <= 0) {
            header("Location: login.php?message=Login+Error");
            exit();
        } else {
            $row = mysqli_fetch_assoc($result);
            if(!password_verify($author_password, $row['author_password'])) {
                header("Location: login.php?message=Login+Error");
                exit();
            } else {
                $_SESSION['author_id'] = $row['author_id'];
                $_SESSION['author_name'] = $row['author_name'];
                $_SESSION['author_email'] = $row['author_email'];
                $_SESSION['author_bio'] = $row['author_bio'];
                $_SESSION['author_role'] = $row['author_role'];
                
                header("Location: index.php");
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; 
            color: #333; 
        }
        .form-signin {
            max-width: 400px;
            padding: 15px;
            margin: auto;
            background: #fff; 
            border-radius: 10px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
        }
        .form-signin .form-control {
            margin-bottom: 10px;
        }
        .alert-fixed {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        }
        .form-signin h1 {
            margin-bottom: 30px;
        }
        .form-signin p, .form-signin a {
            margin-bottom: 0;
        }
        .form-signin .additional-text {
            margin-top: 20px;
        }
        .form-signin .copyright {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-12 col-md-8 col-lg-6">
            <form method="post" class="form-signin">
                <h1 class="h3 mb-3 font-weight-normal text-center">Please Log In</h1>
                <input type="email" id="inputEmail" name="author_email" class="form-control" placeholder="Email address" required autofocus>
                <input type="password" id="inputPassword" name="author_password" class="form-control" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Log In</button>
                <a class="mt-3 mb-2 text-muted text-center d-block" href="signup.php">New here? Let's create an account</a>
                <p class="additional-text mt-4 mb-2 text-muted text-center">Inspiration and news just a click away!</p>
                <p class="copyright mt-4 mb-2 text-muted text-center">&copy; 2024 | All rights are reserved by Multiverse Media Group</p>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
