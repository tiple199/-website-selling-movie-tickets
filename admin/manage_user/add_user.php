<?php
require_once("../../connect/connection.php");

// Xử lý thêm người dùng
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $gender = $_POST['gender'];
    $username = $_POST['username'];
    $password =$_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $level_id = $_POST['level_id'];
    $status = $_POST['status'];

    $sql_check_username = "SELECT id FROM user WHERE username = '$username'";
    $result_check = $conn->query($sql_check_username);

    if ($result_check->num_rows > 0) {
        echo "<script>alert('Tên đăng nhập đã tồn tại, vui lòng chọn tên khác');</script>";
        // Giữ lại các giá trị đã nhập
        $error = true;
    } else {
        // Câu lệnh SQL để chèn dữ liệu vào bảng `user`
        $sql = "INSERT INTO user (fullname, gender, username, password, email, phone, date, level_id, status) 
                VALUES ('$fullname', '$gender', '$username', '$password', '$email', '$phone', '$date', '$level_id', '$status')";
    
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Người dùng đã được thêm thành công'); window.location.href='../../admin.php?option=user';</script>";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Mới Người Dùng</title>
</head>
<body>
    <h1>Thêm Mới Người Dùng</h1>
    <form action="" method="post">
        <table border="0">
            <!-- Thông tin người dùng -->
            <tr>
                <td align="right">Họ và tên:</td>
                <td><input type="text" name="fullname" value="<?php echo isset($fullname) ? htmlspecialchars($fullname) : ''; ?>" required></td>
            </tr>
            <tr>
                <td align="right">Giới tính:</td>
                <td>
                    <input type="radio" name="gender" value="1" <?php echo (isset($gender) && $gender == '1') ? 'checked' : ''; ?>> Nam
                    <input type="radio" name="gender" value="2" <?php echo (isset($gender) && $gender == '2') ? 'checked' : ''; ?>> Nữ
                    <input type="radio" name="gender" value="3" <?php echo (isset($gender) && $gender == '3') ? 'checked' : ''; ?>> Khác
                </td>
            </tr>
            <tr>
                <td align="right">Tên đăng nhập:</td>
                <td><input type="text" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required></td>
            </tr>
            <tr>
                <td align="right">Mật khẩu:</td>
                <td><input type="password" name="password" required></td>
            </tr>
            <tr>
                <td align="right">Email:</td>
                <td><input type="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required></td>
            </tr>
            <tr>
                <td align="right">Số điện thoại:</td>
                <td><input type="text" name="phone" value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>"></td>
            </tr>
            <tr>
                <td align="right">Ngày đăng ký:</td>
                <td><input type="date" name="date" value="<?php echo isset($date) ? $date : date('Y-m-d'); ?>"></td>
            </tr>
            <tr>
                <td align="right">Cấp độ:</td>
                <td>
                    <select name="level_id">
                        <?php
                        $sql = "SELECT level_id, level_name FROM level_id";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $selected = (isset($level_id) && $level_id == $row['level_id']) ? 'selected' : '';
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
                    <input type="radio" name="status" value="1" <?php echo (isset($status) && $status == '1') ? 'checked' : ''; ?>> Kích hoạt
                    <input type="radio" name="status" value="0" <?php echo (isset($status) && $status == '0') ? 'checked' : ''; ?>> Không kích hoạt
                </td>
            </tr>

            <tr>
                <td colspan="2" align="center">
                    <button type="submit">Thêm Người Dùng</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
