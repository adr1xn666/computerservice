<?php
    include_once("../db_connect.php");

    if(isset($_POST["submit"])){
        if($_POST["submit"] == "register"){
        $query = "INSERT INTO `todo_users`(`email`, `login`, `password`) VALUES ('".$_POST["email"]."','".$_POST["login"]."','".$_POST["password"]."')";
        $res_query = mysqli_query($connection, $query);

        if(!$res_query) echo("<p>Ошибка в запросе</p><p>".$query."</p>");
    }
    session_start();
    session_regenerate_id();
    setcookie("session", session_id());

    $query = "INSERT INTO `todo_sessions`(`user_id`, `session`) VALUES ((SELECT `id` FROM `todo_users` WHERE `login`='".$_POST["login"]."' AND `password`='".$_POST["password"]."'), '".session_id()."')";
    $res_query = mysqli_query($connection, $query);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
 <title>Вход и регистрация</title>
 <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
 <div class="container">
  <div class="login-box">
   <h2>Логин</h2>
   <form action="login.php" method="post">
    <div class="user-box">
     <input type="text" name="login" required="">
     <label>Имя</label>
    </div>
    <div class="user-box">
     <input type="password" name="password" required="">
     <label>Пароль</label>
    </div>
    <a href="#">
     <span></span>
     <span></span>
     <span></span>
     <span></span>
     <button type = "submit" name = "submit" value = "login">Login</button>
    </a>
   </form>
  </div>

  <div class="register-box">
   <h2>Регистрация</h2>
   <form action="login.php" method="post"> 
    <div class="user-box">
     <input type="text" name="login" required="">
     <label>Имя</label>
    </div>
    <div class="user-box">
     <input type="email" name="email" required="">
     <label>Почта</label>
    </div>
    <div class="user-box">
     <input type="password" name="password" required="">
     <label>Пароль</label>
    </div>
    <a>
     <span></span>
     <span></span>
     <span></span>
     <span></span>
     <button type = "submit" name = "submit" value = "register" style = "margin-left: 38px;">Register</button>
    </a>
   </form>
  </div>
  
 </div>

</body>
</html>