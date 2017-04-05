<?php include '../includes/db.php'; ?>

<?php
if (isset($_POST['submit'])) {

    $title = mysqli_real_escape_string($conn, strip_tags($_POST['title']));
    $category = mysqli_real_escape_string($conn, strip_tags($_POST['category']));
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);
    $qty = mysqli_real_escape_string($conn, strip_tags($_POST['qty']));
    $cost = mysqli_real_escape_string($conn, strip_tags($_POST['cost']));
    $price = mysqli_real_escape_string($conn, strip_tags($_POST['price']));
    $discount = mysqli_real_escape_string($conn, strip_tags($_POST['discount']));
    $delivery = mysqli_real_escape_string($conn, strip_tags($_POST['delivery']));

    if (isset($_FILES['image']['name'])) {
        $fileName = $_FILES['image']['name'];
        $pathAddressFile = "../images/items/$fileName";
        $pathAddressFileDB = "images/items/$fileName";
        $imgConfirm = 1;
        $fileType = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        if ($_FILES['image']['size'] > 400000) {
            $imgConfirm = 0;
            echo "Wybierz zdjęcie o mniejszym rozmiarze";
        }
        if ($fileType != 'jpg' && $fileType != 'png' && $fileType != 'gif') {
            $imgConfirm = 0;
            echo "Zły typ pliku (do wyboru .jpg, .png lub .gif)";
        }
        if ($imgConfirm == 0) {

        } else {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $pathAddressFile)) {
                $itemsInsSQL = "INSERT INTO item (item_image, item_title, item_desc, item_cat, 
                                                  item_qty, item_cost, item_price, item_discount, item_delivery)
                                VALUES ('$pathAddressFileDB', '$title', '$desc', '$category', '$qty', '$cost', 
                                        '$price', '$discount', '$delivery')";
                $itemsQuery = mysqli_query($conn, $itemsInsSQL);
                if (!$itemsQuery) {

                    die("QUERY FAILED" . " " . mysqli_error($conn));
                }
            }
        }
    }

}

?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">

    <title>Lista produktów</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/admin_style.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>tinymce.init({selector: 'textarea'});</script>
    <script>
        function get_item_list_data() {

            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                    document.getElementById('get_item_list_data').innerHTML = xmlhttp.responseText;
                }

            }
            xmlhttp.open('GET', 'item_list_process.php', true);
            xmlhttp.send();
        }
        function delete_item_list(item_id) {
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById('get_item_list_data').innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open('GET', 'item_list_process.php?del_item_id='+item_id, true);
            xmlhttp.send();
        }
        function edit_item_list(item_id) {


                    item_id = document.getElementById('up_item_id').value;
                    item_title = document.getElementById('up_title').value;
                    item_desc = document.getElementById('up_desc').value;
                    item_category = document.getElementById('up_category').value;
                    item_qty = document.getElementById('up_qty').value;
                    item_cost = document.getElementById('up_cost').value;
                    item_price = document.getElementById('up_price').value;
                    item_discount = document.getElementById('up_discount').value;
                    item_delivery = document.getElementById('up_delivery').value;

            xmlhttp.open('GET', 'item_list_process.php?up_item_id='+item_id+'&up_title='+item_title+'&up_desc='+item_desc+'&up_category='+item_category+'&up_qty='+item_qty+'&up_cost='+item_cost+'&up_price='+item_price+'&up_discount='+item_discount+'&up_delivery='+item_delivery, true);
            xmlhttp.send();
        }

    </script>
</head>
<body onload="get_item_list_data();">
<?php include 'includes/header.php'; ?>
<div class="container">
    <button class="btn btn-primary" data-toggle="modal" data-backdrop="static" data-keybord="false"
            data-target="#add_new_item">Dodaj produkt
    </button>
    <!--MODAL-->
    <div id="add_new_item" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Dodaj produkt</h3>
                </div>
                <div class="modal-body">
                    <form  method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="image">Zdjęcie</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nazwa produktu (tytuł)</label>
                            <input type="text" name="title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Opis produktu</label>
                            <textarea class="form-control" name="desc"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Kategoria</label>
                            <select name="category" class="form-control">
                                <option value="watches">Wybierz kategorie</option>
                                <?php
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
                                    echo "                    
                                            <option value=$catSlug>$catName</option>
                                            ";

                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Ilość</label>
                            <input type="number" name="qty" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Cena początkowa</label>
                            <input type="number" name="cost" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Cena końcowa</label>
                            <input type="number" name="price" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Zniżka</label>
                            <input type="number" name="discount" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Koszty przesyłki</label>
                            <input type="number" name="delivery" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-success btn-block" value="Dodaj produkt">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--END MODAL-->

    <div id="get_item_list_data">

        <!--Proces item list data ajax-->

    </div>
</div>

<div class="clearfix"></div>
</body>
<?php include 'includes/footer.php'; ?>

</html>