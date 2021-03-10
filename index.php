<?php
session_start();
require_once "database.php";

$home_pg = true;

$sql = "SELECT * FROM `danger_places` ORDER BY `id` DESC";
$dg_places = mysqli_query($connection, $sql);

$last_dat = mysqli_query($connection, $sql);

$last_date = mysqli_fetch_assoc($last_dat);
$_SESSION['date'] = $last_date['date'];
$date = $_SESSION['date'];

if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = false;
    $user = $_SESSION['user'];
} else {
    $user = $_SESSION['user'];
}

if (isset($_SESSION['message'])) $message = $_SESSION['message'];

if (isset($_GET['day'])) {
    $day = $_GET['day'];
    $sql = "SELECT * FROM `danger_places` WHERE `date` <= '$day'";
    $dg_places = mysqli_query($connection, $sql);
    unset($_GET['day']);
}

if (isset($_SESSION['search'])) 
    $search = $_SESSION['search'];

$num_rows = mysqli_num_rows($dg_places);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pandemic</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <?php require('includes/navbar.php'); ?>

    <div class="container">
    <?php
    if (isset($message)) {
        echo '<span class="alert-warning"> <strong>' . $message . '</strong></span>';
        unset($message);
        unset($_SESSION['message']);
    }
    ?>
        <br>
        <div class="row d-flex justify-content-between">
            <div class="form-inline time">
                <form class="mr-sm-2" action="" method="get">
                    <input class="btn btn-warning" type="date" name="day" id="date">
                    <button class="btn btn-warning" type="submit">Поиск</button>
                </form>
            </div>
            <?php
            if (!$user) {
            ?>
            <div class="sign">
                <span class="title">В зоне риска?</span>
                <a href="/includes/reg.php" class="btn btn-primary">Зарегистрироватся</a>
                <a href="/includes/auth.php" class="btn btn-success">Войти</a>
            </div>
            <?php
            }
            ?>
        </div><br>
        <div id="map"></div><br>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script>
        let pageHeight = document.documentElement.scrollHeight;
        pageHeight = pageHeight - 150;
        $("#map").css("height", pageHeight);
        let map = L.map('map').setView([56.8519000, 60.61200], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        let counter = '<?php echo $num_rows; ?>';
        let i = 0;
        let circle, status, loc, loc2, adres
        </script>
    <?php
    if (isset($day)) {
        while ($danger_pl = mysqli_fetch_assoc($dg_places)) {
            ?>
            <script>
                loc = '<?php echo $danger_pl['loc']; ?>';
                loc2 = '<?php echo $danger_pl['loc2']; ?>';
                status = '<?php echo $danger_pl['status']; ?>';
                adres = '<?php echo $danger_pl['adres']; ?>';
                if (status == 4) {
                    circle = L.circle([loc, loc2], {
                        color: 'red',
                        fillColor: 'red',
                        fillOpacity: 0.5,
                        radius: 100
                    }).addTo(map);
                    circle.bindPopup(adres + '<br> Уровень опастности: очень высокий');
                }
                else if (status == 3) {
                    circle = L.circle([loc, loc2], {
                        color: 'orange',
                        fillColor: 'orange',
                        fillOpacity: 0.5,
                        radius: 100
                    }).addTo(map);
                    circle.bindPopup(adres + '<br> Уровень опастности: высокий');
                }
                else if (status == 2) {
                    circle = L.circle([loc, loc2], {
                        color: 'yellow',
                        fillColor: 'yellow',
                        fillOpacity: 0.5,
                        radius: 100
                    }).addTo(map);
                    circle.bindPopup(adres + '<br> Уровень опастности: средний');
                }
                if (status == 1) {
                    circle = L.circle([loc, loc2], {
                        color: 'green',
                        fillColor: 'green',
                        fillOpacity: 0.5,
                        radius: 100
                    }).addTo(map);
                    circle.bindPopup(adres + '<br> Уровень опастности: небольшой');
                }
            </script>
        <?php
        }
        unset($day);
    } else {
        if (isset($search)) {
            ?>
            <script>
                loc = '<?php echo $search['loc']; ?>';
                loc2 = '<?php echo $search['loc2']; ?>';
                status = '<?php echo $search['status']; ?>';
                adres = '<?php echo $search['adres']; ?>';
                if (status == 4) {
                    circle = L.circle([loc, loc2], {
                        color: 'red',
                        fillColor: 'red',
                        fillOpacity: 0.5,
                        radius: 100
                    }).addTo(map);
                    circle.bindPopup(adres + '<br> Уровень опастности: очень высокий');
                }
                else if (status == 3) {
                    circle = L.circle([loc, loc2], {
                        color: 'orange',
                        fillColor: 'orange',
                        fillOpacity: 0.5,
                        radius: 100
                    }).addTo(map);
                    circle.bindPopup(adres + '<br> Уровень опастности: высокий');
                }
                else if (status == 2) {
                    circle = L.circle([loc, loc2], {
                        color: 'yellow',
                        fillColor: 'yellow',
                        fillOpacity: 0.5,
                        radius: 100
                    }).addTo(map);
                    circle.bindPopup(adres + '<br> Уровень опастности: средний');
                }
                if (status == 1) {
                    circle = L.circle([loc, loc2], {
                        color: 'green',
                        fillColor: 'green',
                        fillOpacity: 0.5,
                        radius: 100
                    }).addTo(map);
                    circle.bindPopup(adres + '<br> Уровень опастности: небольшой');
                }
            </script>
        <?php
        unset($search);
        unset($_SESSION['search']);
        } else {
            while ($danger_pl = mysqli_fetch_assoc($dg_places)) {
                ?>
                <script>
                    loc = '<?php echo $danger_pl['loc']; ?>';
                    loc2 = '<?php echo $danger_pl['loc2']; ?>';
                    status = '<?php echo $danger_pl['status']; ?>';
                    adres = '<?php echo $danger_pl['adres']; ?>';
                    if (status == 4) {
                        circle = L.circle([loc, loc2], {
                            color: 'red',
                            fillColor: 'red',
                            fillOpacity: 0.5,
                            radius: 100
                        }).addTo(map);
                        circle.bindPopup(adres + '<br> Уровень опастности: очень высокий');
                    }
                    else if (status == 3) {
                        circle = L.circle([loc, loc2], {
                            color: 'orange',
                            fillColor: 'orange',
                            fillOpacity: 0.5,
                            radius: 100
                        }).addTo(map);
                        circle.bindPopup(adres + '<br> Уровень опастности: высокий');
                    }
                    else if (status == 2) {
                        circle = L.circle([loc, loc2], {
                            color: 'yellow',
                            fillColor: 'yellow',
                            fillOpacity: 0.5,
                            radius: 100
                        }).addTo(map);
                        circle.bindPopup(adres + '<br> Уровень опастности: средний');
                    }
                    if (status == 1) {
                        circle = L.circle([loc, loc2], {
                            color: 'green',
                            fillColor: 'green',
                            fillOpacity: 0.5,
                            radius: 100
                        }).addTo(map);
                        circle.bindPopup(adres + '<br> Уровень опастности: небольшой');
                    }
                </script>
            <?php
            }
        }
    }
    ?>
</body>
</html>