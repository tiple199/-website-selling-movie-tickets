<?php
    require_once("connect/connection.php");
    session_start();

    $option = $_REQUEST['option'] ?? ''; // Biến dùng lựa chọn quản lý
    $catfilm = $_REQUEST['catfilm'] ?? ''; // Biến dùng để Lọc danh mục phim

    $action = $_POST['action'] ?? '';


    $searchQuery = $_POST['txtSearch'] ?? ''; // Search
    $cinemaName = $_POST['cinema_name'] ?? ''; // Lấy tên rạp

    // Điều kiện tìm kiếm phim theo tên
    $searchCondition = "";
    if (!empty($searchQuery)) {
        $searchCondition = " AND m.movie_name LIKE '%" . $conn->real_escape_string($searchQuery) . "%'";
    }

    // Lọc để lấy ra danh sách theo danh mục phim
    $categoryCondition = "";
    if ($catfilm === "dangchieu") {
        $categoryCondition = "WHERE fc.cat_name = 'Đang chiếu'";
    } elseif ($catfilm === "sapchieu") {
        $categoryCondition = "WHERE fc.cat_name = 'Sắp chiếu'";
    } elseif ($catfilm === "imax") {
        $categoryCondition = "WHERE fc.cat_name = 'Phim IMAX'";
    }

    // Pagination
    $recordsPerPage = 8; // Số bản ghi trên mỗi trang
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Trang hiện tại
    $offset = ($currentPage - 1) * $recordsPerPage; // Vị trí bắt đầu

    // Đếm tổng số bản ghi
    $countSql = "SELECT COUNT(*) as total 
                 FROM movies m 
                 INNER JOIN movie__categories mc ON m.movie_id = mc.movie_id
                 INNER JOIN film_categories fc ON mc.cat_id = fc.cat_id 
                 {$categoryCondition} {$searchCondition}";
    $countResult = $conn->query($countSql);
    $totalRecords = $countResult->fetch_assoc()['total'];
    $totalPages = ceil($totalRecords / $recordsPerPage); // Tổng số trang
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
                        <a href="?option=schedule" class="menu-item <?php if($option === "schedule") echo "active";?>" id="schedule">Suất chiếu</a>
                        <a href="?option=room" class="menu-item <?php if($option === "room") echo "active";?>" id="room">Phòng chiếu</a>
                        <a href="?option=food" class="menu-item <?php if($option === "food") echo "active";?>" id="product">Đồ ăn</a>
                        <a href="?option=user" class="menu-item <?php if($option === "user") echo "active";?>" id="website">Người dùng</a>
                        <a href="home.php" class="menu-item" id="website">Đăng xuất</a>
                    </div>
                </div>
                <div class="content">
                    <!-- Quản Lý Phim -->

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
                                            $sql = "SELECT * FROM movies m 
                                            INNER JOIN movie__categories mc ON m.movie_id = mc.movie_id
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
                                                            <a href="./admin/quanlyphim/edit_movie.php?movie_id=<?php echo $row['movie_id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                            <a onclick="return confirm('are you sure to delete')" href="admin/quanlyphim/delete_movie.php?movie_id=<?php echo $row['movie_id']; ?>"><i class="fa-regular fa-trash-can"></i></a>
                                                            <a href="schedule_movie.php?movie_id=<?php echo $row['movie_id']; ?>"><i class="fa-solid fa-calendar-days"></i></a>
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
                    <!-- Quản người dùng -->
                    <?php if ($option === "user"): ?>
                    <form action="admin.php?option=<?php echo $option;?>" method="post">
                        <div class="inner-content">
                            <div class="function">
                                <div class="function-search">
                                    <input type="text" placeholder="Nhập tên người dùng cần tìm" name="txtSearch" value="<?php echo htmlspecialchars($searchQuery); ?>">
                                    <input type="hidden" name="action" value="search">
                                    <button class="search-button">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                                <div class="function-add-film">
                                    <a href = "./admin/manage_user/add_user.php" class="add-movie-button">Thêm người dùng mới</a>
                                </div>
                            </div>
                            <?php 
                                if($option = "user" || $action = "search"){
                            ?>  
                            <div class="table-content">
                                <form action="">
                                    <table class="movie-table">
                                        <tr class="table-header">
                                            <th class="movie-id-header">Mã người dùng</th>
                                            <th class="movie-name-header">Tên người dùng</th>
                                            <th class="movie-tag-header">Email</th>
                                            <th class="movie-duration-header">Ngày sinh</th>
                                            <th class="movie-nation-header">Quyền</th>
                                            <th class="movie-release-header">Trạng thái</th>
                                        </tr>
                                        <?php 
                                            // Xử lý phần tìm kiếm người dùng
                                            if (!empty($searchQuery)) {
                                                $searchCondition = "WHERE fullname LIKE '%" . $conn->real_escape_string($searchQuery) . "%'";
                                            }
                                            $sql = "SELECT * FROM user u 
                                            INNER JOIN level_id l ON u.level_id = l.level_id {$searchCondition}";

                                            $result = $conn->query($sql);
                                            while ($row = $result->fetch_assoc()): 
                                        ?>
                                            <tr class="table-row">
                                                <td class="movie-id"><?php echo $row['id']; ?></td>
                                                <td class="movie-name"><?php echo $row['fullname']; ?></td>
                                                <td class="movie-tag"><?php echo $row['email']; ?></td>
                                                <td class="movie-duration"><?php echo $row['date']; ?></td>
                                                <td class="movie-nation"><?php echo $row['level_name']; ?></td>
                                                <td class="movie-release"><?php 
                                                    if ($row['status'] == 1) {
                                                        echo 'Đang hoạt động';
                                                    } else {
                                                        echo 'Ngừng hoạt động';
                                                    }
                                                ?>
                                                </td>
                                                <td class="movie-action">
                                                    <div class="action-menu">
                                                        <span class="action-button"><i class="fa-solid fa-ellipsis-vertical"></i></span>
                                                        <div class="action-dropdown">
                                                            <a href="./admin/manage_user/edit_user.php?id=<?php echo $row['id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                            <a onclick="return confirm('Bạn có chắc chắn muốn xóa')" href="./admin/manage_user/delete_user.php?id=<?php echo $row['id'];?>"><i class="fa-regular fa-trash-can"></i></a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </table>
                                </form>
                            </div>
                            <?php 
                                }
                                endif;
                            ?>     
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
                                            <th>Xóa</th>
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
                                                <td class="delete-icon-cell">                                                         
                                                    <a onclick="return confirm('are you sure to delete')" href="admin/quanlydoan/delete_food.php?food_id=<?php echo $row1['food_id']; ?>"><i class="fa-regular fa-trash-can"></i></a>

                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </form>
                    <?php endif; ?>
                    <!-- Quản phòng chiếu -->
                    <?php if ($option === "room"): ?>
                    <form action="admin.php?option=<?php echo $option;?>" method="post">
                        <div class="inner-content">
                            <select class="cinema_name" name="cinema_name" id="cinema_name">
                                <option>Chọn rạp</option>
                                <?php
                                    // Lấy danh sách tên các rạp để hiển thị trong select
                                    $cinemaSql = "SELECT cinema_name FROM cinema";
                                    $cinemaResult = $conn->query($cinemaSql);
                                    while ($cinema = $cinemaResult->fetch_assoc()) {
                                        $selected = (!empty($cinemaName) && $cinema['cinema_name'] === $cinemaName) ? 'selected' : '';
                                        echo "<option value='" . $cinema['cinema_name'] . "' $selected>" . $cinema['cinema_name'] . "</option>";
                                    }
                                ?>
                            </select>
                            <div class="function">
                                <div class="function-search">
                                    <!-- Thêm phần Select cho việc chọn tên rạp -->
                                    
                                    <!-- Ô tìm kiếm theo tên phòng -->
                                    <input type="text" placeholder="Nhập tên phòng cần tìm" name="txtSearch" value="<?php echo htmlspecialchars($searchQuery); ?>">
                                    <input type="hidden" name="action" value="search">
                                    <button class="search-button">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                                <div class="function-add-film">
                                    <a href = "./admin/manage_room/add_room.php" class="add-movie-button">Thêm phòng chiếu mới</a>
                                </div>
                            </div>
                            <?php 
                                if ($option == "room" || $action == "search") {
                                    // Thêm điều kiện tìm kiếm theo tên rạp
                                    $searchCondition = "";
                                    if (!empty($searchQuery)) {
                                        $searchCondition .= " WHERE r.room_name LIKE '%" . $conn->real_escape_string($searchQuery) . "%'";
                                    }
                                    if (!empty($cinemaName)) {
                                        if ($searchCondition == "") {
                                            $searchCondition .= " WHERE c.cinema_name = '" . $conn->real_escape_string($cinemaName) . "'";
                                        } else {
                                            $searchCondition .= " AND c.cinema_name = '" . $conn->real_escape_string($cinemaName) . "'";
                                        }
                                    }
                            ?>  
                            <div class="table-content">
                                <form action="">
                                    <table class="movie-table">
                                        <tr class="table-header">
                                            <th class="movie-id-header">Mã phòng</th>
                                            <th class="movie-name-header">Tên phòng</th>
                                            <th class="movie-tag-header">Rap</th>
                                            <th class="movie-duration-header">Số ghế</th>
                                        </tr>
                                        <?php
                                            // Hiển thị phòng 
                                            $sql = "SELECT * FROM room r 
                                            INNER JOIN cinema c ON r.cinema_id = c.cinema_id {$searchCondition}";

                                            $result = $conn->query($sql);
                                            while ($row = $result->fetch_assoc()): 
                                        ?>
                                        <tr class="table-row">
                                            <td class="movie-id"><?php echo $row['room_id']; ?></td>
                                            <td class="movie-name"><?php echo $row['room_name']; ?></td>
                                            <td class="movie-tag"><?php echo $row['cinema_name']; ?></td>
                                            <td class="movie-duration"><?php echo $row['seat_quantity']; ?></td>
                                            </td>
                                            <td class="movie-action">
                                                <div class="action-menu">
                                                    <span class="action-button"><i class="fa-solid fa-ellipsis-vertical"></i></span>
                                                    <div class="action-dropdown">
                                                        <a href="./admin/manage_room/edit_room.php?room_id=<?php echo $row['room_id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa phòng chiếu này không?')" href="./admin/manage_room/delete_room.php?id=<?php echo $row['room_id'];?>"><i class="fa-regular fa-trash-can"></i></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </table>
                                </form>
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