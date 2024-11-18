<?php
// Danh sách các món ăn
$foods = [
    ["id" => 1, "name" => "iCombo 1 Big Extra STD", "price" => 109000],
    ["id" => 2, "name" => "iCombo 1 Big STD", "price" => 89000],
    ["id" => 3, "name" => "iCombo 2 Big Extra STD", "price" => 129000],
    ["id" => 4, "name" => "iCombo 2 Big STD", "price" => 109000],
    ["id" => 5, "name" => "iCombo D&D Dice Tower Promotion", "price" => 199000],
    ["id" => 6, "name" => "iCombo Optimus Prime 1 - Promotion", "price" => 199000]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Food</title>
    <link rel="stylesheet" href="style.css">
    <style>
                body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 20px;
            padding: 20px;
        }
        
        .food-list, .selected-foods {
            width: 50%;
        }
        
        .food-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        button {
            padding: 5px 10px;
            cursor: pointer;
        }
        
        #selected-foods-list {
            list-style: none;
            padding: 0;
        }
        
    </style>
</head>

<body>
    <div class="food-list">
        <h2>Chọn Combo</h2>
        <?php foreach ($foods as $food): ?>
            <div class="food-item" data-id="<?= $food['id'] ?>" data-price="<?= $food['price'] ?>">
                <span><?= $food['name'] ?></span>
                <span><?= number_format($food['price'], 0, ',', '.') ?> đ</span>
                <div class="quantity-control">
                    <button class="minus-btn" onclick="updateQuantity(<?= $food['id'] ?>, -1)">-</button>
                    <span id="quantity-<?= $food['id'] ?>">0</span>
                    <button class="plus-btn" onclick="updateQuantity(<?= $food['id'] ?>, 1)">+</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="selected-foods">
        <h3>Danh sách đã chọn</h3>
        <ul id="selected-foods-list"></ul>
        <p>Tổng cộng: <span id="total-price">0</span> đ</p>
    </div>
    <script>
                let selectedFoods = {};
                
        function updateQuantity(foodId, change) {
            const foodElement = document.querySelector(`.food-item[data-id='${foodId}']`);
            const quantityElement = document.getElementById(`quantity-${foodId}`);
            const foodName = foodElement.querySelector('span').textContent;
            const foodPrice = parseInt(foodElement.getAttribute('data-price'));
        
            // Cập nhật số lượng
            let currentQuantity = parseInt(quantityElement.textContent) || 0;
            currentQuantity = Math.max(0, currentQuantity + change);
            quantityElement.textContent = currentQuantity;
        
            // Cập nhật danh sách đã chọn
            if (currentQuantity > 0) {
                selectedFoods[foodId] = { name: foodName, price: foodPrice, quantity: currentQuantity };
            } else {
                delete selectedFoods[foodId];
            }
        
            updateSelectedFoods();
        }
        
        function updateSelectedFoods() {
            const selectedFoodsList = document.getElementById("selected-foods-list");
            const totalPriceElement = document.getElementById("total-price");
        
            // Làm sạch danh sách cũ
            selectedFoodsList.innerHTML = "";
        
            // Cập nhật danh sách mới
            let totalPrice = 0;
            for (const foodId in selectedFoods) {
                const food = selectedFoods[foodId];
                const listItem = document.createElement("li");
                listItem.textContent = `${food.name} x ${food.quantity} - ${food.price * food.quantity} đ`;
                selectedFoodsList.appendChild(listItem);
            
                totalPrice += food.price * food.quantity;
            }
        
            // Cập nhật tổng giá
            totalPriceElement.textContent = totalPrice.toLocaleString();
        }

    </script>
</body>
</html>
