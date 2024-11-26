<?php
session_start();
unset($_SESSION["login_status"]);
unset($_SESSION["id_user"]);
header("Location: ../home.php");
?>