<?php
include_once('func.php');
$conn=mysqli_connect($server,$login,$password);
mysqli_query($conn, "SET NAMES UTF8");
mysqli_select_db($conn, $database);
//PHP Login Registration Script by using password_hash() method
 if(isset($_SESSION["login"]))
 {
      header("location:entry.php");
 }
 if(isset($_POST["register"]))//если нажата сабмит Зарегиться и пустые поля одно или другое, вывести сообщение "Оба поля должны быть заполнены!"
 {
      if(empty($_POST["login"]) || empty($_POST["password"]))
      {
           echo '<script>alert("Оба поля должны быть заполнены!")</script>';
      }
      else
      {
           $login = trim(mysqli_real_escape_string($conn, $_POST["login"]));
           $password = md5(mysqli_real_escape_string($conn, $_POST["password"]));
           $email = trim(mysqli_real_escape_string($conn, $_POST["email"]));
           $username = trim(mysqli_real_escape_string($conn, $_POST["username"]));

           $result = mysqli_query($conn, "SELECT username, password FROM users WHERE username = '".$username."' && password = '".$password."'");
           if(mysqli_num_rows($result)!=0){
               echo '<script>alert("Пользователь с таким именем уже зарегистрирован")</script>';
           } else {

           $query = "INSERT INTO `users` (`userid`, `login`, `password`, `email`, `username`) VALUES (NULL, '".$login."', '".$password."', '".$email."', '".$username."')";
           if(mysqli_query($conn, $query))
           {
                echo '<script>alert("Регистрация выполнена успешно.")</script>';
                //Header("Location: index.php");
           }
           }
      }
 }
 /*if(isset($_POST["login"]))
 {
      if(empty($_POST["username"]) || empty($_POST["password"]))
      {
           echo '<script>alert("Оба поля должны быть заполнены!")</script>';
      }
      else
      {
           $username = mysqli_real_escape_string($conn, $_POST["username"]);
           $password = mysqli_real_escape_string($conn, $_POST["password"]);
           $query = "SELECT * FROM users WHERE username = '$username'";
           $result = mysqli_query($conn, $query);
           if(mysqli_num_rows($result) > 0)
           {
                while($row = mysqli_fetch_array($result))
                {
                     if(password_verify($password, $row["password"]))
                     {
                          //return true;
                          $_SESSION["username"] = $username;
                          header("location:entry.php");
                     }
                     else
                     {
                          //return false;
                          echo '<script>alert("Wrong User Details")</script>';
                     }
                }
           }
           else
           {
                echo '<script>alert("Wrong User Details")</script>';
           }
      }
 }*/
 ?>
 <!DOCTYPE html>
 <html>
      <head>
           <title>registration</title>
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
      </head>
      <body>
           <br /><br />
           <div class="container" style="width:500px;">
               <form class="btn btn-primary" method="post">

                <h2 align="center">Регистрируемся</h2>
                <br />
                     <label>Придумайте логин</label>
                     <input type="text" name="login" class="form-control" />
                     <br />
                     <label>Придумайте пароль</label>
                     <input type="password" name="password" class="form-control" />
                     <br />

                       <label>email</label>
                       <input type="text" name="email" class="form-control" />
                       <br />

                       <label>Как к Вам обращаться?</label>
                       <input type="text" name="username" class="form-control" />
                       <br />


                     <input type="submit" name="register" value="Зарегистрироваться" class="btn btn-warning" />
                     <br /><br />
                     <p align="center"><a class= "btn btn-primary" href="index.php?action=login">Назад</a></p>
                </form>

           </div>
      </body>
 </html>