<?php
session_start();
unset($_SESSION['login'], $_SESSION['password']);
session_destroy();
header("location:index.php?action=login");
?>