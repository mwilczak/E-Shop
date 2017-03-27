<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<a href="" class="navbar-brand">Online Shopping</a>
				</div>
				<ul class="nav navbar-nav">
					<li><a href="#">Home</a></li>

                    <?php
                        $categoryQuery = "SELECT * FROM category";
                        $allCategory = mysqli_query($conn, $categoryQuery);
                        while ($catRows = mysqli_fetch_assoc($allCategory)) {
                            $categoryName = ucwords($catRows['cat_name']);
                            $categorySlug = $catRows['cat_slug'];
                                if($categorySlug == '') {
                                    $categorySlug = $categoryName;
                                }
                            echo "<li><a href='category.php?category=$categorySlug'>$categoryName</a></li>
";
                        }
                    ?>

				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#">LogOut</a></li>
				</ul>
			</div>
		</nav>