<?php
session_start();
include 'includes/db.php';

if(isset($_GET['chk_item_id'])){
        $date = date('Y-m-d h:i:s');
        $randNum = mt_rand();
if(isset($_SESSION['ref'])){



}else {
    $_SESSION['ref'] = $date.'_'.$randNum;

}

        $chkSQL = "INSERT INTO checkout (chk_item, chk_ref, chk_timing) ";
        $chkSQL .= "VALUES ('$_GET[chk_item_id]', '$_SESSION[ref]', '$date')";

        $query = mysqli_query($conn, $chkSQL);

}
?>


<html>
	<head>
		<title>Koszyk</title>
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="css/font-awesome.css">
		<link rel="stylesheet" href="css/style.css">
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		<div class="container">
		
			<div class="page-header">
				<h2 class="text-left">Checkout</h2><p class="text-right"> <button class="btn btn-success" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false">Proceed Button</button></p>
				<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
     
      </div>
      <div class="modal-body">
        <div class="group">
			<label>Imię i nazwisko</label>
			<input type="text"  class="form-control">
		</div>
		<div class="group">
			<label>Email</label>
			<input type="text" class="form-control">
		</div>
		<div class="group">
			<label>Numer telefonu</label>
			<input type="text" class="form-control">
		</div>
        <div>
            <label for="address">Adres dostawy</label>
            <textarea class="form-control"></textarea>


        </div>
		<div class="group">
			<label>Województwo</label>
			<input list="states" class="form-control">
            <datalist id="states">
                <option>dolnośląskie</option>
                <option>kujawsko-pomorskie</option>
                <option>lubelskie</option>
                <option>lubuskie</option>
                <option>łódzkie</option>
                <option>małopolskie</option>
                <option>mazowieckie</option>
                <option>opolskie</option>
                <option>podkarpackie</option>
                <option>podlaskie</option>
                <option>pomorskie</option>
                <option>śląskie</option>
                <option>świętokrzyskie</option>
                <option>warmińsko-mazurskie</option>
                <option>wielkopolskie</option>
                <option>zachodnio-pomorskie</option>

            </datalist>

		</div>

		<div class="group">
			<label></label>
			<input type="button" class="btn btn-info btn-lg btn-block" value="Submit">
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
			</div>
			
			<div class="panel panel-default">
				<div class="panel-heading">Order Detail</div>
				<div class="panel-body">
					<table class="table">
						<thead>
							<tr>
								<th>S.no</th>
								<th>Item</th>
								<th>qty</th>
								<th width="5%">Delete</th>
								<th class="text-right">Price</th>
								<th class="text-right">Total</th>
								
							</tr>
						</thead>
						<tbody>

                            <?php
                                 $quantity = 1;
//                                 $chkSelectSql = "SELECT * FROM checkout WHERE chk_ref = '$_SESSION[ref]' ";
                                 $chkSelectSql = "SELECT * FROM checkout c JOIN item i ON c.chk_item = i.item_id ";
                                 $chkSelectSql .= "WHERE c.chk_ref = '$_SESSION[ref]' ";
                                 $chkSelectQuery = mysqli_query($conn, $chkSelectSql);
                                 while ($chkSelectRows = mysqli_fetch_assoc($chkSelectQuery)){
                                     $discounted = $chkSelectRows['item_price'] - $chkSelectRows['item_discount'];
                                     echo "
                                        <tr>
                                            <td>$quantity</td>
                                            <td>$chkSelectRows[item_title]</td>
                                            <td>1</td>
                                            <td><button class='btn btn-danger btn-sm'>Delete</button></td>
                                            <td class='text-right'><b>$discounted</b></td>
                                            <td class='text-right'><b>100/=</b></td>  
                                        </tr>
                                          ";
                                     $quantity++;

                                 }

                            ?>

						</tbody>
					</table>
					<table class="table">
						<thead>
							<tr>
								<th class="text-center" colspan="2">Order Summary</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Subtotal</td>
								<td class="text-right"><b>700/=</b></td>
							</tr>
							<tr>
								<td>Delivery Charges</td>
								<td class="text-right"><b>Free</b></td>
							</tr>
							<tr>
								<td>Grand Total</td>
								<td class="text-right"><b>700/=</b></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<br><br><br><br><br>
		<?php include 'includes/footer.php'; ?>
	</body>
</html>