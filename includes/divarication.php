<?php 
require_once ("../db.php");
session_start();

if ($_SESSION['user']) {
    $_SESSION['request'] = '/includes/user.php';
} else {
    $_SESSION['request'] = '/includes/auth.php';
}

//==================================================================================================

// Проверка регистрации (reg.php)
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
        $_POST['reg_password'] = md5($_POST['reg_password']);
        $sign =  "INSERT INTO `users` (`login`, `password`, `status`, `home`, `loc`, `loc2`, `place`, `loc_p`, `loc2_p`, `place2`, `loc_p2`, `loc2_p2`) VALUES (
                                                                                                                                        '".$_POST['reg_login']."',
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
        $user = mysqli_query($connection, "SELECT * FROM `users` WHERE `login`='". $_POST['reg_login'] ."'");
        $num_rows = mysqli_num_rows($user);
        if (!$num_rows) {
            //mysqli_query($connection, "INSERT INTO `cameras` (`addres`, `location`, `location2`, `descr`, `owner`) VALUES ('".$_POST['adres']."','".$_POST['location1']."', '".$_POST['location2']."', '".$_POST['quantity']."', '".$_POST['ownr']."')") 
            $add_user = mysqli_query($connection, $sign);
            if($add_user) {
                $_SESSION['user'] = true;
                $_SESSION['login'] = $_POST['reg_login'];
                $login = $_SESSION['login'];
                $location_user = mysqli_query($connection, "SELECT * FROM `users` WHERE `login`='$login'");
                $_SESSION['user-info'] = mysqli_fetch_assoc($location_user);
                header('Location: /includes/user.php');
                exit();
            } else {
                $_SESSION['errors'] = 'Что-то пошло не так';
                header("Location: reg.php");
                exit();
            }
        } else {
            $_SESSION['errors'] = 'Пользователь с таким логином уже существует';
            header("Location: reg.php");
            exit();
        }
    } else {
        $_SESSION['errors'] = 'Не все формы заполнены';
        header("Location: reg.php");
        exit();
    }
}

//=======================================================================================================================================================

// Проверка входа (auth.php)
// $users = mysqli_query($connection, "SELECT * FROM `users`");
if (isset($_POST['auth-login']) and isset($_POST['auth-password'])) {
    $login = $_POST['auth-login'];
    $password = md5($_POST['auth-password']);
    $check_user = mysqli_query($connection, "SELECT * FROM `users` WHERE `login`='$login' AND `password`='$password'");
    $num_rows = mysqli_num_rows($check_user);
    if ($num_rows == 1) {
        $_SESSION['user-info'] = mysqli_fetch_assoc($check_user);
        $_SESSION['login'] = $_POST['auth-login'];
        $_SESSION['user'] = true;
        header("Location: /includes/user.php");
        exit();
    }
}

//==================================================================================================================

//Проверка выхода из аккаунта
if (isset($_POST['reset'])) {
    if ($_POST['reset']) {
        unset($_SESSION['login']);
        unset( $_SESSION['user-info']);
        unset($_SESSION['user']);
        header("Location: ../index.php");
    }
}

//=====================================================================================================================

//Проверка обновления статуса
if (isset($_POST['quantity_update'])) {
    $login = $_SESSION['login'];
    $_SESSION['status-update'] = $_POST['quantity_update'];
    $update = "UPDATE `users` SET `status`='".$_POST['quantity_update']."' WHERE `login` = '".$login."'";
    if (mysqli_query($connection, $update)) {
        $login = $_SESSION['login'];
        $user_info = mysqli_query($connection, "SELECT * FROM `users` WHERE `login`='$login'");
        $_SESSION['user-info'] = mysqli_fetch_assoc($user_info);
        $_SESSION['success-update'] = true;
        header("Location: user.php");
        exit();
    }
}


