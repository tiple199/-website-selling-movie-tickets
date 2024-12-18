<?php
require_once("../../connect/connection.php");

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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movieName = isset($_POST['txtMovieName']) ? $_POST['txtMovieName'] : "";
    $movieImage = isset($_FILES['txtMovieImage']['name']) ? $_FILES['txtMovieImage']['name'] : "";
    $movieMinage = isset($_POST['txtMovieMinage']) ? $_POST['txtMovieMinage'] : "";
    $movieTime = isset($_POST['txtMovieTime']) ? $_POST['txtMovieTime'] : "";
    $movieTrailer = isset($_POST['txtMovieTrailer']) ? $_POST['txtMovieTrailer'] : "";
    $movieDate = isset($_POST['txtMovieDate']) ? $_POST['txtMovieDate'] : "";
    $movieNation = isset($_POST['txtMovieNation']) ? $_POST['txtMovieNation'] : "";
    $movieManufacturer = isset($_POST['txtMovieManufac']) ? $_POST['txtMovieManufac'] : "";
    $movieStatus = isset($_POST['txtMovieStatus']) ? $_POST['txtMovieStatus'] : "";
    $contentPart1 = !empty($_POST['txtMovieContentPart1']) ? $_POST['txtMovieContentPart1'] : "";
    $contentPart2 = !empty($_POST['txtMovieContentPart2']) ? $_POST['txtMovieContentPart2'] : "";
    $contentPart3 = !empty($_POST['txtMovieContentPart3']) ? $_POST['txtMovieContentPart3'] : "";
    $contentPart4 = !empty($_POST['txtMovieContentPart4']) ? $_POST['txtMovieContentPart4'] : "";
    $contentPart5 = !empty($_POST['txtMovieContentPart5']) ? $_POST['txtMovieContentPart5'] : "";
    $directors = $_POST['txtNameDirector'];
    $actors = $_POST['txtNameActor'];
    $genres = $_POST['txtNameGenre'];
    $categories = $_POST['txtMovieCategories'];

    // Xử lý tải hình ảnh
    $targetDir = "../.././assets/image/image__film/";
    $targetFile = $targetDir . basename($movieImage);
    if (!move_uploaded_file($_FILES["txtMovieImage"]["tmp_name"], $targetFile)) {
        die("Có lỗi xảy ra khi tải hình ảnh.");
    }

    // Chèn vào bảng movies
    $stmt = $conn->prepare("INSERT INTO movies (movie_name, movie_img, movie_minage, movie_time, movie_date, movie_nation, movie_manufacturer, movie_status, movie_trailer) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssis", $movieName, $movieImage, $movieMinage, $movieTime, $movieDate, $movieNation, $movieManufacturer, $movieStatus, $movieTrailer);
    $stmt->execute();
    $movieId = $stmt->insert_id;

    // Chèn nội dung phim vào bảng content_film
    $stmt = $conn->prepare("INSERT INTO content_film (movie_id, content_part1, content_part2, content_part3, content_part4, content_part5) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $movieId, $contentPart1, $contentPart2, $contentPart3, $contentPart4, $contentPart5);
    $stmt->execute();

    // Xử lý thêm đạo diễn
    foreach ($directors as $director) {
        if (!empty($director)) {
            $directorId = checkAndInsert($conn, "director", "d_name", $director);

            // Liên kết phim và đạo diễn
            $stmt = $conn->prepare("INSERT INTO movie__director (d_id, movie_id) VALUES (?, ?)");
            $stmt->bind_param("ii",$directorId, $movieId);
            $stmt->execute();
        }
    }

    // Xử lý thêm diễn viên
    foreach ($actors as $actor) {
        if (!empty($actor)) {
            $actorId = checkAndInsert($conn, "actor", "a_name", $actor);

            // Liên kết phim và diễn viên
            $stmt = $conn->prepare("INSERT INTO movie__actor (a_id, movie_id) VALUES (?, ?)");
            $stmt->bind_param("ii",$actorId, $movieId);
            $stmt->execute();
        }
    }

    // Xử lý thêm thể loại
    foreach ($genres as $genre) {
        if (!empty($genre)) {
            $genreId = checkAndInsert($conn, "genre_film", "g_name", $genre);

            // Liên kết phim và thể loại
            $stmt = $conn->prepare("INSERT INTO movie__genre (genre_id, movie_id) VALUES (?, ?)");
            $stmt->bind_param("ii",  $genreId, $movieId);
            $stmt->execute();
        }
    }

    // Xử lý thêm danh mục phim
    foreach ($categories as $categoryId) {
        if (!empty($categoryId)) {
            // Liên kết phim và danh mục
            $stmt = $conn->prepare("INSERT INTO movie__categories (movie_id, cat_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $movieId, $categoryId );
            $stmt->execute();
        }
    }
    
    echo "<script>alert('Phim đã được thêm thành công'); window.location.href='../../admin.php?option=movie';</script>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style_movie.css">
    <title>Add Movie</title>
</head>
<body>
    <form action="add-movie.php" method="post" enctype="multipart/form-data">
        <a href="../../admin.php?option=movie"><i class="fa-solid fa-arrow-left"></i></a>
        <h1>Thêm Mới Phim</h1>
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
                <td align="right">Trailer:</td>
                <td><input type="text" name="txtMovieTrailer"></td>
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
                    <textarea name="txtMovieContentPart1" rows="3" cols="40" placeholder="Nội dung phần 1"></textarea><br>
                    <textarea name="txtMovieContentPart2" rows="3" cols="40" placeholder="Nội dung phần 2"></textarea><br>
                    <textarea name="txtMovieContentPart3" rows="3" cols="40" placeholder="Nội dung phần 3"></textarea><br>
                    <textarea name="txtMovieContentPart4" rows="3" cols="40" placeholder="Nội dung phần 4"></textarea><br>
                    <textarea name="txtMovieContentPart5" rows="3" cols="40" placeholder="Nội dung phần 5"></textarea>
                </td>
            </tr>
            <!-- Thêm đạo diễn -->
            <tr>
                <td align="right">Tên đạo diễn:</td>
                <td>
                    <div id="directorsContainer">
                        <input type="text" name="txtNameDirector[]">
                    </div>
                    <button type="button" onclick="addField('directorsContainer', 'txtNameDirector[]')">+</button>
                </td>
            </tr>

            <!-- Thêm diễn viên -->
            <tr>
                <td align="right">Tên diễn viên:</td>
                <td>
                    <div id="actorsContainer">
                        <input type="text" name="txtNameActor[]">
                    </div>
                    <button type="button" onclick="addField('actorsContainer', 'txtNameActor[]')">+</button>
                </td>
            </tr>

            <!-- Thêm thể loại -->
            <tr>
                <td align="right">Tên thể loại:</td>
                <td>
                    <div id="genresContainer">
                        <input type="text" name="txtNameGenre[]">
                    </div>
                    <button type="button" onclick="addField('genresContainer', 'txtNameGenre[]')">+</button>
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
                    <button type="button" onclick="addField('categoriesContainer', 'txtMovieCategories[]', 'select')">+</button>
                </td>
            </tr>

            <tr>
                <td><input type="reset" value="Hủy"></td>
                <td align="right"><input type="submit" name="cmd" value="Thêm"></td>
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
