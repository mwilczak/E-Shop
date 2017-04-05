<?php include "../includes/db.php"; ?>
<?php

if (isset($_REQUEST['del_item_id'])) {

    $delItemSQL = "DELETE FROM item WHERE item_id = '$_REQUEST[del_item_id]'";
    $deleteQuery = mysqli_query($conn, $delItemSQL);
}

if (isset($_REQUEST['up_item_id'])) {

    $upTitle = mysqli_real_escape_string($conn, strip_tags($_REQUEST['up_title']));
    $upCategory = mysqli_real_escape_string($conn, strip_tags($_REQUEST['up_category']));
    $upDesc = mysqli_real_escape_string($conn, $_REQUEST['up_desc']);
    $upQty = mysqli_real_escape_string($conn, strip_tags($_REQUEST['up_qty']));
    $upCost = mysqli_real_escape_string($conn, strip_tags($_REQUEST['up_cost']));
    $upPrice = mysqli_real_escape_string($conn, strip_tags($_REQUEST['up_price']));
    $upDiscount = mysqli_real_escape_string($conn, strip_tags($_REQUEST['up_discount']));
    $upDelivery = mysqli_real_escape_string($conn, strip_tags($_REQUEST['up_delivery']));
    $item_id = $_REQUEST['up_item_id'];

    $updateItemSQL = "UPDATE item SET item_title = '$upTitle', item_desc = '$upDesc', item_cat = '$upCategory',
                     item_qty = '$upQty', item_cost = $upCost, item_price = '$upPrice', item_discount = '$upDiscount',
                      item_delivery = '$upDelivery' WHERE item_id = '$item_id' ";

    $updateItemQuery = mysqli_query($conn, $updateItemSQL);

    if(!$updateItemQuery) {
        die("QUERY FAILED" . " " . mysqli_error($conn));
    }


}

?>


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
        $itemId = $row['item_id'];
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

        echo "<tr>
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
                                                   <li>
                                                   <a href='#edit_modal' data-toggle='modal'>Edytuj</a>      
                                                   </li>"; ?>
                    <li><a href="javascript:;" onclick="delete_item_list(<?php echo $itemId; ?>);">Usuń</a></li>
                    <?php echo " </ul>
                                        </div>
    
                <div class='modal fade' id='edit_modal'>
                   <div class='modal-dialog'>
                      <div class='modal-content'>
                         <div class='modal-header'>
                                <button class='close' data-dismiss='modal'>&times;</button>
                                <h3 class='modal-title'>Dodaj produkt</h3>
                         </div>
                            <div class='modal-body'>
                               <div id='form1'>
                                   
                                    <div class='form-group'>
                                        <label>Nazwa produktu (tytuł)</label>
                                        <input type='text' id='up_title' class='form-control' value='$itemTitle'required>
                                    </div>
                                    <div class='form-group'>
                                        <label>Opis produktu</label>
                                        <textarea class='form-control' id='up_desc' value='$itemDesc' required></textarea>
                                    </div>
                                    <div class='form-group'>
                                        <label>Kategoria</label>
                                        <select id='up_category' class='form-control' required>
                                            <option>Wybierz kategorie</option> ";


                                    $catSQL = "SELECT * FROM category";
                                    $query = mysqli_query($conn, $catSQL);
                                    foreach ($query as $rowsCat) {
                                        $catName = ucwords($rowsCat['cat_name']);
                                        $catSlug = $rowsCat['cat_slug'];
                                        if ($catSlug == '') {
                                            $catSlug = $catName;
                                        } else {
                                            $catSlug = $catSlug;
                                        }
                                        if ($catSlug == $itemCategory) {
                                            echo "<option selected value='$catSlug'>$catName</option>";

                                        }else {
                                            echo "
                                                <option value=$catSlug>$catName</option>
                                                ";
                                        }
                                    }

                                    echo "</select>
                                        </div>
                                        <div class='form-group'> 
                                            <label>Ilość</label>
                                            <input type='number' id='up_qty' value='$itemQty' class='form-control' required>
                                        </div>
                                        <div class='form-group'>
                                            <label for=>Cena początkowa</label>
                                            <input type='number' id='up_cost' value='$itemCost' class='form-control'>
                                        </div>
                                        <div class='form-group'>
                                            <label>Cena końcowa</label>
                                            <input type='number' id='up_price' value='$itemPrice' class='form-control' required>
                                        </div>
                                        <div class='form-group'>
                                            <label>Zniżka</label>
                                            <input type='number' id='up_discount' value='$itemDiscount' class='form-control'>
                                        </div>
                                        <div class='form-group'>
                                            <label>Koszty przesyłki</label>
                                            <input type='number' id='up_delivery' value='$itemDelivery' class='form-control' required>
                                        </div>
                                        <div class='form-group'>
                                            <input type='hidden' id='up_item_id' value='$itemId'>"; ?>
                                            <button onclick="edit_item_list();" class='btn btn-success btn-block'>Update</button>
                                        </div>
                
                               </div>
                            </div>
                                    <div class='modal-footer'>
                                    <button class='btn btn-danger' data-dismiss='modal'>Close</button>
                                    </div>
                      </div>
                   </div>
                </div>
                                             <!--END EDIT MODAL-->
                                        </div>
                         
                                </td>   
                               
                            </tr>

        <?php
        $quantity++;
    }
    ?>

    </tbody>
</table>
