<?php
include_once("../includes/functions.php");
include_once("../includes/connection.php");
session_start();

if (isset($_SESSION['author_role']) && $_SESSION['author_role'] == "admin") {
    if (isset($_GET['id'])) {
        $post_id = $_GET['id'];
        $FormSql = "SELECT * FROM post WHERE post_id = '$post_id'";
        $FormResult = mysqli_query($conn, $FormSql);

        $msg = isset($_GET['message']) ? $_GET['message'] : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post Page</title>
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
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Edit Post</h1>
                    <h6>Hello <?php echo $_SESSION['author_name']; ?> | Your role is <?php echo $_SESSION['author_role']; ?></h6>
                </div>
                <div id="admin-index-form">
                    <?php
                    if (!empty($msg)) {
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    '.$msg.'
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>';
                    }
                    ?>
                    <?php
                    while ($FormRow = mysqli_fetch_assoc($FormResult)) {
                        $postTitle = $FormRow['post_title'];
                        $postContent = $FormRow['post_content'];
                        $postImage = $FormRow['post_image'];
                        $postKeywords = $FormRow['post_keywords'];
                    ?>
                    <form enctype="multipart/form-data" method="post">
                        <div class="form-group">
                            <label for="postTitle">Post Title:</label>
                            <input type="text" name="post_title" class="form-control" id="postTitle" placeholder="Post Title" value="<?php echo $postTitle ?>">
                        </div>
                        <div class="form-group">
                            <label for="postContent">Post Content:</label>
                            <textarea name="post_content" class="form-control" id="postContent" rows="6"><?php echo $postContent ?></textarea>
                        </div>
                        <div class="form-group">
                            <img src="../<?php echo $postImage; ?>" width="150px" height="150px"><br>
                            <label for="postImage">Post Image:</label>
                            <input type="file" name="file" class="form-control-file" id="postImage">
                        </div>
                        <div class="form-group">
                            <label for="postKeywords">Post Keywords:</label>
                            <input type="text" name="post_keywords" class="form-control" id="postKeywords" placeholder="Enter Keywords" value="<?php echo $postKeywords ?>">
                        </div>
                        <button name="submit" type="submit" class="btn btn-primary">Update</button>
                    </form>
                    <?php } ?>
                    <?php 
                    if (isset($_POST['submit'])) {
                        $post_title = mysqli_real_escape_string($conn, $_POST['post_title']);
                        $post_content = mysqli_real_escape_string($conn, $_POST['post_content']);
                        $post_keywords = mysqli_real_escape_string($conn, $_POST['post_keywords']);

                        if (empty($post_title) || empty($post_content)) {
                            echo '<script>window.location = "edit_post.php?id='.$post_id.'&message=Empty+Fields";</script>';
                            exit();
                        }

                        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                            $file = $_FILES['file'];
                            $fileName = $file['name'];
                            $fileTmp = $file['tmp_name'];
                            $fileSize = $file['size'];

                            $allowedExt = array('jpg', 'jpeg', 'png', 'gif');
                            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                            if (in_array($fileExt, $allowedExt) && $fileSize < 3000000) {
                                $newFileName = uniqid('', true) . '.' . $fileExt;
                                $destination = '../uploads/' . $newFileName;
                                $dbdestination = "uploads/$newFileName";
                                move_uploaded_file($fileTmp, $destination);

                                $sql = "UPDATE post SET post_title='$post_title', post_keywords='$post_keywords', post_content='$post_content', post_image='$dbdestination' WHERE post_id='$post_id'";

                                if (mysqli_query($conn, $sql)) {
                                    echo '<script>window.location = "posts.php?message=Post+Updated";</script>';
                                    exit();
                                } else {
                                    echo '<script>window.location = "edit_post.php?id='.$post_id.'&message=Error+Updating+Post+With+Image";</script>';
                                    exit();
                                }
                            } else {
                                echo '<script>window.location = "edit_post.php?id='.$post_id.'&message=Invalid+File+Type+or+Size";</script>';
                                exit();
                            }
                        } else {
                            $sql = "UPDATE post SET post_title='$post_title', post_keywords='$post_keywords', post_content='$post_content' WHERE post_id='$post_id'";
                            if (mysqli_query($conn, $sql)) {
                                echo '<script>window.location = "posts.php?message=Post+Updated";</script>';
                                exit();
                            } else {
                                echo '<script>window.location = "edit_post.php?id='.$post_id.'&message=Error+Updating+Post";</script>';
                                exit();
                            }
                        }
                    }
                    ?>
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
<?php
    }
} else {
    header("Location: login.php");
    exit();
}
?>
