<?php
require_once("../../connect/connection.php"); // Kết nối đến cơ sở dữ liệu
session_start();

if (isset($_GET['schedule_id'])) {
    $schedule_id = intval($_GET['schedule_id']); // Lấy movie_id từ URL và đảm bảo là số nguyên

    // Câu lệnh SQL để xóa dữ liệu liên quan đến movie_id
    $queries = [
        "DELETE FROM schedules WHERE schedule_id = $schedule_id",
    ];

    $success = true; // Biến kiểm tra tất cả truy vấn đều thành công

    // Thực thi từng câu lệnh
    foreach ($queries as $query) {
        if (!mysqli_query($conn, $query)) {
            $success = false;
            break; // Dừng lại nếu có lỗi
        }
    }

    // Kiểm tra kết quả và đưa ra thông báo
    if ($success) {
        echo "<script>alert('Đã xóa lịch chiếu thành công'); window.location.href='../../admin.php?option=schedule';</script>";
    } else {
        echo "<script>alert('Đã xảy ra lỗi khi xóa lịch chiếu. Vui lòng thử lại.'); window.location.href='admin.php?option=tatca';</script>";
    }
}
?>