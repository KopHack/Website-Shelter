<?php 
    session_start();
    
    include_once "../php/connectBD.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/itemStyle.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <title>Приют</title>
</head>
<body>
<body <? if($_SESSION['set_scroll'] == 1) {
    ?> 
        onload="document.getElementsByName('scroll-point')[0].scrollIntoView(1)";
    <?php }
       unset($_SESSION['set_scroll']); 
    ?>>
    <div class="wrapper">
        <header>
            <div class="top__info">
                <div class="content">
                    <div class="info_content">
                        <div class="city">рязань</div>
                        <div class="info_nav">
                            <a href="#"><span class="info_nav_label">помощь</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="main_header">
                <div class="content">
                    <div class="header_content">
                        <div class="header_logo">
                            <a href="../php/unsort.php"><img src="../img/logo.jpg" alt="" class="img"></a>
                        </div>
                        <div class="header_search">
                            <form action="#" method="post">
                                <input type="text" name="search" placeholder="Поиск по сайту">
                            </form>
                        </div>
                        <div class="header-basket-container">
                            <a href="#" class="header_basket" onclick="toggleBasket()" id="basket-ref">
                                <img src="../img/basket.svg" alt="basket_logo">
                                <span class="header_label">Избранное</span>
                            </a>
                            <div class="header-basket-form profile-form-inactive" id="basket-div">
                                <div class="basket-form-header active">
                                    <span>Избранное</span>
                                </div>
                                <div class="basket-container">
                                    <?php
                                        include_once "../php/basket.php";
                                        $basket = $_SESSION['basket'];
                                        if(isset($_SESSION['current_user'])) {
                                            if(count($basket) > 0) {
                                                ?>
                                                <form action="../php/deleteBasket.php" method="post">
                                                    <?php
                                                        while($item = mysqli_fetch_assoc($basket)) {
                                                                $id = $item['id_Animal'];
                                                                $id_Animal = mysqli_query($db, "SELECT `nickname`, `name` FROM `Animal` INNER JOIN `BreedAnimal` ON `Breed` = `BreedAnimal`.`id` WHERE `Animal`.`id` = $id");
                                                                $item_name = mysqli_fetch_assoc($id_Animal);
                                                            ?>
                                                            <div class="basket-item">
                                                                <input type="checkbox" name="item[]" value="<?php echo $item['id_Animal'];?>">
                                                                <div class="item-name">
                                                                    <?php 
                                                                        echo $item_name['nickname'].' ('.$item_name['name'].')';
                                                                    ?>
                                                                </div>

                                                            </div>
                                                            <?
                                                                unset($id_Animal);
                                                                unset($item_name);
                                                        }                                                
                                                    ?>
                                                    <div class="basket-buttons">
                                                        <input type="submit" name="delete" value="Очистить">
                                                    </div>
                                                </form>
                                                <?php
                                            }
                                        } else {
                                            echo "<center>Авторизуйтесь</center>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="header-profile-container">
                            <?php
                                if (isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == 0) {
                                    ?>
                                        <a href="#" class="header_profile" onclick="toggleUserMenu()" id="user-ref">
                                            <img src="../img/user.svg" alt="profile_logo">
                                            <span class="header_label"><?php echo $_SESSION['current_user']; ?></span>
                                        </a>
                                        <div class="header-profile-user profile-form-inactive" id="user-div">
                                            <?php 
                                                if($_SESSION['user_type'] == 2) {
                                                    ?>
                                                    <div class="header-profile-admin">
                                                        <a href="#" class="header-profile-nav" onclick="callAddForm()"><span>Добавить питомца</span></a>    
                                                        <hr>
                                                        <form action="../php/unlogin.php" method="post">
                                                            <div class="header-profile-nav"><input type="submit" value="Выйти из профиля"></div>
                                                        </form> 
                                                        </div>
                                                    <?php
                                                } else if($_SESSION['user_type'] == 1) {
                                                    ?>
                                                    <div class="header-profile-common">   
                                                        <hr>
                                                        <form action="../php/unlogin.php" method="post">
                                                            <div class="header-profile-nav"><input type="submit" value="Выйти из профиля"></div>
                                                        </form> 
                                                    </div>
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                    <?php
                                } 
                                else {
                                ?>
                                <a href="#" class="header_profile
                                <?php
                                    if($_SESSION['registration'] == 1 || $_SESSION['authorisation'] == 1) {
                                        echo " profile-form-active-ref";
                                    }
                                    ?>" onclick="toggleLoginForm()" id="login-ref">
                                    <img src="../img/user.svg" alt="profile_logo">
                                    <span class="header_label">личный кабинет</span>
                                </a>
                                <div class="header-profile-form 
                                <?php
                                if($_SESSION['registration'] == 0 && $_SESSION['authorisation'] == 0) {
                                    echo " profile-form-inactive";
                                }
                                ?>" id="login-div">
                                <div class="header-profile-login
                                    <?php
                                    if($_SESSION['registration'] == 1) {
                                        echo " profile-form-inactive";
                                    } 
                                    ?>" id="login-form">
                                    <div class="profile-form-header">
                                        <span>Авторизация</span>
                                        /
                                        <span id="active-span" onclick="toggleRegistration()">Регистрация</span>
                                    </div>
                                    <form action="../php/login.php" method="post" id="profile-form">
                                        <div class="
                                        <?php
                                            if($_SESSION['authorisation'] == 1) {
                                                $errors = $_SESSION["errors"];
                                                if($errors['not_login_pass']){
                                                    echo "error-input-tag-loginorpass";
                                                }
                                                else
                                                if($errors['login_wrong'] || $errors['pass_wrong']){
                                                    echo "error-input-tag";
                                                }
                                            }
                                        ?>"><input type="text" name="login" placeholder="Логин"/></div>
                                        <div><input type="password" name="password" id="pass" placeholder="Пароль"/></div>
                                        <div class="profile-buttons">
                                            <input type="submit" value="Войти"/>
                                        </div>
                                    </form>
                                    </div>
                                    <div class="header-profile-registration
                                    <?php
                                    if($_SESSION['registration'] == 0) {
                                        echo " profile-form-inactive";
                                    }
                                    ?>" id="registration-form">
                                    <div class="profile-form-header">
                                        <span id="active-span" onclick="toggleRegistration()">Авторизация</span>
                                        /
                                        <span>Регистрация</span>
                                    </div>
                                    <form action="../php/registration.php" method="post" id="profile-form">
                                        <div class="
                                        <?php 
                                            if($_SESSION['registration'] == 1) {
                                                $errors = $_SESSION["errors"];
                                                if($errors["login_lenght"])
                                                {
                                                    echo "error-input-tag-login-lenght";
                                                }
                                                if($errors['login_compare']) 
                                                {    
                                                    echo "error-input-tag-login";
                                                }
                                            }
                                        ?>">
                                        <input type="text" required name="login" placeholder="Логин"/></div>
                                        <input type="text" required name="FIO" placeholder="ФИО"/>
                                        <input type="password" required name="password" id="pass" placeholder="Пароль"/>
                                        <input type="text" required pattern="8[0-9]{10}" title="Пример: 87776665544" name="phone" placeholder="Телефон"/>
                                        <input type="text" name="adress" placeholder="Адрес"/>
                                        <input type="text" title="Пример: 0123-456789" pattern="[0-9]{4}-[0-9]{6}" name="passport" placeholder="Серия-номер паспотра"/>
                                        <div class="profile-buttons">
                                            <input type="submit" value="Зарегестрироваться"/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header_catalog">
                <div class="catalog_nav content">
                    <a href="../php/sorting.php?type=1" class="catalog_item_reference" >
                        <div class="catalog_item">
                            <img src="" alt="" class="catalog_item_logo">
                            <div class="span catalog_label">Кошки</div>
                        </div>
                    </a>
                    <a href="../php/sorting.php?type=2" class="catalog_item_reference">
                        <div class="catalog_item">
                            <img src="" alt="" class="catalog_item_logo">
                            <div class="span catalog_label">Собаки</div>
                        </div>
                    </a>
                    <a href="../php/sorting.php?type=3" class="catalog_item_reference">
                        <div class="catalog_item">
                            <img src="" alt="" class="catalog_item_logo">
                            <div class="span catalog_label">Грызуны</div>
                        </div>
                    </a>
                    <a href="../php/sorting.php?type=4" class="catalog_item_reference">
                        <div class="catalog_item">
                            <img src="" alt="" class="catalog_item_logo">
                            <div class="span catalog_label">Птицы</div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="add-edit-content  profile-form-inactive" id="add-edit">
                <div class="add-edit-container">
                    <div class="add-form-content profile-form-inactive" id="add-div">
                        <div class="add-form-container">
                            <div class="add-edit-header">
                                <span>Добавить нового питомца</span>
                            </div>
                            <div class="add-form">
                                <form action="../php/addAnimal.php" method="post" enctype="multipart/form-data">
                                    <div class="add-edit-input"><input type="text" name="nickname" placeholder="Кличка"/></div>
                                    <div class="add-edit-input">
                                        <select name="type" id="i1" required>
                                            <option value="0" selected disabled>Выберите породу</option>
                                            <?php
                                                $result = mysqli_query($db, "SELECT * FROM `BreedAnimal`");
                                                while($item = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <option value="<?php echo $item["id"]?>"><?php echo $item["Name"]?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                    <span>Дата рождения:</span>
                                    <div class="add-edit-input"><input required type="date" name="birthday"/ ></div>
                                    <div class="add-edit-input"><input required type="radio" name="gender" value="1"/>Самка
                                    <input required type="radio" name="gender" value="2"/>Самец</div>
                                    <div class="add-edit-input"><label class="colorlabel">Цвет:</label><input required type="color" name="color" placeholder="Цвет"/></div>
                                    <div class="add-edit-input"><input required type="number" name="weight"  min="1" placeholder="Вес в граммах"/></div>
                                    <div class="add-edit-input"><input required type="number" name="length"  min="1" placeholder="Длина в сантиметрах"/></div>
                                    <div class="add-edit-input"><input required type="number" name="height"  min="1" placeholder="Высота в сантиметрах"/></div>
                                    <span>Выберите фото животного</span>
                                    <div class="add-edit-input"><input required type="file" accept=".jpg, .jpeg, .png" name="photo" id="photo"></div>
                                    <div class="add-edit-buttons">
                                        <div class="add-edit-input"><input type="reset" value="Сбросить"></div>
                                        <div class="add-edit-input"><input type="submit" value="Создать"></div>
                                    </div>
                                </form>
                            </div>
                            <div class="close-form"><a href="#" onclick="closeAddForm()">X</a></div>
                        </div>
                    </div>
                    <div class="edit-form-content profile-form-inactive" id="edit-div">
                        <div class="edit-form-container">
                            <div class="add-edit-header">
                                <span>Отредактировать питомца</span>
                            </div>
                            <div class="edit-form">
                                <form action="../php/changeAnimal.php" method="post" enctype="multipart/form-data">
                                    <?php
                                        $item_id = $_SESSION['edit_id'];
                                        if (isset($item_id))
                                        {
                                            $result = mysqli_query($db, "SELECT `id`, `Nickname`, `Breed`, `BirthDay`, `Gender`, `Color`, `Weight`, `Length`, `Height`, `Image`
                                            FROM `Animal`
                                                WHERE `Animal`.`id` = '$item_id'");
                                            while($item = mysqli_fetch_assoc($result)) {
                                    ?>
                                       <div class="add-edit-input"><input type="text" name="nickname" placeholder="Кличка"  value="<?php echo $item['Nickname'];?>"/></div>
                                    <div class="add-edit-input">
                                        <select name="type" id="i1" required>
                                            <option value="0" disabled>Выберите породу</option>
                                            <?php
                                                $result2 = mysqli_query($db, "SELECT * FROM `BreedAnimal`");
                                                while($itemBread = mysqli_fetch_assoc($result2)) {
                                                if ($item["Breed"] == $itemBread["id"])
                                                {
                                            ?>
                                                <option selected value="<?php echo $itemBread["id"]?>"><?php echo $itemBread["Name"]?></option>
                                            <?php } else {?>
                                                <option value="<?php echo $itemBread["id"]?>"><?php echo $itemBread["Name"]?></option>  
                                            <?php    }}
                                            ?>
                                        </select>
                                    </div>
                                    <span>Дата рождения:</span>
                                    <div class="add-edit-input"><input required type="date" name="birthday" value="<?php echo $item["BirthDay"]?>"/></div>
                                    <?php  
                                        if ($item["Gender"] == 2)
                                        {
                                    ?>
                                            <div class="add-edit-input"><input required type="radio" name="gender" value="1"/>Самка
                                            <input checked required type="radio" name="gender" value="2"/>Самец</div>
                                    <?php } else { ?>
                                            <div class="add-edit-input"><input checked required type="radio" name="gender" value="1"/>Самка
                                            <input required type="radio" name="gender" value="2"/>Самец</div>
                                    <?php } ?>
                                    <div class="add-edit-input"><label class="colorlabel">Цвет:</label><input required type="color" name="color" placeholder="Цвет" value="<?php echo $item["Color"]?>"/></div>
                                    <div class="add-edit-input"><input required type="number" name="weight"  min="1" placeholder="Вес в граммах" value="<?php echo $item["Weight"]?>"/></div>
                                    <div class="add-edit-input"><input required type="number" name="length"  min="1" placeholder="Длина в сантиметрах" value="<?php echo $item["Length"]?>"/></div>
                                    <div class="add-edit-input"><input required type="number" name="height"  min="1" placeholder="Высота в сантиметрах" value="<?php echo $item["Height"]?>"/></div>
                                    <span>Выберите фото животного</span>
                                    <div class="add-edit-input"><input type="file" accept=".jpg, .jpeg, .png" name="photo" id="photo"></div>
                                    <div class="add-edit-buttons">
                                        <div class="add-edit-input"><input type="reset" value="Сбросить"></div>
                                        <div class="add-edit-input"><input type="submit" value="Изменить"></div>
                                    </div>
                                    <img src="<?php echo $item['Image']?>" alt="" class="edit-img">
                                    <?php }}
                                    ?>
                                </form>
                            </div>
                            <div class="close-form"><a href="#" onclick="closeEditForm()">X</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    <div class="main-content">
        <div class="content">
            <div class="main-view">
                <?php
                    $animal_id = $_SESSION['animal_id'];
                    if (isset($animal_id))
                    {
                        $result = mysqli_query($db, "CALL `GetAllInfoOneAnimal`('$animal_id')");
                        $animal = mysqli_fetch_assoc($result);
                    }
                ?>
                <div class="item-photo">
                    <div class="item-photo-main">
                        <div class="photo-main"><img src="<?php echo $animal['Image']?>"></div>
                    </div>
                </div>
                <div class="item-short-view">
                    <div class="title"><?php echo $animal['Nickname']?></div>
                    
                    <div class="item-short-info">
                        <span><?php echo $animal['Info']?></span>
                    </div>
                    <div class="catalog-item-price">
                        <center><span><?php echo $animal['BreedName']?></span></center>
                        <div class="item-buy-buttons">
                            <a href="../php/addBasket.php?idAnimal=<?php echo $animal_id;?>">
                                <div class="buy-button">
                                    Запросить
                                </div>
                            </a>
  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="info-view">
            <div class="info-switch">    
                <div class="content">
                    <div class="item-info-switch">
                        <div class="switch-item">
                            <span>Обзор</span>
                        </div>
                        <div class="switch-item">
                            <span>Информация</span>
                        </div>
                        <div class="switch-item">
                            <span>Условие</span>
                        </div>
                        <div class="switch-item">
                            <span>Питание</span>
                        </div>
                    </div>
                </div>  
            </div> 
            <div class="item-info">
                <div class="content">
                    <div class="info-container-slider">
                        <div class="item-info-container">
                            <div class="info-title">
                                Общая информация
                            </div>
                            <div class="info-content">
                                <div class="info-row">
                                    <div class="info-col">Класс</div>
                                    <div class="info-col"><?php echo $animal['ClassName']?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-col">Тип</div>
                                    <div class="info-col"><?php echo $animal['TypeName']?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-col">Порода</div>
                                    <div class="info-col"><?php echo $animal['BreedName']?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-col">Продолжительность жизни</div>
                                    <div class="info-col"><?php echo $animal['LifeExpectancy'].' лет'?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-col">Длительность беременности</div>
                                    <div class="info-col"><?php echo $animal['DurationPregnancy'].' дней'?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-col">Кол-во детей в одном помёте</div>
                                    <div class="info-col"><?php echo $animal['Masonry'].' штук'?></div>
                                </div>
                            </div>
                        </div>
                        <div class="item-info-container">
                            <div class="info-title">
                                Информация о животном
                            </div>
                            <div class="info-content">
                               <div class="info-row">
                                    <div class="info-col">Кличка</div>
                                    <div class="info-col"><?php echo $animal['Nickname']?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-col">Дата рождения</div>
                                    <div class="info-col"><?php echo $animal['BirthDay']?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-col">Гендер</div>
                                    <div class="info-col"><?php if($animal['Gender'] == 2){echo 'Самец';} else {echo 'Самка';}?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-col">Цвет</div>
                                    <style>
                                        .square {
                                            height: 35px;
                                            width: 100%;
                                            background-color: <?php echo $animal['Color']?>;
                                        }
                                        </style>
                                    <div class="info-col"><div class="square"></div></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-col">Вес</div>
                                    <div class="info-col"><?php echo ($animal['Weight']/1000).' кг'?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-col">Длина</div>
                                    <div class="info-col"><?php echo $animal['Length'].' см'?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-col">Рост</div>
                                    <div class="info-col"><?php echo $animal['Height'].' см'?></div>
                                </div>
                            </div>
                        </div>
                        <div class="item-info-container">
                            <div class="info-title">
                                Условия содержания
                            </div>
                            <div class="info-content">
                                <div class="text">
                                    <?php 
                                        if(!empty($animal['ConditionsKeeping']))
                                        {
                                            echo $animal['ConditionsKeeping'];
                                        } 
                                        else 
                                        {    
                                            echo 'Описание по содержанию отсутствует';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="item-info-container">
                            <div class="info-title">
                                План питания
                            </div>
                            <div class="info-content">
                                <div class="text">
                                    <?php 
                                        if(!empty($animal['Nutrition']))
                                        {
                                            echo $animal['Nutrition'];
                                        } 
                                        else 
                                        {    
                                            echo 'План питания отсутствует';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>  
    </div>
       <footer>
        <div class="logo">
            <img src="../img/logo.jpg" alt="">
        </div>
        <div class="footer-info">
                <a href="#" class="footer-reference">о компании</a>
                <a href="#" class="footer-reference">партнеры</a>
                <a href="#" class="footer-reference">контакты</a>
        </div>
        <div class="footer-contact">
            <span>8 (800) 888 88 88</span>
            <span> DASHULYA-SHASHKOVA@MAIL.RU</span>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../js/slick.min.js"></script>
    <script src="../js/toggleScript.js"></script>
    <script src="../js/itemScript.js"></script>
    <?php
        if(isset($_SESSION['edit']) && $_SESSION['edit'] == 1) {
            ?>
            <script>callEditForm();</script>
            <?
            unset($_SESSION['edit']);
        }    
    ?>
</body>
</html>