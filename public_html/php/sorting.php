<?php
   session_start();
   $sort_type = filter_var(trim($_GET['type']), FILTER_SANITIZE_STRING);

   if(isset($sort_type)) {
       $_SESSION['sort'] = 1;
       $_SESSION['sort_type'] = $sort_type;
       $_SESSION['set_scroll'] = 1;
       unset($_SESSION['sort_breed']);
   }

   header('Location: index.php');
?>