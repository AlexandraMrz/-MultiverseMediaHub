<?php
include_once("../includes/functions.php");
include_once("../includes/connection.php");
session_start();
if(isset($_SESSION['author_role'])){
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
            background-color: #f4f7f6;
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
        .table img {
            border-radius: 5px;
        }
        .table thead th {
            background-color: #343a40;
            color: #fff;
        }
        .btn-info, .btn-danger {
            margin-right: 5px;
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
                    <h1 class="h2">Posts</h1>
                    <h6>Hello <?php echo htmlspecialchars($_SESSION['author_name']); ?> | Your role is <?php echo htmlspecialchars($_SESSION['author_role']); ?></h6>
                </div>
                <div id="admin-index-form" class="main-content">
                    <?php
                    if(isset($_GET['message'])) {
                        $msg = htmlspecialchars($_GET['message']);
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                '.$msg.'
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>';
                    }
                    ?>
                    <h1>ALL POSTS</h1>
                    <a href="newpost.php" class="btn btn-info mb-3">Add New</a>
                    <hr>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Post Id</th>
                                <th scope="col">Post Image</th>
                                <th scope="col">Post Title</th>
                                <th scope="col">Post Author</th>
                                <?php if($_SESSION['author_role']=="admin"){ ?>
                                <th scope="col">Action</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM post ORDER BY post_id DESC";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $post_title = $row['post_title'];
                                $post_image = $row['post_image'];
                                $post_author = $row['post_author'];
                                $post_content = $row['post_content'];
                                $post_id = $row['post_id'];
                                $sqlauth = "SELECT * FROM author WHERE author_id='$post_author'";
                                $resultauth = mysqli_query($conn, $sqlauth);
                                while($authrow=mysqli_fetch_assoc($resultauth)){
                                    $post_author_name = $authrow["author_name"];
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $post_id; ?></th>
                                        <td><img src="../<?php echo $post_image; ?>" width="50px" height="50px" alt="Post Image"></td>
                                        <td><?php echo htmlspecialchars($post_title); ?></td>
                                        <td><?php echo htmlspecialchars($post_author_name); ?></td>
                                        <?php if($_SESSION['author_role']=="admin"){ ?>
                                        <td>
                                            <a href="editpost.php?id=<?php echo $post_id; ?>" class="btn btn-info">Edit</a>
                                            <a href="deletepost.php?id=<?php echo $post_id; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
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
