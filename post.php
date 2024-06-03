<?php
include_once "includes/connection.php";
include_once "includes/functions.php";

if (!isset($_GET['id'])) {
    header("Location: index.php?geterr");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
if (!is_numeric($id)) {
    header("Location: index.php?numerror");
    exit();
}

$sql = "SELECT * FROM post WHERE post_id='$id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) <= 0) {
    header("Location: index.php?noresult");
    exit();
}

while ($row = mysqli_fetch_assoc($result)) {
    $post_title = $row['post_title'];
    $post_content = $row['post_content'];
    $post_date = $row['post_date'];
    $post_image = $row['post_image'];
    $post_keywords = $row['post_keywords'];
    $post_author = $row['post_author'];
    $post_category = $row['post_category'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $post_title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .post-header {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?php echo $post_image; ?>') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 6rem 2rem;
            text-align: center;
        }
        .post-header h1 {
            font-size: 3rem;
            font-weight: 700;
        }
        .post-meta {
            margin: 1rem 0;
            font-size: 0.9rem;
            color: #6c757d;
        }
        .post-content {
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <!--NAVIGATION BAR HERE-->
    <?php include_once "includes/nav.php"; ?>
    <!--NAVIGATION BAR ENDS HERE-->

    <div class="post-header">
        <h1><?php echo $post_title; ?></h1>
    </div>

    <div class="container mt-4">
        <div class="post-meta">
            <span>Posted On: <?php echo $post_date; ?></span> | 
            <span>By: <?php getAuthorName($post_author); ?></span> | 
            <span>Category: <a href="category.php?id=<?php echo $post_category; ?>"><?php getCategoryName($post_category); ?></a></span>
        </div>
        <div class="post-content">
            <p><?php echo $post_content; ?></p>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scroll.js"></script>
</body>
</html>

<?php
}
?>
