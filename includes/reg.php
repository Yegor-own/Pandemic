<?php

require_once "../db.php";

session_start();
$auth = mysqli_fetch_assoc($users);
// это проверка регистрации
if (isset($_POST['reg_login']) and
    isset($_POST['reg_password']) and
    isset($_POST['adres']) and
    isset($_POST['adres2']) and
    isset($_POST['quantity']) and
    isset($_POST['location1']) and
    isset($_POST['location2']) and
    isset($_POST['location1_p']) and
    isset($_POST['location2_p']) and
    isset($_POST['adres3']) and
    isset($_POST['location1_p2']) and
    isset($_POST['location2_p2'])) {
    if (!empty($_POST['reg_login']) and
        !empty($_POST['reg_password']) and
        !empty($_POST['adres']) and
        !empty($_POST['adres2']) and
        !empty($_POST['quantity']) and
        !empty($_POST['location1']) and
        !empty($_POST['location2']) and
        !empty($_POST['location1_p']) and
        !empty($_POST['location2_p']) and
        !empty($_POST['adres3']) and
        !empty($_POST['location1_p2']) and
        !empty($_POST['location2_p2'])) {
        $sign =  "INSERT INTO `users` (`login`, `password`, `status`, `home`, `loc`, `loc2`, `place`, `loc_p`, `loc2_p`, `place2`, `loc_p2`, `loc2_p2`) VALUES ('".$_POST['reg_login']."',
                                                                                                                                        '".$_POST['reg_password']."',
                                                                                                                                        '".$_POST['quantity']."',
                                                                                                                                        '".$_POST['adres']."',
                                                                                                                                        '".$_POST['location1']."',
                                                                                                                                        '".$_POST['location2']."',
                                                                                                                                        '".$_POST['adres2']."',
                                                                                                                                        '".$_POST['location1_p']."',
                                                                                                                                        '".$_POST['location2_p']."',
                                                                                                                                        '".$_POST['adres3']."',
                                                                                                                                        '".$_POST['location1_p2']."',
                                                                                                                                        '".$_POST['location2_p2']."')";
        if ($_POST['reg_login'] != $auth['login']) {
            //mysqli_query($connection, "INSERT INTO `cameras` (`addres`, `location`, `location2`, `descr`, `owner`) VALUES ('".$_POST['adres']."','".$_POST['location1']."', '".$_POST['location2']."', '".$_POST['quantity']."', '".$_POST['ownr']."')") 
            if(mysqli_query($connection, $sign)) {
                $_SESSION['login'] = $_POST['reg_login'];
                $_SESSION['pass'] = $_POST['reg_password'];
                $_SESSION['user'] = true;
                $user = $_SESSION['user'];
            } else {
                $errors = true;
            }
        }
    } else {
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>
<body>
    <div class="container reg border-secondary"><br><br>
    <?php
    if (!isset($user)) {
    ?>
        <form action="reg.php" method="post">
            <div class="title">
                <h1>Зарегестрироваться</h1>
            </div>
            <div class="form-group">
                <label for="login">Ваш Логин</label>
                <input name="reg_login" type="text" value="" class="form-control" id="login" placeholder="Введите Login">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input name="reg_password" type="password" value="" class="form-control" id="password" placeholder="Введите пароль">
            </div>
            <p>Выберите место жительства</p>
            <div id="mapOne" style="height: 400px; cursor: pointer;"></div><br>
            <input type="text" name="adres" class="form-control" value="" placeholder="Автозаполнение"><br>
            <p>Выберите часто посещаемое место №1</p>
            <div id="mapTwo" style="height: 400px; cursor: pointer;"></div><br>
            <input type="text" name="adres2" class="form-control" value="" placeholder="Автозаполнение"><br>
            <p>Выберите часто посещаемое место №2</p>
            <div id="mapThree" style="height: 400px; cursor: pointer;"></div><br>
            <input type="text" name="adres3" class="form-control" value="" placeholder="Автозаполнение"><br>
            <div class="form-group">
                <p class="title">Ваше состояние</p>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="quantity" id="Radios1" value="1" checked>
                    <label class="form-check-label" for="Radios1">
                        Положительный результат тестирования
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="quantity" id="Radios2" value="2" checked>
                    <label class="form-check-label" for="Radios2">
                    Отрицательный результат тестирования
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="quantity" id="Radios3" value="3" checked>
                    <label class="form-check-label" for="Radios3">
                        Ожидание результатов тестирования
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="quantity" id="Radios4" value="4">
                    <label class="form-check-label" for="Radios4">
                        Был в контакте с подтвержденным случаем
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="quantity" id="Radios5" value="5">
                    <label class="form-check-label" for="Radios5">
                        Был в контакте с потенциальным носителем вируса
                    </label>
                </div>
            </div>
            <input type="hidden" name="location1" value="">
            <input type="hidden" name="location2" value="">
            <input type="hidden" name="location1_p" value="">
            <input type="hidden" name="location2_p" value="">
            <input type="hidden" name="location1_p2" value="">
            <input type="hidden" name="location2_p2" value="">
            <?php
                $ip = $_SERVER['REMOTE_ADDR']; 
                $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip.'?lang=ru'));
                if($query && $query['status'] == 'success') {
                    $lat = $query['lat'];
                    $lng = $query['lon'];
                    echo '<script>';
                    echo 'let lat = ' . $lat . ';';
                    echo 'let lng = ' . $lng . ';';
                    echo 'const mapOne = L.map(\'mapOne\', {}).setView([lat, lng], 13);';
                    echo 'const mapTwo = L.map(\'mapTwo\', {}).setView([lat, lng], 13);';
                    echo 'const mapThree = L.map(\'mapThree\', {}).setView([lat, lng], 13);';
                    echo '</script>';
                } else {
                    echo '<script>';
                    echo 'const mapOne = L.map(\'mapOne\', {}).setView([55.753960, 37.620393], 13);';
                    echo 'const mapTwo = L.map(\'mapTwo\', {}).setView([55.753960, 37.620393], 13);';
                    echo 'const mapThree = L.map(\'mapThree\', {}).setView([55.753960, 37.620393], 13);';
                    echo '</script>';
                }
            ?>
            <script type="text/javascript">
            // Add a tile layer to the map (Mapbox Streets tile layer)
            const mapboxToken = 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
            const mapboxUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
            const mapboxAttribution = [
                'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors,',
                '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>,',
                'Imagery © <a href="http://mapbox.com">Mapbox</a>',
            ].join(" ");
            
            const mapbox = (map) => {
                return L.tileLayer(mapboxUrl, {
                    id: 'mapbox.streets',
                    token: mapboxToken,
                    attribution: mapboxAttribution,
                }).addTo(map)
            };

            [mapOne, mapTwo, mapThree].forEach(mapInstance => mapbox(mapInstance));

            // Add a zoom control to the map
            const zoomControl = new L.Control.Zoom({
                position: 'topleft'
            });
            zoomControl.addTo(mapOne);
            zoomControl.addTo(mapTwo);
            zoomControl.addTo(mapThree);

            const scaleControl = L.control.scale({
                maxWidth: 200,
                metric: true,
                imperial: false,
                position: 'bottomright'
            });
            scaleControl.addTo(mapOne);
            scaleControl.addTo(mapTwo);
            scaleControl.addTo(mapThree);
            let marker;
            mapOne.on('click', function(e) {
                console.clear();
                if(marker) mapOne.removeLayer(marker);
                position = e.latlng;
                let loc1 = e.latlng.lat;
                let loc2 = e.latlng.lng;
                marker = L.marker(e.latlng).addTo(mapOne);
                $("input[name=location1]").val(loc1);
                $("input[name=location2]").val(loc2);
                let url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/geolocate/address";
                let token = "9c9a6d48fabaaa617279d5fdb10ea468caf66c41";
                let query = { lat: loc1, lon: loc2, radius_meters: 80 };
                let options = {
                    method: "POST",
                    mode: "cors",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "Authorization": "Token " + token
                    },
                    body: JSON.stringify(query)
                }
                let adr;
                let ad = '';
                function adres (address) {
                    adr = address;
                    console.log(typeof adr);
                    let length = adr.length;
                    console.log(length);
                    let i = 0;
                    let write;
                    while (i != length) {
                        i++;
                        if (adr[i] == 'г') {
                            write = true;
                        }
                        if (write) {
                            if (adr[i] != '"') {
                                ad += adr[i];
                            }
                            else {break;}
                        }
                    }
                    $("input[name=adres]").val(ad);
                }
                fetch(url, options)
                .then(response => response.text())
                .then(result => adres(result))
                .catch(error => console.log("error", error));
            });
            // =============================================================
            // =============================================================
            // =============================================================
            mapTwo.on('click', function(e) {
                console.clear();
                if(marker) mapTwo.removeLayer(marker);
                position = e.latlng;
                let loc1 = e.latlng.lat;
                let loc2 = e.latlng.lng;
                marker = L.marker(e.latlng).addTo(mapTwo);
                $("input[name=location1_p]").val(loc1);
                $("input[name=location2_p]").val(loc2);
                let url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/geolocate/address";
                let token = "9c9a6d48fabaaa617279d5fdb10ea468caf66c41";
                let query = { lat: loc1, lon: loc2, radius_meters: 80 };
                let options = {
                    method: "POST",
                    mode: "cors",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "Authorization": "Token " + token
                    },
                    body: JSON.stringify(query)
                }
                let adr;
                let ad = '';
                function adres (address) {
                    adr = address;
                    console.log(typeof adr);
                    let length = adr.length;
                    console.log(length);
                    let i = 0;
                    let write;
                    while (i != length) {
                        i++;
                        if (adr[i] == 'г') {
                            write = true;
                        }
                        if (write) {
                            if (adr[i] != '"') {
                                ad += adr[i];
                            }
                            else {break;}
                        }
                    }
                    $("input[name=adres2]").val(ad);
                }
                fetch(url, options)
                .then(response => response.text())
                .then(result => adres(result))
                .catch(error => console.log("error", error));
            });
            // =============================================================
            // =============================================================
            // =============================================================
            mapThree.on('click', function(e) {
                console.clear();
                if(marker) mapThree.removeLayer(marker);
                position = e.latlng;
                let loc1 = e.latlng.lat;
                let loc2 = e.latlng.lng;
                marker = L.marker(e.latlng).addTo(mapThree);
                $("input[name=location1_p2]").val(loc1);
                $("input[name=location2_p2]").val(loc2);
                let url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/geolocate/address";
                let token = "9c9a6d48fabaaa617279d5fdb10ea468caf66c41";
                let query = { lat: loc1, lon: loc2, radius_meters: 80 };
                let options = {
                    method: "POST",
                    mode: "cors",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "Authorization": "Token " + token
                    },
                    body: JSON.stringify(query)
                }
                let adr;
                let ad = '';
                function adres (address) {
                    adr = address;
                    console.log(typeof adr);
                    let length = adr.length;
                    console.log(length);
                    let i = 0;
                    let write;
                    while (i != length) {
                        i++;
                        if (adr[i] == 'г') {
                            write = true;
                        }
                        if (write) {
                            if (adr[i] != '"') {
                                ad += adr[i];
                            }
                            else {break;}
                        }
                    }
                    $("input[name=adres3]").val(ad);
                }
                fetch(url, options)
                .then(response => response.text())
                .then(result => adres(result))
                .catch(error => console.log("error", error));
            });
            </script>
            <button type="submit" class="btn btn-success">Подтвердить</button>
        </form>
        <?php
        } else {
            require_once "request.php";
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>
</html>