<?php
require_once("../../connect/connection.php");

// Lấy ID phòng chiếu
$room_id = $_GET['id'] ?? '';

// Xóa ghế liên quan đến phòng chiếu
$delete_seats_sql = "DELETE FROM seats WHERE room_id = ?";
$delete_seats_stmt = $conn->prepare($delete_seats_sql);
$delete_seats_stmt->bind_param('i', $room_id);

if ($delete_seats_stmt->execute()) {
    // Sau khi xóa ghế, xóa phòng chiếu
    $delete_room_sql = "DELETE FROM room WHERE room_id = ?";
    $delete_room_stmt = $conn->prepare($delete_room_sql);
    $delete_room_stmt->bind_param('i', $room_id);

    if ($delete_room_stmt->execute()) {
        echo "<script>alert('Xóa phòng chiếu và các ghế thành công!'); window.location.href='../../admin.php?option=room';</script>";
    } else {
        echo "<script>alert('Có lỗi khi xóa phòng chiếu: " . $delete_room_stmt->error . "');</script>";
    }
} else {
    echo "<script>alert('Có lỗi khi xóa ghế: " . $delete_seats_stmt->error . "');</script>";
}

$delete_seats_stmt->close();
$delete_room_stmt->close();
?>