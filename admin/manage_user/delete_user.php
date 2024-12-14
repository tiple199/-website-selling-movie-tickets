<?php
// Kết nối cơ sở dữ liệu
require_once("../../connect/connection.php");

// Kiểm tra nếu ID được truyền qua phương thức GET
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Kiểm tra xem người dùng có tồn tại trong cơ sở dữ liệu không
    $sql_check_user = "SELECT id FROM user WHERE id = $user_id";
    $result_check = $conn->query($sql_check_user);

    if ($result_check->num_rows > 0) {
        // Nếu người dùng tồn tại, thực hiện xóa
        $sql_delete_user = "DELETE FROM user WHERE id = $user_id";

        if ($conn->query($sql_delete_user) === TRUE) {
            echo "<script>alert('Người dùng đã được xóa thành công'); window.location.href='../../admin.php?option=user';</script>";
        } else {
            echo "<script>alert('Lỗi khi xóa người dùng: " . $conn->error . "'); window.location.href='../../admin.php?option=user';</script>";
        }
    } else {
        // Nếu không tìm thấy người dùng
        echo "<script>alert('Người dùng không tồn tại'); window.location.href='../../admin.php?option=user';</script>";
    }
} else {
    // Nếu không có ID trong GET, chuyển hướng về trang danh sách
    echo "<script>alert('Không tìm thấy ID người dùng'); window.location.href='../../admin.php?option=user';</script>";
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
