<?php
    include_once "connectBD.php";
    $user_login = $_SESSION['current_user'];
    $result = mysqli_query($db, "SELECT * FROM `Requests` WHERE `LoginUser` = '$user_login'");

    $_SESSION['basket'] = $result;
    
    header('Location: index.php');
?>