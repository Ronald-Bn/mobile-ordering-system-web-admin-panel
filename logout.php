<?php
session_start();

if (isset($_POST['logout_btn'])) {
    unset($_SESSION['verified_user_id']);
    unset($_SESSION['idTokenString']);

    $_SESSION['status'] = "Log out Succesfully";
    header('Location:login.php');
    exit();
}
