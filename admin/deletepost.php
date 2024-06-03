<?php
session_start();
include_once "../includes/connection.php";

if(!isset($_GET['id'])){
    header("Location: index.php");
    exit();
} else {
    if(!isset($_SESSION['author_role'])){
        header("Location: login.php?message=Please+login");
        exit();
    } else {
        if($_SESSION['author_role'] != "admin"){
            echo "ERROR! You cannot access this page";
            exit();
        } else {
            $id = $_GET['id'];

            $sqlCheck = "SELECT * FROM post WHERE post_id='$id'";
            $result = mysqli_query($conn, $sqlCheck);
            if(mysqli_num_rows($result)<= 0)
            {
                header("Location: posts.php?message=NoFile");
                exit();
            }
            $sql = "DELETE FROM post WHERE post_id='$id'";
            if(mysqli_query($conn, $sql)){
                header("Location: posts.php?message=Post+Deleted");
            } else {
                header("Location: posts.php?message=Post+Not+Deleted");
            }
        }
    }
}
?>