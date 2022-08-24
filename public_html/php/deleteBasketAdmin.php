<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include ('connectBD.php');

$user = $_SESSION['current_user'];
$but = $_POST['but'];
$boxes = $_POST['item'];

if(isset($_POST['item'])) {
	$count = count($boxes);
	while($count != 0) {
	    $items = explode(' ', $boxes[$count - 1]);
		$id = $items[0];
		$user = $items[1];
		if ($but == "Принять")
		{
            mysqli_query($db, "INSERT INTO `RequestsStore`(`LoginUser`, `id_Animal`, `Date`, status) SELECT `LoginUser`, `id_Animal`, `Date`, 'Принята' FROM `Requests` WHERE `id_Animal` = '$id' AND `LoginUser` = '$user'");            
        }
        else
        {
            mysqli_query($db, "INSERT INTO `RequestsStore`(`LoginUser`, `id_Animal`, `Date`, status) SELECT `LoginUser`, `id_Animal`, `Date`, 'Отклонена' FROM `Requests` WHERE `id_Animal` = '$id' AND `LoginUser` = '$user'");      
        }
        include ('connectBD.php');
		mysqli_query($db, "DELETE FROM `Requests` WHERE `id_Animal` = '$id' AND `LoginUser` = '$user'");
		$count = ($count - 1);
	}
}
   
header('Location: index.php');
?>