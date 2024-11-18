<?php
    session_start();
    
    require_once("../connect/connection.php");
    // heading
    $film_categories= $conn->query("select * from film_categories");
    $film_premiere = $conn->query("select * from movies where movie_ispremiere = 1 and movie_status  = 1");
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
     <link rel="stylesheet" href="../assets/css/booking/style__payment.css">
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
            <span class="step_book done__step">Thanh toán</span>
            <span class="step_book">Xác nhận</span>
        </div>

        <!-- booking -->
        <div class="booking">
            <div class="container">
                <div class="booking__inner">
                    <!-- Chọn ghế -->
                    <div class="column_01">
                        <!-- Thay đổi thời gian -->
                        <div class="sale">
                            <h2 class="title__page">
                                Khuyến mãi
                            </h2>      
                            <span >Mã khuyến mãi</span>
                            <div class="discount__wrap">
                                <input type="text" class="input__discount">
                                <button class="btn__discount">Áp Dụng</button>
                            </div>
                            <p class="text__desc">Lưu ý: Có thể áp dụng nhiều vouchers vào 1 lần thanh toán</p>
                        </div>

                        <div class="paymethod">
                            <h2 class="title__page">
                                Phương thức thanh toán
                            </h2>
                            <div class="select__method">
                                <!-- item1 -->
                                <div class="method__item">
                                    <input type="radio" name="select__method" id="method_01">                                   
                                    <label for="method_01" class="label__method">
                                        <img src="../assets/image/payment/shopee.png" alt="" class="img__method">
                                        <p class="method__desc">Ví ShopeePay - Nhập mã: SPPCINE10 Giảm 10K cho đơn từ 100K</p>
                                    </label>
                                </div>
                                <!-- item2 -->
                                <div class="method__item">
                                    <input type="radio" name="select__method" id="method_02">                                   
                                    <label for="method_02" class="label__method">
                                        <img src="../assets/image/payment/momo.png" alt="" class="img__method">
                                        <p class="method__desc">Ví Điện Tử MoMo</p>
                                    </label>
                                </div>
                                <!-- item3 -->
                                <div class="method__item">
                                    <input type="radio" name="select__method" id="method_03">                                   
                                    <label for="method_03" class="label__method">
                                        <img src="../assets/image/payment/vnpay.png" alt="" class="img__method">
                                        <p class="method__desc">VNPAY</p>
                                    </label>
                                </div>
                                <!-- item4 -->
                                <div class="method__item">
                                    <input type="radio" name="select__method" id="method_04">                                   
                                    <label for="method_04" class="label__method">
                                        <img src="../assets/image/payment/zalopay.png" alt="" class="img__method">
                                        <p class="method__desc">Zalopay - Bạn mới Zalopay nhập mã GIAMSAU - Giảm 50% tối đa 40k </p>
                                    </label>
                                </div>
                                

                            </div>
                        </div>
                        

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
                                <ul class="food__quantity" id="selected-foods-list">
                                    <!-- danh sách list food -->
                                    <?php
                                        $total_food=0;
                                        if(!empty($_SESSION["foods"])){
                                            foreach($_SESSION["foods"] as $k=>$v){
                                                $sql_food="select * from food where food_id = $k";
                                                $result_food=$conn->query($sql_food);
                                                while($r = $result_food->fetch_assoc()){
                                                    $total_food += $r["food_price"]*$v;
                                    ?>

                                        <li class="item__food">
                                            <div><span class="bold"><?=$v?>x</span> <?=$r["food_name"]?></div> <div class="bold"><?=number_format($r["food_price"]*$v)?> đ</div>
                                        </li>

                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                                </ul>
                                
                              </div>
                            <div class="total__booking">
                                <span class="text__total">Tổng cộng</span>
                                <span class="price__booking" id="total-price"><?=number_format($_SESSION["price_seat"] + $total_food)?> đ</span>
                            </div>
                        </div>
                        <div class="control__booking">
                            <div class="row__booking">
                                <div class="btn__booking style__btn"><a href="#!" class="btn__link ">Quay lại</a></div>
                                <div class="btn__booking btn__link_continue style__btn"><label for="overlay" class="label__control"><p class="text__continue">Tiếp tục</p></label></div>
                            </div>
                        </div>
                    </div>
                    <!-- ticket -->
                    <div class="control__display">
                        <input type="checkbox" id="overlay" hidden>
                        <label for="overlay"><div class="overlay"></div></label>
                        <div class="ticket">
                            <h2 class="title__ticket">THÔNG TIN ĐẶT VÉ</h2>
                            <!-- film -->
                            <div class="row__film">
                                <span class="span__page">Phim</span>
                                
                                <div class="box_namefilm border__ticket">
                                    <p class="text_namefilm ticket__namefilm">Cô Dâu Hào Môn</p>
                                    <div class="row__subinfo">
                                        <span class="text__subnamefilm">2D Phụ Đề - </span>
                                        <span class="text__limitage text__ticketage">T18</span>
                                    </div>
                                </div>
    
                                
                            </div>
                            <!-- room -->
                            <div class="row__film">
                                <span class="span__page">Rạp</span>
                                
                                <div class="box_namefilm border__ticket">
                                    <p class="text_namefilm ticket__namefilm">TTNP Cầu Giấy</p>
                                    <div class="row__subinfo">
                                        <span class="text__subnamefilm showtime__film">23:00 - Chủ Nhật,27/10/2024</span>
                                    </div>
                                </div>
                                
    
                                
                            </div>
                            <!-- room -->
                            <div class="row__film">
                                <span class="span__page"></span>
                                
                                <div class="box_namefilm border__ticket">
                                    <p class="text_namefilm room__name">RẠP 3</p>
                                    <div class="row__subinfo">
                                        <span class="text__subnamefilm room__seat">Vé 2D G8</span>
                                    </div>
                                </div>
                                
    
                                
                            </div>
                            <!-- total -->
                            <div class="row__film">
                                <span class="span__page">Tổng</span>
                                
                                <div class="box_namefilm border__ticket border__ticket--color">
                                    <span class="ticket__price">60000&nbsp;VNĐ</span>
                                </div>
                                
                            </div>
                            <div class="decor">
                                <img src="../assets/image/decor/line.png" alt="" class="decor__line">
                            </div>
                            <p class="confirm">Tôi xác nhận các thông tin đặt vé đã chính xác <input type="checkbox"></p>
                            <button class="confirm__pay btn">Thanh Toán</button>
                        </div>
                    </div>
                    

                </div>
            </div>
        </div>
     </main>
     <script src="../assets/js/booking/booking_food.js"></script>
</body>
</html>