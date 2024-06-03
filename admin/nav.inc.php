<nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                    <li class="nav-item">
                            
                            <a class="nav-link active" href="../index.php">
                                <img src="../icons/homepage.svg" style="width: 20px; height: 20px;">
                                <span data-feather="home"></span>
                                Home  <span class="sr-only">(current)</span>
                                
                            </a>
                        </li>
                        <li class="nav-item">
                            
                            <a class="nav-link active" href="index.php">
                                <img src="../icons/dashboardIcon.svg" style="width: 20px; height: 20px;">
                                <span data-feather="home"></span>
                                Dashboard <span class="sr-only">(current)</span>
                                
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="posts.php">
                            <img src="../icons/allPostsIcon.svg" style="width: 20px; height: 20px;">
                                <span data-feather="home"></span>
                                All Posts
                            </a>
                        </li>
                        <?php
                        if(isset($_SESSION['author_role'])){
                            if($_SESSION['author_role']=="admin"){
                                ?>
                                <!--ONLY ADMIN LINKS ARE DISPLAYED -->
                                <li class="nav-item">
                                <a class="nav-link" href="category.php">
                                <img src="../icons/categoryIcon.svg" style="width: 25px; height: 25px;">
                                <span data-feather="file"></span>
                                All Categories
                                </a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" href="page.php">
                                <img src="../icons/allPagesIcon.svg" style="width: 20px; height: 20px;">
                                <span data-feather="file"></span>
                                All Pages
                                </a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" href="settings.php">
                                <img src="../icons/settingsIcon.svg" style="width: 20px; height: 20px;">
                                <span data-feather="file"></span>
                                Settings
                                </a>
                                </li>
                                <?php

                            }
                        }
                        ?>
                    </ul>
                </div>
            </nav>