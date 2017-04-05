<?php include 'includes/db.php'; ?>
<html>
<head>
    <title>Online Shopping</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
</head>
<body>
<?php include 'includes/header.php'; ?>
<div class="container">
    <div class="row">
        <?php
        if (isset($_GET['category'])) {
        }
        $query = "SELECT * FROM item WHERE item_cat = '$_GET[category]'";
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
            $finalPrice = $itemPrice - $itemDiscount;
            echo "
                          <div class='col-md-3'>
                            <div class='col-md-12  single-item noPadding'>
                            <div class='top'><img src=$itemImage></div>
                            <div class='bottom'>
                                   <h3 class='item-title'><a href='item.php?itemId=$itemId&itemTitle=$itemTitle'>$itemTitle</a></h3>
                                   <div class='pull-right cutted-price text-muted'><del>$itemPrice</del></div>
                                   <div class='clearfix'></div>
                                   <div class='pull-right discounted-price'>$finalPrice</div>
                            </div>
                            </div>
                          </div>
                                 
                         ";
        }


        ?>


    </div>
</div>

<div class="clearfix"></div>
</body>
<?php include 'includes/footer.php'; ?>

</html>