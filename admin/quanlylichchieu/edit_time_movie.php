<?php
    require_once("../../connect/connection.php"); // Kết nối đến cơ sở dữ liệu
    session_start();

    // Lấy ID phim từ URL
    $schedule_id = isset($_GET['schedule_id']) ? $_GET['schedule_id'] : 0;

    // Lấy thông tin phim từ cơ sở dữ liệu
    $sqlMovie = "SELECT * FROM schedules 
        INNER JOIN movies ON schedules.movie_id = movies.movie_id
        INNER JOIN room ON schedules.room_id = room.room_id
        INNER JOIN cinema ON room.cinema_id = cinema.cinema_id
        INNER JOIN movie__categories mc ON movies.movie_id = mc.movie_id
        INNER JOIN film_categories fc ON mc.cat_id = fc.cat_id  
        WHERE schedule_id = ?";
    $stmt = $conn->prepare($sqlMovie);
    $stmt->bind_param("i", $schedule_id);
    $stmt->execute();
    $resultMovie = $stmt->get_result();
    $schedule = $resultMovie->fetch_assoc();

    // Truy vấn dữ liệu rạp phim
    $sqlCinemas = "SELECT cinema_id, cinema_name FROM cinema";
    $resultCinemas = $conn->query($sqlCinemas);

   // Truy vấn dữ liệu phòng chiếu
   $sqlRooms = "SELECT room_id, room_name FROM room";
   $resultRooms = $conn->query($sqlRooms);

   // Truy vấn dữ liệu phim
   $sqlMovies = "SELECT movie_id, movie_name FROM movies";
   $resultMovies = $conn->query($sqlMovies);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Thu thập và làm sạch dữ liệu từ form
        $Cinema_name = isset($_POST['txtCinema']) ? trim($_POST['txtCinema']) : '';
        $Room_name = isset($_POST['txtRoom']) ? trim($_POST['txtRoom']) : '';
        $Movie_name = isset($_POST['txtMovieName']) ? $_POST['txtMovieName'] : '';
        $Day = isset($_POST['txtDay']) ? trim($_POST['txtDay']) : '';
        $Date = isset($_POST['txtDate']) ? trim($_POST['txtDate']) : '';
        $Time = isset($_POST['txtTime']) ? trim($_POST['txtTime']) : '';

    // Chuẩn bị câu lệnh SQL để cập nhật dữ liệu vào bảng schedules
       $stmt = $conn->prepare("UPDATE schedules SET show_date = ?, show_day = ?, show_time = ? WHERE schedule_id = ?");
       $stmt->bind_param("sssi",  $Date, $Day, $Time, $schedule['schedule_id']);

    // Thực thi câu lệnh
        if ($stmt->execute()) {
            echo "<script>alert('Đã sửa lịch chiếu thành công'); window.location.href='../../admin.php?option=schedule';</script>";
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

    <style>
           body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container_1 {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .inner-content {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 10px;
        }
        input[type="text"], input[type="date"], select {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"], input[type="reset"], input[type="button"] {
            background-color:rgb(8, 19, 239);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        input[type="submit"]:hover, input[type="reset"]:hover, input[type="button"]:hover {
            background-color: rgb(8, 19, 239);
        }
        .button-container {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container_1 d-flex">
        <h1 align="center">Sửa lịch chiếu</h1>
        <div class="inner-content">
            <form action="" method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td align="right">Rạp chiếu:</td>
                        <td><input type="text" name="txtCinema" value="<?php echo htmlspecialchars($schedule['cinema_name']); ?>"></td>
                    </tr>
                    <tr>
                        <td align="right">Phòng chiếu:</td>
                        <td><input type="text" name="txtRoom" value="<?php echo htmlspecialchars($schedule['room_name']); ?>"></td>
                    </tr>
                    <tr>
                        <td align="right">Tên phim:</td>
                        <td><input type="text" name="txtMovieName" value="<?php echo htmlspecialchars($schedule['movie_name']); ?>"></td>
                    </tr>
                    <tr>
                        <td align="right">Thứ chiếu:</td>
                        <td><input type="text" name="txtDay" value="<?php echo htmlspecialchars($schedule['show_day']); ?>"></td>
                    </tr>
                    <tr>
                        <td align="right">Ngày chiếu:</td>
                        <td><input type="date" name="txtDate" value="<?php echo htmlspecialchars($schedule['show_date']); ?>"></td>
                    </tr>
                    <tr>
                        <td align="right">Thời gian chiếu:</td>
                        <td><input type="text" name="txtTime" value="<?php echo htmlspecialchars($schedule['show_time']); ?>"></td>
                    </tr>
                    <tr>
                        <td><input type="submit" name = "cmd" value = "Submit"></td>
                        <td><input type="reset" value = "Reset"></td>
                        <td><input type="button" value = "Back" onclick="window.location.href='../../admin.php?option=schedule'"></td>
                    </tr>
                </table>      
            </form>
        </div>
    </div>
</body>
</html>