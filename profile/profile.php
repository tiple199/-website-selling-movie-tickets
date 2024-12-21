<?php
    session_start();
    require_once("../connect/connection.php");
    $film_categories= $conn->query("select * from film_categories");
    // Truy vấn lấy user
    $user_id = $_SESSION["id_user"];
    $sql_user= "select * from user where id = $user_id";
    $result_user = $conn->query($sql_user);
    $row_user = $result_user->fetch_assoc();

    // save change
    if(isset($_REQUEST["action_save"]))
    {
        
        switch ($_REQUEST["action_save"]){
            case "save_email":
                $email = $_REQUEST["email_change"];
                $sql_save_email = "update user set email = '$email' where id = $user_id";
                $conn->query($sql_save_email);
                echo "<script>
                    alert('Thay đổi email thành công. Xin mời đăng nhập lại!');
                    window.location.href = '../login/logout.php';
                    </script>";
                break;
            case "save_password":
                $pass = $_REQUEST["current_password"];
                $new_pass = $_REQUEST["new_password"];
                $sql_save_password = "select * from user where id = $user_id and password = '$pass'";
                $result =$conn->query($sql_save_password);
                if($result->num_rows > 0){
                    $sql_save_password = "update user set password = '$new_pass' where id = $user_id";
                    $conn->query($sql_save_password);
                    echo "<script>
                    alert('Thay đổi mật khẩu thành công. Xin mời đăng nhập lại!');
                    window.location.href = '../login/logout.php';
                    </script>";
                }
                else{
                    $_SESSION["error_save_pass"] = "Password hiện tại không chính xác!";
                    Header("Location: ./profile.php?error_save_password=true");
                }
                break;
        }
            
    }

    
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
    <link rel="stylesheet" href="../assets/css/home/styles.css">
    <link rel="stylesheet" href="../assets/css/user/styles.css">
    <link rel="stylesheet" href="../assets/css/home/grid.css">
    <link rel="stylesheet" href="../assets/css/booking/styles.css">
    <link rel="stylesheet" href="../assets/css/profile/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body>
    <!-- header -->
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
                                                WHERE mc.cat_id = 3 and mc.movie_id = m.movie_id
                                                ORDER BY 
                                                CASE 
                                                    WHEN mc.cat_id = 1 THEN 1
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
                            <li class="header__submenu--item"><a href="../discount/show_discount.php" class="header__submenu--link">Ưu Đãi</a> <span class="decor__submenu"></span></li>
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
                            <li class="header__submenu--item"><a href="../cinema/cinema_detail.php?cinema_id=<?=$r_cinema['cinema_id']?>" class="header__submenu--link"><?=$r_cinema["cinema_name"]?></a> <span class="decor__submenu"></span></li>
                            <?php
                                }
                            ?>
                        </ul>
                    </li>
                </ul>
                <div class="header__cta--wrap">
                    <!-- search -->
                    <div class="search__wrap">
                        <label for="" class="header__search"><i
                                class="fa-solid fa-magnifying-glass search__icon"></i></label>
                        <form action=""></form>
                    </div>
                    <!-- box_user -->
                    <div class="box_user">
                        <div class="avatar__userwrap">
                            <i class="fa-regular fa-user avatar__usser"></i>
                        </div>
                        <div class="control_profile">
                            <P class="name__user"><?=$row_user["fullname"];?></P>
                            <ul class="header__submenu">
                                    <li class="header__submenu--item"><a href="../profile/profile.php" class="header__submenu--link">Tài Khoản</a> <span class="decor__submenu"></span></li>
                                    <li class="header__submenu--item"><a href="../login/logout.php" class="header__submenu--link">Đăng Xuất</a> <span class="decor__submenu"></span></li>
                                </ul>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="body">
            <div class="container">
                <div class="body__inner">
                    <!-- column1 -->
                    <div class="column1">
                        <div class="name__user">
                            <div class="avatar">
                                <i class="fa-regular fa-user avatar_user"></i>
                                <p><?=$row_user["fullname"];?></p>
                            </div>
                        </div>
                        <!-- total_price -->
                        <div class="totalvalue">
                            <p>Tổng chi tiêu 2024</p>
                            <span class="price"><?php
                                $sql_total_price = "select sum(I.amount) as total_price,user_id from invoices I
                                join booking B on B.booking_id = I.booking_id
                                where B.user_id = $user_id and I.date > '".date('Y-01-01')."' and I.date < '".date('Y-12-31')."'
                                group by user_id";
                                $result_total_price = $conn->query($sql_total_price);
                                $r = $result_total_price->fetch_assoc();
                            ?><?php

                            if($r == NULL) {
                                echo "0";
                             }
                             else{
                                 echo number_format($r["total_price"]);
                             }
                            
                            ?> đ</span>
                        </div>
                        <!-- row contact -->
                         <div class="contact">
                            <p>HOTLINE hỗ trợ: <span class="blue">19002024 (9:00 - 22:00)</span></p>
                            <i class="fa-solid fa-arrow-right"></i>
                         </div>
                         <!-- contact email -->
                          <div class="contact_email">
                            <p>Email: <span class="blue">hotro@ttnpstudio.vn</span></p>
                            <i class="fa-solid fa-arrow-right"></i>
                          </div>
                          <!-- question -->
                           <div class="question">
                                <p>Câu hỏi thường gặp</p>
                                <i class="fa-solid fa-arrow-right"></i>
                           </div>
                    </div>
                    <!-- column 2 -->
                    <div class="column2">
                        <div class="navbar_sub">
                            <span class="active__history " id="active__history">Lịch Sử Giao Dịch</span>
                            <span class="active__profile active_cat" id="active__profile">Thông Tin Cá Nhân</span>
                            
                        </div>
                        <!-- Thông tin cá nhân -->
                         
                        <div class="show__item row" id="show__profile" style="--spacer : 15px;--space-x:15px;">
                            <!-- item 1 -->
                            <div class="col-6">
                                <div class="item">
                                    <p class="txt_item">Họ và tên</p>
                                    
                                    <div class="row_item">
                                        <i class="fa-solid fa-user icon_item"></i>
                                        <p class="txt_sub_item"><?=$row_user["fullname"];?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- item 2 -->
                            <div class="col-6">
                                <div class="item">
                                    <p class="txt_item">Ngày sinh</p>
                                    
                                    <div class="row_item">
                                        <i class="fa-solid fa-calendar icon_item"></i>
                                        <p class="txt_sub_item"><?php $date = new DateTime($row_user["date"]); echo $date->format('d/m/Y');?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- item 3 -->
                            <div class="col-6">
                                <div class="item">
                                    <p class="txt_item">Email</p>
                                    
                                    <div class="row_item">
                                        <i class="fa-solid fa-envelope icon_item"></i>
                                        <p class="txt_sub_item txt__email"><?=$row_user["email"];?></p>
                                        <button class="btn_update" id="btn_email">Thay đổi</button>
                                    </div>
                                </div>
                            </div>
                            <!-- item 4 -->
                            <div class="col-6">
                                <div class="item">
                                    <p class="txt_item">Số điện thoại</p>
                                    
                                    <div class="row_item">
                                        <i class="fa-solid fa-phone icon_item"></i>
                                        <p class="txt_sub_item"><?=$row_user["phone"];?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- item 5 -->
                            <div class="col-6">
                                <div class="item">
                                    <input type="radio" disabled name="gender" <?php
                                        if($row_user["gender"] == 1) echo "checked";
                                    ?>> Nam
                                    <input type="radio" disabled name="gender"
                                    <?php if($row_user["gender"] == 0) echo "checked";?>
                                    > Nữ
                                </div>
                            </div>
                            <!-- item 6 -->
                            <div class="col-6">
                                <div class="item">
                                    <p class="txt_item">Mật khẩu</p>
                                    
                                    <div class="row_item">
                                        <i class="fa-solid fa-lock icon_item"></i>
                                        <div class="txt_sub_item">
                                            <div class="dot">
                                            </div>
                                            <div class="dot">
                                            </div>
                                            <div class="dot">
                                            </div>
                                            <div class="dot">
                                            </div>
                                            <div class="dot">
                                            </div>
                                            <div class="dot">
                                            </div>
                                            <div class="dot">
                                            </div>
                                            <div class="dot">
                                            </div>
                                            <div class="dot">
                                            </div>
                                            <div class="dot">
                                            </div>
                                            
                                        </div>
                                        <button class="btn_update" id="btn_password">Thay đổi</button>
                                    </div>
                                </div>
                            </div>
                            <button class="btn_update_main">
                                Cập nhật
                            </button>
                            <div class="overlay" id="overlay">

                            </div>
                            <!-- change email -->
                            <div class="change_email" id="change_email">
                                <h3 class="title__item">Thay đổi Email</h3>
                                <i class="fa-regular fa-circle-xmark icon_close" id="btn_close"></i>
                                <p class="desc__item">Vui lòng cung cấp email mới, chúng tôi sẽ gửi mã xác thực cho bạn!</p>
                                <form action="./profile.php?action_save=save_email" method="POST">
                                    <label for="input__email" class="label__change_mail">Email mới</label>
                                    <input type="email" id="input__email" name="email_change" placeholder="Nhập địa chỉ email mới">
                                    <span id="error_email"></span>
                                    <button class="btn_continue" id="btn_continue">Tiếp Tục</button>
                                </form>
                            </div>
                            <!-- change password -->
                            <div class="change_email change_password" id="change_password">
                                <h3 class="title__item">Chỉnh Sửa Mật Khẩu</h3>
                                <span id="error_change_password"></span>
                                <p class="error_save_password"><?php if(isset($_REQUEST["error_save_password"])) echo $_SESSION["error_save_pass"];?></p>
                                <i class="fa-regular fa-circle-xmark icon_close" id="btn_close__password"></i>
                                <!-- current pass -->
                                <form action="./profile.php?action_save=save_password" method="POST">
                                    <label for="input_current_password" class="label__change_mail">Mật khẩu hiện tại</label>
                                    <input type="password" class="input__password" id="input_current_password" name="current_password" placeholder="Nhập mật khẩu hiện tại">
                                    <span id="error_current_pass"></span>
                                    <!-- new pass -->
                                    <label for="input_new_password" class="label__change_mail">Mật khẩu mới</label>
                                    <input type="password" class="input__password" id="input_new_password" name="new_password" placeholder="Nhập mật khẩu mới">
                                    <span id="error_new_pass"></span>
                                    <!-- confirm pass -->
                                    <label for="input_confirm_password" class="label__change_mail">Xác nhận mật khẩu mới</label>
                                    <input type="password" class="input__password" id="input_confirm_password" placeholder="Xác nhận mật khẩu mới">
                                    <span id="error_confirm_pass"></span>
                                    <!-- button an -->
                                     <button type="submit" hidden id="submit_form_pass"></button>
                                </form>
                                
                                <button type="button" class="btn_continue btn_confirm" id="btn_submit">CẬP NHẬT MẬT KHẨU MỚI</button>
                            </div>
                        </div>
                        
                        <!-- Lịch sử giao dịch -->
                         
                         <?php
                            
                            $sql_history = "select * from invoices I
                            join booking B on B.booking_id = I.booking_id
                            join schedules S on S.schedule_id = B.schedule_id
                            join movies M on M.movie_id = S.movie_id
                            join paymethod P on P.pay_id = I.payment_id
                            join room R on R.room_id = S.room_id
                            join cinema C on C.cinema_id = R.cinema_id
                            where B.user_id = $user_id order by date DESC";
                            $result_history = $conn->query($sql_history);
                           if($result_history->num_rows > 0){
                            $num_size = 10;
                            $num_page = ceil($result_history->num_rows / $num_size);
                            if(!isset($_REQUEST["page"])){
                                $_REQUEST["page"] = 1;
                            }
                            $page =$_REQUEST["page"];
                            if($page < 1){
                                $page = 1;
                            }
                            else if($page > $num_page){
                                $page = $num_page;
                            }
                            $sql_history .= " limit ".(($page-1)*$num_size).",".$num_size;
                            $result_history_1 = $conn->query($sql_history);

                           }

                         ?>

                        <div class="history_tran" id="history_tran">
                            <p class="txt_history">Lưu ý: chỉ hiển thị 20 giao dịch gần nhất</p>
                            
                            <table border= 1 class="table__item">
                                <?php if(isset($result_history_1)){?>
                                <tr class="row_title">
                                    <th>STT</th>
                                    <th>Tên phim</th> 
                                    <th>Ngày đặt</th>
                                    <th>Phương thức thanh toán</th>
                                    <th>Rạp</th>
                                    <th>Tổng hóa đơn</th>
                                    <th>QR Code</th>
                                </tr>

                                <?php
                                }
                                    if(!isset($_REQUEST["stt"])){
                                        $_REQUEST["stt"] = 1;
                                    }
                                    $count = $_REQUEST["stt"];
                                    if(isset($result_history_1) && $result_history_1->num_rows > 0){
                                    while($r = $result_history_1->fetch_assoc()){
                                        if($count == 21){
                                            break;
                                        }
                                ?>
                                <tr class="row_history_item">
                                    <td><?=$count?></td>
                                    
                                    <td><?=$r["movie_name"]?></td>
                                    <td><?php $date = new DateTime($r["date"]);echo $date->format('d/m/Y H:i:s');?></td>
                                    <td><?=$r["pay_name"]?></td>
                                    <td><?=$r["cinema_name"]?></td>
                                    <td class="amount_invoice"><?=number_format($r["amount"])?> đ</td>
                                    <td><span class="body_qr-<?=$r["invoice_id"]?>"></span></td> 
                                </tr>
                                <?php
                                        
                                    $count++;
                                    }
                                }
                                    $_REQUEST["stt"] = $count;
                                ?>
                                
                            </table>
                            <!-- Điều khiển phan trang -->
                            <div class="page">
                                
                                <?php if(isset($result_history_1)){
                                    echo "<span>Trang </span>";
                                    for($i = 1; $i <= $num_page;$i++){
                                        if($i == $page){
                                            echo "<a class='page__current'>$i</a>";
                                        }
                                        else{
                                            $stt = ($i-1)*$num_size + 1;
                                            echo "<a href=?page=$i&stt=$stt&check_history=true class='page__other'>$i</a>";
                                        }
                                    }
                                }
                                    ?>
                                </div>
                            <!-- <div class="row_history">

                            </div> -->
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
    <!-- script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded",function(){
            const btn_changepassword = document.getElementById('btn_submit');
            const btn_show_pass = document.getElementById('btn_password');
            const btn_show_email = document.getElementById('btn_email');
            const show_overlay = document.getElementById('overlay');
            const show_change_mail = document.getElementById('change_email');
            const btn_close = document.getElementById('btn_close');
            const btn_close_pass = document.getElementById('btn_close__password');
            const active__his = document.getElementById('active__history');
            const active__pro = document.getElementById('active__profile');
            const btn_changeEmail = document.getElementById('btn_continue');
            show_overlay.addEventListener("click",function(){
                overlay.style.display = "none";
                change_email.style.display = "none";
                change_password.style.display = "none";
            })
            btn_close.addEventListener("click",function(){
                overlay.style.display = "none";
                change_email.style.display = "none";
            })
            btn_close_pass.addEventListener("click",function(){
                overlay.style.display = "none";
                change_password.style.display = "none";
            })
            btn_show_email.addEventListener("click",function(){
                overlay.style.display = "block";
                change_email.style.display = "block";
            })
            btn_show_pass.addEventListener("click",function(){
                overlay.style.display = "block";
                change_password.style.display = "block";
            })
            active__his.addEventListener("click",function(){
                active__his.classList.add('active_cat');
                active__pro.classList.remove('active_cat');
                history_tran.style.display = "block";
                show__profile.style.display = "none";
            })
            active__pro.addEventListener("click",function(){
                active__his.classList.remove('active_cat');
                active__pro.classList.add('active_cat');
                history_tran.style.display = "none";
                show__profile.style.display = "flex";
            })
            // Xử lý ở lại trang history khi dùng phân trang
            <?php
                if(isset($_REQUEST["check_history"])){
            ?>
                active__his.classList.add('active_cat');
                active__pro.classList.remove('active_cat');
                history_tran.style.display = "block";
                show__profile.style.display = "none";
            <?php }
            ?>
            btn_changepassword.addEventListener("click",function(){
                if(input_new_password.value == ""){
                    error_new_pass.textContent="Bạn chưa nhập mật khẩu mới!";
                    
                }
                if(input_current_password.value == ""){
                    error_current_pass.textContent="Bạn chưa nhập mật khẩu hiện tại!";
                    
                }
                if(input_confirm_password.value == ""){
                    error_confirm_pass.textContent="Bạn chưa nhập xác nhận mật khẩu!";
                    
                }
                if(input_confirm_password.value != "" && input_current_password.value != "" && input_new_password.value != ""){
                    if(input_new_password.value != input_confirm_password.value){
                        error_change_password.textContent = "Mật khẩu mới không khớp nhau!"; 
                    }
                    else{
                        submit_form_pass.click();
                    }
                }

            })

            btn_changeEmail.addEventListener("click",function(){
                if(input__email.value == ""){
                    error_email.textContent = "Bạn cần nhập email thay đổi trước khi bấm thi đổi";
                    event.preventDefault();
                }
            })

            <?php
                if(isset($_REQUEST["error_save_password"])){
                    
                
            ?>
                overlay.style.display = "block";
                change_password.style.display = "block";
            <?php
            }?>
            
        })

    // Xử lý mã qr
    <?php
        if(isset($result_history_1)){
            $result_history_1->data_seek(0);
            if($result_history_1->num_rows > 0){
                while($r = $result_history_1->fetch_assoc()){
    ?>
        generateQRcode(<?=$r["invoice_id"]?>);
    <?php
            }
        }
    }
    ?>
    function generateQRcode(id_invoice) {
        const fixedSize = 50;
        const qr_codeblock = document.querySelector(`.body_qr-${id_invoice}`);
    
        // Tạo QR code với kích thước cố định và đoạn text đã có sẵn
        let qrcode = new QRCode(qr_codeblock, {
            text: id_invoice,
            width: fixedSize,
            height: fixedSize,
            colorDark: "#000000",
            colorLight: "#ffffff"
        });
    }

    </script>
</body>