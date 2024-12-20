<?php
    require_once("connect/connection.php");
    session_start();

    $option = $_REQUEST['option'] ?? ''; // Biến dùng lựa chọn quản lý
    $catfilm = $_REQUEST['catfilm'] ?? ''; // Biến dùng để Lọc danh mục phim

    $action = $_POST['action'] ?? '';

    $searchQuery = $_POST['txtSearch'] ?? ''; // Search Movies
    // Điều kiện tìm kiếm phim theo tên
    $searchCondition = "";
    if (!empty($searchQuery)) {
        $searchCondition = " AND movies.movie_name LIKE '%" . $conn->real_escape_string($searchQuery) . "%'";
    }

    // Lọc để lấy ra danh sách theo danh mục phim
    $categoryCondition = "";
    if ($catfilm === "dangchieu") {
        $categoryCondition = " WHERE fc.cat_name = 'Đang chiếu'";
    } elseif ($catfilm === "sapchieu") {
        $categoryCondition = "WHERE fc.cat_name = 'Sắp chiếu'";
    } elseif ($catfilm === "imax") {
        $categoryCondition = "WHERE fc.cat_name = 'Phim IMAX'";
    }

    // Pagination
    $recordsPerPage = 8; // Số bản ghi trên mỗi trang
    $recordsPerPageTimeMovie = 20; // Số bản ghi trên mỗi trang
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Trang hiện tại
    $offset = ($currentPage - 1) * $recordsPerPage; // Vị trí bắt đầu
    $offsetTimeMovie = ($currentPage - 1) * $recordsPerPageTimeMovie;

    // Đếm tổng số bản ghi movies
    $countSql = "SELECT COUNT(*) as total 
                 FROM movies 
                 INNER JOIN movie__categories mc ON movies.movie_id = mc.movie_id
                 INNER JOIN film_categories fc ON mc.cat_id = fc.cat_id 
                 {$categoryCondition} {$searchCondition}";
    $countResult = $conn->query($countSql);
    $totalRecords = $countResult->fetch_assoc()['total'];
    $totalPages = ceil($totalRecords / $recordsPerPage); // Tổng số trang
    // Đếm tổng số bản ghi lịch chiếu
    $CountScheduleSql = "SELECT COUNT(schedule_id) as total 
                 FROM schedules";
    $CountScheduleResult = $conn->query($CountScheduleSql);
    $totalSchedule = $CountScheduleResult->fetch_assoc()['total'];
    $totalPagesSchedule = ceil($totalSchedule / $recordsPerPageTimeMovie); // Tổng số trang
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
        <div class="container d-flex">
                <div class="sidebar">
                    <div class="inner-sidebar">
                        <a href="admin.php" class=""><img src="./logo.png" alt="logo">TTNP Cinema</a>
                        <a href="?option=movie" class="menu-item <?php if($option === "movie") echo "active";?>" id="movie">Phim</a>
                        <a href="?option=schedule" class="menu-item <?php if($option === "schedule") echo "active";?>" id="schedule">Lịch chiếu</a>
                        <a href="#" class="menu-item <?php if($option === "cinema") echo "active";?>" id="cinema">Rạp chiếu</a>
                        <a href="?option=food" class="menu-item <?php if($option === "food") echo "active";?>" id="product">Đồ ăn</a>
                        <a href="#" class="menu-item <?php if($option === "promotion") echo "active";?>" id="promotion">Khuyến mãi</a>
                        <a href="#" class="menu-item <?php if($option === "ticket") echo "active";?>" id="ticket-type">Loại vé</a>
                        <a href="?option=user" class="menu-item <?php if($option === "user") echo "active";?>" id="website">Người dùng</a>
                        <a href="home.php" class="menu-item" id="website">Đăng xuất</a>
                    </div>
                </div>
                <!-- Quản Lý Phim -->
                <div class="content">
                    <!-- Chào -->
                    <?php
                    if($option == ""){
                    ?>
                    <div class="banner">
                        <h1>Chào mừng bạn đã đến với trang quản trị</h1>
                    </div>
                    <?php
                    }
                    ?>
                    <!-- Xử lý -->
                    <?php if ($option === "movie"): ?>
                    <form action="admin.php?option=<?php echo $option."&catfilm=$catfilm";?>" method="post">
                        <div class="inner-content">
                            <div class="categories-film">
                                <a href="?option=movie&catfilm=tatca" id="tab-tatca" class="tab-option <?php if($catfilm === "tatca") echo "active";?>" onclick="selectTab(this)">Tất cả</a>
                                <a href="?option=movie&catfilm=dangchieu" class="tab-option <?php if($catfilm === "dangchieu") echo "active";?>" onclick="selectTab(this)">Đang chiếu</a>
                                <a href="?option=movie&catfilm=sapchieu" class="tab-option <?php if($catfilm === "sapchieu") echo "active";?>" onclick="selectTab(this)">Sắp chiếu</a>
                                <a href="?option=movie&catfilm=imax" class="tab-option <?php if($catfilm === "imax") echo "active";?>" onclick="selectTab(this)">Phim IMAX</a>
                                <div class="underline"></div>
                            </div>
                            <div class="function">
                                <div class="function-search">
                                    <input type="text" placeholder="Nhập tên phim cần tìm" name="txtSearch" value="<?php echo htmlspecialchars($searchQuery); ?>">

                                    <input type="hidden" name="action" value="search">
                                    <button class="search-button">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                                <div class="function-add-film">
                                    <a href = "./admin/quanlyphim/add-movie.php" class="add-movie-button">Thêm phim mới</a>
                                </div>
                            </div>
                            <?php 
                                if($catfilm != "" || $action = "search"){
                            ?>  
                            <div class="table-content">
                                <form action="">
                                    <table class="movie-table">
                                        <tr class="table-header">
                                            <th class="movie-id-header">Mã phim</th>
                                            <th class="movie-name-header">Tên phim</th>
                                            <th class="movie-tag-header">Tag</th>
                                            <th class="movie-duration-header">Thời lượng</th>
                                            <th class="movie-nation-header">Quốc gia</th>
                                            <th class="movie-release-header">Phát hành</th>
                                            <th class="movie-category-header">Danh mục</th>
                                        </tr>
                                        <?php 
                                            $sql = "SELECT * FROM movies  
                                            INNER JOIN movie__categories mc ON movies.movie_id = mc.movie_id
                                            INNER JOIN film_categories fc ON mc.cat_id = fc.cat_id  
                                            {$categoryCondition} {$searchCondition}
                                            LIMIT $offset, $recordsPerPage";

                                            $result = $conn->query($sql);
                                            while ($row = $result->fetch_assoc()): 
                                        ?>
                                            <tr class="table-row">
                                                <td class="movie-id"><?php echo $row['movie_id']; ?></td>
                                                <td class="movie-name">
                                                    <img src="assets/image/image__film/<?php echo $row['movie_img']; ?>" alt="anh" class="movie-img">
                                                    <?php echo $row['movie_name']; ?>
                                                </td>
                                                <td class="movie-tag"><?php echo $row['movie_minage']; ?></td>
                                                <td class="movie-duration"><?php echo $row['movie_time']; ?> Phút</td>
                                                <td class="movie-nation"><?php echo $row['movie_nation']; ?></td>
                                                <td class="movie-release"><?php echo $row['movie_date']; ?></td>
                                                <td class="movie-category"><?php echo $row['cat_name']; ?></td>
                                                <td class="movie-action">
                                                    <div class="action-menu">
                                                        <span class="action-button"><i class="fa-solid fa-ellipsis-vertical"></i></span>
                                                        <div class="action-dropdown">
                                                            <a href="edit_movie.php?movie_id=<?php echo $row['movie_id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                            <a onclick="return confirm('are you sure to delete')" href="admin/quanlyphim/delete_movie.php?movie_id=<?php echo $row['movie_id']; ?>"><i class="fa-regular fa-trash-can"></i></a>
                                                            <a href="admin/quanlylichchieu/schedule_movie.php?movie_id=<?php echo $row['movie_id']; ?>"><i class="fa-solid fa-calendar-days"></i></a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </table>
                                </form>
                            </div>
                            <!-- Hiển thị phân trang -->
                            <div class="pagination">
                                <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                                    <a href="?option=movie&catfilm=<?php echo $catfilm; ?>&page=<?php echo $page; ?>"
                                       class="pagination-link <?php if ($page == $currentPage) echo 'active'; ?>">
                                        <?php echo $page; ?>
                                    </a>
                                <?php endfor; ?>
                            </div>
                            <?php 
                                }
                            ?>
                        </div>
                    </form>
                    <?php endif; ?>
                    <!-- Quản lý đồ ăn -->
                    <?php if ($option === "food"): ?>
                        <div class="inner-content">                         
                            <div class="function">                             
                                <a href = "./admin/quanlydoan/add-food.php" class="add-movie-button">Thêm đồ ăn mới</a>
                            </div>
                            <br>
                            <div >
                                <form action="">
                                    <table class="movie-table">
                                        <tr class="table-header">
                                            <th>Mã đồ ăn</th>
                                            <th>Ảnh</th>
                                            <th>Tên đồ ăn</th>
                                            <th>Mô tả</th>
                                            <th>Giá</th>
                                            <th></th>
                                        </tr>
                                        <?php 
                                            $sql1 = "SELECT * FROM food";

                                            $result1 = $conn->query($sql1);
                                            while ($row1 = $result1->fetch_assoc()): 
                                        ?>
                                            <tr class="table-row">
                                                <td class="centered-cell"><?php echo $row1['food_id']; ?></td>
                                                <td>
                                                    <img src="assets/image/food/<?php echo $row1['food_image']; ?>" class="food-img">
                                                </td>
                                                <td>
                                                    <?php echo $row1['food_name']; ?>
                                                </td>
                                                <td><?php echo $row1['food_desc']; ?></td>
                                                <td><?php echo $row1['food_price']; ?></td>
                                                <td class="movie-action">
                                                    <div class="action-menu">
                                                        <span class="action-button"><i class="fa-solid fa-ellipsis-vertical"></i></span>
                                                        <div class="action-dropdown">  
                                                            <a href="admin/quanlydoan/edit_food.php?food_id=<?php echo $row1['food_id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>                                                       
                                                            <a onclick="return confirm('are you sure to delete')" href="admin/quanlydoan/delete_food.php?food_id=<?php echo $row1['food_id']; ?>"><i class="fa-regular fa-trash-can"></i></a>
                                                        </div>
                                                    </div>
                                                </td>
                                                
                                            </tr>
                                        <?php endwhile; ?>
                                    </table>
                                </form>
                            </div>
                        </div>                       
                    <?php endif; ?>
                    <!-- Quản lý lịch chiếu -->
                    <?php if ($option === "schedule"): ?>
                        <form action="admin.php?option=<?php echo $option."&catfilm=$catfilm";?>" method="post">
                        <div class="inner-content">
                            <div class="categories-film">
                                <a href="?option=schedule&catfilm=tatca" id="tab-tatca" class="tab-option <?php if($catfilm === "tatca") echo "active";?>" onclick="selectTab(this)">Tất cả</a>
                                <div class="underline"></div>
                            </div>
                            <div class="function">
                                <div class="function-search">
                                    <input type="text" placeholder="Nhập tên phim cần tìm" name="txtSearch" value="<?php echo htmlspecialchars($searchQuery); ?>">

                                    <input type="hidden" name="action" value="search">
                                    <button class="search-button">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                                <div class="function-add-film">
                                    <a href = "./admin/quanlylichchieu/add_time_movie.php" class="add-movie-button">Thêm lịch chiếu mới</a>
                                </div>
                            </div>
                            <?php 
                                if($catfilm != "" || $action = "search"){
                            ?>  
                            <div class="table-content">
                                <form action="">
                                    <table class="movie-table">
                                        <tr class="table-header">
                                            <th class="movie-id-header">Mã phim</th>
                                            <th class="movie-name-header">Tên phim</th>
                                            <th class="movie-tag-header">Rạp</th>
                                            <th class="movie-duration-header">Phòng</th>
                                            <th class="movie-nation-header">Giờ chiếu</th>
                                            <th class="movie-release-header">Ngày chiếu</th>
                                            <th class="movie-category-header">Thứ</th>
                                        </tr>
                                        <?php 
                                            $sql2 = "SELECT * FROM schedules 
                                            INNER JOIN movies ON schedules.movie_id = movies.movie_id
                                            INNER JOIN room ON schedules.room_id = room.room_id
                                            INNER JOIN cinema ON  room.cinema_id = cinema.cinema_id
                                            INNER JOIN movie__categories mc ON movies.movie_id = mc.movie_id
                                            INNER JOIN film_categories fc ON mc.cat_id = fc.cat_id  
                                            {$categoryCondition} {$searchCondition}
                                            LIMIT $offsetTimeMovie, $recordsPerPageTimeMovie";
                                
                                            $result2 = $conn->query($sql2);
                                            while ($row2 = $result2->fetch_assoc()): 
                                        ?>
                                            <tr class="table-row">
                                                <td class="movie-id"><?php echo $row2['movie_id']; ?></td>
                                                <td class="movie-name">
                                                    <img src="assets/image/image__film/<?php echo $row2['movie_img']; ?>" alt="anh" class="movie-img">
                                                    <?php echo $row2['movie_name']; ?>
                                                </td>
                                                <td class="movie-tag"><?php echo $row2['cinema_name']; ?></td>
                                                <td class="movie-duration"><?php echo $row2['room_name']; ?></td>
                                                <td class="movie-nation"><?php echo $row2['show_time']; ?></td>
                                                <td class="movie-release"><?php echo $row2['show_date']; ?></td>
                                                <td class="movie-category"><?php echo $row2['show_day']; ?></td>
                                                <td class="movie-action">
                                                    <div class="action-menu">
                                                        <span class="action-button"><i class="fa-solid fa-ellipsis-vertical"></i></span>
                                                        <div class="action-dropdown">
                                                            <a href="admin/quanlylichchieu/edit_time_movie.php?schedule_id=<?php echo $row2['schedule_id']; ?>?movie_id=<?php echo $row2['movie_id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                            <a onclick="return confirm('are you sure to delete')" href="admin/quanlylichchieu/delete_time_movie.php?schedule_id=<?php echo $row2['schedule_id']; ?>"><i class="fa-regular fa-trash-can"></i></a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </table>
                                </form>
                            </div>
                            <!-- Hiển thị phân trang -->
                            <div class="pagination">
                                <?php for ($page = 1; $page <= $totalPagesSchedule; $page++): ?>
                                    <a href="?option=schedule&catfilm=<?php echo $catfilm; ?>&page=<?php echo $page; ?>"
                                       class="pagination-link <?php if ($page == $currentPage) echo 'active'; ?>">
                                        <?php echo $page; ?>
                                    </a>
                                <?php endfor; ?>
                            </div>
                            <?php 
                                }
                            ?>
                        </div>
                    </form>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    <script src = "./assets/js/admin/main.js"></script>
</body>
</html>