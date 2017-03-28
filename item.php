<?php include 'includes/db.php';?>

<html>
	<head>
		<title>Product detail</title>
		
		<link rel="stylesheet" href="css/font-awesome.css">
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="css/style.css">
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<style>
			.btn {
				font-size: 40px;
				height: 70px;
			}
		</style>
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		<div class="container">
			<div class="row">
				<ol class="breadcrumb">
					<li><a href="index.php">Home</a></li>
                    <?php
                    if(isset($_GET['itemId'])) {
                        $query = "SELECT * FROM item WHERE item_id = '$_GET[itemId]' ";
                        $selectAll = mysqli_query($conn, $query);
                    while ($rows = mysqli_fetch_assoc($selectAll)) {

                            $itemId = $rows['item_id'];
                            $itemImage = $rows['item_image'];
                            $itemTitle = $rows['item_title'];
                            $itemDesc = $rows['item_desc'];
                            $itemQty = $rows['item_qty'];
                            $itemCost = $rows['item_cost'];
                            $itemPrice = $rows['item_price'];
                            $itemDiscount = $rows['item_discount'];
                            $itemCat = ucwords($rows['item_cat']);
                            $finalPrice = $itemPrice - $itemDiscount;
                        echo "
                            <li><a href='category.php?category=$itemCat'>$itemCat</a></li>
					        <li class='active'> $itemTitle</li>
                        
                        ";

                    ?>

				</ol>
			</div>
			<div class="row">
<?php


        echo "
        
			<div class='col-md-8'>
				<h3 class='pp-title'>$itemTitle</h3>
				<img src=$itemImage class='img-responsive'>
				<h4 class='pp-desc-head'>Description</h4>
				<div class='pp-desc-detail'>$itemDesc</div>
			</div>
        
        ";
    }

}
    ?>

			<aside class="col-md-4">
				
				<a href="buy.php" class="btn btn-success btn-lg btn-block">Buy</a>
				<br>
				<ul class="list-group">
					<li class="list-group-item">
						<div class="row">
							<div class="col-md-3"><i class="fa fa-truck fa-2x"></i></div>
							<div class="col-md-9">Delivered within 5 days</div>
						</div>
					</li>
					<li class="list-group-item">
						<div class="row">
							<div class="col-md-3"><i class="fa fa-refresh fa-2x"></i></div>
							<div class="col-md-9">Easy return in 7 days</div>
						</div>
					</li>
					<li class="list-group-item">
						<div class="row">
							<div class="col-md-3"><i class="fa fa-phone fa-2x"></i></div>
							<div class="col-md-9">Call at 123456789</div>
						</div>
					</li>
				</ul>
			</aside>
			</div>
			<div class="page-header">
				<h2>Related Items</h2>
			</div>
			<section class="row">
				<?php
                $relSql = "SELECT * FROM item ORDER BY rand() LIMIT 4";
                $relQuery = mysqli_query($conn, $relSql);
                while ($relRows = mysqli_fetch_assoc($relQuery)){
                    $discounted = $relRows['item_price'] - $relRows['item_discount'];
                    $itemId = $relRows['item_id'];
                    $itemTitle = str_replace(' ','-', $relRows['item_title']);
                    echo "
                            <div class='col-md-3'>
                            <div class='col-md-12  single-item noPadding'>
                                <div class='top'><img src='$relRows[item_image]'></div>
                                <div class='bottom'>
                                    <h3 class='item-title'><a href='item.php?itemId=$itemId&itemTitle=$itemTitle'>$itemTitle</a></h3>
                                    <div class='pull-right cutted-price text-muted'><del>$relRows[item_price]</del></div>
                                    <div class='clearfix'></div>
                                    <div class='pull-right discounted-price'>$discounted/=</div>
                                </div>
                            </div>
                        </div>
                    
                    
                    ";
                }

                ?>


			</section>
		</div><br><br><br><br><br>
		<?php include 'includes/footer.php'; ?>
	</body>
</html>