<?php
include_once('config.php');
include_once('functions.php');
include_once('find_token.php');

//тута будет апишка

if(!isset($_GET['type'])){
    echo ajax_echo(
        "Ошибка!", 
        "Нет GET параметра type",
        true,
        "ERROR",
        null
    );
    exit();
}

if(preg_match_all("/^list_product$/ui", $_GET['type'])){
    $query = "SELECT `id`, `name`, `price` FROM `product` WHERE `deleted` = false";
    $res_query = mysqli_query($connection,$query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }
    echo ajax_echo(
        "Успех!", 
        "Список товаров!",
        true,
        "SUCCESS",
        $arr_res
    );
    exit();
}

else if(preg_match_all("/^add_product$/ui", $_GET['type'])){

    if(!isset($_GET['price'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр price!",
            "ERROR",
            null
        );
        exit;
    }

    if(!isset($_GET['name'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр name!",
            "ERROR",
            null
        );
        exit;
    }
    
    if(!isset($_GET['amount'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр amount!",
            "ERROR",
            null
        );
        exit;
    }
    $query = "INSERT INTO `product`(`name`, `price`, `amount`) VALUES ('".$_GET['name']."',".$_GET['price'].", ".$_GET['amount'].")";
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            true,
            null
        );
        exit;
    }
    
    echo ajax_echo(
        "Успех!",
        "Новый товар был добавлен в базу данных!",
        false,
        "SUCCESS"
    );
    exit;
}

else if(preg_match_all("/^remove_product$/ui", $_GET['type'])){

    if(!isset($_GET['id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр id!",
            "ERROR",
            null
        );
        exit;
    }
    
    $query = "UPDATE `product` SET `deleted`= true WHERE `id` = ".$_GET['id']."";
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            true,
            null
        );
        exit;
    }
    
    echo ajax_echo(
        "Успех!",
        "Товар был удален из базы данных!",
        false,
        "SUCCESS"
    );
    exit;
}

else if(preg_match_all("/^register_user$/ui", $_GET['type'])){

    if(!isset($_GET['login'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр login!",
            "ERROR",
            null
        );
        exit;
    }

    if(!isset($_GET['password'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр password!",
            "ERROR",
            null
        );
        exit;
    }
    
    if(!isset($_GET['email'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр email!",
            "ERROR",
            null
        );
        exit;
    }
    $query = "INSERT INTO `users`(`login`, `password`, `email`) VALUES ('".$_GET['login']."','".$_GET['password']."','".$_GET['email']."')";
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            true,
            null
        );
        exit;
    }
    
    echo ajax_echo(
        "Успех!",
        "Новый пользователь был добавлен в базу данных!",
        false,
        "SUCCESS"
    );
    exit;
}

else if(preg_match_all("/^add_service$/ui", $_GET['type'])){

    if(!isset($_GET['price'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр price!",
            "ERROR",
            null
        );
        exit;
    }

    if(!isset($_GET['name'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр name!",
            "ERROR",
            null
        );
        exit;
    }
    
    $query = "INSERT INTO `services`(`name`, `price`) VALUES ('".$_GET['name']."',".$_GET['price'].")";
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            true,
            null
        );
        exit;
    }
    
    echo ajax_echo(
        "Успех!",
        "Новая услуга была добавлена в базу данных!",
        false,
        "SUCCESS"
    );
    exit;
}

else if(preg_match_all("/^edit_info$/ui", $_GET['type'])){

    if(!isset($_GET['id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр id!",
            "ERROR",
            null
        );
        exit;
    }

    if(!isset($_GET['surname'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр surname!",
            "ERROR",
            null
        );
        exit;
    }

    if(!isset($_GET['name'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр name!",
            "ERROR",
            null
        );
        exit;
    }

    if(!isset($_GET['phone'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр phone!",
            "ERROR",
            null
        );
        exit;
    }

    if(!isset($_GET['address'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр address!",
            "ERROR",
            null
        );
        exit;
    }
    
    $query = "UPDATE `users` SET `name`='".$_GET['name']."',`surname`='".$_GET['surname']."',`address`='".$_GET['address']."',`phone`='".$_GET['phone']."' WHERE `id` = ".$_GET['id'];
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            true,
            null
        );
        exit;
    }
    
    echo ajax_echo(
        "Успех!",
        "Пользователь был изменен в базе данных!",
        false,
        "SUCCESS"
    );
    exit;
}

else if(preg_match_all("/^edit_product$/ui", $_GET['type'])){

    if(!isset($_GET['id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр id!",
            "ERROR",
            null
        );
        exit;
    }

    if(!isset($_GET['price'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр price!",
            "ERROR",
            null
        );
        exit;
    }

    if(!isset($_GET['name'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр name!",
            "ERROR",
            null
        );
        exit;
    }

    if(!isset($_GET['amount'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр amount!",
            "ERROR",
            null
        );
        exit;
    }

    $query = "UPDATE `product` SET `name`='".$_GET['name']."',`price`=".$_GET['price'].",`amount`=".$_GET['amount']." WHERE `id` = ".$_GET['id'];
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            true,
            null
        );
        exit;
    }
    
    echo ajax_echo(
        "Успех!",
        "Товар был изменен в базе данных!",
        false,
        "SUCCESS"
    );
    exit;
}

else if(preg_match_all("/^list_service$/ui", $_GET['type'])){
    $query = "SELECT `id`, `name`, `price` FROM `services` WHERE `deleted` = false";
    $res_query = mysqli_query($connection,$query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }
    echo ajax_echo(
        "Успех!", 
        "Список услуг!",
        true,
        "SUCCESS",
        $arr_res
    );
    exit();
}

else if(preg_match_all("/^edit_service$/ui", $_GET['type'])){

    if(!isset($_GET['id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр id!",
            "ERROR",
            null
        );
        exit;
    }

    if(!isset($_GET['price'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр price!",
            "ERROR",
            null
        );
        exit;
    }

    if(!isset($_GET['name'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр name!",
            "ERROR",
            null
        );
        exit;
    }

    $query = "UPDATE `services` SET `name`='".$_GET['name']."',`price`=".$_GET['price']." WHERE `id` = ".$_GET['id'];
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            true,
            null
        );
        exit;
    }
    
    echo ajax_echo(
        "Успех!",
        "Услуга была изменена в базе данных!",
        false,
        "SUCCESS"
    );
    exit;
}

else if(preg_match_all("/^add_cart_product$/ui", $_GET['type'])){

    if(!isset($_GET['user_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр user_id!",
            "ERROR",
            null
        );
        exit;
    }

    if(!isset($_GET['product_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр product_id!",
            "ERROR",
            null
        );
        exit;
    }
    
    $query = "INSERT INTO `cart_products`(`user_id`, `product_id`) VALUES (".$_GET['user_id'].",".$_GET['product_id'].")";
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            true,
            null
        );
        exit;
    }
    
    echo ajax_echo(
        "Успех!",
        "Новый товар был добавлен в корзину!",
        false,
        "SUCCESS"
    );
    exit;
}

else if(preg_match_all("/^list_cart_product$/ui", $_GET['type'])){

    if(!isset($_GET['user_id'])){
    echo ajax_echo(
        "Ошибка!",
        "Вы не указали GET параметр user_id!",
        "ERROR",
        null
    );
    exit;
    }
    $query = "SELECT `name`, `price`, `amount` FROM `product` WHERE `deleted` = false AND `id` IN (SELECT `product_id` FROM `cart_products` WHERE `user_id` = ".$_GET['user_id'].")";
    $res_query = mysqli_query($connection,$query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }
    echo ajax_echo(
        "Успех!", 
        "Список продукции в корзине!",
        true,
        "SUCCESS",
        $arr_res
    );
    exit();
}

else if(preg_match_all("/^add_cart_service$/ui", $_GET['type'])){

    if(!isset($_GET['user_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр user_id!",
            "ERROR",
            null
        );
        exit;
    }

    if(!isset($_GET['service_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр service_id!",
            "ERROR",
            null
        );
        exit;
    }
    
    $query = "INSERT INTO `cart_services`(`user_id`, `service_id`) VALUES (".$_GET['user_id'].",".$_GET['service_id'].")";
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            true,
            null
        );
        exit;
    }
    
    echo ajax_echo(
        "Успех!",
        "Новая услуга была добавлена в корзину!",
        false,
        "SUCCESS"
    );
    exit;
}

else if(preg_match_all("/^list_cart_services$/ui", $_GET['type'])){

    if(!isset($_GET['user_id'])){
    echo ajax_echo(
        "Ошибка!",
        "Вы не указали GET параметр user_id!",
        "ERROR",
        null
    );
    exit;
    }
    $query = "SELECT `name`, `price` FROM `services` WHERE `deleted` = false AND `id` IN (SELECT `service_id` FROM `cart_services` WHERE `user_id` = ".$_GET['user_id'].")";
    $res_query = mysqli_query($connection,$query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }
    echo ajax_echo(
        "Успех!", 
        "Список услуг в корзине!",
        true,
        "SUCCESS",
        $arr_res
    );
    exit();
}

else if(preg_match_all("/^list_users$/ui", $_GET['type'])){
    $query = "SELECT `id`, `name`, `surname`, `login`, `password`, `email`, `phone`, `address` FROM `users`";
    $res_query = mysqli_query($connection,$query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }
    echo ajax_echo(
        "Успех!", 
        "Список пользователей!",
        true,
        "SUCCESS",
        $arr_res
    );
    exit();
}