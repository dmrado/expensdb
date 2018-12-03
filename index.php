<?php
echo '<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>login</title>
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
    <!--<div class="thumbnail"><img src ="images/#"></div>-->
    <div class="caption">
        <form action="milestone.php" method="POST" class="btn btn-primary">
            <h1>СИСТЕМА УПРАВЛЕНИЯ ЛИЧНЫМИ ФИНАНСАМИ</h1>
            <h2>Привет! Мы рады Вам дорогой пользователь!</h2>
                <br/><h2>Заходите, открыто</h2>
            <input class="btn-default" type="text" name="login" value="" placeholder="имя пользователя"/>
            <input class="btn-default" type="password" name="password" value="" placeholder="пароль"/>
            <br/><br/>
            <input class="btn btn-primary" type="submit" value="Уперёд!"/>
                <br/> <br/>
                <h2>впервые здесь?<br/><a class="btn btn-warning" href="reg.php">регистрируйтесь</a></h2>
         
        </form>
    </div>
</body>
</html>';
?>