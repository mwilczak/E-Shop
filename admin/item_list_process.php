<?php include "../includes/db.php"; ?>
<table class="table table-bordered table-striped">
    <thead>
    <tr class="admin-head">
        <th>Lp</th>
        <th>Zdjęcie</th>
        <th>Nazwa produktu</th>
        <th>Opis produktu</th>
        <th>Kategoria</th>
        <th>Ilość</th>
        <th>Cena początkowa</th>
        <th>Zniżka</th>
        <th>Cena</th>
        <th>Koszty przesyłki</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $selectSQL = "SELECT * FROM item";
    $query = mysqli_query($conn, $selectSQL);
    $quantity = 1;
    foreach ($query as $row) {
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
                                <td><img style='width:60px;' src='../$itemImage'</td>
                                <td>$itemTitle</td>
                                <td>";
        echo strip_tags($itemDesc);
        echo "</td>
                                <td>$itemCategory</td>
                                <td>$itemQty</td>
                                <td>$itemCost</td>
                                <td>$itemDiscount</td>
                                <td>$discounted</td>
                                <td>$itemDelivery</td>
                                <td>
                                    <div class='dropdown'>
                                       <button class='btn btn-danger dropdown-toggle'
                                       data-toggle='dropdown'>Actions<span class='caret'></span></button> 
                                       <ul class='dropdown-menu dropdown-menu-right'>
                                           <li><a href='#'>Edytuj</a></li>
                                           <li><a href='#'>Usuń</a></li>
                                       </ul>
                                    </div>
                                    

                                </td>   
                            </tr>
                        
                        
                        ";
        $quantity++;
    }

    ?>

    </tbody>
</table>
