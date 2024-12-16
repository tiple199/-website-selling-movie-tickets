<?php
    session_start();
    if(!isset($_SESSION["time_movie_error"])){
        $_SESSION["time_movie_error"] = "";  
    }
    require_once("../../connect/connection.php");

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
    $sqlRooms = "SELECT *  FROM room INNER JOIN cinema ON room.cinema_id = cinema.cinema_id";
    $resultRooms = $conn->query($sqlRooms);

   // Truy vấn dữ liệu phim
   $sqlMovies = "SELECT movie_id, movie_name FROM movies";
   $resultMovies = $conn->query($sqlMovies);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Thu thập và làm sạch dữ liệu từ form
        $Room_name = isset($_POST['txtRoom']) ? trim($_POST['txtRoom']) : '';
        $Movie_name = isset($_POST['txtMovieName']) ? $_POST['txtMovieName'] : '';
        $Day = isset($_POST['txtDay']) ? trim($_POST['txtDay']) : '';
        $Date = isset($_POST['txtDate']) ? trim($_POST['txtDate']) : '';
        $Time = isset($_POST['txtTime']) ? trim($_POST['txtTime']) : '';


        $stmt = $conn->prepare("INSERT INTO schedules (movie_id, room_id, show_date, show_day, show_time) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $Movie_name, $Room_name, $Date, $Day, $Time);

    // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('Đã thêm lịch chiếu thành công'); window.location.href='../../admin.php?option=schedule';</script>";
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- <link rel="stylesheet" href="../../assets/css/admin/styles.css"> -->
    
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
    <center>
        <font color = "red"><?php echo $_SESSION["time_movie_error"];?></font>
    </center>
    <div class="container_1 d-flex">
        <h1 align="center">Thêm mới lịch chiếu</h1>
        <div class="inner-content">
            <form action="add_time_movie.php" method="post" enctype="multipart/form-data">
                <table align="center" border="0">
                    <tr>
                        <td  align="right">Phòng chiếu:</td>
                        <td>
                            <select name="txtRoom">
                                <?php
                                    if ($resultRooms->num_rows > 0) {
                                        while($row = $resultRooms->fetch_assoc()) {
                                            $selected = ($row["room_id"] == $schedule["room_id"]) ? "selected" : "";
                                            echo "<option value='" . $row["room_id"] . "' $selected>" . $row["room_name"] . " - " . $row["cinema_name"] .  "</option>";
                                        }
                                    } else {
                                    echo "<option value=''>Không có dữ liệu</option>";
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td  align="right">Tên phim:</td>
                        <td>
                            <select name="txtMovieName">
                                <?php
                                    if ($resultMovies->num_rows > 0) {
                                        while($row = $resultMovies->fetch_assoc()) {
                                            $selected = ($row["movie_id"] == $schedule["movie_id"]) ? "selected" : "";
                                            echo "<option value='" . $row["movie_id"] . "' $selected>" . $row["movie_name"] . "</option>";
                                        }
                                    } else {
                                    echo "<option value=''>Không có dữ liệu</option>";
                                    }
                                ?>
                            </select>
                        </td>
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
                        <td><input type="button" value = "Back" onclick="window.location.href='../../admin.php?option=schedule'"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
        <script src = "./assets/js/admin/main.js"></script>
</body>
</html>
<?php $_SESSION["time_movie_error"] = "";?>