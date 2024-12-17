<?php
require_once("../../connect/connection.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_name = $_POST['room_name'];
    $cinema_id = $_POST['cinema_id'];
    $length = $_POST['length'];
    $width = $_POST['width'];

    // Thêm thông tin phòng chiếu vào cơ sở dữ liệu
    $sql = "INSERT INTO room (room_name, cinema_id, seat_quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $seat_quantity = (int)$length * (int)$width; // Số ghế dựa trên chiều dài và chiều rộng
    $stmt->bind_param('sii', $room_name, $cinema_id, $seat_quantity);

    if ($stmt->execute()) {
        // Lấy ID của phòng chiếu vừa tạo
        $room_id = $conn->insert_id;

        // Tạo các ghế trong phòng chiếu
        for ($i = 1; $i <= $length; $i++) {
            for ($j = 1; $j <= $width; $j++) {
                $seat_number = $j;
                $row = chr(64 + $i); // Tạo hàng (A, B, C...)

                // Điều chỉnh giá ghế và loại ghế cho hai hàng gần cuối
                if ($i >= $length - 2 && $i < $length) {
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

        echo "<script>alert('Thêm phòng chiếu và các ghế thành công!');</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Lấy danh sách rạp chiếu để hiển thị trong dropdown
$cinema_query = "SELECT cinema_id, cinema_name FROM cinema";
$cinema_result = $conn->query($cinema_query);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Phòng Chiếu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 500px;
            margin: auto;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input, select, button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Thêm Phòng Chiếu</h1>
    <form method="POST">
        <label for="room_name">Tên phòng chiếu</label>
        <input type="text" id="room_name" name="room_name" placeholder="Nhập tên phòng chiếu" required>

        <label for="cinema_id">Rạp chiếu</label>
        <select id="cinema_id" name="cinema_id" required>
            <option value="">Chọn rạp chiếu</option>
            <?php while ($row = $cinema_result->fetch_assoc()) { ?>
                <option value="<?php echo $row['cinema_id']; ?>">
                    <?php echo $row['cinema_name']; ?>
                </option>
            <?php } ?>
        </select>

        <label for="length">Chiều dài</label>
        <input type="number" id="length" name="length" placeholder="Nhập chiều dài" required>

        <label for="width">Chiều rộng</label>
        <input type="number" id="width" name="width" placeholder="Nhập chiều rộng" required>

        <button type="submit">Thêm Phòng Chiếu</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>
