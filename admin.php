<?php
    require_once("connect/connection.php");
    session_start();

    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TTNP: Hệ thống đặt vé xem phim online</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/admin/styles.css">

</head>

<body>
    <main>
        <div class="container">

                <div class="sidebar">
                    <div class="inner-sidebar">
                        <a href="#" class=""><img src="./logo.png" alt="logo">TTNP Cinema</a>
                        <a href="#" class="menu-item" id="movie">Phim</a>
                        <a href="#" class="menu-item" id="schedule">Suất chiếu</a>
                        <a href="#" class="menu-item" id="cinema">Rạp chiếu</a>
                        <a href="#" class="menu-item" id="product">Đồ ăn</a>
                        <a href="#" class="menu-item" id="promotion">Khuyến mãi</a>
                        <a href="#" class="menu-item" id="ticket-type">Loại vé</a>
                        <a href="#" class="menu-item" id="website">Người dùng</a>
                        <a href="#" class="menu-item" id="website">Đăng xuất</a>
                    </div>
                </div>
                <div class="content">

                </div>
            </div>
        </div>
    </main>
    <script src = "./assets/js/admin/main.js"></script>
</body>
</html>