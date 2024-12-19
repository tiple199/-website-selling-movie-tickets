<?php
    session_start();
    require_once("../connect/connection.php");
    // heading
    $film_categories= $conn->query("select * from film_categories");
    $film_premiere = $conn->query("select * from movies where movie_ispremiere = 1 and movie_status  = 1");
    // cinema_id
    $check_cinema_id = $_REQUEST["cinema_id"];
    // schedule
    $check_schedule = $_REQUEST["schedule_id"];
    $_SESSION["schedule_id"] = $check_schedule;
    $sql = "select S.schedule_id,S.show_time from schedules S
        join room R on R.room_id = S.room_id
        join cinema C on C.cinema_id = R.cinema_id
        where S.show_date = (select show_date from schedules where schedule_id = $check_schedule) and S.movie_id = (select movie_id from schedules where schedule_id = $check_schedule) and C.cinema_id= $check_cinema_id
        order by show_time
    ";
    $change_time = $conn->query($sql);
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
    <title>Bookking</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../assets/css/home/reset.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/home/styles.css">
    <link rel="stylesheet" href="../assets/css/home/grid.css">
    <link rel="stylesheet" href="../assets/css/booking/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
    <!-- heading -->
    <header class="header">
        <div class="container" style="--spacer:20px;">
            <div class="header__inner">
                <a href="../home.php"><img src="../logo.png" alt="" class="header__img"></a>
                <img src="../assets/image/decor/decor__header.webp" alt="" class="decor__header">
                <ul class="header__list">
                    <li class="header__item">Phim <i
                                class="fa-solid fa-check list-icon"></i>
                        <ul class="header__showfilm">
                            <li class="film-header__wrap">  
                                <?php
                                    while($row = $film_categories->fetch_assoc()){
                                        $cat_id = $row["cat_id"];
                                        if($cat_id != 3){
                                            $result = $conn->query("SELECT m.*,mc.cat_id FROM movie__categories mc, movies m WHERE mc.cat_id = $cat_id AND mc.movie_id = m.movie_id and movie_status  = 1 ORDER BY m.movie_rating DESC");
                                        }
                                        else{
                                            $result = $conn->query("SELECT m.*,mc.cat_id
                                                FROM movie__categories mc,movies m
                                                WHERE mc.cat_id = 3 and mc.movie_id = m.movie_id and movie_status  = 1
                                                ORDER BY 
                                                CASE 
                                                    WHEN m.movie_ispremiere = 1 THEN 1
                                                    ELSE 2
                                                END                                    
                                            ");
                                        }
                                        // $result->data_seek(0);
                                        $count = 0;
                                ?>
                                    <li class="header__showfilm--item"><?php echo $row["cat_name"];?></li>
                                <div class="header__film--wrap row">
                                        <?php
                                            
                                            while($row1 = $result->fetch_assoc()){
                                            if($count < 4 && $row["cat_id"] == $row1["cat_id"]){
                                            
                                        ?>
                                        <div class="col-3">
                                            <div class="item__film header__itemflim">
                                                <div class="film__title"><img src="../assets/image/image__film/<?php echo $row1["movie_img"];?>" alt=""
                                                        class="img__film header__imgfilm">
                                                    <p class="film__name header__filmname"><?php echo $row1["movie_name"];?></p>
                                                </div>
                                                <div class="book_film header__bookfilm">
                                                    <a href="../show_detailfilm.php?movie_id=<?php echo $row1["movie_id"]?>"><div class="ticket__film header__ticket"><i class="fa-solid fa-ticket" style="margin-right:5px"></i> Mua vé</div></a>
                                                </div>
                                                <div class="vote header__vote">
                                                    <span class="rate__film"><i class="fa-solid fa-star rate__star"></i><?php echo $row1["movie_rating"];?></span>
                                                </div>
                                                <div class="age__limit header__agelimit">
                                                    <span class="age__limit--text"><?php echo $row1["movie_minage"]?></span>
                                                </div>
                                                <div class="decor__moviepremiere">
                                                    <?php
                                                        if($cat_id == 3){
                                                        while($row2 = $film_premiere->fetch_assoc()){
                                                            if($row2["movie_id"] == $row1["movie_id"]){
                                                    ?>
                                                        <img src="../assets/image/decor/decor__premiere.png" alt="" class="decor__premiere">
                                                    <?php
                                                            }
                                                        }  
                                                    }   
                                                    $film_premiere->data_seek(0);                                     
                                                    ?>
                                                </div>
                                        </div>
                                </div>
                                        <?php
                                                }
                                            $count++;
                                            
                                            }
                                            
                                        ?>
                                    </div>
                                <?php
                                }
                                $film_categories->data_seek(0);
                                ?>
                            </li>  
                        </ul>
                    </li>
                    <li class="header__item">Góc Điện Ảnh <i
                                class="fa-solid fa-check list-icon"></i>
                        <ul class="header__submenu">
                            <li class="header__submenu--item"><a href="#!" class="header__submenu--link">Diễn Viên</a> <span class="decor__submenu"></span></li>
                            <li class="header__submenu--item"><a href="#!" class="header__submenu--link">Đạo Diễn</a> <span class="decor__submenu"></span></li>
                            <li class="header__submenu--item"><a href="#!" class="header__submenu--link">Bình Luận Phim</a> <span class="decor__submenu"></span></li>
                            <li class="header__submenu--item"><a href="#!" class="header__submenu--link">Blog Điện Ảnh</a> <span class="decor__submenu"></span></li>
                        </ul>
                    </li>
                    <li class="header__item">Sự Kiện <i
                                class="fa-solid fa-check list-icon"></i>
                        <ul class="header__submenu">
                            <li class="header__submenu--item"><a href="#!" class="header__submenu--link">Ưu Đãi</a> <span class="decor__submenu"></span></li>
                            <li class="header__submenu--item"><a href="#!" class="header__submenu--link">Phim Hay Tháng</a> <span class="decor__submenu"></span></li>
                        </ul>
                    </li>

                    <li class="header__item">Rạp/Giá Vé <i
                                class="fa-solid fa-check list-icon"></i>
                        <ul class="header__submenu">
                            <li class="header__submenu--item"><a href="#!" class="header__submenu--link">TTNP Cầu Giấy</a> <span class="decor__submenu"></span></li>
                            <li class="header__submenu--item"><a href="#!" class="header__submenu--link">TTNP Giải Phóng</a> <span class="decor__submenu"></span></li>
                            <li class="header__submenu--item"><a href="#!" class="header__submenu--link">TTNP Lê Văn Lương</a> <span class="decor__submenu"></span></li>
                            <li class="header__submenu--item"><a href="#!" class="header__submenu--link">TTNP Láng Hạ</a> <span class="decor__submenu"></span></li>
                        </ul>
                    </li>
                </ul>
                <div class="header__cta--wrap">
                    <div class="search__wrap">
                        <label for="" class="header__search"><i
                                class="fa-solid fa-magnifying-glass search__icon"></i></label>
                        <form action=""></form>
                    </div>
                    <!-- Xử lý phần đăng nhập tài khoản -->
                    <?php
                    if(!isset($_SESSION["login_status"]) && !isset($_SESSION["id_user"])){
                    ?>
                    <button id="loginBtn" class="btn btn__header">Đăng Nhập</button>
                    <?php
                    } else {
                        $iduserdb = $_SESSION["id_user"];
                        $sqtaccount= $conn->query("select * from user where id = $iduserdb");
                        $row1 = $sqtaccount->fetch_assoc();
                        if($_SESSION["login_status"] == "1"){
                    
                    ?>
                    <div class="account">
                        <img src="../assets/image/avatar.jpg" alt="taikhoan" width="50px" height="50px">
                        <h2 class="header__item"><?php echo $row1["fullname"];?>
                            <ul class="header__submenu">
                                <li class="header__submenu--item"><a href="./profile/profile.php" class="header__submenu--link">Tài Khoản</a> <span class="decor__submenu"></span></li>
                                <li class="header__submenu--item"><a href="./login/logout.php" class="header__submenu--link">Đăng Xuất</a> <span class="decor__submenu"></span></li>
                            </ul>
                        </h2>
                        <?php
                        }
                    }
                        ?>
                    </div>
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
            <span class="step_book">Chọn thức ăn</span>
            <span class="step_book">Thanh toán</span>
            <span class="step_book">Xác nhận</span>
        </div>

        <!-- booking -->
        <div class="booking">
            <div class="container">
                <div class="booking__inner">
                    <!-- Chọn ghế -->
                    <div class="column_01">
                        <!-- Thay đổi thời gian -->
                        <div class="changetime">
                            <p class="text_changetime">Đổi suất chiếu</p>
                            <div class="showtime">
                                <?php
                                    while($row=$change_time->fetch_assoc()){
                                ?>
                                    <a href="?schedule_id=<?php echo $row["schedule_id"];?>&cinema_id=<?=$check_cinema_id?>"><span class="border__time <?php if($row["schedule_id"] == $check_schedule) echo "active";?>"><?php echo $row["show_time"];?></span></a>

                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <!-- Chọn ghê -->
                         <div class="select__reservation">
                            <?php
                                
                                $sql_row = "SELECT DISTINCT row FROM seats";
                                $result_row = $conn->query("$sql_row");
                                
                                while($row1 = $result_row->fetch_assoc()){
                                    $check_row = $row1["row"];
                                    
                            ?>
                            <div class="row__seat">
                                <div class="row"><?php echo $row1["row"];?></div>
                                <div class="seat__wrap">
                                    <?php 
                                    // truy vấn lấy ghế
                                        $sql_seat = "select S.row,S.seat_number,S.seat_id,S.seat_price from seats S
                                        join room R on R.room_id = S.room_id
                                        join schedules SD on SD.room_id = R.room_id
                                        where SD.schedule_id = $check_schedule and S.row = '$check_row' order by S.row ASC,S.seat_number ASC
                                        ";
                                        $result_seat = $conn->query($sql_seat);
                                    // truy vấn lấy ghế đã được bán
                                        $sql_seat_sold="select S.seat_id from seat_booking S
                                        join schedules SD on SD.schedule_id = S.schedule_id
                                        join room R on R.room_id = SD.room_id
                                        where SD.schedule_id = $check_schedule";
                                        $result_seat_sold=$conn->query($sql_seat_sold);

                                        // truy vấn lấy ghế vip
                                        $sql_seat_vip = "select seat_id from seats where seat_type = 1";
                                        $rs_seat_vip = $conn->query($sql_seat_vip);
                                        
                                        while($row = $result_seat->fetch_assoc()){
                                            
                                    ?>
                                    <!-- list ghế -->
                                    <div>
                                        <input type="checkbox" value="<?php echo $row["seat_id"];?>" id = "<?php echo $row["seat_id"];?>" data-price="<?php echo $row["seat_price"];?>" hidden <?php
                                            while($r = $result_seat_sold->fetch_assoc()){
                                                if($row["seat_id"] == $r["seat_id"]){
                                                    echo " disabled ";
                                                    break;
                                                }
                                            }
                                            $result_seat_sold->data_seek(0);
                                        ?>>
                                        <label for="<?php echo $row["seat_id"];?>">
                                            <div class="seat <?php
                                                while($r = $result_seat_sold->fetch_assoc()){
                                                    if($row["seat_id"] == $r["seat_id"]){
                                                        echo " seat_readonly ";
                                                        break;
                                                    }
                                                    

                                                }
                                                $result_seat_sold->data_seek(0);
                                                while($r1 = $rs_seat_vip->fetch_assoc()){
                                                    if($row["seat_id"] == $r1["seat_id"]){
                                                        echo "seat_vip_form";
                                                        break;
                                                    }
                                                }
                                                $rs_seat_vip->data_seek(0);
                                            ?>">
                                                <span hidden><?php echo $row["row"]?></span><?php echo $row["seat_number"];?>  
                                            </div>
                                        </label>
                                    </div>
                                    
                                    
                                    <?php 
                                                
                                        }
                                    ?>
                                </div>
                                <div class="row"><?php echo $row1["row"];?></div>
                            </div>
                            <?php 
                            }
                            ?>
                            <!-- form lưu session -->
                            <form id="seatForm" method="POST" action="save_seat_selection.php">
                                <input type="hidden" name="selectedSeats" id="selectedSeats">
                                <button type="submit" hidden id="next_step_booking"></button>
                            </form>
                            <!-- Khối hiện lỗi -->
                            <div class="error-message" id="errorMessage">
                                <p>Vui lòng chọn ít nhất một ghế trước khi tiếp tục!</p>
                                <button id="closeError">Đóng</button>
                            </div>
                            <!-- screen -->
                            <div class="screen">
                              <p class="text__screen">Màn hình</p>
                            </div>

                            <!-- desc seat -->
                             <div class="seat__desc">
                                <div class="desc__wrap">
                                    <span class="info__seat seat_sold">Ghế đã bán</span>
                                    <span class="info__seat seat_buy">Ghế đang chọn</span>
                                </div>
                                <div class="desc__wrap">
                                    <span class="info__seat seat_vip">Ghế vip</span>
                                    <span class="info__seat seat_normal">Ghế thường</span>
                                </div>
                             </div>
                        </div>
                         
                    </div>
                    <!-- hiện thị thông tin vé -->
                    <div class="column_02">
                        <div class="item__film_selected">
                            <?php
                                while($row = $result_infofilm->fetch_assoc()){
                                    $movie_id = $row["movie_id"];
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
                                    <span class="seat__quantity"><strong class="bold">1x</strong> Ghế đơn</span>
                                    <span class="seat__selected">Ghế: <strong class="bold">A1</strong></span>
                                </div>
                                <span class="price_total_seat bold"></span>
                             </div>
                            <div class="total__booking">
                                <span class="text__total">Tổng cộng</span>
                                <span class="price__booking">0 đ</span>
                            </div>
                        </div>
                        <div class="control__booking">
                            <div class="row__booking row">
                                <div class="col-6 btn__booking"><a href="../show_detailfilm.php?movie_id=<?=$movie_id?>" class="btn__link">Quay lại</a></div>
                                <div class="col-6 btn__booking btn__link_continue"><label for="next_step_booking" class="link__continue">Tiếp tục</label></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </main>
     <!-- Xử lý khi chọn ghế -->
     <script>
        // Xử lý chọn ghế
        document.addEventListener("DOMContentLoaded", function () {
        const seatCheckboxes = document.querySelectorAll('input[type="checkbox"]');
        const ticketDetails = document.querySelector(".info_seat");
        const seatQuantity = document.querySelector(".seat__quantity strong");
        const selectedSeats = document.querySelector(".seat__selected strong");
        const priceDisplay = document.querySelector(".price_total_seat");
        const totalPriceDisplay = document.querySelector(".price__booking");
            
        ticketDetails.style.display = "none"; // Ẩn thông tin vé ban đầu
            
        seatCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener("change", () => {
                let totalPrice = 0;
                let selectedSeatNumbers = [];
            
                seatCheckboxes.forEach((seat) => {
                    if (seat.checked) {
                        const seatNumber = seat.nextElementSibling.querySelector(".seat").textContent.trim();
                        const seatPrice = parseInt(seat.dataset.price, 10);
                        selectedSeatNumbers.push(seatNumber);
                        totalPrice += seatPrice;
                    }
                });
            
                if (selectedSeatNumbers.length > 0) {
                    ticketDetails.style.display = "flex"; // Hiện thông tin vé khi có ghế được chọn
                    seatQuantity.textContent = `${selectedSeatNumbers.length}x`; // Cập nhật số lượng ghế
                    selectedSeats.textContent = selectedSeatNumbers.join(", "); // Hiển thị số ghế
                    priceDisplay.textContent = `${totalPrice.toLocaleString()} đ`; // Hiển thị giá
                    totalPriceDisplay.textContent = `${totalPrice.toLocaleString()} đ`; // Hiển thị tổng giá
                } else {
                    ticketDetails.style.display = "none"; // Ẩn thông tin vé nếu không chọn ghế nào
                    totalPriceDisplay.textContent = "0 đ"; // Reset tổng giá về 0
                }
            });
        });
        });



        
        // Xử lý session
        document.addEventListener("DOMContentLoaded", function () {
            const seatCheckboxes = document.querySelectorAll('input[type="checkbox"]');
            const seatForm = document.getElementById("seatForm");
            const closeErrorButton = document.getElementById("closeError");
            const selectedSeatsInput = document.getElementById("selectedSeats");

            // Khi nhấn nút "Tiếp tục", cập nhật danh sách ghế đã chọn
            seatForm.addEventListener("submit", function () {
                const selectedSeatIds = Array.from(seatCheckboxes)
                    .filter((seat) => seat.checked) // Lọc ra những checkbox được chọn
                    .map((seat) => seat.value); // Lấy giá trị ID ghế

                // Gán danh sách ghế vào input ẩn
                if (selectedSeatIds.length === 0) {
                    // Nếu không có ghế nào được chọn, ngăn form gửi và hiển thị thông báo lỗi
                    event.preventDefault();
                    errorMessage.style.display = "block";
                }
                selectedSeatsInput.value = selectedSeatIds.join(",");
            });
            closeErrorButton.addEventListener("click", function () {
                errorMessage.style.display = "none";
            });
        });


        
    </script>

</body>
</html>