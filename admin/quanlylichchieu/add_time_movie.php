<?php
session_start();
if(!isset($_SESSION["time_movie_error"])){
    $_SESSION["time_movie_error"] = "";  
}
require_once("../../connect/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $IdMovie = isset($_POST['txtIdMovie']) ? trim($_POST['txtIdMovie']) : '';
    $RoomId = isset($_POST['txtRoomId']) ? trim($_POST['txtRoomId']) : '';
    $Date = isset($_POST['txtDate']) ? trim($_POST['txtDate']) : '';
    $Time = isset($_POST['txtTime']) ? trim($_POST['txtTime']) : '';
    $Day = isset($_POST['txtDay']) ? trim($_POST['txtDay']) : '';

    // Prepare SQL query to insert data into the food table using prepared statements
    $stmt = $conn->prepare("INSERT INTO schedules (movie_id, room_id, show_date, show_day, show_time) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $IdMovie, $RoomId, $Date, $Day, $Time);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1 align="center">Thêm mới đồ ăn</h1>
    <div align="center"><a href="/doan/-website-selling-movie-tickets/admin.php" style="text-decoration:none">Home</a></div><br>
    <center>
        <font color = "red"><?php echo $_SESSION["time_movie_error"];?></font>
    </center>
    <form action="add_time_movie.php" method="post" enctype="multipart/form-data">
        <table align="center" border="0">
            <!-- Thông tin đồ ăn -->
            <tr>
                <td align="right">Id phim:</td>
                <td><input type="text" name="txtIdMovie"></td>
            </tr>
            <tr>
                <td align="right">Id phòng chiếu:</td>
                <td><input type="text" name="txtRoomId"></td>
            </tr>
            <tr>
                <td align="right">Ngày chiếu:</td>
                <td><input type="date" name="txtDate"></td>
            </tr>
            <tr>
                <td align="right">Giờ chiếu:</td>
                <td><input type="text" name="txtTime"></td>
            </tr>
            <tr>
                <td align="right">Thứ chiếu:</td>
                <td><input type="text" name="txtDay"></td>
            </tr>
            <tr>
                <td><input type="submit" name = "cmd" value = "Submit"></td>
                <td><input type="reset" value = "Reset"></td>
            </tr>
        </table>
</body>
</html>
<?php $_SESSION["time_movie_error"] = "";?>