<?php
include_once "../includes/connection.php";
include_once "../includes/functions.php";
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; 
            color: #333; 
        }
        .form-signup {
            max-width: 400px;
            padding: 15px;
            margin: auto;
        }
        .form-signup .form-control {
            margin-bottom: 10px;
        }
        .alert-fixed {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if (isset($_GET['message'])) {
            $msg = htmlspecialchars($_GET['message']);
            echo '<div class="alert alert-warning alert-dismissible fade show alert-fixed" role="alert">
                    ' . $msg . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
        }
        ?>

        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-12 col-md-8 col-lg-6">
                <form method="post" class="form-signup">
                    <h1 class="h3 mb-3 font-weight-normal text-center">Please sign up</h1>

                    <input type="text" id="inputName" name="author_name" class="form-control" placeholder="Name" required autofocus>
                    <input type="email" id="inputEmail" name="author_email" class="form-control" placeholder="Email address" required>
                    <input type="password" id="inputPassword" name="author_password" class="form-control" placeholder="Password" required>

                    <button class="btn btn-lg btn-primary btn-block" name="signup" type="submit">Sign up</button>
                    <p class="mt-5 mb-3 text-muted text-center">Inspiration and news just a click away!</p>
                    <p class="mt-5 mb-3 text-muted text-center">&copy; 2024 | All rights are reserved by Multiverse Media Group</p>
                </form>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['signup'])) {
        $author_name = mysqli_real_escape_string($conn, $_POST['author_name']);
        $author_email = mysqli_real_escape_string($conn, $_POST['author_email']);
        $author_password = mysqli_real_escape_string($conn, $_POST['author_password']);
        
        if (empty($author_name) || empty($author_email) || empty($author_password)) {
            header("Location: signup.php?message=Empty+Fields");
            exit();
        }

        if (!filter_var($author_email, FILTER_VALIDATE_EMAIL)) {
            header("Location: signup.php?message=Please+Enter+A+Valid+Email");
            exit();
        } else {
            $sql = "SELECT * FROM `author` WHERE author_email='$author_email'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                header("Location: signup.php?message=Email+Already+Exists");
                exit();
            } else {
                $hash = password_hash($author_password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `author` (`author_name`, `author_email`, `author_password`, `author_bio`, `author_role`) VALUES ('$author_name', '$author_email', '$hash', 'Enter Bio', 'author')";
                if (mysqli_query($conn, $sql)) {
                    header("Location: login.php?message=Successfully+Signed+Up");
                } else {
                    echo "Error: " . mysqli_error($conn);
                    exit();
                }
            }
        }
    }
    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
