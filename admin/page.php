<?php
include_once("../includes/functions.php");
include_once("../includes/connection.php");
session_start();
if(isset($_SESSION['author_role'])){
    if($_SESSION['author_role']=="admin")
    {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .content-header {
            background-color: #343a40;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .form-section {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            vertical-align: middle;
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
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 content-header">
                    <h1 class="h2">Pages</h1>
                    <h6>Hello <?php echo $_SESSION['author_name']; ?> | Your role is <?php echo $_SESSION['author_role']; ?></h6>
                </div>
                <div id="admin-index-form">
                    <?php
                    if(isset($_GET['message'])) {
                        $msg = $_GET['message'];
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    '.$msg.'
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>';
                    }
                    ?>
                    <div class="form-section mb-4">
                        <h1>ALL Pages</h1>
                        <button id="toggleForm" class="btn btn-info mb-3">Add New</button>
                        <div style="display: none;" id="newPageForm">
                            <form action="newpage.php" method="post">
                                <div class="form-group">
                                    <input type="text" name="page_title" class="form-control" placeholder="Enter Page Title" required>
                                </div>
                                <div class="form-group">
                                    <textarea name="page_content" class="form-control" rows="3" placeholder="Enter Some Content..." required></textarea>
                                </div>
                                <button name="submit" class="btn btn-success">Add Page</button>
                            </form>
                        </div>
                    </div>
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Page Id</th>
                                <th scope="col">Page Title</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT * FROM page ORDER BY page_id DESC";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $page_id = $row['page_id'];
                                    $page_title = $row['page_title'];
                            ?>
                            <tr>
                                <th scope="row"><?php echo $page_id; ?></th>
                                <td><?php echo $page_title; ?></td>
                                <td>
                                    <a href="editpage.php?id=<?php echo $page_id; ?>" class="btn btn-info btn-sm">Edit</a>
                                    <a onclick="return confirm('Are you sure?')" href="deletepage.php?id=<?php echo $page_id; ?>" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#toggleForm").click(function(){
                $("#newPageForm").slideToggle();
            });
        });
    </script>
</body>
</html>
<?php
    }
} else {
    header("Location: login.php");
    exit();
}
?>
