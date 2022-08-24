<?php 
session_start();

$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
$fio = filter_var(trim($_POST['FIO']), FILTER_SANITIZE_STRING);
$pass = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING); 
$phone = filter_var(trim($_POST['phone']), FILTER_SANITIZE_STRING); 
$adress = filter_var(trim($_POST['adress']), FILTER_SANITIZE_STRING); 
$passport = filter_var(trim($_POST['passport']), FILTER_SANITIZE_STRING); 

if(mb_strlen($login) < 5 || mb_strlen($login) > 35)
{
	// "Недопустимая длина логина"
	$errors['login_lenght'] = 1;
}
$pass = md5($pass."md5encryption".$login);

include ('connectBD.php');

$result = mysqli_query($db, "SELECT `Login` FROM `Users` WHERE `Login` = '$login'");
$myrow = mysqli_fetch_assoc($result);
if (!empty($myrow['login'])) {
	$errors['login_compare'] = 1;
}


if(count($errors) == 0) {
	$today = date("y.m.d h:m:s"); 
	mysqli_query ($db, "CALL AddUser('$login', '$pass', '$fio', '$phone',' $adress', '$passport')");
}

if(count($errors) > 0) 
{	
	$_SESSION["registration"] = 1;
	$_SESSION["errors"] = $errors;
}
else 
{
	$_SESSION["registration"] = 0;
}

header('Location: index.php');

?>