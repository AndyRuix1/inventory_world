<?php 
include_once './template/header.php';
    $userSession->logout();
    header('Location: login.php');
include_once './template/footer.php';
?>