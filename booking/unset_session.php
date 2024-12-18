<?php
    unset($_SESSION["info_seat_selected"]);
    unset($_SESSION["foods"]);
    Header("Location: ../home.php");
?>