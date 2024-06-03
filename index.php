<?php
include_once "includes/functions.php";
include_once "includes/connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Site</title>
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .jumbotron {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('icons/multiverseMediaHub.jpg') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 6rem 2rem;
        }
        .jumbotron .display-4 {
            font-weight: 700;
        }
        .jumbotron .lead {
            font-size: 1.25rem;
        }
        .card-columns {
            column-count: 3;
        }
        .card {
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }
        .card img {
            height: 200px;
            object-fit: cover;
        }
        .card .card-body {
            text-align: center;
        }
        .pagination {
            justify-content: center;
            margin-top: 20px;
        }
        .pagination .page-item .page-link {
            color: #17a2b8;
            border-radius: 50%;
        }
        .pagination .page-item.active .page-link {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
        .btn-primary {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
    </style>
</head>
<body>

<!--NAVBAR -->
<?php include_once("includes/nav.php"); ?>
<!--END NAVBAR -->

<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4"><?php echo getSettingValue("home_jumbo_title"); ?></h1>
        <p class="lead"><?php echo getSettingValue("home_jumbo_desc"); ?></p>
    </div>
</div>

<div class="container">
  <?php
  // Pagination
  $sqlpg = "SELECT * FROM post";
  $resultpg = mysqli_query($conn, $sqlpg);
  $totalposts = mysqli_num_rows($resultpg);
  $totalpages = ceil($totalposts / 9);
  ?>
  <?php
  // Pagination get
  $pageid = isset($_GET['p']) ? $_GET['p'] : 1;
  $start = ($pageid * 9) - 9;
  $sql = "SELECT * FROM post ORDER BY post_id DESC LIMIT $start, 9";
  ?>
  <div class="card-columns">
  <?php
  
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) 
  {
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
<div class="card">
  <img class="card-img-top" src="<?php echo $post_image ?>" alt="...">
  <div class="card-body">
    <h5 class="card-title"><?php echo $post_title ?></h5>
    <h6 class="card-subtitle mb-2 text-muted"><?php echo $post_author_name ?></h6>
    <p class="card-text"><?php echo substr(strip_tags($post_content), 0, 100)."..."; ?></p>
    <a href="post.php?id=<?php echo $post_id ?>" class="btn btn-primary">Read more</a>
  </div>
</div>
<?php }} ?>
  </div>
  
  <nav aria-label="Page navigation">
    <ul class="pagination">
      <?php 
      for($i = 1; $i <= $totalpages; $i++){
        echo '<li class="page-item'.($i == $pageid ? ' active' : '').'"><a class="page-link" href="?p='.$i.'">'.$i.'</a></li>';
      }
      ?>
    </ul>
  </nav>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/scroll.js"></script>
</body>
</html>
