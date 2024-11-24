<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu số lượng từ POST
    $quantities = $_POST['quantities'];

    // Khởi tạo session nếu chưa có
    if (!isset($_SESSION['foods'])) {
        $_SESSION['foods'] = [];
    }

    // Lưu số lượng vào session
    foreach ($quantities as $foodId => $quantity) {
        $quantity = (int)$quantity;
        if ($quantity > 0) {
            $_SESSION['foods'][$foodId] = $quantity;
        } else {
            unset($_SESSION['foods'][$foodId]); // Xóa nếu số lượng bằng 0
        }
    }

    Header("Location: booking_payment.php");
    
}
