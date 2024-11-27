<?php
// Kết nối cơ sở dữ liệu
require_once("../../connect/connection.php");

// Lấy ID phim từ URL
$movie_id = isset($_GET['movie_id']) ? $_GET['movie_id'] : 0;

// Lấy thông tin phim từ cơ sở dữ liệu
$sqlMovie = "SELECT * FROM movies WHERE movie_id = ?";
$stmt = $conn->prepare($sqlMovie);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$resultMovie = $stmt->get_result();
$movie = $resultMovie->fetch_assoc();


// Lấy danh mục, diễn viên, đạo diễn, thể loại liên quan
$sqlCategories = "SELECT cat_id FROM movie_categories WHERE movie_id = ?";
$stmtCat = $conn->prepare($sqlCategories);
$stmtCat->bind_param("i", $movie_id);
$stmtCat->execute();
$resultCat = $stmtCat->get_result();
$categories = [];
while ($row = $resultCat->fetch_assoc()) {
    $categories[] = $row['cat_id'];
}

$sqlActors = "SELECT a_name FROM actor INNER JOIN movie_actor ON actor.a_id = movie_actor.a_id WHERE movie_actor.movie_id = ?";
$stmtActors = $conn->prepare($sqlActors);
$stmtActors->bind_param("i", $movie_id);
$stmtActors->execute();
$resultActors = $stmtActors->get_result();
$actors = [];
while ($row = $resultActors->fetch_assoc()) {
    $actors[] = $row['a_name'];
}

$sqlDirectors = "SELECT d_name FROM director INNER JOIN movie__director ON director.d_id = movie__director.d_id WHERE movie__director.movie_id = ?";
$stmtDirectors = $conn->prepare($sqlDirectors);
$stmtDirectors->bind_param("i", $movie_id);
$stmtDirectors->execute();
$resultDirectors = $stmtDirectors->get_result();
$directors = [];
while ($row = $resultDirectors->fetch_assoc()) {
    $directors[] = $row['d_name'];
}

// Xử lý cập nhật phim khi người dùng gửi biểu mẫu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $movieName = $_POST['txtMovieName'];
    $movieMinage = $_POST['txtMovieMinage'];
    $movieTime = $_POST['txtMovieTime'];
    $movieDate = $_POST['txtMovieDate'];
    $movieNation = $_POST['txtMovieNation'];
    $movieManufac = $_POST['txtMovieManufac'];
    $movieStatus = $_POST['txtMovieStatus'];
    $movieContentParts = [
        $_POST['txtMovieContentPart1'],
        $_POST['txtMovieContentPart2'],
        $_POST['txtMovieContentPart3'],
        $_POST['txtMovieContentPart4'],
        $_POST['txtMovieContentPart5']
    ];

    // Cập nhật thông tin phim
    $sqlUpdateMovie = "UPDATE movies SET movie_name = ?, movie_minage = ?, movie_time = ?, movie_date = ?, movie_nation = ?, movie_manufacturer = ?, movie_status = ? WHERE movie_id = ?";
    $stmtUpdate = $conn->prepare($sqlUpdateMovie);
    $stmtUpdate->bind_param("sssssiii", $movieName, $movieMinage, $movieTime, $movieDate, $movieNation, $movieManufac, $movieStatus, $movie_id);
    $stmtUpdate->execute();

    // Xóa và cập nhật nội dung phim
    $sqlDeleteContent = "DELETE FROM content_film WHERE movie_id = ?";
    $stmtDeleteContent = $conn->prepare($sqlDeleteContent);
    $stmtDeleteContent->bind_param("i", $movie_id);
    $stmtDeleteContent->execute();

    foreach ($movieContentParts as $part) {
        if (!empty($part)) {
            $sqlInsertContent = "INSERT INTO content_film (content_part1, movie_id) VALUES (?, ?)";
            $stmtInsertContent = $conn->prepare($sqlInsertContent);
            $stmtInsertContent->bind_param("si", $part, $movie_id);
            $stmtInsertContent->execute();
        }
    }

    echo "Cập nhật phim thành công!";
    header("Location: movies.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Phim</title>
</head>
<body>
    <h1>Sửa Phim</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Tên phim:</td>
                <td><input type="text" name="txtMovieName" value="<?php echo htmlspecialchars($movie['movie_name']); ?>"></td>
            </tr>
            <tr>
                <td>Hình ảnh:</td>
                <td><input type="file" name="txtMovieImage"></td>
            </tr>
            <tr>
                <td>Nhãn:</td>
                <td><input type="text" name="txtMovieMinage" value="<?php echo htmlspecialchars($movie['movie_minage']); ?>"></td>
            </tr>
            <tr>
                <td>Thời gian:</td>
                <td><input type="text" name="txtMovieTime" value="<?php echo htmlspecialchars($movie['movie_time']); ?>"></td>
            </tr>
            <tr>
                <td>Ngày chiếu:</td>
                <td><input type="date" name="txtMovieDate" value="<?php echo htmlspecialchars($movie['movie_date']); ?>"></td>
            </tr>
            <tr>
                <td>Quốc gia:</td>
                <td><input type="text" name="txtMovieNation" value="<?php echo htmlspecialchars($movie['movie_nation']); ?>"></td>
            </tr>
            <tr>
                <td>Nhà sản xuất:</td>
                <td><input type="text" name="txtMovieManufac" value="<?php echo htmlspecialchars($movie['movie_manufacturer']); ?>"></td>
            </tr>
            <tr>
                <td>Trạng thái:</td>
                <td>
                    <input type="radio" name="txtMovieStatus" value="1" <?php if ($movie['movie_status'] == 1) echo 'checked'; ?>> Active
                    <input type="radio" name="txtMovieStatus" value="0" <?php if ($movie['movie_status'] == 0) echo 'checked'; ?>> Inactive
                </td>
            </tr>
            <tr>
                <td>Nội dung:</td>
                <td>
                    <textarea name="txtMovieContentPart1"><?php echo htmlspecialchars($movie['content_part1']); ?></textarea>
                    <textarea name="txtMovieContentPart2"><?php echo htmlspecialchars($movie['content_part2']); ?></textarea>
                    <!-- Thêm các phần nội dung khác nếu có -->
                </td>
            </tr>
        </table>
        <button type="submit">Cập nhật</button>
    </form>
</body>
</html>
