<?php
session_start();
if (isset($_SESSION['user'])) $user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Краудсорсинг здоровья</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <style>
        html, body{
            height: 97%;
        }

        .container-fluid, .row, #map {
            height: 98%;
        }
    </style>
</head>
<body>
    <?php require('includes/navbar.php'); ?>

    <div class="container-fluid">
        <br>
        <div class="row">
            <div class="map col-9" id="map"></div>
            <div class="sidebar col-3">
            <?php
            if (!$user) {
                ?>
                <div class="sign jusyfy-content-center">
                    <div class="title"><h3>В зоне риска?</h3></div>
                    <a href="/includes/reg.php" class="btn btn-primary">Зарегистрироватся</a><br><br>
                    <a href="/includes/divarication.php" class="btn btn-success">Войти</a>
                </div>
                <?php
                } else { ?>
                <style>
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
                <div class="description">
                    <p><img src="blue.png" height="15px" alt=""> - Место жительства</p>
                    <p><img src="red.png" height="15px" alt=""> - Положительный результат тестирования</p>
                    <p><img src="orange.png" height="15px" alt=""> - Отрицательный результат тестирования, <br>Ожидание результатов тестирования, <br>Был в контакте с подтвержденным случаем</p>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script>
        let map = L.map('map').setView([56.8519000, 60.6122000], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
    </script>
</body>
</html>