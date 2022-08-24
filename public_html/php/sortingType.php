<?php
   session_start();
   
   $sort_breed = array_keys($_POST);

   if(count($sort_breed) == 1) {
       $_SESSION['sort_breed'] = $sort_breed[0];
   }

   header('Location: index.php');
?>