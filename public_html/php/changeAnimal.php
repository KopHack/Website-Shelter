<?php 
session_start();
  
  function can_upload($file)
{
    if($file['name'] == '')
	    return false;
	
	if($file['size'] == 0)
		return false;
	
	$getMime = explode('.', $file['name']);

	$mime = strtolower(end($getMime));

    $types = array('jpg', 'png', 'jpeg');
	
	if(!in_array($mime, $types))
        return false;

    return true;
}

function make_upload($file)
{	
	$name = mt_rand(0, 10000) . $file['name'];
	copy($file['tmp_name'], '../img/' . $name);
	return $name;
}
  
$idp = $_SESSION['edit_id'];
$nickname = filter_var(trim($_POST['nickname']), FILTER_SANITIZE_STRING);
$type = filter_var(trim($_POST['type']), FILTER_SANITIZE_STRING);
$birthday = filter_var(trim($_POST['birthday']), FILTER_SANITIZE_STRING); 
$gender = filter_var(trim($_POST['gender']), FILTER_SANITIZE_STRING); 
$color = filter_var(trim($_POST['color']), FILTER_SANITIZE_STRING); 
$weight = filter_var(trim($_POST['weight']), FILTER_SANITIZE_STRING); 
$length = filter_var(trim($_POST['length']), FILTER_SANITIZE_STRING); 
$height = filter_var(trim($_POST['height']), FILTER_SANITIZE_STRING); 

if (empty($type) or empty($birthday) or empty($gender) or empty($color) or empty($weight) or empty($length) or empty($height)) 
{
    $errors['not_all_data'] = 1;
}
else
{
     $check = can_upload($_FILES['photo']);
     $img = make_upload($_FILES['photo']);
    if($check == 1)
    {
        $img = "../img/".$img;
    }
    else
    {
        $img = null;
    }
    include ('connectBD.php');
    mysqli_query ($db, "CALL ChangeAnimal('$idp', '$nickname', '$type', '$birthday', '$gender', '$color', '$weight', '$length', '$height', '$img')");
}    
   header('Location: index.php');
?>