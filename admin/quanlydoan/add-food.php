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
            background-color:rgb(8, 19, 239);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        input[type="submit"]:hover, input[type="reset"]:hover, input[type="button"]:hover {
            background-color: rgb(8, 19, 239);
        }
        .button-container {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container_1 d-flex">
        <h1 align="center">Thêm mới đồ ăn</h1>
        <center>
            <font color = "red"><?php echo $_SESSION["food_add_error"];?></font>
        </center>
        <div class="inner-content">
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
                        <td><input type="button" value = "Back" onclick="window.location.href='../../admin.php?option=food'"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>
<?php $_SESSION["food_add_error"] = "";?>