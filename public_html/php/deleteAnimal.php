<?php 
session_start();

$idp = array_keys($_POST);

if(count($idp) == 1) {
	include ('connectBD.php');
	
	$id = $idp[0];
	mysqli_query ($db, "DELETE FROM `Animal` WHERE `id` = '$id'");
}
header('Location: index.php');
?>