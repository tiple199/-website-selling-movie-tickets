
<?php
// Lấy tên người dùng và mật khẩu từ form
$user = $_POST['txtusername'];
$password = $_POST['txtpassword'];
require_once("../connect/connection.php");
// Truy vấn
$result = $conn->query("SELECT password, status, level_id FROM `user` WHERE username = '$user'") or die($conn->error);


// Kiểm tra xem tên người dùng có tồn tại và so sánh mật khẩu
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($password == $row["password"]) {
        if ($row["status"] == false) {
            session_start();
            $_SESSION["login"] = false;
            $_SESSION["login_error"] = "Account has been disabled";
            header("Location: login.php");
            exit();
        } else {
            session_start();
            $_SESSION["login"] = true;
            $_SESSION["login_error"] = "";

            switch ($row["level_id"]) {
                case 1:
                    header("Location: ../usera/admin.php");
                    break;
                case 2:
                    header("Location: ../usera/user.php");
                    break;
            }
            exit();
        }
    } else {
        session_start();
        $_SESSION["login"] = false;
        $_SESSION["login_error"] = "Username or Password is incorrect";
        header("Location: login.php");
        exit();
    }
} else {
    session_start();
    $_SESSION["login"] = false;
    $_SESSION["login_error"] = "Username or Password is incorrect";
    header("Location: login.php");
    exit();
}

// Giải phóng tài nguyên
$result->close();
$conn->close();
?>
