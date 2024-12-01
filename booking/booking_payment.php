<?php
    session_start();
    require_once("../connect/connection.php");
    $discount = 0;
    $check_discount = false;
    $show_error_discount = false;
    if(isset($_REQUEST["input_discount"])){
        $check_discount = $_REQUEST["input_discount"];
        $sql = "select * from discount where discount_id = '$check_discount'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $row_discount = $result->fetch_assoc();
            $check_discount= true;
        }
        else{
            $check_discount= false;
            $show_error_discount = true;
        }
        
    }


    
    
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
                    <!-- Chọn thanh toán -->
                    <div class="column_01">
                        <!-- sale -->
                        <div class="sale">
                            <h2 class="title__page">
                                Khuyến mãi
                            </h2>      
                            <span >Mã khuyến mãi</span>
                            <div class="discount__wrap">
                                <form action="booking_payment.php?check_discount=check" method="post">
                                    <input type="text" class="input__discount" name="input_discount" placeholder="Nhập mã giảm giá vào đây">
                                    <button type="submit" class="btn__discount">Áp Dụng</button>
                                </form>
                            </div>
                            <p class="text__desc">Lưu ý: Chỉ có thể áp dụng 1 voucher vào 1 lần thanh toán</p>
                        </div>
                        <!-- payment -->
                        <div class="paymethod">
                            <h2 class="title__page">
                                Phương thức thanh toán
                            </h2>
                            <div class="select__method">
                                <!-- item -->
                                <?php
                                    $sql_payment= "select * from paymethod";
                                    $result_method = $conn->query($sql_payment);
                                    while($row = $result_method->fetch_assoc()){
                                ?>

                                <div class="method__item">
                                    <input type="radio" name="select__method" id="method_<?php echo $row["pay_id"];?>" value="<?php echo $row["pay_id"];?>">                                   
                                    <label for="method_<?=$row["pay_id"];?>" class="label__method">
                                        <img src="../assets/image/payment/<?php echo $row["pay_image"];?>" alt="" class="img__method">
                                        <p class="method__desc"><?php echo $row["pay_name"];?></p>
                                    </label>
                                </div>
                                <?php
                                    }
                                ?>
                                

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
                              <?php 
                              $total_food=0;
                              if(!empty($_SESSION["foods"])){  ?>              
                             <div class="info_food selected-foods">             
                                <ul class="food__quantity" id="selected-foods-list">
                                    <!-- danh sách list food -->
                                    <?php
                                        
                                        
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
                                        
                                    ?>
                                </ul>
                                
                              </div>
                              <?php }?>
                              <!-- discount -->
                               <?php 
                               
                                if($check_discount){  
                                    $_SESSION["discount_id"] = $row_discount["discount_id"];
                                    $discount = $row_discount["discount_price"];                         
                               ?>
                                    <div class="discount">
                                        
                                        <span class="text_discount">Mã giảm giá: <?php echo $row_discount["discount_id"];?></span>
                                        <span class="bold"> -<?=number_format($row_discount["discount_price"])?> đ</span>
                                    </div>
                               <?php }
                               $_SESSION["amount"] = $_SESSION["price_seat"] + $total_food - $discount;
                               $_SESSION["price_ticket"] = $_SESSION["price_seat"] + $total_food;
                               ?>
                               <!-- show error discount -->
                               <?php
                                if($show_error_discount){
                               ?>
                                    <div class="show_error" id="show_error">
                                        <p class="text_error"><i class="fa-solid fa-circle-info"></i> Không tồn tại mã giảm giá!</p>
                                        <button id="close_error">OK</button>
                                    </div>
                               <?php 
                                }
                               ?>
                               <!--  -->
                            <div class="total__booking">
                                <span class="text__total">Tổng cộng</span>
                                <span class="price__booking" id="total-price"><?=number_format($_SESSION["price_seat"] + $total_food - $discount)?> đ</span>
                            </div>
                        </div>
                        <div class="control__booking">
                            <div class="row__booking">
                                <div class="btn__booking style__btn"><a href="#!" class="btn__link ">Quay lại</a></div>
                                <div class="btn__booking btn__link_continue style__btn"><label class="label__control" id="label_continue"><p class="text__continue">Tiếp tục</p></label></div>
                            </div>
                        </div>
                    </div>
                    <!-- show lỗi chưa chọn phương thức -->
                    <div class="show_error" id="show_error_method">
                        <p class="text_error"><i class="fa-solid fa-circle-info"></i> Bạn chưa chọn phương thức thanh toán!</p>
                        <button id="close_error_method">OK</button>
                    </div>
                    <!-- ticket -->
                        <div class="control__display">
                        <input type="checkbox" id="overlay" hidden>
                        <label for="overlay"><div class="overlay"></div></label>
                        <div class="ticket" id="ticket">
                            <?php
                            $result_infofilm->data_seek(0);
                            $r = $result_infofilm->fetch_assoc();

                            ?>
                            <h2 class="title__ticket">THÔNG TIN ĐẶT VÉ</h2>
                            <!-- film -->
                            <div class="row__film">
                                <span class="span__page">Phim</span>
                                
                                <div class="box_namefilm border__ticket">
                                    <p class="text_namefilm ticket__namefilm"><?=$r["movie_name"]?></p>
                                    <div class="row__subinfo">
                                        <span class="text__subnamefilm">2D Phụ Đề - </span>
                                        <span class="text__limitage text__ticketage"><?=$r["movie_minage"]?></span>
                                    </div>
                                </div>
    
                                
                            </div>
                            <!-- room -->
                            <div class="row__film">
                                <span class="span__page">Rạp</span>
                                
                                <div class="box_namefilm border__ticket">
                                    <p class="text_namefilm ticket__namefilm"><?=$r["cinema_name"]?></p>
                                    <div class="row__subinfo">
                                        <span class="text__subnamefilm showtime__film"><?=$r["show_time"]?> - <?=$r["show_day"]?>,<?php $date = new DateTime($r["show_date"]);echo $date->format("d/m/Y"); ?></span>
                                    </div>
                                </div>
                                
    
                                
                            </div>
                            <!-- room -->
                            <div class="row__film">
                                <span class="span__page"></span>
                                
                                <div class="box_namefilm border__ticket">
                                    <p class="text_namefilm room__name"><?=$r["room_name"]?></p>
                                    <div class="row__subinfo">
                                        <span class="text__subnamefilm room__seat">Vé 2D:
                                        <?php   
                                        
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

                                    }
                                    ?>
                                        </span>
                                    </div>
                                </div>
                                
    
                                
                            </div>
                            <!-- total -->
                            <div class="row__film">
                                <span class="span__page">Tổng</span>
                                
                                <div class="box_namefilm border__ticket border__ticket--color">
                                    <span class="ticket__price"><?=number_format($_SESSION["amount"])?>&nbsp;VNĐ</span>
                                </div>
                                
                            </div>
                            <div class="decor">
                                <img src="../assets/image/decor/line.png" alt="" class="decor__line">
                            </div>
                            <p class="confirm">Tôi xác nhận các thông tin đặt vé đã chính xác <input type="checkbox" name="confirm"></p>
                            <p class="error_confirm" id="error_confirm">Vui lòng xác nhận lại thông tin đã đặt</p>
                            <button class="confirm__pay btn" id="btnpayment">Thanh Toán</button>
                        </div>
                        </div>
                        <!-- form insert vào data -->
                   <form action="save_data.php" hidden>
                        <input type="text" id="method" name="method_id">
                        <button type="submit" id="btn_save"></button>
                   </form>

                </div>
            </div>
        </div>
     </main>
    <script>
        // Xử lý mã sai
        document.addEventListener("DOMContentLoaded",function(){
            const btn_close = document.getElementById("close_error");
            btn_close.addEventListener("click", function (){
                show_error.style.display = "none";
            });
        });
        // xử lý chưa chọn phương thức
        document.addEventListener("DOMContentLoaded",function(){
            const btn_close = document.getElementById("close_error_method");
            btn_close.addEventListener("click", function (){
                show_error_method.style.display = "none";
            });
        });
        // Xử lý chọn phương thức
        document.addEventListener("DOMContentLoaded",function (){
            const btnnext = document.getElementById("label_continue");
            const overlay = document.getElementById("overlay");
            
            btnnext.addEventListener("click", function(){
                const method = document.querySelector('input[name="select__method"]:checked');
                if(method){
                    overlay.checked = true;
                }
                else{
                    show_error_method.style.display = "block";
                }
            });
        });
        document.addEventListener("DOMContentLoaded",function(){
            const btnpayment = document.getElementById("btnpayment");
            const method = document.getElementById("method");
            btnpayment.addEventListener("click",function(){
                const confirm = document.querySelector('input[name="confirm"]:checked');
                const method_id = document.querySelector('input[name="select__method"]:checked');
                if(confirm){
                    overlay.checked= false;
                    alert("Thanh toán thành công");
                    method.value = method_id.value;
                    btn_save.click();
                }
                else
                {
                    error_confirm.style.display = "block";
                }
            });
        });

    </script>
</body>
</html>