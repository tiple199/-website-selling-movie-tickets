<?php
require_once("../../connect/connection.php"); // Kết nối đến cơ sở dữ liệu
session_start();

if (!isset($_SESSION["food_edit_error"])) {
    $_SESSION["food_edit_error"] = "";
}

// Lấy ID món ăn từ URL
$food_id = isset($_GET['food_id']) ? $_GET['food_id'] : 0;

// Lấy thông tin món ăn từ cơ sở dữ liệu
$sqlFood = "SELECT * FROM food WHERE food_id = ?";
$stmt = $conn->prepare($sqlFood);
$stmt->bind_param("i", $food_id);
$stmt->execute();
$resultFood = $stmt->get_result();
$food = $resultFood->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Thu thập và làm sạch dữ liệu từ form
    $Food_name = isset($_POST['txtNameFood']) ? trim($_POST['txtNameFood']) : '';
    $Food_desc = isset($_POST['txtDesc']) ? trim($_POST['txtDesc']) : '';
    $Food_price = isset($_POST['txtPrice']) ? trim($_POST['txtPrice']) : '';

    // Xử lý hình ảnh tải lên
    if (isset($_FILES['foodImage']) && $_FILES['foodImage']['error'] == UPLOAD_ERR_OK) {
        $imageDir = '../../assets/image/food/'; // Thư mục lưu hình ảnh
        $imageFile = $imageDir . basename($_FILES['foodImage']['name']);
        
        // Kiểm tra và di chuyển tệp tải lên
        if (move_uploaded_file($_FILES['foodImage']['tmp_name'], $imageFile)) {
            $Food_image = basename($_FILES['foodImage']['name']);
        } else {
            $_SESSION["food_edit_error"] = "Không thể tải lên hình ảnh.";
        }
    } else {
        $Food_image = $food['food_image']; // Giữ nguyên nếu không có hình ảnh mới được tải lên
    }

    // Kiểm tra xem tên món ăn mới có tồn tại trong cơ sở dữ liệu không
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM food WHERE food_name = ? AND food_id != ?");
    $checkStmt->bind_param("si", $Food_name, $food_id);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        $_SESSION["food_edit_error"] = "Món ăn đã tồn tại!";
    } else {
        // Cập nhật thông tin món ăn trong cơ sở dữ liệu
        $sqlUpdate = "UPDATE food SET food_name = ?, food_desc = ?, food_price = ?, food_image = ? WHERE food_id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("ssdsi", $Food_name, $Food_desc, $Food_price, $Food_image, $food_id);

        if ($stmtUpdate->execute()) {
            echo "<script>alert('Đã sửa đồ ăn thành công'); window.location.href='../../admin.php?option=food';</script>";
        } else {
            echo "Có lỗi xảy ra khi cập nhật thông tin món ăn.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa đồ ăn</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container_1 {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .inner-content {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 10px;
        }
        input[type="text"], input[type="date"], select {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"], input[type="reset"], input[type="button"] {
            background-color:rgb(232, 98, 40);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        input[type="submit"]:hover, input[type="reset"]:hover, input[type="button"]:hover {
            background-color: rgb(232, 98, 40);
        }
        .button-container {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container_1 d-flex">
        <center>
            <font color="red"><?php echo $_SESSION["food_edit_error"]; ?></font>
        </center>
        <h1 align="center">Sửa đồ ăn</h1>
        <div class="inner-content">
            <form action="" method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td align="right">Tên đồ ăn:</td>
                        <td><input type="text" name="txtNameFood" value="<?php echo htmlspecialchars($food['food_name']); ?>"></td>
                    </tr>
                    <tr>
                        <td align="right">Mô tả:</td>
                        <td><input type="text" name="txtDesc" value="<?php echo htmlspecialchars($food['food_desc']); ?>"></td>
                    </tr>
                    <tr>
                        <td align="right">Giá:</td>
                        <td><input type="text" name="txtPrice" value="<?php echo htmlspecialchars($food['food_price']); ?>"></td>
                    </tr>
                    <tr>
                        <td align="right">Ảnh:</td>
                        <td>
                            <input type="file" name="foodImage">
                            <br>
                            <br>
                            Ảnh hiện tại: <?php echo htmlspecialchars($food['food_image']); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="submit" name="cmd" value="Submit"></td>
                        <td><input type="reset" value="Reset"></td>
                        <td><input type="button" value="Back" onclick="window.location.href='../../admin.php?option=food'"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>
<?php $_SESSION["food_edit_error"] = ""; ?>
