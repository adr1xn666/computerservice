<?php
header('Content-Type: application/json');

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
    $query = "SELECT * FROM `product` WHERE `deleted` = false";
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

else if(preg_match_all("/^get_product$/ui", $_GET['type'])){
    if(!isset($_GET["id"])){
        echo ajax_echo(
            "Ошибка!", 
            "Вы не указали GET параметр id",
            true,
            "ERROR",
            null
        );
        exit();
    }

    $query = "SELECT * FROM `product` WHERE `deleted` = false AND id=".$_GET["id"];
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
    $query = "SELECT * FROM `product` WHERE `deleted` = false AND `id` IN (SELECT `product_id` FROM `cart_products` WHERE `user_id` = ".$_GET['user_id']." AND `deleted`=false)";
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

else if(preg_match_all("/^remove_cart_product$/ui", $_GET['type'])){

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
    
    $query = "CALL `remove_product_from_cart`(".$_GET['user_id'].", ".$_GET['product_id'].")";
    
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
        "Товар был удален из корзины!",
        false,
        "SUCCESS"
    );
    exit;
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
    $query = "SELECT * FROM `services` WHERE `deleted` = false AND `id` IN (SELECT `service_id` FROM `cart_services` WHERE `user_id` = ".$_GET['user_id']." AND `deleted`=false)";
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

else if(preg_match_all("/^remove_cart_service$/ui", $_GET['type'])){

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
    
    $query = "CALL `remove_service_from_cart`(".$_GET['user_id'].", ".$_GET['service_id'].")";
    
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
        "Товар был удален из корзины!",
        false,
        "SUCCESS"
    );
    exit;
}

else if(preg_match_all("/^list_users$/ui", $_GET['type'])){
    if(isset($_GET["id"])) $id = " WHERE `id`=".$_GET["id"];
    else $id = "";

    if(isset($_GET["login"]) && isset($_GET["pass"])) $lp = " WHERE `login`='".$_GET["login"]."' AND `password`='".$_GET["pass"]."'";
    else $lp = "";

    $query = "SELECT * FROM `users`".$id.$lp;
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

else if(preg_match_all("/^list_orders$/ui", $_GET['type'])){
    if(!isset($_GET['user_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр user_id!",
            "ERROR",
            null
        );
        exit;
        }
        $query = "SELECT * FROM `product` WHERE `deleted` = false AND `id` IN (SELECT `product_id` FROM `orders` WHERE `user_id` = ".$_GET['user_id']." AND `deleted`=false)";
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
            "Список продукции!",
            true,
            "SUCCESS",
            $arr_res
        );
        exit();
}

else if(preg_match_all("/^list_orders_services$/ui", $_GET['type'])){
    if(!isset($_GET['user_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр user_id!",
            "ERROR",
            null
        );
        exit;
        }
        $query = "SELECT * FROM `services` WHERE `deleted` = false AND `id` IN (SELECT `service_id` FROM `orders_service` WHERE `user_id` = ".$_GET['user_id']." AND `deleted`=false)";
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
            "Список продукции!",
            true,
            "SUCCESS",
            $arr_res
        );
        exit();
}

else if(preg_match_all("/^add_order$/ui", $_GET['type'])){

    if(isset($_GET['user_id'])){
        $first = ", `user_id`";
        $last = ", ".$_GET['user_id'];
    }
    else{
        $first = "";
        $last = "";
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
    if(!isset($_GET['name'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр name!",
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
    if(!isset($_GET['email'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр email!",
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
    
    $query = "INSERT INTO `orders`(`name`, `surname`, `email`, `phone`, `product_id`".$first.") VALUES ('".$_GET["name"]."', '".$_GET["surname"]."', '".$_GET["email"]."', '".$_GET["phone"]."', ".$_GET["product_id"].$last.")";
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
        "Новая услуга была добавлена в заказы!",
        false,
        "SUCCESS"
    );
    exit;
}

else if(preg_match_all("/^add_order_by_user_id$/ui", $_GET['type'])){

    if(!isset($_GET['product_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр product_id!",
            "ERROR",
            null
        );
        exit;
    }
    if(!isset($_GET['user_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр user_id!",
            "ERROR",
            null
        );
        exit;
    }
    
    $query = "INSERT INTO `orders`(`product_id`,`user_id`) VALUES (".$_GET["product_id"].", ".$_GET["user_id"].")";
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
        "Новая услуга была добавлена в заказы!",
        false,
        "SUCCESS"
    );
    exit;
}

else if(preg_match_all("/^add_order_service$/ui", $_GET['type'])){

    if(!isset($_GET['service_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр service_id!",
            "ERROR",
            null
        );
        exit;
    }
    if(!isset($_GET['user_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр user_id!",
            "ERROR",
            null
        );
        exit;
    }
    
    $query = "INSERT INTO `orders_service`(`service_id`,`user_id`) VALUES (".$_GET["service_id"].", ".$_GET["user_id"].")";
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
        "Новая услуга была добавлена в заказы!",
        false,
        "SUCCESS"
    );
    exit;
}


else if(preg_match_all("/^ViborMaxMin$/ui", $_GET['type'])){
    $arr = file(__DIR__."/../data.txt");
    echo '<pre>';
        print_r(ViborMaxMin($arr));
        echo '</pre>';
}

else if(preg_match_all("/^ViborMinMax$/ui", $_GET['type'])){
    $arr = file(__DIR__."/../data.txt");
    echo '<pre>';
        print_r(ViborMinMax($arr));
        echo '</pre>';
}

else if(preg_match_all("/^scanpapki$/ui", $_GET['type'])){
    $arr = @ScanirovanieDirectorii(__DIR__);
    echo(json_encode($arr));
}

else if(preg_match_all("/^phoneformat$/ui", $_GET['type'])){
    if(!isset($_GET['phone'])){
        echo ajax_echo (
            "Ошибка!",
            "Вы не указали GET параметр phone!",
            "ERROR",
            null
        );
        exit;
    }
    $arr = PhoneFormat($_GET['phone']);
    echo($arr);
}

else if(preg_match_all("/^mailobfuscation$/ui", $_GET['type'])){
    if(!isset($_GET['mail'])){
        echo ajax_echo (
            "Ошибка!",
            "Вы не указали GET параметр mail!",
            "ERROR",
            null
        );
        exit;
    }
    $arr = MailObfuscation($_GET['mail']);
    echo($arr);
}

else if(preg_match_all("/^minmaxtime$/ui", $_GET['type'])){
    $date_values = array(
        array(
          '23:59:33',
          '23:58'
        ),
        '11:00:12',
        '11:00:12:01',
        '15:54:13:29',
        '21:65:22:52',
        '11:09:24:77',
        'asd:e3',
        '22:15:31:4',
        '59:58:55:33',
        '59:58:55:02',
        array(
          '13:54:62:422',
          '21:01:27:34',
          '25:41:00:2233',
          '13:67:20:22',
          '27:76:23243124234:22235'
        )
    );
    $result = minmaxtime($date_values);
    echo "Минимальная временная отметка: " . $result['min'] . "<br>";
    echo "Максимальная временная отметка: " . $result['max'] . "<br>";
}

else if(preg_match_all("/^tobd$/ui", $_GET['type'])){
    $arr = json_decode(file_get_contents("https://dev.rea.hrel.ru/FILE_SIZE.json"));
    $arr = SortirovkaMassiva($arr);
    $size = count($arr);
    for($i=0; $i < $size; $i++) {
        $is_dir = $arr[$i] -> is_dir;
        if($is_dir){
            $is_dir = "true";
        }
        else{
            $is_dir = "false";
        }
        $query = "INSERT INTO `information`(`name`, `size`, `path`, `is_dir`, `ext`) 
        VALUES ('".$arr[$i] -> name."',".$arr[$i] -> size.",'".$arr[$i] -> path."',".$is_dir.",'".$arr[$i] -> ext."')";
    
        $res_query = mysqli_query($connection, $query);
    
        if(!$res_query){
            echo ajax_echo(
                "Ошибка!",
                "Ошибка в запросе!",
                true,
                $query
            );
            exit;
        }
    
    }
    echo ajax_echo(
        "Успех!",
        "Информация добавлена в базу данных!",
        false,
        "SUCCESS"
    );
}

