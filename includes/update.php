<?php
session_start();

$usr_pg = true;

if (isset($_SESSION['errors'])) $err = $_SESSION['errors'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Облновление</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>
<body>
    <?php require_once "navbar.php"; ?>
    <div class="container reg border-secondary"><br>
    <?php
    if (isset($err)) {
        echo '<p class="alert-danger">' . $err . '</p>';
        unset($err);
        unset($_SESSION['errors']);
    }
    ?><br>
        <form action="divarication.php" method="post">
            <p>Выберите часто посещаемое место №1</p>
            <div id="mapTwo" style="height: 400px; cursor: pointer;"></div><br>
            <input type="text" name="adres2" class="form-control" value="" placeholder="Автозаполнение"><br>
            <p>Выберите часто посещаемое место №2</p>
            <div id="mapThree" style="height: 400px; cursor: pointer;"></div><br>
            <input type="text" name="adres3" class="form-control" value="" placeholder="Автозаполнение"><br>
            <input type="hidden" name="loc_p" value="">
            <input type="hidden" name="loc2_p" value="">
            <input type="hidden" name="loc_p2" value="">
            <input type="hidden" name="loc2_p2" value="">
            <button type="submit" class="btn btn-success">Подтвердить</button><br><br>
        </form>
    </div>
    <script src="update.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>
</html>