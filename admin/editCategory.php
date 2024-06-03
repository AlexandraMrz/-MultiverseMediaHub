<?php
include_once("../includes/connection.php");

if(isset($_POST['category_id']) && isset($_POST['category_name'])) {
    $categoryId = $_POST['category_id'];
    $categoryName = $_POST['category_name'];

    $sql = "UPDATE category SET category_name = '$categoryName' WHERE category_id = '$categoryId'";
    if(mysqli_query($conn, $sql)) {
        echo "Category updated successfully";
    } else {
        echo "Error updating category: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}
?>
