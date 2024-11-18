<?php
    session_start();
    require_once("../connect/connection.php");
    $check_schedule = $_SESSION["schedule_id"];
    // info_film
    $info_film = "select * from schedules S
        join movies M on M.movie_id = S.movie_id
        join room R on R.room_id = S.room_id
        join cinema C on C.cinema_id = R.cinema_id
        where S.schedule_id = $check_schedule
    ";
    $result_infofilm = $conn->query($info_film);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../assets/css/home/reset.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/home/styles.css">
    <link rel="stylesheet" href="../assets/css/home/grid.css">
    <link rel="stylesheet" href="../assets/css/booking/styles.css">
    <link rel="stylesheet" href="../assets/css/booking/style__food.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>
<body>
    <!-- heading -->
    <header class="header">
        <div class="container" style="--spacer:20px;">
            <div class="header__inner">
                <a href="./home.php"><img src="../logo.png" alt="" class="header__img"></a>
                <div class="cancel_tran">
                    <a href="#!" class="link__cancel">Hủy giao dịch <i class="fa-solid fa-xmark"></i></a>
                </div>
            </div>
        </div>
    </header>
    <!-- step booking -->
     <main class="main__class">
        <!-- booking_-step -->
        <div class="booking__step">
            <span class="step_book done__step">Chọn phim/Rạp/Suất</span>
            <span class="step_book done__step">Chọn ghế</span>
            <span class="step_book done__step">Chọn thức ăn</span>
            <span class="step_book">Thanh toán</span>
            <span class="step_book">Xác nhận</span>
        </div>

        <!-- booking -->
        <div class="booking">
            <div class="container">
                <div class="booking__inner">
                    <!-- Chọn ghế -->
                    <div class="column_01">
                        <!-- list food -->
                        <form id="food-form" method="POST" action="save_food_selection.php">
                            <div class="changetime food_list">
                                <span class="title__page">Chọn Combo</span>
                                <!-- item 1 -->
                                 <?php
                                    $sql_item_food="select * from food";
                                    $result_item_food = $conn->query($sql_item_food);
                                    while($row = $result_item_food->fetch_assoc()){ 
                                 ?>
    
                                <div class="food__item food-item" data-id="<?=$row['food_id'];?>" data-price="<?=$row['food_price'];?>">
                                    <img src="../assets/image/food/<?php echo $row["food_image"];?>" alt="" class="img__food">
                                    <div class="info__food">
                                        <p class="food__name"><?php echo $row["food_name"];?></p>
                                        <p class="food__desc"><?php echo $row["food_desc"];?></p>
                                        <div class="box_price">
                                            <span class="food_price">Giá: <span class="bold"><?php echo number_format($row["food_price"])  ;?></span>&nbsp;₫</span>
                                            <div class="quantity-control counter">
                                                <button type="button" class="btn_count" onclick="updateQuantity(<?= $row['food_id'] ?>, -1)">-</button>
                                                <span id="quantity-<?= $row['food_id']; ?>">0</span>
                                                <button type="button" class="btn_count" onclick="updateQuantity(<?= $row['food_id'] ?>, 1)">+</button>
                                            </div>
                                        </div>
    
                                    </div>
                                    <input type="hidden" name="quantities[<?=$row["food_id"]?>]" id="input-quantity-<?=$row["food_id"]?>" value="0">
                                </div>
    
                                <?php
                                    }
                                ?>
                            </div>
                            
                            <button hidden type="submit" id="save_food_session"></button>
                        </form>
                        

                    </div>
                    <!-- hiện thị thông tin vé -->
                    <div class="column_02">
                        <div class="item__film_selected">
                            <?php
                                while($row = $result_infofilm->fetch_assoc()){
                            ?>
                                <div class="info_film">
                                    <img src="../assets/image/image__film/<?php echo $row["movie_img"];?>" alt="" class="film__img">
                                    <div class="box_namefilm">
                                        <p class="text_namefilm"><?php echo $row["movie_name"];?></p>
                                        <div class="row__subinfo">
                                            <span class="text__subnamefilm">2D Phụ Đề - </span>
                                            <span class="text__limitage"><?php echo $row["movie_minage"];?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="info__cinema">
                                    <p class="name__Cinema"><?php echo $row["cinema_name"];?> - <span class="room_name"><?php echo $row["room_name"];?></span></p>
                                    <p class="info__booking">Suất: <strong class="text__bold"><?php echo $row["show_time"];?></strong> - <span class = "date__current"><?php echo $row["show_day"];?>,<strong class="text__bold"><?php $date = new DateTime($row["show_date"]);echo $date->format("d/m/Y"); ?></strong></span></p>
                                </div>

                            <?php
                                }
                            ?>
                            
                            <!-- selected_seat -->
                             <div class="info_seat">
                                <div class="info_seat___selected">
                                    <span class="seat__quantity"><strong class="bold">
                                        <?php
                                            $count = 0;
                                            foreach($_SESSION["info_seat_selected"] as $k=>$v){
                                                $count++;
                                            }
                                            echo $count;
                                        ?>x</strong> Ghế đơn</span>
                                    <span class="seat__selected">Ghế: 
                                    <?php   
                                        $money_seat = 0;
                                        $count1 = 0;
                                        foreach($_SESSION["info_seat_selected"] as $k=>$v){
                                            $count1++;
                                            $sql = "select S.seat_number,S.row,S.seat_price from seats S
                                            join room R on R.room_id = S.room_id
                                            join schedules SD on SD.room_id = R.room_id
                                            where SD.schedule_id = $check_schedule and S.seat_id = $v
                                            ";
                                            $result = $conn->query($sql);
                                            while($row = $result->fetch_assoc()){
                                                $money_seat += $row["seat_price"];

                                        
                                    ?>
                                        <strong class="bold"><?php echo $row["row"].$row["seat_number"]; if($count != $count1) echo ",";?>  </strong>
                                    <?php
                                            }
                                        // $result->data_seek(0);
                                        $_SESSION["price_seat"] = $money_seat;
                                    }
                                    ?>
                                    </span>
                                </div>
                                <span class="price_total_seat bold"><?php echo number_format($money_seat)?>&nbspđ</span>
                             </div>
                             <!-- selected_food -->
                              <div class="info_food selected-foods">             
                                <ul class="food__quantity" id="selected-foods-list"></ul>
                                <!-- <span class="price_total_seat bold">100đ</span> -->
                                <!-- <p>Tổng cộng: <span id="total-price">0</span> đ</p> -->
                              </div>
                            <div class="total__booking">
                                <span class="text__total">Tổng cộng</span>
                                <span class="price__booking" id="total-price"><?=number_format($_SESSION["price_seat"])?> đ</span>
                            </div>
                        </div>

                        <div class="control__booking">
                            <div class="row__booking row">
                                <div class="col-6 btn__booking"><a href="#!" class="btn__link">Quay lại</a></div>
                                <div class="col-6 btn__booking btn__link_continue"><label for="save_food_session" class="link__continue">Tiếp tục</label></div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
     </main>
     <!-- <script src="../assets/js/booking/booking_food.js"></script> -->
     <script>
                let selectedFoods = {};
                
        function updateQuantity(foodId, change) {
            const foodElement = document.querySelector(`.food-item[data-id='${foodId}']`);
            const quantityElement = document.getElementById(`quantity-${foodId}`);
            const foodName = foodElement.querySelector('p').textContent;
            const foodPrice = parseInt(foodElement.getAttribute('data-price'));
        
            // Cập nhật số lượng
            let currentQuantity = parseInt(quantityElement.textContent) || 0;
            currentQuantity = Math.max(0, currentQuantity + change);
            quantityElement.textContent = currentQuantity;
            
            // lưu số lượng vào session

            const inputElement = document.getElementById(`input-quantity-${foodId}`);
            inputElement.value = currentQuantity;

            // Cập nhật danh sách đã chọn
            if (currentQuantity > 0) {
                selectedFoods[foodId] = {name: foodName, price: foodPrice, quantity: currentQuantity };
            } else {
                delete selectedFoods[foodId];
            }
            updateSelectedFoods();
        }
        
        function updateSelectedFoods() {
            const show_list_food=document.querySelector(".info_food");
            const selectedFoodsList = document.getElementById("selected-foods-list");
            const totalPriceElement = document.getElementById("total-price");

            
            
           
            
            // Làm sạch danh sách cũ
            selectedFoodsList.innerHTML = "";
            
            

            // Cập nhật danh sách mới
            let totalPrice = 0;
            for (const foodId in selectedFoods) {
                const food = selectedFoods[foodId];
                const listItem = document.createElement("li");
                // listItem.textContent = `${food.name} x ${food.quantity} - ${food.price * food.quantity} đ`;
                let price_total_food = (food.price * food.quantity).toLocaleString();
                listItem.innerHTML = `<div style="display:flex;justify-content:space-between;"><div><span style="font-size:1.4rem;font-weight: 700;">${food.quantity}x</span> ${food.name}</div> <div> <span style="font-weight:700">${price_total_food} đ</span></div></div>`;

                selectedFoodsList.appendChild(listItem);
            
                totalPrice += food.price * food.quantity;

            }
            totalPrice += <?=$_SESSION["price_seat"];?>;
            // Cập nhật tổng giá
            totalPriceElement.textContent = totalPrice.toLocaleString() + " đ";

             // show list food
            if(totalPrice == <?=$_SESSION["price_seat"];?>){
                show_list_food.style.display = "none";
            }
            else{
                show_list_food.style.display = "block";
            }
            
        }

    </script>
</body>
</html>