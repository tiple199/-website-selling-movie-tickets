<?php
// Kết nối cơ sở dữ liệu
require_once("../../connect/connection.php");
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    $_SESSION["login_error"] = "Vui lòng đăng nhập để tiếp tục!";
    header("Location: ../.././home.php");
    exit;
}

// Kiểm tra nếu `g_id` được truyền qua phương thức GET
if (isset($_GET['g_id'])) {
    $g_id = $_GET['g_id'];

    // Kiểm tra xem thể loại có tồn tại không
    $sql_check_genre = "SELECT * FROM genre_film WHERE g_id = ?";
    $stmt = $conn->prepare($sql_check_genre);
    $stmt->bind_param("i", $g_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Xóa thể loại
        $sql_delete_genre = "DELETE FROM genre_film WHERE g_id = ?";
        $stmt = $conn->prepare($sql_delete_genre);
        $stmt->bind_param("i", $g_id);

        if ($stmt->execute()) {
            echo "<script>alert('Xóa thể loại phim thành công!'); window.location.href='../../admin.php?option=genre';</script>";
        } else {
            echo "<script>alert('Lỗi khi xóa thể loại: " . $conn->error . "'); window.location.href='../../admin.php?option=genre';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Thể loại không tồn tại!'); window.location.href='../../admin.php?option=genre';</script>";
    }
} else {
    echo "<script>alert('Không tìm thấy ID thể loại!'); window.location.href='../../admin.php?option=genre';</script>";
    exit();
}
?>