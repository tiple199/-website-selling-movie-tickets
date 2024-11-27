
<?php
session_start();
// Lấy tên người dùng và mật khẩu từ form
$user = $_POST['txtusername'];
$password = $_POST['txtpassword'];
require_once("../connect/connection.php");
// Truy vấn
$result = $conn->query("SELECT id, fullname, username, password, status, level_id FROM `user` WHERE username = '$user'") or die($conn->error);


// Kiểm tra xem tên người dùng có tồn tại và so sánh mật khẩu
$row = $result->fetch_assoc();
if ($password == $row["password"]) {
        $_SESSION["login_error"] = "";

        switch ($row["level_id"]) {
            case 1:
                header("Location: ../admin.php");
                break;
            case 2:
                $_SESSION["login_status"] = "1";
                $_SESSION["id_user"] = $row["id"];
                // Kiểm tra xem có URL hiện tại không
                if (isset($_SESSION['current_url'])) {
                    // Nếu có, chuyển hướng về trang đó (showfilmdetail hoặc trang người dùng đang đứng)
                    header("Location: " . $_SESSION['current_url']);
                    unset($_SESSION['current_url']); // Xóa URL sau khi sử dụng
                } else {
                    // Nếu không có, chuyển về trang home mặc định
                    header("Location: ../home.php");
                }
                break;
        }
        exit();
    }else {
        session_start();
        $_SESSION["login_error"] = "Username or Password is incorect";
        
        // Kiểm tra xem có trang referrer không (nếu có thì quay lại trang đó)
        $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../home.php';

        // Chuyển hướng về trang trước đó nếu có, nếu không thì chuyển về trang home.php
        header("Location: $redirectUrl");

        exit();
}

// Giải phóng tài nguyên
$result->close();
$conn->close();
?>
