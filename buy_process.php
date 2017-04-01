<?php
session_start();
include 'includes/db.php';

    if(isset($_REQUEST['chk_del_id'])){
        $chkDeleteSQL = "DELETE FROM checkout WHERE chk_id = '$_REQUEST[chk_del_id]'";
        $chlDeleteQuery = mysqli_query($conn, $chkDeleteSQL);
    }


        $quantity = 1;
        //  $chkSelectSql = "SELECT * FROM checkout WHERE chk_ref = '$_SESSION[ref]' ";
        $chkSelectSql = "SELECT * FROM checkout c JOIN item i ON c.chk_item = i.item_id ";
        $chkSelectSql .= "WHERE c.chk_ref = '$_SESSION[ref]' ";
        $chkSelectQuery = mysqli_query($conn, $chkSelectSql);
        while ($chkSelectRows = mysqli_fetch_assoc($chkSelectQuery)){
            $discounted = $chkSelectRows['item_price'] - $chkSelectRows['item_discount'];
            echo "
                    <tr>
                        <td>$quantity</td>
                        <td>$chkSelectRows[item_title]</td>
                        <td>1</td>"; ?>
                        <td><button class='btn btn-danger btn-sm' onclick="del_func(<?php echo $chkSelectRows['chk_id'];?>);">Delete</button></td>
                        <?php echo "<td class='text-right'><b>$discounted</b></td>
                        <td class='text-right'><b>100/=</b></td>  
                    </tr>
                      ";
            $quantity++;

        }

?>