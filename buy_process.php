<?php
session_start();
include 'includes/db.php';
if (!isset($_SESSION['ref'])) {
    echo "Koszyk jest pusty";
} else {

    if (isset($_REQUEST['chk_del_id'])) {
        $chkDeleteSQL = "DELETE FROM checkout WHERE chk_id = '$_REQUEST[chk_del_id]'";
        $chkDeleteQuery = mysqli_query($conn, $chkDeleteSQL);
    }

    if (isset($_REQUEST['up_chk_qty'])) {

        $chkQtySQL = "UPDATE checkout SET chk_qty = '$_REQUEST[up_chk_qty]' WHERE chk_id = '$_REQUEST[up_chk_id]'";
        $chkQtyQuery = mysqli_query($conn, $chkQtySQL);
    }


    $quantity = 1;
    $i = 1;
    $total = 0;
    $delivery = 0;

//  $chkSelectSql = "SELECT * FROM checkout WHERE chk_ref = '$_SESSION[ref]' ";
    $chkSelectSql = "SELECT * FROM checkout c JOIN item i ON c.chk_item = i.item_id WHERE c.chk_ref = '$_SESSION[ref]' ";

    $chkSelectQuery = mysqli_query($conn, $chkSelectSql);
    while ($chkSelectRows = mysqli_fetch_assoc($chkSelectQuery)) {
        $discounted = $chkSelectRows['item_price'] - $chkSelectRows['item_discount'];
        $subTotal = $discounted * $chkSelectRows['chk_qty'];
        $total += $subTotal;
        $delivery += $chkSelectRows['item_delivery'];
        echo "
                    <tr>
                        <td>$quantity</td>
                        <td>$chkSelectRows[item_title]</td>"; ?>
        <td><input type='number' style='width: 45px;' min="1"
                   onblur="up_chk_qty(this.value, '<?php echo $chkSelectRows['chk_id']; ?>');"
                   value='<?php echo $chkSelectRows['chk_qty']; ?>'></td>
        <td>
            <button class='btn btn-danger btn-sm' onclick="del_func(<?php echo $chkSelectRows['chk_id']; ?>);">Usuń
            </button>
        </td>
        <?php echo "<td class='text-right'><b>$discounted</b></td>
                        <td class='text-right'><b>$subTotal</b></td>  
                    </tr>
                      ";
        $quantity++;

    }
    $_SESSION['grand_sum'] = $grandSum = $total + $delivery;

    echo "

            <table class='table'>
                <thead>
                    <tr>
                        <th class='text-center' colspan='2'>Podsumowanie zamówienia</th>
                    </tr>
                </thead>
                 <tbody>
                    <tr>
                        <td>Za towar</td>
                        <td class='text-right'><b>$total</b></td>
                    </tr>
                    <tr>
                        <td>Koszty przesyłki</td>
                        <td class='text-right'><b></b>$delivery</b></td>
                    </tr>
                    <tr>
                        <td>Całkowity koszt</td>
                        <td class='text-right'><b></b>$_SESSION[grand_sum]</b></td>
                    </tr>
                 </tbody>
                        </table>


";
}
?>