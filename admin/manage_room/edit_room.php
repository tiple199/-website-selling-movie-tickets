<?php
require_once("../../connect/connection.php");

$room_id = $_GET['room_id'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $room_name = $_POST['room_name'];
    $length = $_POST['length'];
    $width = $_POST['width'];

    // Cập nhật thông tin phòng chiếu
    $update_room_sql = "UPDATE room SET room_name = ?, seat_quantity = ? WHERE room_id = ?";
    $update_room_stmt = $conn->prepare($update_room_sql);
    $seat_quantity = (int)$length * (int)$width; // Tính lại số ghế dựa trên chiều dài và chiều rộng
    $update_room_stmt->bind_param('sii', $room_name, $seat_quantity, $room_id);

    if ($update_room_stmt->execute()) {
        // Xóa tất cả các ghế cũ liên quan đến phòng chiếu
        $delete_seats_sql = "DELETE FROM seats WHERE room_id = ?";
        $delete_seats_stmt = $conn->prepare($delete_seats_sql);
        $delete_seats_stmt->bind_param('i', $room_id);

        if ($delete_seats_stmt->execute()) {
            // Tạo các ghế mới trong phòng chiếu
            for ($i = 1; $i <= $length; $i++) {
                for ($j = 1; $j <= $width; $j++) {
                    $seat_number = $j;
                    $row = chr(64 + $i); // Tạo hàng (A, B, C...)

                    // Điều chỉnh giá ghế và loại ghế cho hai hàng gần cuối
                    if ($i >= $length - 2 && $i < $length && $j >= 3 && $j <= 8) {
                        $seat_price = 85000;
                        $seat_type = 1;
                    } else {
                        $seat_price = 50000;
                        $seat_type = 0;
                    }

                    $seat_status = 0;

                    $seat_sql = "INSERT INTO seats (room_id, row, seat_number, status, seat_price, seat_type) VALUES (?, ?, ?, ?, ?, ?)";
                    $seat_stmt = $conn->prepare($seat_sql);
                    $seat_stmt->bind_param('isiidi', $room_id, $row, $seat_number, $seat_status, $seat_price, $seat_type);
                    $seat_stmt->execute();
                }
            }

            echo "<script>alert('Cập nhật phòng chiếu và các ghế thành công!');</script>";
        } else {
            echo "<script>alert('Có lỗi khi xóa ghế cũ: " . $delete_seats_stmt->error . "');</script>";
        }
    } else {
        echo "<script>alert('Có lỗi khi cập nhật phòng chiếu: " . $update_room_stmt->error . "');</script>";
    }

    $update_room_stmt->close();
}

// Lấy thông tin phòng chiếu hiện tại để hiển thị trong form (nếu cần)
$room_query = "SELECT * FROM room WHERE room_id = ?";
$room_stmt = $conn->prepare($room_query);
$room_stmt->bind_param('i', $_GET['room_id']);
$room_stmt->execute();
$room_result = $room_stmt->get_result();
$room = $room_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Phòng Chiếu</title>
    <link rel="stylesheet" href="style_room.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
    <form method="POST">
        <a href="../../admin.php?option=room"><i class="fa-solid fa-arrow-left"></i></a>
        <h1>Sửa Phòng Chiếu</h1>
        <input type="hidden" name="room_id" value="<?php echo $room['room_id']; ?>">

        <label for="room_name">Tên phòng chiếu</label>
        <input type="text" id="room_name" name="room_name" value="<?php echo $room['room_name']; ?>" required>

        <label for="length">Chiều dài</label>
        <input type="number" id="length" name="length" placeholder="Nhập chiều dài" required>

        <label for="width">Chiều rộng</label>
        <input type="number" id="width" name="width" placeholder="Nhập chiều rộng" required>

        <button type="submit">Cập Nhật Phòng Chiếu</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>
