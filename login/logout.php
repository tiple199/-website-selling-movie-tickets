<?php
session_start();
unset($_SESSION["login_status"]);
unset($_SESSION["user_logged_in"]);
unset($_SESSION["id_user"]);
header("Location: ../home.php");
?>