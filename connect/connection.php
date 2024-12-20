<?php
    $conn = new mysqli("localhost:3307","root","","doan1");
    if($conn->connect_error){
        die("Connection failed: " .$conn->connect_error);
    }
?>
