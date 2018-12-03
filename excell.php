<?php
/**
 * Created by PhpStorm.
 * User: dmrado
 * Date: 27.07.2018
 * Time: 13:56
 */
session_start();
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
    $date_from = mysqli_real_escape_string($conn, $_POST['date_from']);
    $date_to = mysqli_real_escape_string($conn, $_POST['date_to']);

    function cleanData(&$str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }

// Имя загружаемого файла файла.
    $filename = "otchet_" . date('Ymd') . ".xls";

    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Type: application/vnd.ms-excel");

// Подключение к бд
  //  include_once ("func.php");

//Указать кодировку выводимых данных

    mysqli_query($conn, 'SET character_set_database = utf8_general_ci');
    mysqli_query($conn, "SET NAMES 'utf8'");

//запрос и вывод данных
    $flag = false;
    $result = mysqli_query($conn, "SELECT * FROM expdescrtb WHERE expdate>='".$date_from."' AND expdate<='".$date_to."' ORDER BY expdate ASC") or die('Запрос не выполнен!');
    while (false !== ($row = mysqli_fetch_assoc($result))) {
        if (!$flag) {
            // Вывод заголовков
            echo implode("\t", array_keys($row)) . "\r\n";
            $flag = true;
        }
        //Вывод данных столбцов
        array_walk($row, 'cleanData');
        echo implode("\t", array_values($row)) . "\r\n";
    }
    exit;
}
?>
