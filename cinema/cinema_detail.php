<?php 
    session_start();
    require_once("../connect/connection.php");
    $film_premiere = $conn->query("select * from movies where movie_ispremiere = 1 and movie_status  = 1");
    $film_categories= $conn->query("select * from film_categories");
    // id rạp
    $cinema_id = $_REQUEST["cinema_id"];
    $sql_cinema = "select * from cinema where cinema_id = $cinema_id";
    $result_cinema = $conn->query($sql_cinema);
    $r = $result_cinema->fetch_assoc();
    // truy vấn hiện thị phim
    if(!isset($_REQUEST["check_date"])){
        $check_date="2024-11-11";
    }
    else{
        $check_date = $_REQUEST["check_date"];
    }
    $sql_film = "select * from schedules S
    join room R on R.room_id = S.room_id
    join cinema C on C.cinema_id = R.cinema_id
    join movies M on M.movie_id = S.movie_id
    where S.show_date = '$check_date' and C.cinema_id = $cinema_id
    group by S.movie_id 
    ";
    $result_film = $conn->query($sql_film);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TTNP: Hệ thống đặt vé xem phim online</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../assets/css/home/reset.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap"
        rel="stylesheet">
    <!-- link css phan login -->
    <link rel="stylesheet" href="../assets/css/login/login.css"> 
    <!--  -->
    <link rel="stylesheet" href="../assets/css/home/grid.css">
    <link rel="stylesheet" href="../assets/css/home/styles.css">
    <link rel="stylesheet" href="../assets/css/cinema/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body style="height: 1000px">
    <!-- header -->
    <header class="header">
        <div class="container" style="--spacer:20px;">
            <div class="header__inner">
                <a href="home.php"><img src="../logo.png" alt="" class="header__img"></a>
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
                                                    <a href="./show_detailfilm.php?movie_id=<?php echo $row1["movie_id"];?>"><div class="ticket__film header__ticket"><i class="fa-solid fa-ticket" style="margin-right:5px"></i> Mua vé</div></a>
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
                        <?php 
                                //truy vấn lấy tên rạp
                                $sql_cinema = "select * from cinema";
                                $result_cinema = $conn->query($sql_cinema);
                                
                                while($r_cinema = $result_cinema->fetch_assoc()){
                            ?>
                            <li class="header__submenu--item"><a href="./cinema_detail.php?cinema_id=<?=$r_cinema['cinema_id']?>" class="header__submenu--link"><?=$r_cinema["cinema_name"]?></a> <span class="decor__submenu"></span></li>
                            <?php
                                }
                            ?>
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
                                <li class="header__submenu--item"><a href="../profile/profile.php" class="header__submenu--link">Tài Khoản</a> <span class="decor__submenu"></span></li>
                                <li class="header__submenu--item"><a href="../login/logout.php" class="header__submenu--link">Đăng Xuất</a> <span class="decor__submenu"></span></li>
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
    <!-- main -->
    <main>
        <!-- poster -->
        <div class="poster">

                <div class="poster__list">    
                    <div class="poster__item">
                        <img src="../assets/image/image_cinema/anh1.jpg" alt="" class="home__poster">
                    </div>
                    <div class="poster__item">
                        <img src="../assets/image/image_cinema/anh2.jpg" alt="" class="home__poster">
                    </div>
                    <div class="poster__item">
                        <img src="../assets/image/image_cinema/anh3.jpg" alt="" class="home__poster">
                    </div>
                    <div class="poster__item">
                        <img src="../assets/image/image_cinema/anh4.jpg" alt="" class="home__poster">
                    </div>
                </div>

                <!-- button prev and next-->

                <div class="buttons">
                    <button id="prev"><</button>
                    <button id="next">></button>
                </div>

                <!-- dots -->
                 <ul class="dots">
                    <li class="active_dot"></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                 </ul>

        </div>

        <div class="cinema_wrap">
            <!-- info_cinema -->
            <div class="container">
                <div class="cinema">
                        <div class="info_cinema">
                            <h2 class="title_cinema"><?=$r["cinema_name"]?></h2>
                            <p class="cinema_desc">Địa chỉ: <?=$r["location"]?></p>
                            <p class="hotline">Hotline: <span class="blue">19002004</span></p>
                        </div>
                        <!-- chọn rạp -->
                        <div class="cinema_trl">
                            <form>
                                <select name="" id="" class="select_cinema">
                                    <option value="">Hà Nội</option>
                                </select>
                                <select name="cinema_id" id="" class= "select_cinema">
                                    <?php
                                        // truy vấn lấy tất cả rạp
                                        $sql_all_cinema = "select * from cinema";
                                        $result_all_cinema = $conn->query($sql_all_cinema);
                                        
                                        while($r_all_cinema = $result_all_cinema->fetch_assoc()){
                                    ?>
                                        <option value="<?=$r_all_cinema["cinema_id"]?>" <?php if($r_all_cinema["cinema_id"] == $cinema_id) echo "selected";?>><?=$r_all_cinema["cinema_name"]?></option>   
                                    <?php }?>
                                </select>
                                <button class="select_cinema">Chọn</button>
                            </form>
                        </div>
                     </div>
            </div>
        </div>

        <div class="container_film">
            <div class="container">
                <div class="container_film__inner">
                    <span class="title_page">PHIM</span>
                    <!-- Thứ -->
                    <div class="date_wrap">
                        <a href="?check_date=2024-11-11&cinema_id=<?=$cinema_id?>">
                            <div class="date <?php if($check_date == "2024-11-11") echo "active_day";?>">
                                <span class="date_name">Thứ Hai</span>
                                <span class="day_name">11/11</span>
                            </div>
                        </a>
                        <a href="?check_date=2024-11-12&cinema_id=<?=$cinema_id?>">
                            <div class="date <?php if($check_date == "2024-11-12") echo "active_day";?>">
                                <span class="date_name">Thứ Ba</span>
                                <span class="day_name">12/11</span>
                            </div>
                        </a>
                        <a href="?check_date=2024-11-13&cinema_id=<?=$cinema_id?>">
                            <div class="date <?php if($check_date == "2024-11-13") echo "active_day";?>">
                                <span class="date_name">Thứ Tư</span>
                                <span class="day_name">13/11</span>
                            </div>
                        </a>
                        <a href="?check_date=2024-11-14&cinema_id=<?=$cinema_id?>">
                            <div class="date <?php if($check_date == "2024-11-14") echo "active_day";?>">
                                <span class="date_name">Thứ Năm</span>
                                <span class="day_name">14/11</span>
                            </div>
                        </a>
                        <a href="?check_date=2024-11-15&cinema_id=<?=$cinema_id?>">
                            <div class="date <?php if($check_date == "2024-11-15") echo "active_day";?>">
                                <span class="date_name">Thứ Sáu</span>
                                <span class="day_name">15/11</span>
                            </div>
                        </a>
                        <a href="?check_date=2024-11-16&cinema_id=<?=$cinema_id?>">
                            <div class="date <?php if($check_date == "2024-11-16") echo "active_day";?>">
                                <span class="date_name">Thứ Bảy</span>
                                <span class="day_name">16/11</span>
                            </div>
                        </a>
                        <a href="?check_date=2024-11-17&cinema_id=<?=$cinema_id?>">
                            <div class="date <?php if($check_date == "2024-11-17") echo "active_day";?>">
                                <span class="date_name">Chủ Nhật</span>
                                <span class="day_name">17/11</span>
                            </div>
                        </a>
                    </div>
                    <!-- các phim trong rạp -->
                    <div class="film_item row">
                        <?php 
                            if($result_film->num_rows > 0){
                                while($r_film = $result_film->fetch_assoc()){
                        ?>
                        <div class="col-2">
                            <div class="item__film header__itemflim body_itemfilm">
                                <div class="film__title">
                                    <img src="../assets/image/image__film/<?=$r_film["movie_img"]?>" alt=""
                                        class="img__film">
                                    <p class="film__name header__filmname"><?=$r_film["movie_name"]?></p>
                                </div>
                                <div class="book_film header__bookfilm">
                                    <a href="../show_detailfilm.php?movie_id=<?=$r_film['movie_id']?>&select__cinema=<?=$r_film['cinema_id']?>"><div class="ticket__film header__ticket"><i class="fa-solid fa-ticket" style="margin-right:5px"></i> Mua vé</div></a>
                                </div>
                                <div class="vote header__vote body_vote">
                                    <span class="rate__film"><i class="fa-solid fa-star rate__star"></i><?=$r_film["movie_rating"]?></span>
                                </div>
                                <div class="age__limit header__agelimit body_agelimit">
                                    <span class="age__limit--text"><?=$r_film["movie_minage"]?></span>
                                </div>
                            </div> 
                        </div>
                        <?php
                                }
                            }
                        ?>
                    </div>      
                
                </div>

                <!-- thong tin chi tiet -->
                <div class="price_ticket row">
                    <div class="col-6">
                        <div class="ticket">
                            <span class="title_page">GIÁ VÉ</span>
                            <img src="../assets/image/price_ticket.jpg" alt="" class="img_price">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="cinema_detail">
                            <span class="title_page">THÔNG TIN CHI TIẾT</span>
                            <p class="cinema_address">Địa chỉ: <strong class="strong"><?=$r["location"]?></strong></p>
                            <p class="cinema_hotline">Số điện thoại: <strong class="strong">1900 2224</strong></p>
                            <div class="map__wrap">
                                <iframe src="https://www.google.com/maps?q=<?=$r["cinema_name"]?>&output=embed" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

                            </div>
                            <p style="margin-top:10px;">Là rạp chiếu đầu tiên và đông khách nhất trong hệ thống, TTNP chính thức đi vào hoạt động từ ngày 20/5/2005 và được xem là một trong những cụm rạp mang tiêu chuẩn quốc tế hiện đại bậc nhất đầu tiên xuất hiện tại Việt Nam. TTNP là một trong những rạp chiếu phim tiên phong mang đến cho khán giả những trải nghiệm phim chiếu rạp tốt nhất. </p>
                            </br>
                            <p>TTNP gồm 5 phòng chiếu với hơn 1000 chỗ ngồi, trong đó có 1 phòng chiếu phim 3D và 4 phòng chiếu phim 2D, với hơn 1000 chỗ ngồi được thiết kế tinh tế giúp khách hàng có thể xem những bộ phim hay một cách thoải mái và thuận tiện nhất. Chất lượng hình ảnh rõ nét, âm thanh Dolby 7.1 cùng màn hình chiếu kỹ thuật 3D và Digital vô cùng sắc mịn, mang đến một không gian giải trí vô cùng sống động.</p>
                            </br>
                            <p>Bên cạnh đó, với lợi thế gần khu vực sầm uất bậc nhất ở trung tâm thành phố, bãi để xe rộng rãi, có tiệm cafe ngoài trời – đây là nơi cực thu hút bạn trẻ đến xem phim và check-in.</p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

    </main>
    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer__inner">
                <div class="row">
                    <div class="col-3">
                        <h3 class="title_footer">GIỚI THIỆU</h3>
                        <ul>
                            <li class="item__footer">Về Chúng Tôi</li>
                            <li class="item__footer">Thỏa Thuận Sử Dụng</li>
                            <li class="item__footer">Quy Chế Hoạt Động</li>
                            <li class="item__footer">Chính Sách Bảo Mật</li>
                        </ul>
                    </div>
                    <div class="col-3">
                        <h3 class="title_footer">GÓC ĐIỆN ẢNH</h3>
                        <ul>
                            <li class="item__footer">Thể Loại Phim</li>
                            <li class="item__footer">Bình Luận Phim</li>
                            <li class="item__footer">Blog Điện Ảnh</li>
                            <li class="item__footer">Phim Hay Tháng</li>
                            <li class="item__footer">Phim IMAX</li>
                        </ul>
                    </div>
                    <div class="col-3">
                        <h3 class="title_footer">HỖ TRỢ</h3>
                        <ul>
                            <li class="item__footer">Góp ý</li>
                            <li class="item__footer">Sale & Services</li>
                            <li class="item__footer">Rạp / Giá vé</li>
                            <li class="item__footer">Tuyển Dụng</li>
                            <li class="item__footer">FAG</li>
                        </ul>
                    </div>
                    <div class="col-3">
                        <div><img src="../logo.png" alt="" class="logo_footer"></div>
                        <div class="row__icon">
                            <i class="fa-brands fa-facebook  icon__footer"></i><i class="fa-brands fa-youtube icon__footer"></i><i class="fa-brands fa-instagram icon__footer"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src = "../assets/js/slider.js"></script>
</body>
</html>