<?php
require_once("../../connect/connection.php"); // Kết nối đến cơ sở dữ liệu
session_start();

// Lấy ID phim từ URL
$schedule_id = isset($_GET['schedule_id']) ? $_GET['schedule_id'] : 0;

// Lấy thông tin phim từ cơ sở dữ liệu
$sqlMovie = "SELECT * FROM schedules WHERE schedule_id = ?";
$stmt = $conn->prepare($sqlMovie);
$stmt->bind_param("i", $schedule_id);
$stmt->execute();
$resultMovie = $stmt->get_result();
$schedule = $resultMovie->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Thu thập và làm sạch dữ liệu từ form
    $IdMovie = isset($_POST['txtIdMovie']) ? trim($_POST['txtIdMovie']) : '';
    $RoomId = isset($_POST['txtIdRoom']) ? trim($_POST['txtIdRoom']) : '';
    $Date = isset($_POST['txtDate']) ? $_POST['txtDate'] : '';
    $Day = isset($_POST['txtDay']) ? trim($_POST['txtDay']) : '';
    $Time = isset($_POST['txtTime']) ? trim($_POST['txtTime']) : '';

    // Chuẩn bị câu lệnh SQL để cập nhật dữ liệu vào bảng schedules
    $stmt = $conn->prepare("UPDATE schedules SET movie_id = ?, room_id = ?, show_date = ?, show_day = ?, show_time = ? WHERE schedule_id = ?");
    $stmt->bind_param("sssssi", $IdMovie, $RoomId, $Date, $Day, $Time, $schedule['schedule_id']);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        echo "Cập nhật thành công";
    } else {
        echo "Lỗi: " . $stmt->error;
    }

    // Đóng câu lệnh
    $stmt->close();
}

// Đóng kết nối
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Sửa lịch chiếu</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Id phim:</td>
                <td><input type="text" name="txtIdMovie" value="<?php echo htmlspecialchars($schedule['movie_id']); ?>"></td>
            </tr>
            <tr>
                <td>Id phòng:</td>
                <td><input type="text" name="txtIdRoom" value="<?php echo htmlspecialchars($schedule['room_id']); ?>"></td>
            </tr>
            <tr>
                <td>Ngày chiếu:</td>
                <td><input type="date" name="txtDate" value="<?php echo htmlspecialchars($schedule['show_date']); ?>"></td>
            </tr>
            <tr>
                <td>Thứ chiếu:</td>
                <td><input type="text" name="txtDay" value="<?php echo htmlspecialchars($schedule['show_day']); ?>"></td>
            </tr>
            <tr>
                <td>Giờ chiếu:</td>
                <td><input type="text" name="txtTime" value="<?php echo htmlspecialchars($schedule['show_time']); ?>"></td>
            </tr>
        </table>
        <button type="submit">Cập nhật</button>
    </form>
</body>
</html>