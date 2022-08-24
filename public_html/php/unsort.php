<?php 
    session_start();
    unset($_SESSION['sort']);
    unset($_SESSION['sort_type']);
    unset($_SESSION['set_scroll']);
    unset($_SESSION['sort_breed']);
    header('Location: index.php');
?>