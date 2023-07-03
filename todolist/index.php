<?php
    include_once("../db_connect.php");
    if(isset($_POST["exit"])){
        setcookie("session", null, time()-3600);
    }
    if(!isset($_COOKIE["session"])){
        header("Location: login.php");
        exit;
    }
    else{
        $query = "SELECT * FROM `todo_sessions` WHERE `session`='".$_COOKIE["session"]."'";
        $res_query = mysqli_query($connection, $query);
    
        if(!$res_query) echo("<p>Ошибка в запросе</p>");

        if(mysqli_num_rows($res_query) == 0){
            setcookie("session", null, time()-3600);
            header("Location: login.php");
            exit;
        }
    }
    if(isset($_POST["exit"])){
        setcookie("session", null, time()-3600);
        header("Location: login.php");
        exit;
    }
    if(isset($_POST["delete"])){
        $query = "UPDATE `todo_tasks` SET `completed`=true WHERE `id`=".$_POST["delete"];
        $res_query = mysqli_query($connection, $query);
    
        if(!$res_query) echo("<p>Ошибка в запросе</p>");
        header("Location: index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список задач</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
        <form action="index.php" method="post">
        <button type="submit" name="exit">Выход</button>
    </form>
    <h1>Список задач</h1>
    <form action="add_task.php" method="post">
        <input type="text" name="task" placeholder="Введите задачу">
        <button type="submit" name="add">Добавить задачу</button>
    </form>
    <form action="index.php" method="get">
        <select name="order" style="margin-right: 10px;">
                <option value="" style="display: none;">Сортировка</option>
                <option value="ORDER BY `date` DESC">Сначала новые</option>
                <option value="ORDER BY `date` ASC">Сначала старые</option>
                <option value="ORDER BY `completed` DESC">Сначала выполненные</option>
                <option value="ORDER BY `completed` ASC">Сначала невыполненные</option>
        </select>
        <select name="filter" style="margin-right: 10px;">
                <option value="" style="display: none;">Фильтр</option>
                <option value="AND `completed`=true">Только выполненные</option>
                <option value="AND `completed`=false">Только невыполненные</option>
        </select>
            <div class="date" style="margin-right: 10px;">
                <label for="from">От:</label>
                <input type="date" name="from">
            </div>
            <div class="date" style="margin-right: 10px;">
                <label for="to">До:</label>
                <input type="date" name="to">
            </div>
            <br>
            <button type="submit">Показать</button>
            <button type="reset">Сбросить</button>
    </form>
    <ul>
        <?php include 'list_tasks.php'; ?>
    </ul>
</body>
</html>