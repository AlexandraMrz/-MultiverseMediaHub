<?php
include_once "includes/connection.php";
include_once "includes/functions.php";

if (!isset($_GET['id'])) {
    header("Location: index.php?geterr");
    exit();
}

$id = $_GET['id'];
if (!is_numeric($id)) {
    header("Location: index.php?numerror");
    exit();
}

$id = (int)$id; 
$sql = "SELECT * FROM category WHERE category_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) <= 0) {
    header("Location: index.php?noresult");
    exit();
}

$row = mysqli_fetch_assoc($result);
$category_name = htmlspecialchars($row['category_name']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $category_name; ?> | Project Site</title>
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .category-header {
            background-color: #343a40;
            color: white;
            padding: 50px 0;
            text-align: center;
            margin-bottom: 30px;
        }
        .category-header h1 {
            font-size: 2.5rem;
        }
        .card-columns {
            column-count: 3;
        }
        .card {
            margin-bottom: 30px;
            transition: transform 0.3s ease-in-out;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            height: 200px;
            object-fit: cover;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: 500;
        }
        .card-subtitle {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<?php include_once("includes/nav.php"); ?>
<!-- END NAVBAR -->

<div class="category-header">
    <h1>Showing All Posts From Category: <?php echo $category_name; ?></h1>
</div>

<div class="container">
    <div class="card-columns">
        <?php
        $sql_posts = "SELECT * FROM post WHERE post_category=? ORDER BY post_id DESC";
        $stmt_posts = mysqli_prepare($conn, $sql_posts);
        mysqli_stmt_bind_param($stmt_posts, 'i', $id);
        mysqli_stmt_execute($stmt_posts);
        $result_posts = mysqli_stmt_get_result($stmt_posts);

        while ($row = mysqli_fetch_assoc($result_posts)) {
            $post_title = htmlspecialchars($row['post_title']);
            $post_image = htmlspecialchars($row['post_image']);
            $post_author = htmlspecialchars($row['post_author']);
            $post_content = htmlspecialchars($row['post_content']);
            $post_id = $row['post_id'];

            $sql_auth = "SELECT * FROM author WHERE author_id=?";
            $stmt_auth = mysqli_prepare($conn, $sql_auth);
            mysqli_stmt_bind_param($stmt_auth, 'i', $post_author);
            mysqli_stmt_execute($stmt_auth);
            $result_auth = mysqli_stmt_get_result($stmt_auth);
            $auth_row = mysqli_fetch_assoc($result_auth);

            // Check if $auth_row is null to prevent accessing null values
            if ($auth_row) {
                $post_author_name = htmlspecialchars($auth_row["author_name"]);
            } else {
                $post_author_name = "Unknown Author";
            }

            ?>
            <div class="card">
                <img class="card-img-top" src="<?php echo $post_image ?>" class="card-img-top" alt="Post Image">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $post_title ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">By <?php echo $post_author_name ?></h6>
                    <p class="card-text"><?php echo substr(strip_tags($post_content), 0, 100) . "..."; ?></p>
                    <a href="post.php?id=<?php echo $post_id ?>" class="btn btn-primary">Read more</a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/scroll.js"></script>
</body>
</html>
