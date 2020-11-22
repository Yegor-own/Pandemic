<?php 
require_once ("db.php");
// $auth = mysqli_fetch_assoc($admin);
// $errors = false;
// $page_auth = true;
// $admin = false;
// if (isset($_GET['auth-login']) and isset($_GET['auth-password'])) {
//     if ($_GET['auth-login'] != $auth['login'] or $_GET['auth-password'] != $auth['password']) $errors = true;
// }
// if (isset($_FILES['file'])) {
// 	if (($_FILES and $_FILES['file']['error'] == UPLOAD_ERR_OK) and (	$_FILES['file']['type'] == 'image/png' or 
// 																		$_FILES['file']['type'] == 'image/jpg' or 
// 																		$_FILES['file']['type'] == 'image/jpeg'
// 																	)) {
//         $_FILES['file']['name'] = 'favicon.png';
//         move_uploaded_file($_FILES['file']['tmp_name'], 'favicon.png');
//         $admin = true;
//         header("Location: " . $_SERVER['REQUEST_URI']);
//         exit();
// 	} else echo '<script>
//                     alert("Файл не загружен");
//                 </script>';
// }
// if (isset($_POST['name'])) {
//     if (mysqli_query($connection, "UPDATE `settings` SET `name`='".$_POST['name']."'")) {
//         header("Location: " . $_SERVER['REQUEST_URI']);
//         exit();
//     }
// }

// if (isset($_POST['color'])) {
//     if (mysqli_query($connection, "UPDATE `settings` SET `navbar_color`='".$_POST['color']."'")) {
//         header("Location: " . $_SERVER['REQUEST_URI']);
//         exit();
//     }
// }

// ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
<?php require ('navbar.php'); ?><br>
<?php
// if (    (isset($_GET['auth-login']) and 
//         isset($_GET['auth-password']) and 
//         $_GET['auth-login'] == $auth['login'] and 
//         $_GET['auth-password'] == $auth['password']) or $admin
//     ) {
?>
<div class="container"><br><br>
    <?php
    // if ($success) {
    //     echo '<p class="alert alert-success">Камера добавлена!!!</p>';
    //     $errors = false;
    //     $success = false;
    // }
                
    // elseif ($errors) {
    //     echo '<p class="alert alert-danger">Камера не добавлена!!!</p>';
    //     $errors = false;
    //     $success = false;
    // }
    ?>
    <form action="#" method="post">
        <div class="title">
            <h1>Ваша учетная запись</h1>
            <h5>Изменить состояние</h5>
        </div><br>
        <div id="map" style="height: 600px;
                            cursor: pointer;"></div><br>
        <div class="form-group">
            <input type="text" name="adres" class="form-control" value="" placeholder="Автозаполнение">
            <p class="title">Ваше состояние</p>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="quantity" id="Radios1" value="1" checked>
                <label class="form-check-label" for="Radios1">
                    Ожидание результатов тестирования
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="quantity" id="Radios2" value="2" checked>
                <label class="form-check-label" for="Radios2">
                    Ожидание результатов тестирования
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
        <script type="text/javascript">
            let map = L.map('map').setView([56.8519000, 60.6122000], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);
            let marker;
            map.on('click', function(e) {
                console.clear();
                if(marker) map.removeLayer(marker);
                position = e.latlng;
                let loc1 = e.latlng.lat;
                let loc2 = e.latlng.lng;
                marker = L.marker(e.latlng).addTo(map);
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
        </script>
        <button type="submit" class="btn btn-success">Подтвердить</button>
    </form><br><br>
</div>
    <?php
    // }
    // else {
    //     if ($errors) echo '<div class="alert alert-danger" role="alert"> Логин или пароль неверен!!! </div>';
    //     require_once('auth.php');
    // }
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>