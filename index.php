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

if (isset($_SESSION['day'])) {
    $day = $_SESSION['day'];
    if ($day == 'yesterday') {
        $sql = "SELECT * FROM `danger_places` WHERE `date` <= subdate(now(),1) AND `date` > subdate(now(),2)";
        $date1 = date_create($date);
        date_modify($date1, '-1 day');
        $date1 = date_format($date1, 'Y-m-d');
        $sql = "SELECT * FROM `danger_places` WHERE `date` <= '$date1'";
        $dg_places_date1 = mysqli_query($connection, $sql);
    }
    elseif ($day == 'twodaysago') {
        $date2 = date_create($date);
        date_modify($date2, '-2 day');
        $date2 = date_format($date2, 'Y-m-d');
        $sql = "SELECT * FROM `danger_places` WHERE `date` <= '$date2'";
        $dg_places_date2 = mysqli_query($connection, $sql);
    }
}


$num_rows = mysqli_num_rows($dg_places);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Краудсорсинг здоровья</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <!-- <style>
        html, body{
            height: 97%;
        }

        .container-fluid, .row, #map {
            height: 98%;
        }
    </style> -->
</head>
<body>
    <?php require('includes/navbar.php'); ?>

    <div class="container-fluid">
    <?php
    if (isset($message)) echo '<p class="alert-warning">' . $message . '</p>';
    ?>
        <div class="row d-flex justify-content-between menu">
            <div class="form-inline time">
                <form class="day_form" action="/includes/divarication.php" method="get">
                    <input class="btn btn-secondary" type="submit" name="day" value="Пред предпоследнее добавление"><span>  </span>
                </form>
                <form class="day_form" action="/includes/divarication.php" method="get">
                    <input class="btn btn-secondary" type="submit" name="day" value="Предпоследнее добавление"><span>  </span>
                </form>
                <form class="day_form" action="/includes/divarication.php" method="get">
                    <input class="btn btn-secondary" type="submit" name="day" value="Сейчас"><span>  </span>
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
            }?>
            <style>
                .menu {
                    padding-top: 10px;
                    padding-bottom: 10px;
                }
                .title {
                    font-size: 25px;
                }
                .day_form {
                    margin: 5px;
                }
                .description {
                    list-style: none;
                    margin: 0;
                }
                .home, .il, .risk {
                    height: 15px;
                    width: 15px;
                    border-radius: 50%;
                }
                .home {
                    background-color: blue;
                }
                .il {
                    background-color: red;
                }
                .risk {
                    background-color: orangered;
                }
                span{
                    color: black;
                }
            </style>
        </div>
        <div id="map"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script>

        let pageWidth = document.documentElement.scrollWidth;
        let pageHeight = document.documentElement.scrollHeight;
        pageHeight = pageHeight - 100;
        // if (pageWidth <= 980) {
        //     let row = document.getElementById('row');
        //     let map_class = document.getElementById('map');
        //     let sidebar_class = document.getElementById('sidebar');
        //     row.classList.toggle("row");
        //     map_class.classList.toggle("order-1");
        //     map_class.classList.toggle("col-9");
        //     map_class.classList.toggle("col");
        //     sidebar_class.classList.toggle("order-2");
        //     sidebar_class.classList.toggle("col");
        //     sidebar_class.classList.toggle("col-3");
        //     pageWidth = pageWidth - 50;
        //     pageHeight = pageHeight - 350;
        //     $(".row").css("padding", "10px");
        //     $("#map").css("height", pageHeight);
        //     $("#map").css("width", pageWidth);
        // }
        $("#map").css("height", pageHeight);
        console.log(pageWidth);
        console.log(pageHeight);

        let map = L.map('map').setView([56.8519000, 60.6122000], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        let counter = '<?php echo $num_rows; ?>';
        let i = 0;
    //     let home = L.icon({
    //         iconUrl: 'blue.png',
    //         iconSize: [10, 10],
    //     });
    //     let ile = L.icon({
    //         iconUrl: 'red.png',
    //         iconSize: [10, 10],
    //     });
    //     let risk = L.icon({
    //         iconUrl: 'orange.png',
    //         iconSize: [10, 10],
    //     });
        let circle;
        let status;
        let loc;
        let loc2;
        let adres;
        </script>
    <?php
    if (isset($day)) {
        if ($day == 'today') {
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
        elseif ($day == 'twodaysago') {
            while ($danger_pl = mysqli_fetch_assoc($dg_places_date2)) {
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
        elseif ($day == 'yesterday') {
            while ($danger_pl = mysqli_fetch_assoc($dg_places_date1)) {
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
    ?>
</body>
</html>
