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
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <script type="text/javascript" src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <link type="text/css" rel="stylesheet"  href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <script type="text/javascript" src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <script type="text/javascript" src="http://www.liedman.net/lrm-graphhopper/dist/lrm-graphhopper-1.2.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
<?php require 'navbar.php'; ?><br>
    <?php if ($user) { ?>
    <div class="container">
        <?php
        if (isset($status_update)) {
            $tmp = [
                'Положительный результат тестирования',
                'Отрицательный результат тестирования',
                'Ожидание результатов тестирования',
                'Был в контакте с подтвержденным случаем',
                'Был в контакте с потенциальным носителем вируса'];
            $print = $tmp[$status_update - 1];
            echo '<p class="alert-success"> Удачно обновлен статус на ' . $print . '</p>';
            $_SESSION['success-update'] = false;
            unset($_SESSION['success-update']);
            unset($_SESSION['status-update']);
            unset($status_update);
        }
        ?>
        <form action="divarication.php" method="post">
            <div class="title">
                <h3>Ваша учетная запись</h3>
                <h5>Изменить состояние</h5>
            </div>
            <div class="form-group">
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
        </form><br>
        <a href="update.php" class="btn btn-primary">Изменить геолкацию</a>
        <br><br>
        <?php
        if (isset($dg)) {
            if (isset($dg)) echo '<p class="alert-danger">Часто посещаемое место №1 стало опасно в связи с повышеным риском забольевания по адресу ' . $danger . '</p>';
        }
        if (isset($dg2)) {
            if (isset($dg2)) echo '<p class="alert-danger">Часто посещаемое место №2 стало опасно в связи с повышеным риском забольевания по адресу ' . $danger2 . '</p>';
        }
        if (isset($message)) echo '<p class="alert-danger">' . $message . ' </p>';
        ?>
        <div class="description">
            <p><img src="images/blue.png" height="15px" alt=""> - Место жительства</p>
            <p><img src="images/red.png" height="15px" alt=""> - Положительный результат тестирования</p>
            <p><img src="images/orange.png" height="15px" alt=""> - Отрицательный результат тестирования, <br>Ожидание результатов тестирования, <br>Был в контакте с подтвержденным случаем</p>
        </div><br>
        <p>Чтобы построить маршрут выберите метки на карте</p>
        <div id="map" style="height: 700px;"></div><br>
        <div class="row">
            <form class="col-6" action="divarication.php" method="post">
                <input name="reset" type="submit" class="btn btn-warning" value="Выйти">
            </form>
            <div class="col-6">
                <span>Что делать?   </span><button class="instruction btn btn-primary">Не отображается карта</button><br><br>
                <div class="instruction_body"></div>
            </div>
        </div><br><br>
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
                let home = L.icon({
                    iconUrl: 'images/blue.png',
                    iconSize: [15, 15],
                });
                let ile = L.icon({
                    iconUrl: 'images/red.png',
                    iconSize: [15, 15],
                });
                let risk = L.icon({
                    iconUrl: 'images/orange.png',
                    iconSize: [15, 15],
                });
                const usermap = L.map('map').setView([56.8519000, 60.6122000], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(usermap);
                let circle, status, loc, loc2, adres
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
                        }).addTo(usermap);
                        circle.bindPopup(adres + '<br> Уровень опастности: очень высокий');
                    }
                    else if (status == 3) {
                        circle = L.circle([loc, loc2], {
                            color: 'orange',
                            fillColor: 'orange',
                            fillOpacity: 0.5,
                            radius: 100
                        }).addTo(usermap);
                        circle.bindPopup(adres + '<br> Уровень опастности: высокий');
                    }
                    else if (status == 2) {
                        circle = L.circle([loc, loc2], {
                            color: 'yellow',
                            fillColor: 'yellow',
                            fillOpacity: 0.5,
                            radius: 100
                        }).addTo(usermap);
                        circle.bindPopup(adres + '<br> Уровень опастности: средний');
                    }
                    if (status == 1) {
                        circle = L.circle([loc, loc2], {
                            color: 'green',
                            fillColor: 'green',
                            fillOpacity: 0.5,
                            radius: 100
                        }).addTo(usermap);
                        circle.bindPopup(adres + '<br> Уровень опастности: небольшой');
                    }
                <?php
                }
                ?>
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
                let location1, location2, polyline, marker
                function sendPost() {
                    if (location2 != null && location2 != undefined) {
                        if (polyline) {
                            usermap.removeLayer(polyline)
                        }
                        usermap.removeLayer(marker)
                        polyline = L.Routing.control({
                            waypoints: [
                                L.latLng(location1),
                                L.latLng(location2)
                            ],
                            showAlternatives: true,
                            altLineOptions: {styles: [{color: 'white', opacity: 0.9, weight: 9},{color: '#960800FF', opacity: 1, weight: 5}]},
                            lineOptions: {
                                styles: [{color: 'white', opacity: 0.9, weight: 9},{color: '#4000FFFF', opacity: 1, weight: 5}]
                            },
                            router: L.Routing.graphHopper('641393f2-84a1-4d30-a186-9c3278155c49', {
                                urlParameters: {
                                    vehicle: 'foot'
                                }
                            }),
                            usermapWhileDragging: false,
                        }).addTo(usermap)
                    }
                }
                usermap.on('click', function(e) {
                    if (location1 === undefined) {
                        location1 = e.latlng
                        marker = new L.Marker(e.latlng).addTo(usermap)
                    }
                    else if (location2 === undefined) {
                        location2 = e.latlng
                        sendPost()
                    }
                })
            </script>
            <?php
            }
        unset($danger);
        unset($danger2);
        ?>
</body>

</html>
