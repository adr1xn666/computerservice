<?php
include_once("../db_connect.php");

if (isset($_POST['add']) && !empty($_POST['task'])) {
    $query = "INSERT INTO `todo_tasks`(`task`, `user_id`) VALUES ('".$_POST['task']."', (SELECT `user_id` FROM todo_sessions WHERE `session`='".$_COOKIE["session"]."'))";
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query) echo("<p>Ошибка в запросе</p>");
}

header("Location: index.php");
exit;
?>
