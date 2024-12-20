<?php
// Kết nối cơ sở dữ liệu
require_once("../../connect/connection.php");
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
    $_SESSION["login_error"] = "Vui lòng đăng nhập để tiếp tục!";
    header("Location: ../.././home.php");
    exit;
}

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $g_name = $_POST['g_name'];

    // Kiểm tra nếu tên thể loại bị trống
    if (empty($g_name)) {
        echo "<script>alert('Vui lòng nhập tên thể loại phim!');</script>";
    } else {
        // Kiểm tra xem thể loại đã tồn tại chưa
        $sql_check_genre = "SELECT g_name FROM genre_film WHERE g_name = ?";
        $stmt = $conn->prepare($sql_check_genre);
        $stmt->bind_param("s", $g_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Thể loại đã tồn tại, vui lòng chọn tên khác!');</script>";
        } else {
            // Thêm thể loại vào bảng
            $sql_insert_genre = "INSERT INTO genre_film (g_name) VALUES (?)";
            $stmt = $conn->prepare($sql_insert_genre);
            $stmt->bind_param("s", $g_name);

            if ($stmt->execute()) {
                echo "<script>alert('Thêm thể loại phim thành công!'); window.location.href='../../admin.php?option=genre';</script>";
            } else {
                echo "<script>alert('Lỗi khi thêm thể loại: " . $conn->error . "');</script>";
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
    <title>Thêm Thể Loại Phim</title>
</head>
<body>
    <form action="" method="post">
        <a href="../../admin.php?option=genre"><i class="fa-solid fa-arrow-left"></i></a>
        <h1>Thêm Thể Loại Phim</h1>
        <table border="0">
            <tr>
                <td align="right">Tên thể loại phim:</td>
                <td><input type="text" name="g_name" maxlength="255" required></td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <button type="submit">Thêm Thể Loại</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
