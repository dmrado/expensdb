<?php
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
    while ($ar = mysqli_fetch_array($result)) {
        $userid = $ar['userid'];
        $userlogin = $ar['login'];
        $userpassword = $ar['password'];
        $email = $ar['email'];
        $username = $ar['username'];


        $_SESSION['userid'] = $userid;
        $_SESSION['login'] = $userlogin;
        $_SESSION['password'] = $userpassword;
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $username;

    }

    echo '<!DOCTYPE html>
            <html>
              <head>
                 <meta charset="UTF-8">
            <title>Milestone</title>
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
                <!--<div class="thumbnail"><img src ="images/#"></div>-->
                <div class="caption">
                <form class="form-horizontal" align="center" action="milestone.php" method="POST">
                    <div class="container">
                    <div id="content">
                        <div id="dat">
                            <script>
                                function printTime(){
                                var d = new Date;
                                var hours = d.getHours();
                                var minutes = d.getMinutes();
                                var seconds = d.getSeconds();
                                document.getElementById("dat");
                                dat.innerHTML = hours + ":" + minutes + ":" + seconds;
                                }
                                setInterval(printTime, 1000);
                            </script>
                        </div>';

                    echo '<h2 align="center">Вы выполнили вход, ' . $username . ', выберите действие: </h2>

                    <div class="thumbnail"><!--<img src ="images/#">--></div>
                 
                    <div class="caption">
                    <p><a href="today.php" class="btn btn-primary">НА СЕГОДНЯ   
                    </a></p>
                    <div id="today" class="btn-success">
                        <script>
                            function printDate(){
                                var tod = new Date;
                                var date = tod.getDate();
                                var mon = tod.getMonth();
                                var year = tod.getFullYear();
                                document.getElementById("today");
                                today.innerHTML = date + ":" + mon + ":" + year;
                            }
                             setInterval(printDate, 1000);
                            
                        </script>
                    </div>
              
               <div class="thumbnail"><!--<img src ="images/#">--></div>
                    <div class="caption">
                    <p><a href="income.html" class="btn btn-primary">ЗАПИСАТЬ НОВЫЙ ДОХОД</a></p><br/>
                    </div>
              
                    <div class="thumbnail"> <!--<img src ="images/#">--></div>
                    <div class="caption">
                    <p><a href="exp.html" class="btn btn-primary">ЗАПИСАТЬ НОВЫЙ РАСХОД</a></p><br/>
                    </div>
                    
                    <div class="thumbnail"><!--<img src ="images/#">--></div>
                    <div class="caption">
                    <p><a href="reports.php" class="btn btn-primary">СФОРМИРОВАТЬ ОТЧЕТ</a></p><br/>
                    </div>
                    
                    <div class="thumbnail"><!--<img src ="images/#">--></div>
                    <div class="caption">
                    <p><a href="mov.php" class="btn btn-primary">ДВИЖЕНИЕ НА КОНКРЕТНУЮ ДАТУ</a></p><br/>
                    </div>
                  
                    
                    <div class="thumbnail"><!--<img src ="images/#">--></div>
                 <!--Надо не забыть сделать разрыв сессии при нажатии кнопки "выйти"-->
                 
                    <p><a href="index.php" class="btn btn-default">ВЫЙТИ</a></p>
                    
                <div class="clear"></div>
            </div>
        </div>
   <!--<div id="footer"></div>-->
   </form>
</div>

</body></html>';
    }
?>
