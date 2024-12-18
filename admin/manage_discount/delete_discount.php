<?php
// Kết nối cơ sở dữ liệu
require_once("../../connect/connection.php");

// Kiểm tra nếu discount_id được gửi qua phương thức GET
if (isset($_GET['discount_id'])) {
    $discount_id = $_GET['discount_id'];

    // Kiểm tra mã giảm giá có tồn tại không
    $sql_check_discount = "SELECT * FROM discount WHERE discount_id = '$discount_id'";
    $result_check = $conn->query($sql_check_discount);

    if ($result_check->num_rows > 0) {
        // Xóa mã giảm giá khỏi cơ sở dữ liệu
        $sql_delete_discount = "DELETE FROM discount WHERE discount_id = '$discount_id'";
        
        if ($conn->query($sql_delete_discount) === TRUE) {
            echo "<script>alert('Xóa mã giảm giá thành công!'); window.location.href='../../admin.php?option=discount';</script>";
        } else {
            echo "<script>alert('Lỗi khi xóa mã giảm giá: " . $conn->error . "'); window.location.href='../../admin.php?option=discount';</script>";
        }
    } else {
        echo "<script>alert('Mã giảm giá không tồn tại!'); window.location.href='../../admin.php?option=discount';</script>";
    }
} else {
    echo "<script>alert('Không tìm thấy mã giảm giá cần xóa!'); window.location.href='../../admin.php?option=discount';</script>";
    exit();
}
?>
