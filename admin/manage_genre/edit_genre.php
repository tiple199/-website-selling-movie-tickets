<?php
// Kết nối cơ sở dữ liệu
require_once("../../connect/connection.php");
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    $_SESSION["login_error"] = "Vui lòng đăng nhập để tiếp tục!";
    header("Location: ../.././home.php");
    exit;
}

// Kiểm tra nếu `g_id` được truyền qua phương thức GET
if (isset($_GET['g_id'])) {
    $g_id = $_GET['g_id'];

    // Lấy thông tin thể loại dựa trên g_id
    $sql_get_genre = "SELECT * FROM genre_film WHERE g_id = ?";
    $stmt = $conn->prepare($sql_get_genre);
    $stmt->bind_param("i", $g_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Lấy thông tin thể loại
        $genre = $result->fetch_assoc();
    } else {
        echo "<script>alert('Thể loại không tồn tại!'); window.location.href='../../admin.php?option=genre';</script>";
        exit;
    }
    $stmt->close();
} else {
    echo "<script>alert('Không tìm thấy ID thể loại!'); window.location.href='../../admin.php?option=genre';</script>";
    exit();
}

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $g_name = $_POST['g_name'];

    // Kiểm tra nếu tên thể loại bị trống
    if (empty($g_name)) {
        echo "<script>alert('Vui lòng nhập tên thể loại phim!');</script>";
    } else {
        // Kiểm tra xem tên thể loại mới đã tồn tại chưa (trừ ID hiện tại)
        $sql_check_name = "SELECT g_id FROM genre_film WHERE g_name = ? AND g_id != ?";
        $stmt = $conn->prepare($sql_check_name);
        $stmt->bind_param("si", $g_name, $g_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Tên thể loại đã tồn tại, vui lòng chọn tên khác!');</script>";
        } else {
            // Cập nhật thông tin thể loại
            $sql_update_genre = "UPDATE genre_film SET g_name = ? WHERE g_id = ?";
            $stmt = $conn->prepare($sql_update_genre);
            $stmt->bind_param("si", $g_name, $g_id);

            if ($stmt->execute()) {
                echo "<script>alert('Cập nhật thể loại phim thành công!'); window.location.href='../../admin.php?option=genre';</script>";
            } else {
                echo "<script>alert('Lỗi khi cập nhật thể loại: " . $conn->error . "');</script>";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href=".././manage_user/style_user.css">
    <title>Sửa Thể Loại Phim</title>
</head>
<body>
    <form action="" method="post">
        <a href="../../admin.php?option=genre"><i class="fa-solid fa-arrow-left"></i></a>
        <h1>Sửa Thể Loại Phim</h1>
        <table border="0">
            <tr>
                <td align="right">Tên thể loại phim:</td>
                <td><input type="text" name="g_name" value="<?php echo htmlspecialchars($genre['g_name']); ?>" required></td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <button type="submit">Cập nhật</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>