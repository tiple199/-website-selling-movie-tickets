<?php
session_start();
if(!isset($_SESSION["food_add_error"])){
    $_SESSION["food_add_error"] = "";  
}
require_once("../../connect/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $foodName = isset($_POST['txtFoodName']) ? trim($_POST['txtFoodName']) : '';
    $foodDesc = isset($_POST['txtFoodDesc']) ? trim($_POST['txtFoodDesc']) : '';
    $foodPrice = isset($_POST['txtFoodPrice']) ? (int)$_POST['txtFoodPrice'] : 0;
    $foodImage = isset($_POST['txtFoodImage']) ? trim($_POST['txtFoodImage']) : '';

    // Prepare SQL query to insert data into the food table using prepared statements
    $stmt = $conn->prepare("INSERT INTO food (food_name, food_desc, food_price, food_image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $foodName, $foodDesc, $foodPrice, $foodImage);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1 align="center">Thêm mới đồ ăn</h1>
    <div align="center"><a href="/doan/-website-selling-movie-tickets/admin.php" style="text-decoration:none">Home</a></div><br>
    <center>
        <font color = "red"><?php echo $_SESSION["food_add_error"];?></font>
    </center>
    <form action="add-food.php" method="post" enctype="multipart/form-data">
        <table align="center" border="0">
            <!-- Thông tin đồ ăn -->
            <tr>
                <td align="right">Tên đồ ăn:</td>
                <td><input type="text" name="txtFoodName"></td>
            </tr>
            <tr>
                <td align="right">Mô tả:</td>
                <td><input type="text" name="txtFoodDesc"></td>
            </tr>
            <tr>
                <td align="right">Giá:</td>
                <td><input type="text" name="txtFoodPrice"></td>
            </tr>
            <tr>
                <td align="right">Ảnh:</td>
                <td><input type="text" name="txtFoodImage"></td>
            </tr>
            <tr>
                <td><input type="submit" name = "cmd" value = "Submit"></td>
                <td><input type="reset" value = "Reset"></td>
            </tr>
        </table>
</body>
</html>
<?php $_SESSION["food_add_error"] = "";?>