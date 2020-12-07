<?php
session_start();

$usr_pg = true;

if ($_SESSION['user']) {
    header('Location: user.php');
    exit();
}
if (isset($_SESSION['errors'])) $err = $_SESSION['errors'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'navbar.php'; ?>
    <div class="container auth border-secondary"><br><br>
    <?php
    if (isset($err)) {
        echo '<p class="alert-danger">' . $err . '</p>';
        unset($err);
        unset($_SESSION['errors']);
    }
    ?>
        <form action="divarication.php" method="post">
            <div class="title">
                <h1>Войти</h1>
            </div>
            <div class="form-group">
                <label for="login">Ваш Логин</label>
                <input name="auth-login" type="text" value="" class="form-control" id="login" placeholder="Введите Login">
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input name="auth-password" type="password" value="" class="form-control" id="password" placeholder="Введите пароль">
            </div>
            <button type="submit" class="btn btn-success">Подтвердить</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>
