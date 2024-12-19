<?php
require_once("../../connect/connection.php");

// Lấy ID phòng chiếu
$room_id = $_GET['id'] ?? '';

if (empty($room_id)) {
    echo "<script>alert('Không tìm thấy ID phòng chiếu!'); window.location.href='../../admin.php?option=room';</script>";
    exit();
}

// Cập nhật trạng thái phòng chiếu thành 0 (inactive)
$update_room_status_sql = "UPDATE room SET room_status = 0 WHERE room_id = ?";
$update_room_status_stmt = $conn->prepare($update_room_status_sql);
$update_room_status_stmt->bind_param('i', $room_id);

if ($update_room_status_stmt->execute()) {
    echo "<script>alert('Xóa phòng chiếu thành công!'); window.location.href='../../admin.php?option=room';</script>";
} else {
    echo "<script>alert('Có lỗi khi xóa phòng chiếu: " . $update_room_status_stmt->error . "');</script>";
}

$update_room_status_stmt->close();
?>