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


    $chkSQL = "INSERT INTO checkout (chk_item, chk_ref, chk_timing, chk_qty) ";
    $chkSQL .= "VALUES ('$_GET[chk_item_id]', '$_SESSION[ref]', '$date', 1)";


    if(mysqli_query($conn, $chkSQL)){
        ?><script>window.location = "buy.php";</script>  <?php
    }
}

if(isset($_POST['order_submit'])){
        $name = mysqli_real_escape_string($conn, strip_tags($_POST['name']));
        $email = mysqli_real_escape_string($conn, strip_tags($_POST['email']));
        $tel = mysqli_real_escape_string($conn, strip_tags($_POST['tel']));
        $address = mysqli_real_escape_string($conn, strip_tags($_POST['address']));
        $state = mysqli_real_escape_string($conn, strip_tags($_POST['state']));


$orderInsSQL = "INSERT INTO orders (order_name, order_email, order_contact, order_state, order_delivery, order_checkout_ref, order_total)
                VALUES ('$name', '$email', '$tel','$state', '$address', '$_SESSION[ref]', '$_SESSION[grand_sum]')";

        $query = mysqli_query($conn, $orderInsSQL);
    if (!$query) {

        die("QUERY FAILED" ." ".  mysqli_error($conn));

    }
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
        <script>
            function ajax_func(){
                xmlhttp = new XMLHttpRequest();

                xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                        document.getElementById('buy_process').innerHTML = xmlhttp.responseText;
                    }
                }

                xmlhttp.open('GET', 'buy_process.php', true);
                xmlhttp.send();
            }

            function del_func(chk_id){
                xmlhttp.onreadystatechane = function() {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                        document.getElementById('buy_process').innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open('GET', 'buy_process.php?chk_del_id='+chk_id, true);
                xmlhttp.send();
            }
            function up_chk_qty(chk_qty, chk_id){
//                alert(chk_qty);
                xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                        document.getElementById('buy_process').innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open('GET', 'buy_process.php?up_chk_qty='+chk_qty+'&up_chk_id='+chk_id, true);
                xmlhttp.send();
            }
        </script>
	</head>
	<body onload="ajax_func();">
		<?php include 'includes/header.php'; ?>
		<div class="container">

			<div class="page-header">
				<h2 class="text-left">Koszyk</h2><p class="text-right"> <button class="btn btn-success" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false">Finaluzuj zamówienie</button></p>
				<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>
      <div class="modal-body">
  <form method="POST" action="#">
        <div class="group">
			<label>Imię i nazwisko</label>
			<input type="text" name="name"  class="form-control">
		</div>
		<div class="group">
			<label>Email</label>
			<input type="email" name="email" class="form-control">
		</div>
		<div class="group">
			<label>Numer telefonu</label>
			<input type="text" name="tel" class="form-control">
		</div>
        <div>
            <label for="address">Adres dostawy</label>
            <textarea name="address" class="form-control"></textarea>


        </div>
		<div class="group">
			<label>Województwo</label>
			<input list="state" name="state" class="form-control">
            <datalist id="state">
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
			<input type="submit" name="order_submit" class="btn btn-info btn-lg btn-block" value="Wyślij">
		</div>
  </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
      </div>
    </div>
  </div>
</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Szczegóły zamówienia</div>
				<div class="panel-body">
					<table class="table">
						<thead>
							<tr>
								<th>Lp.</th>
								<th>Produkt</th>
								<th>Ilość</th>
								<th width="5%">Akcja</th>
								<th class="text-right">Cena</th>
								<th class="text-right">Suma</th>

							</tr>
						</thead>
						<tbody id="buy_process">
                            <!--Buy process data-->

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <br><br><br><br><br>
        <?php include 'includes/footer.php'; ?>

    </body>
</html>