<?php
// Kết nối cơ sở dữ liệu
require_once("../../connect/connection.php");

// Kiểm tra nếu discount_id được truyền qua phương thức GET
if (isset($_GET['discount_id'])) {
    $discount_id = $_GET['discount_id'];

    // Lấy thông tin mã giảm giá từ cơ sở dữ liệu
    $sql_get_discount = "SELECT * FROM discount WHERE discount_id = '$discount_id'";
    $result_get_discount = $conn->query($sql_get_discount);

    if ($result_get_discount->num_rows > 0) {
        // Lấy dữ liệu mã giảm giá
        $discount = $result_get_discount->fetch_assoc();
    } else {
        echo "<script>alert('Mã giảm giá không tồn tại'); window.location.href='../../admin.php?option=discount';</script>";
        exit();
    }
} else {
    echo "<script>alert('Không tìm thấy mã giảm giá'); window.location.href='../../admin.php?option=discount';</script>";
    exit();
}

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_discount_id = $_POST['discount_id'];
    $discount_title = $_POST['discount_title'];
    $discount_img = $_POST['discount_img'];
    $discount_price = $_POST['discount_price'];
    $status = $_POST['status'];
    $endDate = $_POST['endDate'];

    // Kiểm tra discount_id mới đã tồn tại hay chưa (ngoại trừ ID hiện tại)
    if ($new_discount_id != $discount['discount_id']) {
        $sql_check_id = "SELECT discount_id FROM discount WHERE discount_id = '$new_discount_id'";
        $result_check_id = $conn->query($sql_check_id);

        if ($result_check_id->num_rows > 0) {
            echo "<script>alert('Mã giảm giá mới đã tồn tại, vui lòng chọn mã khác');</script>";
            exit();
        }
    }

    // Cập nhật thông tin mã giảm giá
    $sql_update_discount = "UPDATE discount 
                            SET discount_id = '$new_discount_id',
                                discount_title = '$discount_title', 
                                discount_img = '$discount_img', 
                                discount_price = '$discount_price', 
                                status = '$status', 
                                endDate = '$endDate' 
                            WHERE discount_id = '{$discount['discount_id']}'";

    if ($conn->query($sql_update_discount) === TRUE) {
        echo "<script>alert('Cập nhật mã giảm giá thành công'); window.location.href='../../admin.php?option=discount';</script>";
    } else {
        echo "<script>alert('Lỗi khi cập nhật mã giảm giá: " . $conn->error . "');</script>";
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
    <title>Sửa Mã Giảm Giá</title>
</head>
<body>
    <form action="" method="post">
        <a href="../../admin.php?option=discount"><i class="fa-solid fa-arrow-left"></i></a>
        <h1>Sửa Mã Giảm Giá</h1>
        <table border="0">
            <tr>
                <td align="right">Mã giảm giá:</td>
                <td>
                    <input type="text" name="discount_id" value="<?php echo htmlspecialchars($discount['discount_id']); ?>" required>
                </td>
            </tr>
            <tr>
                <td align="right">Tiêu đề giảm giá:</td>
                <td>
                    <input type="text" name="discount_title" value="<?php echo htmlspecialchars($discount['discount_title']); ?>" required>
                </td>
            </tr>
            <tr>
                <td align="right">Hình ảnh URL:</td>
                <td>
                    <input type="text" name="discount_img" value="<?php echo htmlspecialchars($discount['discount_img']); ?>">
                </td>
            </tr>
            <tr>
                <td align="right">Giá giảm:</td>
                <td>
                    <input type="number" name="discount_price" step="0.01" value="<?php echo htmlspecialchars($discount['discount_price']); ?>" required>
                </td>
            </tr>
            <tr>
                <td align="right">Trạng thái:</td>
                <td>
                    <input type="radio" name="status" value="1" <?php echo ($discount['status'] == 1) ? 'checked' : ''; ?>> Kích hoạt
                    <input type="radio" name="status" value="0" <?php echo ($discount['status'] == 0) ? 'checked' : ''; ?>> Không kích hoạt
                </td>
            </tr>
            <tr>
                <td align="right">Ngày hết hạn:</td>
                <td>
                    <input type="date" name="endDate" value="<?php echo htmlspecialchars($discount['endDate']); ?>" required>
                </td>
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
