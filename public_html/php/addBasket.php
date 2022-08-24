<?php 
session_start();
  
$ida = filter_var(trim($_GET['idAnimal']), FILTER_SANITIZE_STRING);

$user = $_SESSION['current_user'];
	  
include ('connectBD.php');

mysqli_query ($db, "CALL AddRequest('$user', '$ida')");

   
unset($ida);
header('Location: index.php');
?>