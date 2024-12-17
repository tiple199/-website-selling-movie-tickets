<?php
// Kết nối cơ sở dữ liệu
require_once("../../connect/connection.php");
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
    $_SESSION["login_error"] = "Nhập tài khoản admin để vào trang quản trị!";
    header("Location: ../.././home.php"); // Đảm bảo bạn thay đổi URL này thành đúng trang đăng nhập của bạn
    exit;
}

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $discount_id = $_POST['discount_id'];
    $discount_title = $_POST['discount_title'];
    $discount_img = $_POST['discount_img'];
    $discount_price = $_POST['discount_price'];
    $status = $_POST['status'];
    $endDate = $_POST['endDate'];

    // Kiểm tra nếu các trường bắt buộc trống
    if (empty($discount_id) || empty($discount_title) || empty($discount_price) || empty($endDate)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin!');</script>";
    } else {
        // Kiểm tra discount_id đã tồn tại hay chưa
        $sql_check_id = "SELECT discount_id FROM discount WHERE discount_id = '$discount_id'";
        $result_check_id = $conn->query($sql_check_id);

        if ($result_check_id->num_rows > 0) {
            echo "<script>alert('Mã giảm giá đã tồn tại, vui lòng chọn mã khác');</script>";
        } else {
            // Thêm dữ liệu vào bảng discount
            $sql_insert_discount = "INSERT INTO discount (discount_id, discount_title, discount_img, discount_price, status, endDate) 
                                    VALUES ('$discount_id', '$discount_title', '$discount_img', '$discount_price', '$status', '$endDate')";

            if ($conn->query($sql_insert_discount) === TRUE) {
                echo "<script>alert('Thêm mã giảm giá thành công!'); window.location.href='../../admin.php?option=discount';</script>";
            } else {
                echo "<script>alert('Lỗi khi thêm mã giảm giá: " . $conn->error . "');</script>";
            }
        }
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
    <title>Thêm Mã Giảm Giá</title>
</head>
<body>
    <form action="" method="post">
        <a href="../../admin.php?option=discount"><i class="fa-solid fa-arrow-left"></i></a>
        <h1>Thêm Mã Giảm Giá</h1>
        <table border="0">
            <tr>
                <td align="right">Mã giảm giá:</td>
                <td><input type="text" name="discount_id" maxlength="10" required></td>
            </tr>
            <tr>
                <td align="right">Tiêu đề giảm giá:</td>
                <td><input type="text" name="discount_title" required></td>
            </tr>
            <tr>
                <td align="right">Hình ảnh URL:</td>
                <td><input type="text" name="discount_img"></td>
            </tr>
            <tr>
                <td align="right">Giá giảm:</td>
                <td><input type="number" name="discount_price" step="10000" required></td>
            </tr>
            <tr>
                <td align="right">Trạng thái:</td>
                <td>
                    <input type="radio" name="status" value="1" checked>Kích hoạt
                    <input type="radio" name="status" value="0">Không kích hoạt
                </td>
            </tr>
            <tr>
                <td align="right">Ngày hết hạn:</td>
                <td><input type="date" name="endDate" required></td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <button type="submit">Thêm Mã Giảm Giá</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>

