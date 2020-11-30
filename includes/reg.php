<?php
session_start();

if (isset($_SESSION['errors'])) $err = $_SESSION['errors'];
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
            <script src="registration.js"></script>
            <button type="submit" class="btn btn-success">Подтвердить</button><br><br>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>
</html>