<?php
session_start();

$_SESSION = array();

session_destroy();

setcookie("name", "", time() - 3600, "/");

header("Location: ../View/Registration.php");
exit();
?>