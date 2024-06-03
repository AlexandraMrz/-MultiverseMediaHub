<?php
include_once "../includes/connection.php";
session_start();
if(!isset($_POST['submit'])){
    header("Location: page.php?message=Please+Add+a+Page");
    exit();
} else {
    if(!isset($_SESSION['author_role'])){
        header("Location: login.php");
        exit();
    } else {
        if($_SESSION['author_role'] != "admin"){
            echo "You can't access this page";
            exit();
        } else {
            
            if(isset($_POST['page_title']) && isset($_POST['page_content']) && !empty($_POST['page_title']) && !empty($_POST['page_content'])) {
                $page_title = $_POST['page_title'];
                $page_content = $_POST['page_content'];

                // Corectează eroarea în sintaxa SQL
                $sql = "INSERT INTO page (page_title, page_content) VALUES ('$page_title', '$page_content')";
                if(mysqli_query($conn, $sql)){
                    header("Location: page.php?message=Added+Successfully");
                    exit();
                } else {
                    header("Location: page.php?message=Error+Occured+While+Adding+Page");
                    exit();
                }
            } else {
                header("Location: page.php?message=Please+Fill+All+Fields");
                exit();
            }
        }
    }
}
?>