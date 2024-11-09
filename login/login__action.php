
<?php
// Lấy tên người dùng và mật khẩu từ form
$user = $_POST['txtusername'];
$password = $_POST['txtpassword'];
require_once("../connect/connection.php");
// Truy vấn
$result = $conn->query("SELECT password, status, level_id FROM `user` WHERE username = '$user'") or die($conn->error);


// Kiểm tra xem tên người dùng có tồn tại và so sánh mật khẩu
$row = $result->fetch_assoc();
if ($password == $row["password"]) {
        $_SESSION["login_error"] = "";

        switch ($row["level_id"]) {
            case 1:
                header("Location: ../usera/admin.php");
                break;
            case 2:
                header("Location: ../home.php");
                break;
        }
        exit();
    }else {
        session_start();
        $_SESSION["login_error"] = "Username or Password is incorect";
        // echo $_SESSION["login_error"];
        header("Location: ../home.php");
        exit();
}

// Giải phóng tài nguyên
$result->close();
$conn->close();
?>
