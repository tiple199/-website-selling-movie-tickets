<?php
    session_start();
    require_once("./connect/connection.php");
    $check_movieid = $_REQUEST["movie_id"];
    if(!isset($_REQUEST["check_date"])){
        $_REQUEST["check_date"] = "2024-11-11";
    }
    if(!isset($_REQUEST["select__cinema"]) || $_REQUEST["select__cinema"] == "allcinema"){
        $check_cinemaid = "";
        // cinema
        $cinema = $conn->query("select * from cinema");
    }
    else{
        $check_cinemaid = $_REQUEST["select__cinema"];
        // cinema
        $cinema = $conn->query("select * from cinema where cinema_id = $check_cinemaid");
    }
    $check_date = $_REQUEST["check_date"];
    // header
    $film_categories= $conn->query("select * from film_categories");
    $film_premiere = $conn->query("select * from movies where movie_ispremiere = 1 and movie_status  = 1");
    // thong tin phim qua id
    $search__film = $conn->query("select * from movies where movie_id = $check_movieid and movie_status  = 1");
    // ad
    $film_ad = $conn->query("select * from  movies M where movie_status  = 1 and movie_ad = 1");
    // the loai
    $genre = $conn->query("select G.g_name from movie__genre MG join genre_film G on MG.genre_id = G.g_id where MG.movie_id = $check_movieid");
    // actor
    $actor = $conn->query("select a.a_name from movie__actor MA join actor a on a.a_id = MA.a_id where MA.movie_id = $check_movieid");
    // director
    $director = $conn->query("select d.d_name from movie__director MD join director d on d.d_id = MD.d_id where MD.movie_id = $check_movieid");
    // Content_film
    $content_film = $conn->query("select * from content_film C where C.movie_id = $check_movieid");
    // cinema__selectform
    $cinema_form =$conn->query("select * from cinema");
    // check premiere
    $check_film_premiere = $conn->query("select * from movies where movie_id = $check_movieid");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TTNP: Hệ thống đặt vé xem phim online</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="./assets/css/home/reset.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/home/styles.css">
    <link rel="stylesheet" href="./assets/css/show_detailfilm/styles.css">
    <link rel="stylesheet" href="./assets/css/home/grid.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body>
    <!-- header -->
    <header class="header">
        <div class="container" style="--spacer:20px;">
            <div class="header__inner">
                <a href="./home.php"><img src="./logo.png" alt="" class="header__img"></a>
                <img src="./assets/image/decor/decor__header.webp" alt="" class="decor__header">
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
                                                <div class="film__title"><img src="./assets/image/image__film/<?php echo $row1["movie_img"];?>" alt=""
                                                        class="img__film header__imgfilm">
                                                    <p class="film__name header__filmname"><?php echo $row1["movie_name"];?></p>
                                                </div>
                                                <div class="book_film header__bookfilm">
                                                    <a href="./show_detailfilm.php?movie_id=<?php echo $row1["movie_id"]?>"><div class="ticket__film header__ticket"><i class="fa-solid fa-ticket" style="margin-right:5px"></i> Mua vé</div></a>
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
                                                        <img src="./assets/image/decor/decor__premiere.png" alt="" class="decor__premiere">
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
                    if(!isset($_SESSION["login_status"])){
                    ?>
                    <button id="loginBtn" class="btn btn__header">Đăng Nhập</button>
                    <?php
                    } else {
                        $userdb = $_SESSION["login_status"][1];
                        $sqtaccount= $conn->query("select * from user where username = '$userdb'");
                        $row1 = $sqtaccount->fetch_assoc();
                        if($_SESSION["login_status"][0] == "1"){
                    
                    ?>
                    <div class="account">
                        <img src="assets/image/avatar.jpg" alt="taikhoan" width="50px" height="50px">
                        <h2 class="header__item"><?php echo $row1["fullname"];?>
                            <ul class="header__submenu">
                                <li class="header__submenu--item"><a href="#!" class="header__submenu--link">Tài Khoản</a> <span class="decor__submenu"></span></li>
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
    <!-- trailer -->
    <div class="trailer">
        <div class="trailer__inner">
            <div class="trailer__Film">
                <?php 
                    while($row = $search__film->fetch_assoc()){
                ?>
                <img src="./assets/image/image__trailer/<?php echo $row["movie_img"];?>" alt="" class="img__poster">
                <?php
                    }
                    $search__film->data_seek(0);
                ?>
                <i class="fa-solid fa-circle-play button_play"></i>
            </div>
        </div>
    </div>
    <div class="body__file">
        <div class="container">
            <div class="body__file__inner">
                <!-- body__film -->
                <div class="content__film__wrap">
                    <div class="content__film">
                        <div class="row__content__film">
                            <?php while($row = $search__film->fetch_assoc()){
                            ?>
                            <div class="avatar__film__wrap">
                                <img src="./assets/image/image__film/<?php echo $row["movie_img"];?>" alt="" class="avatar__film">
                            </div>
                            <div class="info__film">
                                <h1 class="name__film"><?php echo $row["movie_name"];?><span class="limit__age"><?php echo $row["movie_minage"];?></span></h1>
                                <div class="row__wrap">
                                    <span class="movie__duration"><i class="fa-regular fa-clock color__primary"></i> <?php echo $row["movie_time"];?> Phút</span>
                                    <span class="movie__date"><i class="fa-regular fa-calendar color__primary"></i> <?php echo $row["movie_date"];?></span>
                                </div>
                                <span class="movie__rating"><i class="fa-solid fa-star color__primary"></i> <?php echo $row["movie_rating"];?></span>
                                <p class="movie_nation">Quốc gia: <?php echo $row["movie_nation"]?></p>    
                                <p class="manufacturer">Nhà sản xuất: <?php echo $row["movie_manufacturer"]?></p>
                                <div class ="movie__genre row_wrap"><p class="text__movie__genre">Thể loại:</p> 
                                    <div class="movie__genre__wrap">
                                        <?php while($row =$genre->fetch_assoc()){
                                        ?>
                                        <span class="border__item"><?php echo $row["g_name"];?></span>
                                        <?php }?>
                                    </div>
                                </div>
                                <!-- director -->
                                
                                <div class="movie__director row_wrap"> <p class="text__movie__director">Đạo diễn: </p> 
                                <div class="movie__director__wrap">
                                    <?php 
                                        if($row = $director->fetch_assoc() != false){
                                            $director->data_seek(0);
                                        while($row = $director->fetch_assoc()){
                                    ?>
                                    <span class="border__item"><?php echo $row["d_name"];?></span>                            
                                    <?php 
                                    }    
                                }
                                else{
                                ?>
                                <p class="text__update">Đang cập nhật...</p>
                                <?php 
                                }?>
                                </div></div>
                                
                                
                                <!-- actor -->
                                
                               <div class="movie__performer row_wrap"><p class="text__movie__performer">Diễn viên:</p> <div class="movie__performer__wrap">
                               <?php 
                                    if($row = $actor->fetch_assoc() != false){
                                        $actor->data_seek(0);
                                    while($row = $actor->fetch_assoc()){
                
                                ?>
                                <span class="border__item actor_border"><?php echo $row["a_name"];?></span>
                                <?php 
                                    }
                                    }
                                    else{
                                ?>
                                <p class="text__update">Đang cập nhật...</p>
                                <?php 
                                    }
                                ?>
                                </div></div>
                                
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="summary__content__wrap">
                            <p class="text_cat">Nội Dung Phim</p>
                            <?php while($row = $content_film->fetch_assoc()){?>
                            <p class="summary__content"><?php echo $row["content_part1"]?></p>
                            <p class="summary__content"><?php echo $row["content_part2"]?></p>
                            <p class="summary__content"><?php echo $row["content_part3"]?></p>
                            <p class="summary__content"><?php echo $row["content_part4"]?></p>
                            <p class="summary__content"><?php echo $row["content_part5"]?></p>
                            <?php }?>
                        </div>
                        <!-- showtime_film -->
                        <?php 
                            while($row = $check_film_premiere->fetch_assoc()){
                                if($row["movie_ispremiere"] == 1){
                        ?>
                        <div class="showtime__film">
                            <p class="text_cat text__showtime">Lịch Chiếu Phim</p>
                            <div class="box__select_day">
                                    <div class="day__wrap">
                                        
                                        <a href="?movie_id=<?php echo $check_movieid;?>&check_date=2024-11-11">
                                            <div class="day__item <?php if($check_date == "2024-11-11") echo "active"?>">
                                                <span class="day_name">Thứ Hai</span>
                                                <span class="date">11/11</span>
                                            </div>
                                        </a>
                                        <a href="?movie_id=<?php echo $check_movieid;?>&check_date=2024-11-12">
                                            <div class="day__item <?php if($check_date == "2024-11-12") echo "active"?>">
                                                <span class="day_name">Thứ Ba</span>
                                                <span class="date">12/11</span>
                                            </div>
                                        </a>
                                        <a href="?movie_id=<?php echo $check_movieid;?>&check_date=2024-11-13">
                                            <div class="day__item <?php if($check_date == "2024-11-13") echo "active"?>">
                                                <span class="day_name">Thứ Tư</span>
                                                <span class="date">13/11</span>
                                            </div>
                                        </a>
                                        <a href="?movie_id=<?php echo $check_movieid;?>&check_date=2024-11-14">
                                            <div class="day__item <?php if($check_date == "2024-11-14") echo "active"?>">
                                                <span class="day_name">Thứ Năm</span>
                                                <span class="date">14/11</span>
                                            </div>
                                        </a>
                                        <a href="?movie_id=<?php echo $check_movieid;?>&check_date=2024-11-15">
                                            <div class="day__item <?php if($check_date == "2024-11-15") echo "active"?>">
                                                <span class="day_name">Thứ Sáu</span>
                                                <span class="date">15/11</span>
                                            </div>
                                        </a>
                                        <a href="?movie_id=<?php echo $check_movieid;?>&check_date=2024-11-16">
                                            <div class="day__item <?php if($check_date == "2024-11-16") echo "active"?>">
                                                <span class="day_name">Thứ Bảy</span>
                                                <span class="date">16/11</span>
                                            </div>
                                        </a>
                                        <a href="?movie_id=<?php echo $check_movieid;?>&check_date=2024-11-17">
                                            <div class="day__item <?php if($check_date == "2024-11-17") echo "active"?>">
                                                <span class="day_name">Chủ Nhật</span>
                                                <span class="date">17/11</span>
                                            </div>
                                        </a>
                                        

                                    </div>
                                    <!-- form chọn rạp -->
                                    <form action="?movie_id=<?php echo $check_movieid?>&check_date=<?php echo $check_date?>" method="post">
                                        <select name="select__cinema" id="" class="select__cinema">
                                                <option value="allcinema">Tất cả rạp</option>
                                                <?php 
                                                    while($row = $cinema_form->fetch_assoc()){
                                                ?>
                                                    <option value="<?php echo $row["cinema_id"];?>" <?php if($row["cinema_id"] == $check_cinemaid) {echo "selected";}?>><?php echo $row["cinema_name"];?></option>
                                                <?php 
                                                    }
                                                    $cinema->data_seek(0);
                                                ?>
                                                

                                            </select>
                                            <input type="submit" value = "Chọn" class="submit__btn">
                                    </form>
                            </div>
                            <!-- select time -->
                            <div class="box_select__time">
                                <?php while($row = $cinema->fetch_assoc()){
                                    if(!isset($_REQUEST["select__cinema"]) || $_REQUEST["select__cinema"] = "allcinema"){
                                        $check_cinemaid = $row["cinema_id"];
                                    }
                                    else{               
                                        $check_cinemaid = $_REQUEST["select__cinema"];
                                    }

                                ?>
                                <div class="box__item_time">
                                    <p class="cenima__name"><?php echo $row["cinema_name"];?></p>
                                    <div class="select__time">
                                        <span class="text__select_time">2D Phụ Đề</span>
                                        <div class="box__border_time">
                                            <?php
                                            $movie_showtime = $conn->query("select C.cinema_id,S.show_time,S.schedule_id from schedules S
                                            join room R on R.room_id = S.room_id
                                            join cinema C on R.cinema_id = C.cinema_id
                                            where S.movie_id = $check_movieid and S.show_date = '$check_date' and C.cinema_id = $check_cinemaid order by S.show_time
                                            ");
                                            while ($row1 = $movie_showtime->fetch_assoc()){
                                                
                                            ?>
                                            <a href="./booking/booking_film.php?schedule_id=<?php echo $row1["schedule_id"]?>"><span class="border__item_selecttime"><?php echo $row1["show_time"];?></span></a>
                                            <?php 
                                                
                                            }
                                            $movie_showtime->data_seek(0);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                        <?php }
                        }?>
                    </div>
                </div>

                <!-- ad__film -->
                <div class="ad_film">
                    <p class="text_cat">PHIM ĐANG CHIẾU</p>
                    <div class="row__filmad">
                        <?php       
                            $count= 0;
                            while($row1 = $film_ad->fetch_assoc()){
                            if($count < 3){
                            ?>
                                <div class="item__filmad">
                                    <div class="item__film header__itemflim">
                                        <div class="film__title"><img src="./assets/image/image__film/<?php echo $row1["movie_img"];?>" alt=""
                                                class="img__film header__imgfilm">
                                            <p class="film__name header__filmname"><?php echo $row1["movie_name"];?></p>
                                        </div>
                                        <div class="book_film header__bookfilm">
                                            <a href="./show_detailfilm.php?movie_id=<?php echo $row1["movie_id"]?>"><div class="ticket__film header__ticket"><i class="fa-solid fa-ticket" style="margin-right:5px"></i> Mua vé</div></a>
                                        </div>
                                        <div class="vote header__vote">
                                            <span class="rate__film"><i class="fa-solid fa-star rate__star"></i><?php echo $row1["movie_rating"];?></span>
                                        </div>
                                        <div class="age__limit header__agelimit">
                                            <span class="age__limit--text"><?php echo $row1["movie_minage"]?></span>
                                        </div>
                        
                                    </div>
                                </div>
                            <?php
                                    }
                                $count++;
                                
                                }
                                
                            ?>
                    </div>
                    <div class="btn__showmore">
                        <a href="" class="show__more">Xem thêm <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>