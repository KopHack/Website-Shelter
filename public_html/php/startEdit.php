<?php
    session_start();

    $edit_id = array_keys($_POST);
    if(count($edit_id) == 1){
        $_SESSION['edit_id'] = $edit_id[0];
    }
    $_SESSION['edit'] = 1;
    header('Location: index.php');
?>