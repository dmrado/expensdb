<?php
/**
 * Created by PhpStorm.
 * User: dmrado
 * Date: 26.07.2018
 * Time: 16:27
 */
session_start();
//подключаемся к базе данных если выражение isset вернет true
include_once('func.php');
$conn=mysqli_connect($server,$login,$password);
mysqli_query($conn, "SET NAMES UTF8");
mysqli_select_db($conn, $database);
if (isset($_POST['login']) && isset($_POST['password'])) {
    $userlogin = mysqli_real_escape_string($conn, $_POST['login']);
    $userpassword = md5(mysqli_real_escape_string($conn, $_POST['password']));
}
else if (isset($_SESSION['login']) && isset($_SESSION['password'])) {
    $userlogin = mysqli_real_escape_string($conn, $_SESSION['login']);
    $userpassword = mysqli_real_escape_string($conn, $_SESSION['password']);
    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
}
else {
    Header("Location: index.html");
}
$result=mysqli_query($conn, "SELECT * FROM users WHERE login='".$userlogin."' && password='".$userpassword."'");
$count=mysqli_num_rows($result);
if($count==0) {
    session_destroy();
    Header("Location: index.php");
}
else {
    echo '<!DOCTYPE html>
            <html>
              <head>
            <meta charset="UTF-8">
            <title>reports</title>
            <link rel="stylesheet" href="css/bootstrap.min.css">
            <link rel="stylesheet" href="css/datatables.bootstrap.css">
            <script src="js/jquery.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/angularjs/angular.min.js"></script>
            <script src="js/angular.min.js"></script>
            <script src="js/angular-datatables.min.js"></script>
            <script src="js/jquery.dataTables.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.css"></script>
              </head>
              <body>
                <!--<div id="wrapper">
                <div id="header"></div>
                <div id="sidebar-left"></div>
                <div id="sidebar-right"></div>-->
                <div class="thumbnail"><!--<img src ="images/#">--></div>
                <div class="caption">
                <form class="btn btn-primary" action="reports.php" method="POST">
                    <div class="container">
                    <div id="content">';
                    echo '<h2 align="center">Здесь мы делаем отчеты, ' . $username . ', выбирайте: </h2>
              
                    <div class="thumbnail"> <!--<img src ="images/#">--></div>
                    <div class="caption">
                    <p><label><a href="datepickerin.php" class="btn btn-primary">ДОХОДЫ ЗА ПЕРИОД</a></p><br/>
                    </div><!--Расходы по статьям за временной отрезок-->
                    
                    <div class="thumbnail"> <!--<img src ="images/#">--></div>
                    <div class="caption">
                    <p><label><a href="datepickerex.php" class="btn btn-primary">РАСХОДЫ ЗА ПЕРИОД</a></p><br/>
                    </div><!--Расходы по статьям за временной отрезок-->
                 
                  
                    <div class="thumbnail"><!--<img src ="images/#">--></div>
                    <div class="caption">
                    <p><a href="#" class="btn btn-primary">ОТЧЕТ О ДВИЖЕНИИ ДЕНЕГ</a></p><br/>
                    </div><!--Доходы и Расходы в общем за временной отрезок-->
                    
                  
                    <p><a href="milestone.php" class="btn btn-default">НА ГЛАВНУЮ</a></p>
                    
                <div class="clear"></div>
            </div>
        </div>
   <!--<div id="footer"></div>-->
   </form>
</div>

</body></html>';
    }
?>
