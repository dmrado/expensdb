<?php
/**
 * Created by PhpStorm.
 * User: dmrado
 * Date: 23.07.2018
 * Time: 22:23
 */
include_once ("func.php");
try{
    $pdo = new PDO('mysql:host=localhost;dbname=catsdb;charset=utf8', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET NAMES "utf8"');
} catch (PDOException $e){
    echo 'Подключение к базе не установлено. Попробуйте-ка еще раз.<br/>'. $e->getMessage();
    exit();
}
?>