<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include ('connectBD.php');

$user = $_SESSION['current_user'];
$boxes = $_POST['item'];
if(isset($_POST['item'])) {
	$count = count($boxes);
	while($count != 0) {
		$id = $boxes[$count - 1];
		mysqli_query($db, "DELETE FROM `Requests` WHERE `id_Animal` = '$id' AND `LoginUser` = '$user'");
		$count = ($count - 1);
	}
}

   
header('Location: index.php');
?>