<?php
include_once("../includes/functions.php");
include_once("../includes/connection.php");
session_start();

if (isset($_SESSION['author_role'])) {
    // Handling form submission before any output
    if (isset($_POST['update'])) {
        $author_name = mysqli_real_escape_string($conn, $_POST['authorName']);
        $author_email = mysqli_real_escape_string($conn, $_POST['authorEmail']);
        $author_password = mysqli_real_escape_string($conn, $_POST['authorPassword']);
        $author_bio = mysqli_real_escape_string($conn, $_POST['authorBio']);

        // Error handling
        if (empty($author_name) || empty($author_email) || empty($author_bio)) {
            $error_message = "Empty fields";
        } else if (!filter_var($author_email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Please enter a valid email address!";
        } else {
            $author_id = $_SESSION['author_id'];
            if (empty($author_password)) {
                $sql = "UPDATE `author` SET author_name='$author_name', author_email='$author_email', author_bio='$author_bio' WHERE author_id='$author_id'";
                if (mysqli_query($conn, $sql)) {
                    $_SESSION['author_name'] = $author_name;
                    $_SESSION['author_email'] = $author_email;
                    $_SESSION['author_bio'] = $author_bio;
                    header("Location: index.php?message=Record+Updated");
                    exit();
                } else {
                    $error_message = "Error updating record";
                }
            } else {
                $hash = password_hash($author_password, PASSWORD_DEFAULT);
                $sql = "UPDATE `author` SET author_name='$author_name', author_email='$author_email', author_bio='$author_bio', author_password='$hash' WHERE author_id='$author_id'";
                if (mysqli_query($conn, $sql)) {
                    $_SESSION['author_name'] = $author_name;
                    $_SESSION['author_email'] = $author_email;
                    $_SESSION['author_bio'] = $author_bio;
                    session_unset();
                    session_destroy();
                    header("Location: login.php?message=Record+Updated");
                    exit();
                } else {
                    $error_message = "Error updating record";
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
        <title>Dashboard</title>
        <link rel="stylesheet" href="../style/bootstrap.min.css">
        <link rel="stylesheet" href="../style/style.css">
        <style>
            body {
                background-color: #f4f7f6;
                color: #333;
            }
            .navbar {
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            .container-fluid {
                padding-top: 20px;
            }
            .main-content {
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                padding: 20px;
            }
            .form-control {
                margin-bottom: 15px;
            }
            .form-heading {
                margin-bottom: 30px;
            }
            .alert {
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
    <nav class="navbar navbar-dark sticky-top bg-dark shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Multiverse Media Group</a>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="logout.php">Sign out</a>
            </li>
        </ul>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <?php include_once "nav.inc.php"; ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <h6>Hello <?php echo htmlspecialchars($_SESSION['author_name']); ?> | Your role is <?php echo htmlspecialchars($_SESSION['author_role']); ?></h6>
                </div>
                <div id="admin-index-form" class="main-content">
                    <?php
                    if (isset($_GET['message'])) {
                        $msg = htmlspecialchars($_GET['message']);
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                ' . $msg . '
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>';
                    }
                    if (isset($error_message)) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                ' . $error_message . '
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>';
                    }
                    ?>
                    <h1 class="form-heading">Your Profile</h1>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="authorName" class="form-control" id="name" placeholder="Enter name" value="<?php echo htmlspecialchars($_SESSION['author_name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email:</label>
                            <input type="email" name="authorEmail" class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="<?php echo htmlspecialchars($_SESSION['author_email']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword">Password:</label>
                            <input type="password" name="authorPassword" class="form-control" id="exampleInputPassword" placeholder="Enter password">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Bio:</label>
                            <textarea class="form-control" name="authorBio" id="exampleFormControlTextarea1" rows="3" required><?php echo htmlspecialchars($_SESSION['author_bio']); ?></textarea>
                        </div>
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/scroll.js"></script>
    </body>
    </html>
<?php
} else {
    header("Location: login.php");
    exit();
}
?>
