<?php
// Kết nối cơ sở dữ liệu
require_once("../../connect/connection.php");

// Kiểm tra nếu ID được truyền qua phương thức GET
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Lấy thông tin người dùng từ cơ sở dữ liệu
    $sql_get_user = "SELECT * FROM user WHERE id = $user_id";
    $result_get_user = $conn->query($sql_get_user);

    if ($result_get_user->num_rows > 0) {
        // Lấy dữ liệu người dùng
        $user = $result_get_user->fetch_assoc();
    } else {
        echo "<script>alert('Người dùng không tồn tại'); window.location.href='../../admin.php?option=user';</script>";
        exit();
    }
} else {
    echo "<script>alert('Không tìm thấy ID người dùng'); window.location.href='../../admin.php?option=user';</script>";
    exit();
}

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $gender = $_POST['gender'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $level_id = $_POST['level_id'];
    $status = $_POST['status'];

    // Kiểm tra nếu tên đăng nhập đã tồn tại (trừ tên hiện tại của người dùng)
    $sql_check_username = "SELECT id FROM user WHERE username = '$username' AND id != $user_id";
    $result_check = $conn->query($sql_check_username);

    if ($result_check->num_rows > 0) {
        echo "<script>alert('Tên người dùng đã tồn tại, vui lòng chọn tên khác');</script>";
    } else {
        // Cập nhật thông tin người dùng
        $sql_update_user = "UPDATE user 
                            SET fullname = '$fullname', 
                                gender = '$gender', 
                                username = '$username', 
                                password = '$password', 
                                email = '$email', 
                                phone = '$phone', 
                                date = '$date', 
                                level_id = '$level_id', 
                                status = '$status' 
                            WHERE id = $user_id";

        if ($conn->query($sql_update_user) === TRUE) {
            echo "<script>alert('Cập nhật người dùng thành công'); window.location.href='../../admin.php?option=user';</script>";
        } else {
            echo "<script>alert('Lỗi khi cập nhật người dùng: " . $conn->error . "');</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Người Dùng</title>
</head>
<body>
    <h1>Sửa Người Dùng</h1>
    <form action="" method="post">
        <table border="0">
            <tr>
                <td align="right">Họ và tên:</td>
                <td><input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required></td>
            </tr>
            <tr>
                <td align="right">Giới tính:</td>
                <td>
                    <input type="radio" name="gender" value="1" <?php echo ($user['gender'] == 1) ? 'checked' : ''; ?>> Nam
                    <input type="radio" name="gender" value="2" <?php echo ($user['gender'] == 2) ? 'checked' : ''; ?>> Nữ
                    <input type="radio" name="gender" value="3" <?php echo ($user['gender'] == 3) ? 'checked' : ''; ?>> Khác
                </td>
            </tr>
            <tr>
                <td align="right">Tên đăng nhập:</td>
                <td><input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required></td>
            </tr>
            <tr>
                <td align="right">Mật khẩu:</td>
                <td><input type="password" name="password" value="<?php echo htmlspecialchars($user['password']); ?>" required></td>
            </tr>
            <tr>
                <td align="right">Email:</td>
                <td><input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required></td>
            </tr>
            <tr>
                <td align="right">Số điện thoại:</td>
                <td><input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"></td>
            </tr>
            <tr>
                <td align="right">Ngày đăng ký:</td>
                <td><input type="date" name="date" value="<?php echo $user['date']; ?>"></td>
            </tr>
            <tr>
                <td align="right">Cấp độ:</td>
                <td>
                    <select name="level_id">
                        <?php
                        $sql_levels = "SELECT level_id, level_name FROM level_id";
                        $result_levels = $conn->query($sql_levels);

                        if ($result_levels->num_rows > 0) {
                            while ($row = $result_levels->fetch_assoc()) {
                                $selected = ($user['level_id'] == $row['level_id']) ? 'selected' : '';
                                echo "<option value='" . $row['level_id'] . "' $selected>" . $row['level_name'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>Không có cấp độ nào</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right">Trạng thái:</td>
                <td>
                    <input type="radio" name="status" value="1" <?php echo ($user['status'] == 1) ? 'checked' : ''; ?>> Kích hoạt
                    <input type="radio" name="status" value="0" <?php echo ($user['status'] == 0) ? 'checked' : ''; ?>> Không kích hoạt
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <button type="submit">Lưu Thay Đổi</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
