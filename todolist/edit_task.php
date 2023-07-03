<?php
include_once("../db_connect.php");

if (isset($_POST['edit']) && !empty($_POST['task'])) {
    $query = "UPDATE `todo_tasks` SET `task`='".$_POST['task']."' WHERE `id`=".$_POST['edit']." AND `user_id` = (SELECT `user_id` FROM todo_sessions WHERE `session`='".$_COOKIE["session"]."')";
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query) echo("<p>Ошибка в запросе</p>");

    header("Location: index.php");
    exit;
}

else if(isset($_POST["save"]) && count($_POST) > 0){
    $json = file_get_contents("https://dev.rea.hrel.ru/NGA/?token=secret&type=list_todo_users&login=".$_COOKIE['session']);
    $users = json_decode($json)->other;

    for ($i=0; $i < count($users); $i++){
        if(isset($_POST[$users[$i]->login])){
            file_get_contents("https://dev.rea.hrel.ru/NGA/?token=secret&type=add_access&login=".$users[$i]->login."&task=".$_GET["index"]);
        }
        else{
            file_get_contents("https://dev.rea.hrel.ru/NGA/?token=secret&type=delete_access&login=".$users[$i]->login."&task=".$_GET["index"]);
        }
    }
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Edit</title>
</head>
<body>
    <form action="edit_task.php" method="post">
        <input type="text" name="task" placeholder="Enter a task">
        <button type="submit" name="edit" value="<?echo $_GET["index"]?>">Add Task</button>
    </form>
    <form method="post" action="edit_task.php?index=<?echo $_GET["index"];?>">
        <br>
        <p>Предоставить доступ следующим пользователям:<button type="submit" name="save">Сохранить</button></p>
        <span id="tasks"></span>
    </form>
    <script>
        function showTasks() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            var tasks = JSON.parse(this.responseText).other;
            var table = document.getElementById("tasks");
            for (var i = 0; i < tasks.length; i++) {
                var task = tasks[i];
                var input = document.createElement("input");

                input.type = "checkbox";
                input.name = task.login;
                input.id = task.login;

                var label = document.createElement("label");
                label.for = input.id;
                label.innerText = task.login;
                
                table.appendChild(input);
                table.appendChild(label);
                table.innerHTML = table.innerHTML+"<br>";

                
                
            }
            for (var i = 0; i < tasks.length; i++) {
                var task = tasks[i];
                <?$json = file_get_contents("https://dev.rea.hrel.ru/NGA/?token=secret&type=list_todo_users_task&taskid=".$_GET["index"]);
                $users = json_decode($json)->other;
                for ($i=0; $i < count($users); $i++){?>
                if(task.login == "<?echo $users[$i]->login;?>") document.getElementById(task.login).checked = true;
                <?}?>
            }
        }
        };
        xhttp.open("GET", "https://dev.rea.hrel.ru/NGA/?token=secret&type=list_todo_users&login=<?echo $_COOKIE["session"];?>", true);
        xhttp.send();
        }
        showTasks();
    </script>
</body>
</html>