<?php
session_start();
include_once "../includes/connection.php";

if(!isset($_GET['id'])){
    header("Location: index.php");
    exit();
}

if(!isset($_SESSION['author_role'])){
    header("Location: login.php?message=Please+login");
    exit();
}

if($_SESSION['author_role'] != "admin"){
    echo "ERROR! You cannot access this page";
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']); 

$sqlCheck = "SELECT * FROM category WHERE category_id='$id'";
$result = mysqli_query($conn, $sqlCheck);

if(mysqli_num_rows($result) <= 0) {
    header("Location: category.php?message=No+Category");
    exit();
}

// Deleting the category
$sqlDelete = "DELETE FROM category WHERE category_id='$id'";
if(mysqli_query($conn, $sqlDelete)){
    header("Location: category.php?message=Category+Deleted");
} else {
    header("Location: category.php?message=Category+Not+Deleted");
}
?>
