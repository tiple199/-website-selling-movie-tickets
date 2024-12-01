<?php
    session_start();
    require_once('../connect/connection.php');
    $payment_id = $_REQUEST["method_id"];
    $user_id = $_SESSION["id_user"];
    $schedule_id = $_SESSION["schedule_id"];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $time_current = date('H:i:s');
    $total_price = $_SESSION["price_ticket"];
    $amount =$_SESSION["amount"];
    $date_current = date('Y-m-d H:i:s');
    
    if(isset($_SESSION["discount_id"])){
        $discount_id = $_SESSION["discount_id"];
    }
    else{
        $discount_id = null;
    }
    //truy vấn chèn vào booking
    $sql = "insert into booking(user_id,schedule_id,booking_time,total_price) values($user_id,$schedule_id,'$time_current',$total_price)";
    $conn->query($sql);
    $booking_id = $conn->insert_id;
    // Xử lý chèn bảng booking_food
    if(!empty($_SESSION["foods"])){
        
        foreach($_SESSION["foods"] as $k=>$v){
            $food_id = $k;
            $sql_food = "insert into booking_food(booking_id,food_id) values($booking_id,$food_id)";
            $conn->query($sql_food);
        }
        
    }
    // Xử lý chèn seat_booking
    foreach($_SESSION["info_seat_selected"] as $k=>$v){
        $seat_id = $v;
        $sql_seat = "insert into seat_booking(schedule_id,seat_id,booking_id,status) values($schedule_id,$seat_id,$booking_id,1)";
        $conn->query($sql_seat);
    }
    
    
    // Xử lý chèn bảng invoices
    $sql_invoice="insert into invoices(booking_id,payment_id,amount,status,date,discount_id) values($booking_id,$payment_id,$amount,1,'$date_current','$discount_id')";
    $conn->query($sql_invoice);
    Header("Location: ../home.php");
?>