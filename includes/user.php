<?php
session_start();
require_once '../database.php';

$usr_pg = true;

$sql = "SELECT * FROM `danger_places` ORDER BY `id` DESC";
$dg_places = mysqli_query($connection, $sql);

if (isset($_SESSION['success-update']) and $_SESSION['success-update']) $status_update = $_SESSION['status-update'];
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $user_info = $_SESSION['user-info'];
    if (isset($_SESSION['danger-place'])) {
            $danger = $_SESSION['danger-place'];
            if (isset($_SESSION['dg'])) $dg = $_SESSION['dg'];
        }
    if (isset($_SESSION['danger-place2'])) {
            $danger2 = $_SESSION['danger-place2'];
            if (isset($_SESSION['dg2'])) $dg2 = $_SESSION['dg2'];
        }
    if (isset($dg) and isset($dg2)) {
        $message = 'Оставайтесь дома и никуда не выходите';
    }
}

$num_rows = mysqli_num_rows($dg_places);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ваша страница</title>
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />

    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
<?php require 'navbar.php'; ?><br>
    <?php if ($user) { ?>
    <div class="container"><br><br>
    <?php
    if (isset($status_update)) {
        switch ($status_update) {
            case 1:
                $print = 'Положительный результат тестирования';
                break;
            case 2:
                $print = 'Отрицательный результат тестирования';
                break;
            case 3:
                $print = 'Ожидание результатов тестирования';
                break;
            case 4:
                $print = 'Был в контакте с подтвержденным случаем';
                break;
            case 5:
                $print = 'Был в контакте с потенциальным носителем вируса';
                break;
        }
        echo '<p class="alert-success"> Удачно обновлен статус на ' . $print . '</p>';
        $_SESSION['success-update'] = false;
        unset($_SESSION['success-update']);
        unset($_SESSION['status-update']);
        unset($status_update);
    }
    ?>

        <form action="divarication.php" method="post">
            <input name="reset" type="submit" class="btn btn-warning" value="Выйти">
        </form><br>
        <span>Что делать?   </span><button class="instruction btn btn-primary">Не отображается карта</button><br><br>
        <div class="instruction_body"></div>
        <?php
        if (isset($dg)) {
            if (isset($dg)) echo '<p class="alert-danger">Часто посещаемое место №1 стало опасно в связи с повышеным риском забольевания по адресу ' . $danger . '</p><br>';
        }
        if (isset($dg2)) {
            if (isset($dg2)) echo '<p class="alert-danger">Часто посещаемое место №2 стало опасно в связи с повышеным риском забольевания по адресу ' . $danger2 . '</p><br>';
        }
        if (isset($message)) echo '<p class="alert-danger">' . $message . ' </p><br>';
        ?>
        <div class="description">
            <p><img src="../blue.png" height="15px" alt=""> - Место жительства</p>
            <p><img src="../red.png" height="15px" alt=""> - Положительный результат тестирования</p>
            <p><img src="../orange.png" height="15px" alt=""> - Отрицательный результат тестирования, <br>Ожидание результатов тестирования, <br>Был в контакте с подтвержденным случаем</p>
        </div><br>
        <div id="map" style="height: 500px;"></div><br>
        <p>Чтобы построить маршрут выберите метки на карте</p>
        <div id="rout" style="height: 500px;"></div><br>
        <form action="divarication.php" method="post">
            <div class="title">
                <h1>Ваша учетная запись</h1>
                <h5>Изменить состояние</h5>
            </div><br>
            <div class="form-group">
                <p class="title">Ваше состояние</p>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="quantity_update" id="Radios1" value="1">
                    <label class="form-check-label" for="Radios1">
                        Положительный результат тестирования
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="quantity_update" id="Radios2" value="2">
                    <label class="form-check-label" for="Radios2">
                        Отрицательный результат тестирования
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="quantity_update" id="Radios3" value="3">
                    <label class="form-check-label" for="Radios3">
                        Ожидание результатов тестирования
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="quantity_update" id="Radios4" value="4">
                    <label class="form-check-label" for="Radios4">
                        Был в контакте с подтвержденным случаем
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="quantity_update" id="Radios5" value="5">
                    <label class="form-check-label" for="Radios5">
                        Был в контакте с потенциальным носителем вируса
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Подтвердить</button>
        </form><br><br>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script>
        $(".instruction").on('click', function(instuct) {
            $(".instruction_body").html("<div class=\"row d-flex justify-content-between\"><br><img class=\"border border-dark\" src=\"images/1.jpg\" width=\"40%\" alt=\"\"><img class=\"border border-dark\" src=\"images/2.jpg\" width=\"40%\" alt=\"\"></div><br><div class=\"row d-flex justify-content-between\"><br><img class=\"border border-dark\" src=\"images/3.jpg\" width=\"40%\" alt=\"\"><img class=\"border border-dark\" src=\"images/4.jpg\" width=\"40%\" alt=\"\"></div><br><div class=\"row d-flex justify-content-between\"><br><img class=\"border border-dark\" src=\"images/5.jpg\" width=\"40%\" alt=\"\"><img class=\"border border-dark\" src=\"images/6.jpg\" width=\"40%\" alt=\"\"></div><br>")
        });
        $(".instruction").off('click', function(instuct_off) {
            $(".instruction_body").html(" ");
        });
        navigator.geolocation.getCurrentPosition(
            function(position) {
                let lat = position.coords.latitude;
                let lng = position.coords.longitude;
                console.log(lat);
                console.log(lng);
                let home = L.icon({
                    iconUrl: '../blue.png',
                    iconSize: [10, 10],
                });
                let ile = L.icon({
                    iconUrl: '../red.png',
                    iconSize: [10, 10],
                });
                let risk = L.icon({
                    iconUrl: '../orange.png',
                    iconSize: [10, 10],
                });
                const usermap = L.map('map', {
                }).setView([lat, lng], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(usermap);
                let stat = '<?php echo $user_info['status']; ?>';
                let locat = '<?php echo $user_info['loc']; ?>';
                let locat2 = '<?php echo $user_info['loc2']; ?>';
                L.marker([locat, locat2], {icon: home}).addTo(usermap)
                    .bindPopup('Ваше место жительства')
                    .openPopup();
                if (stat == 1) {
                    let loc_p = '<?php echo $user_info['loc_p']; ?>';
                    let loc2_p = '<?php echo $user_info['loc2_p']; ?>';
                    L.marker([loc_p, loc2_p], {icon: ile}).addTo(usermap)
                        .bindPopup('Ваше часто посещаепое место №1 <br> <?php echo $user_info['place']; ?> <br> <?php if (isset($dg) and $dg) echo 'Это место стало опастно для вас есть риск заражения'; ?>')
                        .openPopup();
                    let loc_p2 = '<?php echo $user_info['loc_p2']; ?>';
                    let loc2_p2 = '<?php echo $user_info['loc2_p2']; ?>';
                    L.marker([loc_p2, loc2_p2], {icon: ile}).addTo(usermap)
                        .bindPopup('Ваше часто посещаепое место №2 <br> <?php echo $user_info['place2']; ?> <br> <?php if (isset($dg2) and $dg2) echo 'Это место стало опастно для вас есть риск заражения'; ?>')
                        .openPopup();
                } else {
                    let loc_p = '<?php echo $user_info['loc_p']; ?>';
                    let loc2_p = '<?php echo $user_info['loc2_p']; ?>';
                    L.marker([loc_p, loc2_p], {icon: risk}).addTo(usermap)
                        .bindPopup('Ваше часто посещаепое место №1 <br> <?php echo $user_info['place']; ?> <br> <?php if (isset($dg) and $dg) echo 'Это место стало опастно для вас есть риск заражения'; ?>')
                        .openPopup();
                    let loc_p2 = '<?php echo $user_info['loc_p2']; ?>';
                    let loc2_p2 = '<?php echo $user_info['loc2_p2']; ?>';
                    L.marker([loc_p2, loc2_p2], {icon: risk}).addTo(usermap)
                        .bindPopup('Ваше часто посещаепое место №2 <br> <?php echo $user_info['place2']; ?> <br> <?php if (isset($dg2) and $dg2) echo 'Это место стало опастно для вас есть риск заражения'; ?>')
                        .openPopup();
                }


                const route = L.map('rout', {}).setView([lat, lng], 13)
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(route)
                let circle
                let status
                let loc
                let loc2
                let adres
                <?php
                while ($danger_pl = mysqli_fetch_assoc($dg_places)) {
                ?>
                    loc = '<?php echo $danger_pl['loc']; ?>'
                    loc2 = '<?php echo $danger_pl['loc2']; ?>'
                    status = '<?php echo $danger_pl['status']; ?>'
                    adres = '<?php echo $danger_pl['adres']; ?>'
                    if (status == 4) {
                        circle = L.circle([loc, loc2], {
                            color: 'red',
                            fillColor: 'red',
                            fillOpacity: 0.5,
                            radius: 100
                        }).addTo(route);
                        circle.bindPopup(adres + '<br> Уровень опастности: очень высокий');
                    }
                    else if (status == 3) {
                        circle = L.circle([loc, loc2], {
                            color: 'orange',
                            fillColor: 'orange',
                            fillOpacity: 0.5,
                            radius: 100
                        }).addTo(route);
                        circle.bindPopup(adres + '<br> Уровень опастности: высокий');
                    }
                    else if (status == 2) {
                        circle = L.circle([loc, loc2], {
                            color: 'yellow',
                            fillColor: 'yellow',
                            fillOpacity: 0.5,
                            radius: 100
                        }).addTo(route);
                        circle.bindPopup(adres + '<br> Уровень опастности: средний');
                    }
                    if (status == 1) {
                        circle = L.circle([loc, loc2], {
                            color: 'green',
                            fillColor: 'green',
                            fillOpacity: 0.5,
                            radius: 100
                        }).addTo(route);
                        circle.bindPopup(adres + '<br> Уровень опастности: небольшой');
                    }
            <?php
            }
            ?>
                let location1
                let location2
                let polyline
                let marker
                function sendPost() {
                    if (location2 != null && location2 != undefined) {
                        if (polyline) {
                            route.removeLayer(polyline)
                        }
                        route.removeLayer(marker)
                        polyline = L.Routing.control({
                            waypoints: [
                                L.latLng(location1),
                                L.latLng(location2)
                            ],
                            routeWhileDragging: false,
                        }).addTo(route)
                    }
                }
                route.on('click', function(e) {
                    if (location1 === undefined) {
                        location1 = e.latlng
                        marker = new L.Marker(e.latlng).addTo(route)
                    }
                    else if (location2 === undefined) {
                        location2 = e.latlng
                        sendPost()
                    }
                })
                }
            );
            </script>
            <?php
            }
        unset($danger);
        unset($danger2);
        ?>
</body>

</html>
