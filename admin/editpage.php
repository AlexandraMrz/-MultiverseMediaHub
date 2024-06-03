<?php
include_once "../includes/connection.php";
include_once "../includes/functions.php";
session_start();

if (!isset($_GET['id'])) {
    header("Location: page.php?message=Please+click+the+edit+button");
    exit();
}

if (!isset($_SESSION['author_role'])) {
    header("Location: login.php?message=Please+Login");
    exit();
}

if ($_SESSION['author_role'] != "admin") {
    echo ("You can't access this page");
    exit();
}

$page_id = $_GET['id'];
$sql = "SELECT * FROM page WHERE page_id='$page_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) <= 0) {
    header("Location: page.php?message=No+page+found");
    exit();
}

$pageData = mysqli_fetch_assoc($result);
$pageTitle = $pageData['page_title'];
$pageContent = $pageData['page_content'];

if (isset($_POST['submit'])) {
    $page_title = mysqli_real_escape_string($conn, $_POST['page_title']);
    $page_content = mysqli_real_escape_string($conn, $_POST['page_content']);

    if (empty($page_title) || empty($page_content)) {
        header('Location: page.php?message=Empty+Fields');
        exit();
    }

    $sql = "UPDATE page SET page_title='$page_title', page_content='$page_content' WHERE page_id='$page_id'";
    if (mysqli_query($conn, $sql)) {
        header('Location: page.php?message=Page+updated+successfully');
        exit();
    } else {
        header('Location: page.php?message=Error+updating+page');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page</title>
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
        }

        .navbar-brand {
            font-size: 1.5rem;
        }

        .form-signup {
            max-width: 600px;
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

        .container-fluid {
            margin-top: 20px;
        }

        .card {
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
                    <h1 class="h2">Edit Page</h1>
                    <h6>Hello <?php echo $_SESSION['author_name']; ?> | Your role is <?php echo $_SESSION['author_role']; ?></h6>
                </div>
                <div id="admin-index-form">
                    <?php
                    if (isset($_GET['message']) && !empty($_GET['message'])) {
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    ' . urldecode($_GET['message']) . '
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>';
                    }
                    ?>
                    <form enctype="multipart/form-data" method="post" class="form-signup card p-4 shadow-sm">
                        <div class="form-group">
                            <label for="pageTitle">Page Title:</label>
                            <input type="text" name="page_title" id="pageTitle" class="form-control" placeholder="Page Title" value="<?php echo $pageTitle ?>">
                        </div>
                        <div class="form-group">
                            <label for="pageContent">Page Content:</label>
                            <textarea name="page_content" id="pageContent" class="form-control" rows="6"><?php echo $pageContent ?></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Update Page</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/scroll.js"></script>
</body>

</html>
