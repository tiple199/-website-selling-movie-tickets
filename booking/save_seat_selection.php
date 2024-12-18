<?php
session_start(); // Khởi động session

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST["selectedSeats"])) {
        // Lấy danh sách ghế từ form
        $selectedSeats = explode(",", $_POST["selectedSeats"]); // Chuyển chuỗi thành mảng
        $_SESSION["info_seat_selected"] = $selectedSeats; // Lưu vào session

        header("Location: ./booking_food.php");
    } else {
        echo "Không có ghế nào được chọn!";
        header('Location: ./booking_film.php?schedule_id=' . $_SESSION["schedule_id"]);
    }
}
?>
