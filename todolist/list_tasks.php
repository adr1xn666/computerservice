<?php

$from = "";
if(isset($_GET["from"]) && $_GET["from"]!=""){
    $from = " `date`>='".$_GET["from"]."' AND";
}
$to = "";
if(isset($_GET["to"]) && $_GET["to"]!=""){
    $to = " `date`<='".$_GET["to"]."' AND";
}
$filter = "";
if(isset($_GET["filter"])){
    $filter = $_GET["filter"];
}
$order = "";
if(isset($_GET["order"])){
    $order = $_GET["order"];
}

$query = "SELECT `user_id` FROM todo_sessions WHERE `session`='".$_COOKIE["session"]."'";
$res = mysqli_query($connection,$query);
$id = mysqli_fetch_assoc($res)["user_id"];

$query = "SELECT * FROM `todo_tasks` WHERE".$from.$to." `deleted`=false AND (user_id=(SELECT `user_id` FROM todo_sessions WHERE `session`='".$_COOKIE["session"]."') OR `id` IN (SELECT `task_id` FROM todo_access WHERE `user_id`=(SELECT `user_id` FROM todo_sessions WHERE `session`='".$_COOKIE["session"]."')))".$filter." ".$order;
$res_query = mysqli_query($connection, $query);

if(!$res_query) echo("<p>Ошибка в запросе</p><p>".$query."</p>");

$arr_res = array();
$rows = mysqli_num_rows($res_query);

for ($i=0; $i < $rows; $i++){
    $row = mysqli_fetch_assoc($res_query);
    $completedStyle = "";
    if($row["completed"] == 1) $completedStyle = "<input type='checkbox' checked disabled class = 'checkbox'>";

    if($row["user_id"] != $id) echo "<li style='height: 40px;'><input type='checkbox' ".$completedStyle.$row["task"]."</li>";
    else
        echo "<li>".$completedStyle.$row["task"]." (".$row["date"].") <a href='remove_task.php?index=".$row["id"]."' class='button-remove'>Remove </a> <a href='edit_task.php?index=".$row["id"]."' class='button-edit'>Edit</a><form action='index.php' method='post' class='complete'><button type='submit' name='delete' value='".$row["id"]."'>Выполнить</button></form></li>";
}
?>