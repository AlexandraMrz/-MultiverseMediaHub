<?php
include_once("../includes/functions.php");
include_once("../includes/connection.php");
session_start();

if(isset($_SESSION['author_role']) && $_SESSION['author_role'] == "admin") {
    if(isset($_POST['submit'])) {
        $jumboTitle = mysqli_real_escape_string($conn, $_POST['home_jumbo_title']);
        $jumboDesc = mysqli_real_escape_string($conn, $_POST['home_jumbo_desc']);

        setSettingValue("home_jumbo_title", $jumboTitle);
        setSettingValue("home_jumbo_desc", $jumboDesc);
        
        header("Location: settings.php?message=Settings+Updated");
        exit(); 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
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

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Settings</h1>
                    <h6>Hello <?php echo $_SESSION['author_name']; ?> | Your role is <?php echo $_SESSION['author_role']; ?></h6>
                </div>
                <div id="admin-index-form">
                    <?php
                    if(isset($_GET['message'])) {
                        $msg = $_GET['message'];
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    '.$msg.'
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>';
                    }
                    ?>
                    <h1> All Settings </h1>
                    <hr>
                    <div class="card">
                        <div class="card-header">
                            Update HomePage Jumbotron
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <div class="form-group">
                                    <label for="home_jumbo_title">HomePage Jumbotron Title</label>
                                    <input type="text" name="home_jumbo_title" id="home_jumbo_title" class="form-control" placeholder="Enter Jumbo Title" value="<?php echo getSettingValue("home_jumbo_title"); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="home_jumbo_desc">HomePage Jumbotron Description</label>
                                    <input type="text" name="home_jumbo_desc" id="home_jumbo_desc" class="form-control" placeholder="Enter Jumbo Description" value="<?php echo getSettingValue("home_jumbo_desc"); ?>">
                                </div>
                                <button type="submit" name="submit" class="btn btn-success">Update Settings</button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/scroll.js"></script>
</body>
</html>

<?php
} else {
    header("Location: login.php");
    exit(); 
}
?>
