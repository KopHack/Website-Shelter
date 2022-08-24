<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        header('Content-Type: application/json');
        $resultJson = array("text" => "Hello!");
        header('Location: index.php');
    ?>
    
    <div class="block" data-attr="<?=$_SESSION['errors']?>"></div>
    <script src="../js/DBManager.js"></script>
</body>
</html>
