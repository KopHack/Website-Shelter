<?php 
    session_start();
    
    include_once "connectBD.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sliderStyle.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <title>Приют</title>
</head>

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
                                        include_once "basket.php";
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
                                                        <a href="#" class="header-profile-nav" onclick="callRequestForm()"><span>Посмотреть заявки</span></a>  
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
                    <?php
                        $result = mysqli_query($db, "SELECT * FROM `TypeAnimal`");
                        while($item = mysqli_fetch_assoc($result)) {
                    ?>
                        <a href="../php/sorting.php?type=<?php echo $item["id"]?>" class="catalog_item_reference" >
                            <div class="catalog_item">
                                <img src="" alt="" class="catalog_item_logo">
                                <div class="span catalog_label"><?php echo $item["Name"]?></div>
                            </div>
                        </a>
                    <?php }
                    ?>
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
                    <div class="edit-form-content profile-form-inactive" id="request-div">
                        <div class="edit-form-container">
                            <div class="add-edit-header">
                                <span>Заявки пользователей</span>
                            </div>
                                <div class="basket-container">
                                                <form action="../php/deleteBasketAdmin.php" method="post">
                                                    <?php
                                                                $Requests = mysqli_query($db, "SELECT `Requests`.`id_Animal`, `LoginUser`, `Animal`.`Nickname`, `BreedAnimal`.`Name`, `Requests`.`Date` FROM `Requests` INNER JOIN `Animal` ON `Animal`.`id` = `Requests`.`id_Animal` INNER JOIN `BreedAnimal` ON `BreedAnimal`.`id` = `Animal`.`Breed`");
                                                                while($itemRequest = mysqli_fetch_assoc($Requests)){
                                                            ?>
                                                            <div class="basket-item">
                                                                <input type="checkbox" name="item[]" value="<?php echo $itemRequest['id_Animal'];?> <?php echo $itemRequest['LoginUser'];?>">
                                                                <div class="item-name">
                                                                    <?php 
                                                                        echo $itemRequest['LoginUser'].' - '.$itemRequest['Nickname'].' ('.$itemRequest['Name'].')';
                                                                    ?>
                                                                </div>

                                                            </div>
                                                            <?php
                                                        }                                                
                                                    ?>
                                                    <div class="basket-buttons">
                                                        <input type="submit" name="but" value="Отклонить">
                                                        <input type="submit" name="but" value="Принять">
                                                    </div>
                                                </form>
                                </div>
                            <div class="close-form"><a href="#" onclick="closeRequestForm()">X</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="main__body">
            <div class="main-catalog">
                <div class="content">
                    <div class="main-catalog-content">
                    <?php $sort_type = $_SESSION['sort_type']; 
                        if(isset($_SESSION['sort']) && $_SESSION['sort'] == 1) {
                            $sort_type = $_SESSION['sort_type'];
                            $result = mysqli_query($db, "SELECT `id`, `Name` FROM `BreedAnimal` WHERE `Type` = '$sort_type'");
                                if(isset($result)) {
                    ?>
                        <div class="something">
                            <span>Каталог</span>
                            <div class="main-catalog-nav">
                                <div class="catalog-nav-container">
                                    <form action="../php/sortingType.php" method="post">
                                         <?php while($item = mysqli_fetch_assoc($result)) { ?>
                                        <div class="catalog-nav-ref"><input type="submit" value="<?php echo $item['Name']?>" name="<?php echo $item['id']?>"></div>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php }} ?>
                        <div class="main-catalog-container">
                            <?php
                                if(isset($_SESSION['sort']) && $_SESSION['sort'] == 1) {
                                    $sort_type = $_SESSION['sort_type'];
                                    $sort_breed = $_SESSION['sort_breed'];
                                    if(isset($sort_breed))
                                    {
                                        $result = mysqli_query($db, "CALL GetInfoAnimalSortBreed('$sort_breed')");
                                        $rowCount = 3;
                                    }
                                    else
                                    {
                                        $result = mysqli_query($db, "CALL GetInfoAnimalSort('$sort_type')");   
                                        $rowCount = 3;
                                    }
                                } else {
                                    $result = mysqli_query($db, "CALL GetInfoAnimal()");
                                     $rowCount = 4;
                                }
                                
                                if(isset($result)) {
                                    echo "<div class=\"main-catalog-row\">";
                                    while($item = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <div class="main-catalog-item">
                                            <a href="startOpenAnimal.php?id=<?php echo $item["id"]?>"><img src="<?php echo $item['Image'] ?>" alt=""></a>
                                            <div class="catalog-item-text">
                                                <div class="catalog-item-label">
                                                <span><?php echo $item['Nickname'] ?></span>
                                                </div>
                                                <div class="catalog-item-price">
                                                    <span><?php echo $item['Name'] ?></span>
                                                </div>
                                            </div>
                                                <?php
                                                    if($_SESSION['user_type'] == 2) {
                                                        ?>
                                                            <div class="edit-delete-buttons">
                                                                <form action="../php/startEdit.php" method="post" class="inside-form">
                                                                    <input type="submit" value="Редакт." name="<?php echo $item['id']?>" />
                                                                </form>
                                                                <form action="../php/deleteAnimal.php" method="post" class="inside-form">
                                                                    <input type="submit" value="Удалить" name="<?php echo $item['id']?>" >
                                                                </form>
                                                            </div>
                                                            <!-- <a href="#" onclick="callEditForm()">Edit</a> -->
                                                        <?php
                                                        // $_SESSION['edit_id'] = $item['id'];
                                                    }
                                                ?>
                                                <form action="../php/addBasket.php" method="GET">
                                                    <input type="hidden" name="idAnimal" value="<?php echo $item['id'];?>">
                                                    <?php if(isset($_SESSION['current_user'])) {?><input type="submit" value="Запросить" class="buy-button"> <?php } ?>
                                                </form>
                                            </div>
                                        <?php
                                        $rowCount--;
                                        if($rowCount == 0) {
                                            ?></div>
                                            <div class="main-catalog-row">
                                            <?php
                                            $rowCount = 3;
                                        }
                                    }
                                    ?></div><?php
                                }
                                unset($result);
                                unset($item);
                            ?>
                           
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
                <span> MAIL@MAIL.RU</span>
            </div>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../js/slick.min.js"></script>
    <script src="../js/toggleScript.js"></script>
    <script src="../js/script.js"></script>
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