<?php
    session_start();

    $animal_id = filter_var(trim($_GET['id']), FILTER_SANITIZE_STRING);
    $_SESSION['animal_id'] = $animal_id;
    header('Location: ../html/item.php');
?>