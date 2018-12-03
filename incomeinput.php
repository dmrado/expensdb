<?php
/**
 * Created by PhpStorm.
 * User: dmrado
 * Date: 26.07.2018
 * Time: 14:00
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
}
else {
    Header("Location: index.php");
}
$result=mysqli_query($conn, "SELECT * FROM users WHERE login='".$userlogin."' && password='".$userpassword."'");
$count=mysqli_num_rows($result);
if($count==0) {
    session_destroy();
    Header("Location: index.php");
}
else {

    if(isset($_POST["inctype"]) && isset($_POST["incamount"])){
        $incdate = mysqli_real_escape_string($conn, $_POST["incdate"]);
        $inctype = mysqli_real_escape_string($conn, $_POST["inctype"]);
        $incamount = trim(mysqli_real_escape_string($conn, $_POST["incamount"]));
        $incamount = str_replace(',','.', $incamount);
        $incdescr = mysqli_real_escape_string($conn, $_POST["incdescr"]);
    }

    $userid = $_SESSION["userid"];

    $result = mysqli_query($conn, "INSERT INTO `incdescrtb` (`incid`, `incdate`, `inctype`, `incamount`, `incdescr`, `userid`, `reserv`) VALUES (NULL, '".$incdate."', '".$inctype."', '".$incamount."', '".$incdescr."', '".$userid."', '')");

    if($result){
        echo '<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>success expinput</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.css"></script>
</head>
    <div class="btn bg-primary" align="center">'.
            'Данные о доходе '. $incamount .' рублей типа '. $inctype .' успешно внесены';
    } else {
        echo "Что-то пошло не так. Расход не внесён.";
    } echo
    '<br/><br/><p><a href="income.html" class="btn btn-primary">Вернуться</a></p></div>';
}
?>