<?php 
    session_start();
    $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
    $pass = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING); 

    $_SESSION['authorisation'] = 1;

    if (empty($login) or empty($pass)) 
    {
        $errors['not_login_pass'] = 1;
    }

    include ("connectBD.php");
 
    $result = mysqli_query($db, "SELECT `Login`, `Password`, `Role` FROM `Users` WHERE `login`='$login'");
    $myrow = mysqli_fetch_assoc($result);
    if (empty($myrow['Login']))
    {
        $errors['login_wrong'] = 1;
    }
    else 
    {
        if ($myrow['Password']==md5($pass."md5encryption".$login)) 
        {
            $_SESSION['current_user']=$myrow['Login']; 
            $_SESSION['user_type']=$myrow['Role'];
            $_SESSION['authorisation'] = 0;
        }
        else 
        {
            $errors['pass_wrong'] = 1;
        }
    }
    $_SESSION["errors"] = $errors;
    header('Location: index.php');
?>