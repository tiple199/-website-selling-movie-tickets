<?php
session_start();
unset($_SESSION["login_status"]);
header("Location: ../home.php");
?>