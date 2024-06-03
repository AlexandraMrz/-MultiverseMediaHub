<?php
include_once("../includes/functions.php");
include_once("../includes/connection.php");
session_start();

if(isset($_SESSION['author_role']) && $_SESSION['author_role'] == "admin") {
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
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #343a40;
        }
        .container-fluid {
            margin-top: 20px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        #addCatBtn {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark sticky-top shadow">
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
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Categories</h1>
                    <h6>Hello <?php echo $_SESSION['author_name']; ?> | Your role is <?php echo $_SESSION['author_role']; ?></h6>
                </div>
                <div id="admin-index-form">
                    <?php
                    if(isset($_GET['message'])) {
                        $msg = $_GET['message'];
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                '.$msg.'
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>';
                    }
                    ?>
                    <h1 class="mb-4">All Categories</h1>
                    <button id="addCatBtn" class="btn btn-info" onclick="toggleAddCatForm()">Add New</button>
                    <hr>
                    <div style="display:none;" id="addCatForm" class="mb-4">
                        <form action="addCat.php" method="post">
                            <div class="form-group">
                                <input type="text" name="category_name" class="form-control" placeholder="Category Name" required>
                            </div>
                            <button name="submit" class="btn btn-success">Add Category</button>
                        </form>
                    </div>
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Category Id</th>
                                <th scope="col">Category Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM category ORDER BY category_id DESC";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $category_id = $row['category_id'];
                                $category_name = $row['category_name'];
                            ?>
                            <tr>
                                <th scope="row"><?php echo $category_id; ?></th>
                                <td><?php echo $category_name; ?></td>
                                <td>
                                    <button class="btn btn-info btn-sm editCatBtn" data-id="<?php echo $category_id; ?>" data-name="<?php echo $category_name; ?>" data-toggle="modal" data-target="#editCategoryModal">Edit</button>
                                    <a href="deleteCategory.php?id=<?php echo $category_id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Modal for editing a category -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm" action="editCat.php" method="post">
                        <div class="form-group">
                            <label for="edit_category_id">Category ID:</label>
                            <input type="text" class="form-control" id="edit_category_id" name="category_id" readonly>
                        </div>
                        <div class="form-group">
                            <label for="edit_category_name">Category Name:</label>
                            <input type="text" class="form-control" id="edit_category_name" name="category_name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/scroll.js"></script>
    <script>
        function toggleAddCatForm() {
            $('#addCatForm').toggle();
        }

        $(document).on('click', '.editCatBtn', function() {
            const categoryId = $(this).data('id');
            const categoryName = $(this).data('name');
            $('#edit_category_id').val(categoryId);
            $('#edit_category_name').val(categoryName);
        });
    </script>
</body>
</html>
<?php 
} else {
    header("Location: login.php");
    exit();
}
?>
