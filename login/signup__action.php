<?php
// Bắt đầu session
session_start();
require_once("../connect/connection.php");

// Kiểm tra nếu form gửi dữ liệu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $fullname = $_POST['fullname'];
    $date = $_POST['date'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : 3;
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $status = 1; // Trạng thái mặc định (hoạt động)
    $role = 2; // Trạng thái mặc định (hoạt động)

    // Kiểm tra các trường bắt buộc
    if (empty($fullname) || empty($date) || empty($gender) || empty($email) || empty($phone) || empty($username) || empty($password) || empty($confirm_password)) {
        die("Vui lòng điền đầy đủ thông tin.");
    }

    // Kiểm tra mật khẩu và xác nhận mật khẩu
    if ($password !== $confirm_password) {
        die("Mật khẩu không khớp.");
    }

    // Kiểm tra tên người dùng đã tồn tại chưa
    $check_user_query = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($check_user_query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        die("Tên đăng nhập đã tồn tại.");
    }


    // Thêm dữ liệu vào bảng user
    $insert_query = "INSERT INTO user (fullname, date, gender, email, phone, username, password, status, level_id) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ssissssii", $fullname, $date, $gender, $email, $phone, $username, $password, $status, $role);

    if ($stmt->execute()) {
        $_SESSION["login_error"] = "Chào mừng bạn, hãy nhập tài khoản để đăng nhập!";
        echo "<script>alert('Đăng ký thành công'); window.location.href='../home.php';</script>";
    } else {
        echo "Lỗi khi đăng ký: " . $conn->error;
    }

    // Đóng kết nối
    $stmt->close();
    $conn->close();
} else {
    echo "Yêu cầu không hợp lệ!";
}
?>
