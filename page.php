<?php
include_once "includes/connection.php";
include_once "includes/functions.php";

if(!isset($_GET['id'])){
    header("Location: index.php?geterr");
    exit();
} else {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    if(!is_numeric($id)){
        header("Location: index.php?numerror");
        exit();
    } else {
        $sql = "SELECT * FROM page WHERE page_id='$id'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) <= 0){
            header("Location: index.php?nopagefound");
            exit();
        } else {
            while($row = mysqli_fetch_assoc($result)){
                $page_title = $row['page_title'];
                $page_content = $row['page_content'];
                ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .page-title {
            width: 100%;
            background-color: #343a40;
            padding: 25px 0;
            text-align: center;
            color: white;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!--NAVIGATION BAR HERE-->
    <?php include_once "includes/nav.php"; ?>
    <!--NAVIGATION BAR ENDS HERE-->

    <div class="container">
        <h1 class="page-title"><?php echo htmlspecialchars($page_title); ?></h1>
        <div class="content">
            <p><?php echo nl2br(htmlspecialchars($page_content)); ?></p>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php
            }
        }
    }
}
?>
