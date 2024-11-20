<?php
session_start();
require_once("connect/connection.php");

// Hàm kiểm tra và chèn nếu chưa tồn tại
function checkAndInsert($conn, $table, $column, $value) {
    $stmt = $conn->prepare("SELECT * FROM $table WHERE $column = ?");
    $stmt->bind_param("s", $value);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Nếu tồn tại, trả về ID
        $row = $result->fetch_assoc();
        return $row[array_key_first($row)];
    } else {
        // Nếu chưa tồn tại, chèn vào bảng và trả về ID mới
        $stmt = $conn->prepare("INSERT INTO $table ($column) VALUES (?)");
        $stmt->bind_param("s", $value);
        $stmt->execute();
        return $stmt->insert_id;
    }
}

// Lấy dữ liệu từ form
$movieName = $_POST['txtMovieName'];
$movieImage = $_FILES['txtMovieImage']['name'];
$movieMinage = $_POST['txtMovieMinage'];
$movieTime = $_POST['txtMovieTime'];
$movieDate = $_POST['txtMovieDate'];
$movieNation = $_POST['txtMovieNation'];
$movieManufacturer = $_POST['txtMovieManufac'];
$movieStatus = $_POST['txtMovieStatus'];
$movieContent = $_POST['txtMovieContent'];
$directors = $_POST['txtNameDirector'];
$actors = $_POST['txtNameActor'];
$genres = $_POST['txtNameGenre'];
$categories = $_POST['txtMovieCategories'];

// Xử lý tải hình ảnh
$targetDir = "assets/image/image__film/";
$targetFile = $targetDir . basename($movieImage);
if (!move_uploaded_file($_FILES["txtMovieImage"]["tmp_name"], $targetFile)) {
    die("Có lỗi xảy ra khi tải hình ảnh.");
}

// Chèn vào bảng movies
$stmt = $conn->prepare("INSERT INTO movies (movie_name, movie_img, movie_minage, movie_time, movie_date, movie_nation, movie_manufacturer, movie_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssi", $movieName, $movieImage, $movieMinage, $movieTime, $movieDate, $movieNation, $movieManufacturer, $movieStatus);
$stmt->execute();
$movieId = $stmt->insert_id;

// Chèn nội dung phim vào bảng content_film
$stmt = $conn->prepare("INSERT INTO content_film (content_part1) VALUES (?)");
$stmt->bind_param("s", $movieContent);
$stmt->execute();
$contentId = $stmt->insert_id;

// Liên kết phim và nội dung
$stmt = $conn->prepare("INSERT INTO movie_content (movie_id, content_id) VALUES (?, ?)");
$stmt->bind_param("ii", $movieId, $contentId);
$stmt->execute();

// Xử lý thêm đạo diễn
foreach ($directors as $director) {
    if (!empty($director)) {
        $directorId = checkAndInsert($conn, "director", "d_name", $director);

        // Liên kết phim và đạo diễn
        $stmt = $conn->prepare("INSERT INTO movie_director (movie_id, d_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $movieId, $directorId);
        $stmt->execute();
    }
}

// Xử lý thêm diễn viên
foreach ($actors as $actor) {
    if (!empty($actor)) {
        $actorId = checkAndInsert($conn, "actor", "a_name", $actor);

        // Liên kết phim và diễn viên
        $stmt = $conn->prepare("INSERT INTO movie_actor (movie_id, a_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $movieId, $actorId);
        $stmt->execute();
    }
}

// Xử lý thêm thể loại
foreach ($genres as $genre) {
    if (!empty($genre)) {
        $genreId = checkAndInsert($conn, "genre_film", "g_name", $genre);

        // Liên kết phim và thể loại
        $stmt = $conn->prepare("INSERT INTO movie_genre (movie_id, genre_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $movieId, $genreId);
        $stmt->execute();
    }
}

// Xử lý thêm danh mục phim
foreach ($categories as $categoryId) {
    if (!empty($categoryId)) {
        // Liên kết phim và danh mục
        $stmt = $conn->prepare("INSERT INTO movie_categories (movie_id, cat_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $movieId, $categoryId);
        $stmt->execute();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie</title>
</head>
<body>
    <h1>Thêm Mới Phim</h1>
    <form action="movie_add.php" method="post" enctype="multipart/form-data">
        <table border="0">
            <!-- Thông tin phim -->
            <tr>
                <td align="right">Tên phim:</td>
                <td><input type="text" name="txtMovieName"></td>
            </tr>
            <tr>
                <td align="right">Hình ảnh:</td>
                <td><input type="file" name="txtMovieImage"></td>
            </tr>
            <tr>
                <td align="right">Nhãn:</td>
                <td><input type="text" name="txtMovieMinage"></td>
            </tr>
            <tr>
                <td align="right">Thời gian:</td>
                <td><input type="text" name="txtMovieTime"></td>
            </tr>
            <tr>
                <td align="right">Ngày Chiếu:</td>
                <td><input type="date" name="txtMovieDate"></td>
            </tr>
            <tr>
                <td align="right">Quốc gia:</td>
                <td><input type="text" name="txtMovieNation"></td>
            </tr>
            <tr>
                <td align="right">Nhà sản xuất:</td>
                <td><input type="text" name="txtMovieManufac"></td>
            </tr>
            <tr>
                <td align="right">Trạng thái:</td>
                <td>
                    <input type="radio" name="txtMovieStatus" value="1">Active
                    <input type="radio" name="txtMovieStatus" value="0">Inactive
                </td>
            </tr>
            <!-- Nội dung phim -->
            <tr>
                <td align="right">Nội dung phim:</td>
                <td>
                    <textarea name="txtMovieContent" rows="5" cols="40"></textarea>
                </td>
            </tr>

            <!-- Thêm đạo diễn -->
            <tr>
                <td align="right">Tên đạo diễn:</td>
                <td>
                    <div id="directorsContainer">
                        <input type="text" name="txtNameDirector[]">
                    </div>
                    <button type="button" onclick="addField('directorsContainer', 'txtNameDirector[]')">Thêm đạo diễn</button>
                </td>
            </tr>

            <!-- Thêm diễn viên -->
            <tr>
                <td align="right">Tên diễn viên:</td>
                <td>
                    <div id="actorsContainer">
                        <input type="text" name="txtNameActor[]">
                    </div>
                    <button type="button" onclick="addField('actorsContainer', 'txtNameActor[]')">Thêm diễn viên</button>
                </td>
            </tr>

            <!-- Thêm thể loại -->
            <tr>
                <td align="right">Tên thể loại:</td>
                <td>
                    <div id="genresContainer">
                        <input type="text" name="txtNameGenre[]">
                    </div>
                    <button type="button" onclick="addField('genresContainer', 'txtNameGenre[]')">Thêm thể loại</button>
                </td>
            </tr>

            <!-- Thêm danh mục phim -->
            <tr>
                <td align="right">Danh Mục Phim:</td>
                <td>
                    <div id="categoriesContainer">
                        <select name="txtMovieCategories[]">
                            <?php
                            $sqlCatFilm = "SELECT * FROM film_categories";
                            $result = $conn->query($sqlCatFilm);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['cat_id']}'>{$row['cat_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="button" onclick="addField('categoriesContainer', 'txtMovieCategories[]', 'select')">Thêm danh mục</button>
                </td>
            </tr>

            <tr>
                <td><input type="submit" name="cmd" value="Cập nhật"></td>
                <td><input type="reset" value="Hủy"></td>
            </tr>
        </table>
    </form> 
    <script>
        // Hàm thêm trường động
        function addField(containerId, fieldName, fieldType = 'input') {
            const container = document.getElementById(containerId);
            let field;

            if (fieldType === 'input') {
                field = document.createElement("input");
                field.type = "text";
                field.name = fieldName;
            } else if (fieldType === 'select') {
                field = document.querySelector(`#${containerId} select`).cloneNode(true);
                field.name = fieldName;
            }

            container.appendChild(field);
            container.appendChild(document.createElement("br"));
        }
    </script>
</body>
</html>
