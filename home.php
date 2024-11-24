<?php
    require_once("connect/connection.php");
    session_start();

    // xử lý phần đăng nhập
    if(!isset($_SESSION["login_error"])){
        $_SESSION["login_error"] = '';
    }
    $loginError = $_SESSION["login_error"];

    //

    if(!isset($_REQUEST["catid"])){
        $_REQUEST["catid"] = 1;
        
    }
    if(!isset($_REQUEST["catid_active"])){
        $_REQUEST["catid_active"] = "active";
    }
    else{
        $_REQUEST["catid_active"] = "unactive";
    }
    $check_catid = $_REQUEST["catid"];
    $check_active = $_REQUEST["catid_active"];
    if($check_catid != "3"){
        $result_film = $conn->query("SELECT m.* FROM movie__categories mc, movies m WHERE mc.cat_id = $check_catid  AND mc.movie_id = m.movie_id and movie_status  = 1 ORDER BY m.movie_rating DESC");
    }
    else{
        $result_film=$conn->query("SELECT m.*
                FROM movie__categories mc,movies m
                WHERE mc.cat_id = 3 and mc.movie_id = m.movie_id and movie_status  = 1
                ORDER BY
                CASE 
                    WHEN m.movie_ispremiere = 1 THEN 1
                    ELSE 2
                END;
        ");
    }
    $film_premiere = $conn->query("select * from movies where movie_ispremiere = 1 and movie_status  = 1");
    $film_categories= $conn->query("select * from film_categories");
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
    <!-- link css phan login -->
    <link rel="stylesheet" href="./assets/css/login/login.css"> 
    <!--  -->
    <link rel="stylesheet" href="./assets/css/home/styles.css">
    <link rel="stylesheet" href="./assets/css/home/grid.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body>
    <!-- header -->
    <header class="header">
        <div class="container" style="--spacer:20px;">
            <div class="header__inner">
                <a href="#"><img src="./logo.png" alt="" class="header__img"></a>
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
    <main>
        <!-- Poster -->
        <div class="poster">
            <div class="container">
                <div class="poster__list">
                    <div class="post__item">
                        <img src="./assets/image/poster/transformersmot.jpg" alt="" class="home__poster">
                    </div>
                </div>
            </div>
        </div>
        <!-- Film -->
        <div class="film">
            <div class="container">
                <div class="film__inner">
                    <div class="type__film">
                        <span id="location_film"></span>
                        <span class="text__film">PHIM</span>
                        <ul class="type__film--list">
                            <?php
                                while($row = $film_categories->fetch_assoc()){
                            ?>
                                
                                <li class="type__film--item"><label for="" class="label__film"><a class="catid__link <?php if($row["cat_id"] == $check_catid || $check_catid == "active") echo "catid__active"?>" href = "./home.php?catid=<?php echo $row["cat_id"]?>&#location_film"><?php echo $row["cat_name"];?></a></label></li>
                            <?php
                            }
                            ?>

                        </ul>
                    </div>
                    <div class="row film__list">
                        
                        <?php
                            $count = 0;
                            if($result_film->num_rows == 0){
                                echo "Khong co phim!";
                            }
                            else{
                            while($row = $result_film->fetch_assoc()){
                                if($count < 8){
                        ?>
                            <div class="col-3">
                                <div class="item__film">
                                    <div class="film__title"><img src="./assets/image/image__film/<?php echo $row["movie_img"];?>" alt=""
                                            class="img__film">
                                            
                                        <p class="film__name"><?php echo $row["movie_name"];?></p>
                                    </div>
                                    <div class="book_film">
                                                <a href="./show_detailfilm.php?movie_id=<?php echo $row["movie_id"];?>"><div class="ticket__film"><i class="fa-solid fa-ticket" style="margin-right:5px"></i> Mua vé</div></a>
                                                <div class="trailer_film"><i class="fa-solid fa-circle-play" style="margin-right:5px"></i> Trailer</div>
                                    </div>
                                    <div class="vote">
                                        <span class="rate__film"><i class="fa-solid fa-star rate__star"></i><?php echo $row["movie_rating"];?></span>
                                    </div>
                                    <div class="age__limit">
                                        <span class="age__limit--text"><?php echo $row["movie_minage"]?></span>
                                    </div>
                                    <div class="decor__moviepremiere">
                                        <?php
                                            if($check_catid == 3){
                                            while($row1 = $film_premiere->fetch_assoc()){
                                                if($row1["movie_id"] == $row["movie_id"]){
                                        ?>
                                            <img src="./assets/image/decor/decor__premiere.png" alt="" class="decor__premiere">
                                        <?php
                                                }
                                            }  
                                        }                                        
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php 
                                    }
                            $count++;
                            $film_premiere->data_seek(0);
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
<div class="container-login">

    <!-- Lớp phủ làm tối -->d
    <div id="overlay"></div>

    <!-- Khung đăng nhập -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img src="logo.png" alt="Login Image" class="form-image">
            <h2>Đăng Nhập Tài Khoản</h2>
            <p class="text__error">
                <?php echo $_SESSION["login_error"]?>
            </p>
            <form action="./login/login__action.php" method="post" name="f" onsubmit="return check()">
                <input type="text" placeholder="Username" name="txtusername">
                <input type="password" placeholder="Password" name="txtpassword">
                <button type="submit" class="action-btn">Đăng Nhập</button>
            </form>
            <p>Bạn chưa có tài khoản? <button id="showRegister" class="link-btn">Đăng ký</button></p>
        </div>
    </div>

    <!-- Khung đăng ký -->
    <div id="registerModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img src="logo.png" alt="Register Image" class="form-image">
            <h2>Đăng Ký Tài Khoản</h2>
            <form action="./login/login__action.php" method="post">
                <input type="text" placeholder="Nhập Họ và tên">
                <input type="email" placeholder="Nhập Email">
                <input type="text" placeholder="Nhập Số điện thoại">
                <input type="password" placeholder="Nhập Mật khẩu">
                <input type="password" placeholder="Nhập lại Mật khẩu">
            <button class="action-btn">Hoàn thành</button>
            </form>
            <p>Bạn đã có tài khoản? <button id="showLogin" class="link-btn">Đăng nhập</button></p>
        </div>
    </div>
</div>
<script>
    // Kiểm tra nếu có lỗi từ PHP để mở form đăng nhập tự động
    document.addEventListener('DOMContentLoaded', function() {
        const overlay = document.getElementById('overlay');
        const loginModal = document.getElementById('loginModal');
        const loginError = <?php echo json_encode($loginError); ?>;
        
        if (loginError) {
            overlay.style.display = 'block';
            loginModal.style.display = 'block';
            document.getElementById('loginError').innerText = loginError;
        }

        // Các sự kiện khác cho nút đóng và mở form có thể được đặt ở đây
    });
</script>
<script src = "./assets/js/home/main.js"></script>
<?php $_SESSION["login_error"] = ''?>
</html>