<?php include "../includes/db.php";?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lista produktów || Admin Panel</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/admin_style.css">
    <script src="jquery.js"></script>
    <script src="bootstrap.js"></script>
</head>
<body>
    <?php include "includes/header.php";?>

        <div class="container">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="admin-head">
                        <th>Lp</th>
                        <th>Zdjęćie</th>
                        <th>Nazwa produktu</th>
                        <th>Opis produktu</th>
                        <th>Kategoria</th>
                        <th>Ilość</th>
                        <th>Cena początkowa</th>
                        <th>Zniżka</th>
                        <th>Cena</th>
                        <th>Koszty przesyłki</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $selectSQL = "SELECT * FROM item";
                    $query = mysqli_query($conn, $selectSQL);
                    $quantity = 1;
                    foreach ($query as $row){
                        $itemTitle = $row['item_title'];
                        $itemImage = $row['item_image'];
                        $itemDesc = $row['item_desc'];
                        $itemCategory = $row['item_cat'];
                        $itemQty = $row['item_qty'];
                        $itemCost = $row['item_cost'];
                        $itemPrice = $row['item_price'];
                        $itemDiscount = $row['item_discount'];
                        $itemDelivery = $row['item_delivery'];
                        $discounted = $itemCost - $itemDiscount;

                        echo "
                            <tr>
                                <td>$quantity</td>
                                <td><img width='100' src='../$itemImage'</td>
                                <td> $itemTitle</td>
                                <td>"; echo strip_tags($itemDesc); echo"</td>
                                <td>$itemCategory</td>
                                <td>$itemQty</td>
                                <td>$itemCost</td>
                                <td>$itemDiscount</td>
                                <td>$discounted</td>
                                <td>$itemDelivery</td>
                            </tr>
                        
                        
                        ";
                        $quantity++;
                    }

                ?>

                </tbody>
            </table>


        </div>
    <?php include "includes/footer.php";?>
</body>
</html>


<?php
