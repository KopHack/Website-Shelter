<?php 
    session_start();
    unset($_SESSION['authorisation']);
    unset($_SESSION['current_user']);
    unset($_SESSION['user_type']);
    header('Location: index.php');
?>