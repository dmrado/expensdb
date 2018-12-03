<?php
/**
 * Created by PhpStorm.
 * User: dmrado
 * Date: 07.08.2018
 * Time: 22:54
 */session_start();
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
$resultinc = mysqli_query($conn, "SELECT SUM(incamount) AS incsum FROM incdescrtb WHERE expdate<= CURRENT_DATE ()");
$resultex = mysqli_query($conn, "SELECT SUM(amount) AS incsum FROM expdescrtb WHERE expdate<= NOW()");

$result = $resultinc - $resultex;

echo $result;
echo $resultex;
var_dump($resultinc);

echo '<br/><p><a href="milestone.php" class="btn btn-primary">НА ГЛАВНУЮ</a></p>';
?>