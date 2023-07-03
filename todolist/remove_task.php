<?php
include_once("../db_connect.php");

if (isset($_GET["index"])) {
    $query = "UPDATE `todo_tasks` SET `deleted`=true WHERE `id`=".$_GET["index"]." AND `user_id` = (SELECT `user_id` FROM todo_sessions WHERE `session`='".$_COOKIE["session"]."')";
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query) echo("<p>Ошибка в запросе</p>");
}

header("Location: index.php");
exit;
?>