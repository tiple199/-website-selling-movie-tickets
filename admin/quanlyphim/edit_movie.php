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

// Lấy thông tin nội dung phim từ cơ sở dữ liệu
$sqlContentfilm = "SELECT * FROM content_film WHERE movie_id = ?";
$stmt = $conn->prepare($sqlContentfilm);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$resultContentfilm = $stmt->get_result();
$Contentfilm= $resultContentfilm->fetch_assoc();


// Lấy danh mục
$sqlCategories = "SELECT film_categories.cat_id FROM film_categories
                  INNER JOIN movie__categories ON film_categories.cat_id = movie__categories.cat_id
                  WHERE movie__categories.movie_id = ?";
$stmtCat = $conn->prepare($sqlCategories);
$stmtCat->bind_param("i", $movie_id);
$stmtCat->execute();
$resultCat = $stmtCat->get_result();
$categories = [];
while ($row = $resultCat->fetch_assoc()) {
    $categories[] = $row['cat_id'];
}

// Lấy danh sách các đạo diễn tham gia bộ phim từ bảng movie__director
$sqlDirectors = "SELECT director.d_id, d_name FROM director 
                 INNER JOIN movie__director ON director.d_id = movie__director.d_id 
                 WHERE movie__director.movie_id = ?";
$stmtDirectors = $conn->prepare($sqlDirectors);
$stmtDirectors->bind_param("i", $movie_id);
$stmtDirectors->execute();
$resultDirectors = $stmtDirectors->get_result();
$directors = [];
while ($row = $resultDirectors->fetch_assoc()) {
    $directors[] = $row;  // Lưu lại thông tin đạo diễn (ID và tên)
}

// Lấy danh sách các actor tham gia bộ phim từ bảng movie__actor
$sqlActors = "SELECT actor.a_id, a_name FROM actor 
              INNER JOIN movie__actor ON actor.a_id = movie__actor.a_id 
              WHERE movie__actor.movie_id = ?";
$stmtActors = $conn->prepare($sqlActors);
$stmtActors->bind_param("i", $movie_id);
$stmtActors->execute();
$resultActors = $stmtActors->get_result();
$actors = [];
while ($row = $resultActors->fetch_assoc()) {
    $actors[] = $row;  // Lưu lại thông tin diễn viên (ID và tên)
}

// Lấy danh sách các thể loại của bộ phim từ bảng genre__film
$sqlGenres = "SELECT genre_film.g_id, g_name FROM genre_film
              INNER JOIN movie__genre ON genre_film.g_id = movie__genre.genre_id
              WHERE movie__genre.movie_id = ?";
$stmtGenres = $conn->prepare($sqlGenres);
$stmtGenres->bind_param("i", $movie_id);
$stmtGenres->execute();
$resultGenres = $stmtGenres->get_result();
$genres = [];
while ($row = $resultGenres->fetch_assoc()) {
    $genres[] = $row;  // Lưu lại thông tin thể loại (ID và tên thể loại)
}



// Xử lý cập nhật phim khi người dùng gửi biểu mẫu
// Kiểm tra nếu biểu mẫu đã được gửi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ biểu mẫu
    $movie_name = $_POST['txtMovieName'];
    $movie_minage = $_POST['txtMovieMinage'];
    $movie_trailer = $_POST['txtMovieTrailer'];
    $movie_time = $_POST['txtMovieTime'];
    $movie_date = $_POST['txtMovieDate'];
    $movie_nation = $_POST['txtMovieNation'];
    $movie_manufacturer = $_POST['txtMovieManufac'];
    $movie_status = $_POST['txtMovieStatus'];

    $movie_content_part1 = $_POST['txtMovieContentPart1'];
    $movie_content_part2 = $_POST['txtMovieContentPart2'];
    $movie_content_part3 = $_POST['txtMovieContentPart3'];
    $movie_content_part4 = $_POST['txtMovieContentPart4'];
    $movie_content_part5 = $_POST['txtMovieContentPart5'];

    $movie_categories = $_POST['txtMovieCategories'] ?? [];
    $actors = $_POST['actors'] ?? [];
    $directors = $_POST['directors'] ?? [];
    $genres = $_POST['genres'] ?? [];

    // Xử lý file ảnh nếu có upload
    if (isset($_FILES['txtMovieImage']) && $_FILES['txtMovieImage']['error'] === UPLOAD_ERR_OK) {
        $movie_image = $_FILES['txtMovieImage']['name'];
        $target_dir = "../../assets/image/image__film/";
        $target_file = $target_dir . basename($movie_image);
        move_uploaded_file($_FILES['txtMovieImage']['tmp_name'], $target_file);
    } else {
        $movie_image = $movie['movie_img']; // Nếu không upload ảnh mới, giữ nguyên ảnh cũ
    }

    // Cập nhật bảng `movies`
    $sqlUpdateMovie = "UPDATE movies SET 
        movie_name = ?, 
        movie_img = ?, 
        movie_minage = ?, 
        movie_time = ?, 
        movie_date = ?, 
        movie_nation = ?, 
        movie_manufacturer = ?, 
        movie_trailer = ?,
        movie_status = ? 
        WHERE movie_id = ?";
    $stmt = $conn->prepare($sqlUpdateMovie);
    $stmt->bind_param("ssssssssii", $movie_name, $movie_image, $movie_minage, $movie_time, $movie_date, $movie_nation, $movie_manufacturer, $movie_trailer, $movie_status, $movie_id);
    $stmt->execute();

    // Cập nhật bảng `content_film`
    $sqlUpdateContent = "UPDATE content_film SET 
        content_part1 = ?, 
        content_part2 = ?, 
        content_part3 = ?, 
        content_part4 = ?, 
        content_part5 = ? 
        WHERE movie_id = ?";
    $stmt = $conn->prepare($sqlUpdateContent);
    $stmt->bind_param("sssssi", $movie_content_part1, $movie_content_part2, $movie_content_part3, $movie_content_part4, $movie_content_part5, $movie_id);
    $stmt->execute();

    // Cập nhật bảng `movie__categories`
    $sqlDeleteCategories = "DELETE FROM movie__categories WHERE movie_id = ?";
    $stmt = $conn->prepare($sqlDeleteCategories);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $sqlInsertCategory = "INSERT INTO movie__categories (movie_id, cat_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sqlInsertCategory);
    foreach ($movie_categories as $cat_id) {
        $stmt->bind_param("ii", $movie_id, $cat_id);
        $stmt->execute();
    }

    // Cập nhật bảng `movie__actor`
    $sqlDeleteActors = "DELETE FROM movie__actor WHERE movie_id = ?";
    $stmt = $conn->prepare($sqlDeleteActors);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    // Xử lý và chèn diễn viên
    foreach ($actors as $actor_name) {
        // Kiểm tra xem diễn viên có trong bảng `actor` không
        $sqlCheckActor = "SELECT a_id FROM actor WHERE a_name = ?";
        $stmtCheckActor = $conn->prepare($sqlCheckActor);
        $stmtCheckActor->bind_param("s", $actor_name);
        $stmtCheckActor->execute();
        $resultCheckActor = $stmtCheckActor->get_result();

        if ($resultCheckActor->num_rows > 0) {
            // Diễn viên đã tồn tại, lấy id
            $resultActor = $resultCheckActor->fetch_assoc();
            $actor_id = $resultActor['a_id'];
        } else {
            // Diễn viên chưa tồn tại, thêm mới vào bảng `actor`
            $sqlInsertActor = "INSERT INTO actor (a_name) VALUES (?)";
            $stmtInsertActor = $conn->prepare($sqlInsertActor);
            $stmtInsertActor->bind_param("s", $actor_name);
            $stmtInsertActor->execute();
            $actor_id = $stmtInsertActor->insert_id;
        }
    // Chèn vào bảng `movie__actor`
    $sqlInsertMovieActor = "INSERT INTO movie__actor (a_id, movie_id) VALUES (?, ?)";
    $stmtInsertMovieActor = $conn->prepare($sqlInsertMovieActor);
    $stmtInsertMovieActor->bind_param("ii", $actor_id,$movie_id);
    $stmtInsertMovieActor->execute();
    }

    // Cập nhật bảng `movie__director`
    $sqlDeleteDirectors = "DELETE FROM movie__director WHERE movie_id = ?";
    $stmt = $conn->prepare($sqlDeleteDirectors);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    // Xử lý và chèn đạo diễn
    foreach ($directors as $director_name) {
        // Kiểm tra xem đạo diễn có trong bảng `director` không
        $sqlCheckDirector = "SELECT d_id FROM director WHERE d_name = ?";
        $stmtCheckDirector = $conn->prepare($sqlCheckDirector);
        $stmtCheckDirector->bind_param("s", $director_name);
        $stmtCheckDirector->execute();
        $resultCheckDirector = $stmtCheckDirector->get_result();

        if ($resultCheckDirector->num_rows > 0) {
            // Đạo diễn đã tồn tại, lấy id
            $resultDirector = $resultCheckDirector->fetch_assoc();
            $director_id = $resultDirector['d_id'];
        } else {
            // Đạo diễn chưa tồn tại, thêm mới vào bảng `director`
            $sqlInsertDirector = "INSERT INTO director (d_name) VALUES (?)";
            $stmtInsertDirector = $conn->prepare($sqlInsertDirector);
            $stmtInsertDirector->bind_param("s", $director_name);
            $stmtInsertDirector->execute();
            $director_id = $stmtInsertDirector->insert_id;
        }
        // Chèn vào bảng `movie__director`
        $sqlInsertMovieDirector = "INSERT INTO movie__director (d_id, movie_id) VALUES (?, ?)";
        $stmtInsertMovieDirector = $conn->prepare($sqlInsertMovieDirector);
        $stmtInsertMovieDirector->bind_param("ii", $director_id, $movie_id);
        $stmtInsertMovieDirector->execute();
    }

    // Cập nhật bảng `movie__genre`
    $sqlDeleteGenres = "DELETE FROM movie__genre WHERE movie_id = ?";
    $stmt = $conn->prepare($sqlDeleteGenres);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    // Xử lý và chèn thể loại
    foreach ($genres as $genre_name) {
        // Kiểm tra xem thể loại có trong bảng `genre_film` không
        $sqlCheckGenre = "SELECT g_id FROM genre_film WHERE g_name = ?";
        $stmtCheckGenre = $conn->prepare($sqlCheckGenre);
        $stmtCheckGenre->bind_param("s", $genre_name);
        $stmtCheckGenre->execute();
        $resultCheckGenre = $stmtCheckGenre->get_result();

        if ($resultCheckGenre->num_rows > 0) {
            // Thể loại đã tồn tại, lấy id
            $resultGenre = $resultCheckGenre->fetch_assoc();
            $genre_id = $resultGenre['g_id'];
        } else {
            // Thể loại chưa tồn tại, thêm mới vào bảng `genre_film`
            $sqlInsertGenre = "INSERT INTO genre_film (g_name) VALUES (?)";
            $stmtInsertGenre = $conn->prepare($sqlInsertGenre);
            $stmtInsertGenre->bind_param("s", $genre_name);
            $stmtInsertGenre->execute();
            $genre_id = $stmtInsertGenre->insert_id;
        }
        // Chèn vào bảng `movie__genre`
        $sqlInsertMovieGenre = "INSERT INTO movie__genre (genre_id, movie_id) VALUES (?, ?)";
        $stmtInsertMovieGenre = $conn->prepare($sqlInsertMovieGenre);
        $stmtInsertMovieGenre->bind_param("ii", $genre_id, $movie_id);
        $stmtInsertMovieGenre->execute();
    }

    // Hoàn tất và chuyển hướng
    echo "<script>alert('Đã sửa phim thành công'); window.location.href='../../admin.php?option=movie';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style_movie.css">
    <title>Sửa Phim</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <a href="../../admin.php?option=movie"><i class="fa-solid fa-arrow-left"></i></a>
        <h1>Sửa Phim</h1>
        <table style="width: 100%">
            <tr>
                <td align="right">Tên phim:</td>
                <td><input type="text" name="txtMovieName" value="<?php echo htmlspecialchars($movie['movie_name']); ?>"></td>
            </tr>
            <tr>
                <td align="right">Hình ảnh:</td>
                <td><input type="file" name="txtMovieImage"></td>
            </tr>
            <tr>
                <td align="right">Trailer:</td>
                <td><input type="text" name="txtMovieTrailer" value="<?php echo htmlspecialchars($movie['movie_trailer']); ?>"></td>
            </tr>
            <tr>
                <td align="right">Nhãn:</td>
                <td><input type="text" name="txtMovieMinage" value="<?php echo htmlspecialchars($movie['movie_minage']); ?>"></td>
            </tr>
            <tr>
                <td align="right">Thời gian:</td>
                <td><input type="text" name="txtMovieTime" value="<?php echo htmlspecialchars($movie['movie_time']); ?>"></td>
            </tr>
            <tr>
                <td align="right">Ngày chiếu:</td>
                <td><input type="date" name="txtMovieDate" value="<?php echo htmlspecialchars($movie['movie_date']); ?>"></td>
            </tr>
            <tr>
                <td align="right">Quốc gia:</td>
                <td><input type="text" name="txtMovieNation" value="<?php echo htmlspecialchars($movie['movie_nation']); ?>"></td>
            </tr>
            <tr>
                <td align="right">Nhà sản xuất:</td>
                <td><input type="text" name="txtMovieManufac" value="<?php echo htmlspecialchars($movie['movie_manufacturer']); ?>"></td>
            </tr>
            <tr>
                <td align="right">Trạng thái:</td>
                <td>
                    <input type="radio" name="txtMovieStatus" value="1" <?php if ($movie['movie_status'] == 1) echo 'checked'; ?>> Active
                    <input type="radio" name="txtMovieStatus" value="0" <?php if ($movie['movie_status'] == 0) echo 'checked'; ?>> Inactive
                </td>
            </tr>
            <tr>
                <td align="right">Nội dung:</td>
                <td>
                    <textarea name="txtMovieContentPart1"><?php echo $Contentfilm['content_part1']; ?></textarea>
                    <textarea name="txtMovieContentPart2"><?php echo $Contentfilm['content_part2']; ?></textarea>
                    <textarea name="txtMovieContentPart3"><?php echo $Contentfilm['content_part3']; ?></textarea>
                    <textarea name="txtMovieContentPart4"><?php echo $Contentfilm['content_part4']; ?></textarea>
                    <textarea name="txtMovieContentPart5"><?php echo $Contentfilm['content_part5']; ?></textarea>
                </td>
            </tr>
            <tr>
                <td align="right">Diễn viên:</td>
                <td>
                    <?php
                    // Hiển thị danh sách diễn viên với ô input cho mỗi diễn viên
                    foreach ($actors as $actor) {
                        echo "<input type='text' name='actors[]' value='" . htmlspecialchars($actor['a_name']) . "'>";
                        echo "<br>";  // Tạo dòng mới cho mỗi diễn viên
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td align="right">Đạo diễn:</td>
                <td>
                    <?php
                    // Hiển thị danh sách đạo diễn với ô input cho mỗi đạo diễn
                    foreach ($directors as $director) {
                        echo "<input type='text' name='directors[]' value='" . htmlspecialchars($director['d_name']) . "'>";
                        echo "<br>";  // Tạo dòng mới cho mỗi đạo diễn
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td align="right">Thể loại:</td>
                <td>
                    <?php
                    // var_dump($genres);
                    // return;
                    // Hiển thị danh sách thể loại với ô input cho mỗi thể loại
                    foreach ($genres as $genre) {
                        echo "<input type='text' name='genres[]' value='" . htmlspecialchars($genre['g_name']) . "'>";
                        echo "<br>";  // Tạo dòng mới cho mỗi thể loại
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td align="right">Danh mục phim:</td>
                <td>
                    <?php
                    // var_dump($categories);
                    // return;
                    foreach ($categories as $category) {
                    ?>
                    <select name="txtMovieCategories[]">
                        <?php
                        $sqlCatFilm = "SELECT * FROM film_categories";
                        $result = $conn->query($sqlCatFilm);
                        while ($row = $result->fetch_assoc()) {
                            // Kiểm tra nếu danh mục đã được chọn để hiển thị thuộc tính 'selected'
                            if($row["cat_id"] == $category) {
                                $selected = 'selected';
                            }else{
                                $selected = '';
                            };
                            echo "<option value='" . $row['cat_id'] . "' " . $selected . ">" . htmlspecialchars($row['cat_name']) . "</option>";
                        }
                        ?>
                    </select>
                    <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><input type="reset" value="Hủy"></td>
                <td align="right"><input type="submit" name="cmd" value="Cập nhật"></td>
            </tr>
        </table>
    </form>
</body>
</html>
