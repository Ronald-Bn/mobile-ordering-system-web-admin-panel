<?php
session_start();

if (isset($_POST['logout_btn'])) {
    unset($_SESSION['verified_user_id']);
    unset($_SESSION['idTokenString']);

    header('Location:login.php');
    unset($_SESSION['status']);
    exit();
}
