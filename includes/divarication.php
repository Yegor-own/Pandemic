<?php 
require_once ("../db.php");

$auth = mysqli_fetch_assoc($users);
$page_auth = true;
session_start();
// это проверка обновления состояния
$user = $_SESSION['user'];
$login = $_SESSION['login'];
$passwd = $_SESSION['pass'];
if (isset($_POST['reset'])) {
    if ($_POST['reset']) $_SESSION['user'] = false;
}
if (isset($_POST['quantity_update'])) {
    if (!empty($_POST['quantity_update'])) {
        $update = "UPDATE `users` SET `status`='".$_POST['quantity_update']."' WHERE `login` = '".$login."'";
        mysqli_query($connection, $update);
    }
}
if (isset($_GET['auth-login']) and isset($_GET['auth-password'])) {
    if ($_GET['auth-login'] != $auth['login'] or $_GET['auth-password'] != $auth['password']) $errors = true;
    else {
        $user = true;
    }
}
?>

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
if (    (isset($_GET['auth-login']) and 
        isset($_GET['auth-password']) and 
        $_GET['auth-login'] == $auth['login'] and 
        $_GET['auth-password'] == $auth['password']) or $user
    ) {
?>
    <div class="container"><br><br>
        <form action="divarication.php" method="post">
            <input name="reset" type="submit" value="Выйти">
        </form>
        <form action="divarication.php" method="post">
            <div class="title">
                <h1>Ваша учетная запись</h1>
                <h5>Изменить состояние</h5>
            </div><br>
            <div class="form-group">
                <p class="title">Ваше состояние</p>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="quantity_update" id="Radios1" value="1" checked>
                    <label class="form-check-label" for="Radios1">
                        Положительный результат тестирования
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="quantity_update" id="Radios2" value="2" checked>
                    <label class="form-check-label" for="Radios2">
                        Отрицательный результат тестирования
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="quantity_update" id="Radios3" value="3" checked>
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
    <?php
    }
    else {
        require_once('auth.php');
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>