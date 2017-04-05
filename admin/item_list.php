<?php include '../includes/db.php'; ?>
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
    <script>tinymce.init({ selector:'textarea' });</script>
    <script>
        function get_item_list_data() {

            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if(xmlhttp.readyState == 4 && xmlhttp.status == 200){

                    document.getElementById('get_item_list_data').innerHTML = xmlhttp.responseText;
                }

            }
            xmlhttp.open('GET', 'item_list_process.php', true);
            xmlhttp.send();
        }
    </script>
</head>
<body onload="get_item_list_data();">
<?php include 'includes/header.php'; ?>
<div class="container">
    <button class="btn btn-primary" data-toggle="modal" data-backdrop="static" data-keybord="false"
            data-target="#add_new_item">Dodaj produkt</button>
    <!--MODAL-->
    <div id="add_new_item" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Dodaj produkt</h3>
                </div>
                <div class="modal-body">
                    <form action="" method="">
                        <div class="form-group">
                            <label for="image">Zdjęcie</label>
                            <input type="file" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nazwa produktu (tytuł)</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Opis produktu</label>
                            <textarea class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Kategoria</label>
                            <select name="" id="" class="form-control">
                                <option value="">Wybierz kategorie</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Ilość</label>
                            <input type="number" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Cena początkowa</label>
                            <input type="number" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Cena końcowa</label>
                            <input type="number" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Zniżka</label>
                            <input type="number" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Koszty przesyłki</label>
                            <input type="number" class="form-control">
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
<?php include 'includes/footer.php'; ?>
</body>
</html>