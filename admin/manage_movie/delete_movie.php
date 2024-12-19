<?php
require_once("../../connect/connection.php"); // Kết nối đến cơ sở dữ liệu
session_start();

if (isset($_GET['movie_id'])) {
    $movie_id = intval($_GET['movie_id']); // Lấy movie_id từ URL và đảm bảo là số nguyên

    // Cập nhật trạng thái phim thành 0 (inactive)
    $update_movie_status_sql = "UPDATE movies SET movie_status = 0 WHERE movie_id = ?";
    $update_movie_status_stmt = $conn->prepare($update_movie_status_sql);
    $update_movie_status_stmt->bind_param('i', $movie_id);

    if ($update_movie_status_stmt->execute()) {
        echo "<script>alert('Cập nhật trạng thái phim thành công!'); window.location.href='../../admin.php?option=movie';</script>";
    } else {
        echo "<script>alert('Đã xảy ra lỗi khi cập nhật trạng thái phim: " . $update_movie_status_stmt->error . "'); window.location.href='../../admin.php?option=movie';</script>";
    }

    $update_movie_status_stmt->close();
} else {
    echo "<script>alert('Không tìm thấy ID phim!'); window.location.href='../../admin.php?option=movie';</script>";
    exit();
}
?>