-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 19, 2024 lúc 03:47 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `doan`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `actor`
--

CREATE TABLE `actor` (
  `a_id` int(11) NOT NULL,
  `a_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `actor`
--

INSERT INTO `actor` (`a_id`, `a_name`) VALUES
(1, 'Uyển Ân'),
(2, 'Samuel An'),
(3, 'Kiều Minh Tuấn'),
(4, 'Thu Trang'),
(5, 'Lê Giang'),
(6, 'NSND Hồng Vân'),
(7, 'Thuận Nguyễn'),
(8, 'Quốc Cường'),
(9, 'Huỳnh Anh Tuấn'),
(10, 'Cindy Miranda'),
(11, 'Max Nattapol Diloknawarit'),
(12, 'Althea Ruedas'),
(13, 'Lupita Nyong\'o'),
(14, 'Pedro Pascal'),
(15, 'Catherine O’hara'),
(16, 'Tom Hardy'),
(17, 'Juno Temple'),
(18, 'Chiwetel Ejiofor'),
(19, 'Joaquin Phoenix'),
(20, 'Lady Gaga'),
(21, 'Zazie Beetz'),
(22, 'Aaron Taylor-Johnson'),
(23, 'Russell Crowe'),
(24, 'Fred Hechinger'),
(25, 'Anthony Mackie'),
(26, 'Harrison Ford'),
(27, 'Liv Tyler'),
(28, 'Giancarlo Esposito'),
(29, 'Chris Hemsworth'),
(30, 'Scarlett Johansson'),
(31, 'Keegan-Michael Key'),
(32, 'Jon Hamm'),
(33, 'Brian Tyree Henry'),
(34, 'Danny Trejo'),
(35, 'Bill Nighy'),
(36, 'Susan Sarandon'),
(37, 'Hwang Jung Min'),
(38, 'Jung Hae In'),
(39, 'Tatsumi Tsutomu'),
(40, 'Shiraishi Ayano'),
(41, 'Hoài Linh'),
(42, 'Tuấn Trần'),
(44, 'Bảo Ngọc'),
(45, 'Polina Avdeenko'),
(46, 'Yuliya Rudina'),
(47, 'Boris Khasanov'),
(48, 'Cailee Spaeny'),
(49, 'Isabela Merced'),
(50, 'Spike Fearn'),
(51, 'Rima Thanh Vy'),
(52, 'Quốc Cường'),
(53, 'Thúy Diễm'),
(54, 'Lâm Thanh Mỹ'),
(55, 'Nadech Kugimiya'),
(56, 'Denise Jelilcha Kapaun'),
(57, 'Mim Rattawadee Wongthong'),
(58, 'Jean-Pierre Léaud'),
(59, 'Albert Rémy'),
(60, 'Claire Maurier'),
(61, 'Kong Jeong Hwan'),
(62, 'Ji Dae Han');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `booking_time` time NOT NULL,
  `total_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `booking`
--

INSERT INTO `booking` (`booking_id`, `user_id`, `schedule_id`, `booking_time`, `total_price`) VALUES
(25, 5, 9, '10:16:50', 50000),
(27, 5, 9, '17:46:05', 279000),
(28, 6, 13, '20:29:59', 209000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_food`
--

CREATE TABLE `booking_food` (
  `booking_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_food`
--

INSERT INTO `booking_food` (`booking_id`, `food_id`) VALUES
(27, 1),
(28, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cinema`
--

CREATE TABLE `cinema` (
  `cinema_id` int(11) NOT NULL,
  `cinema_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cinema`
--

INSERT INTO `cinema` (`cinema_id`, `cinema_name`, `location`) VALUES
(1, 'TTNP Cầu Giấy', '16 P.Trần Thái Tông, Hà Nội'),
(2, 'TTNP Giải Phóng', '77 Đ.Trường Chinh,Hà Nội'),
(3, 'TTNP Lê Văn Lương', '163 Đ.Lê Văn Lương,Hà Nội'),
(4, 'TTNP Láng Hạ', '18 Đ.Láng Hạ, Hà Nội');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `content_film`
--

CREATE TABLE `content_film` (
  `content_id` int(11) NOT NULL,
  `content_part1` varchar(1000) NOT NULL,
  `content_part2` varchar(1000) NOT NULL,
  `content_part3` varchar(1000) NOT NULL,
  `content_part4` varchar(1000) NOT NULL,
  `content_part5` varchar(1000) NOT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `content_film`
--

INSERT INTO `content_film` (`content_id`, `content_part1`, `content_part2`, `content_part3`, `content_part4`, `content_part5`, `movie_id`) VALUES
(1, 'Không ngoa khi nói rằng, Joker là nhân vật phản diện nổi tiếng hàng đầu thế giới. Kẻ thù của Batman là cái tên mang tính biểu tượng từ truyện tranh đến màn ảnh rộng. Năm 2019, Todd Phillips và Joaquin Phoenix mang đến cho khán giả một Joker cực kì khác biệt, chưa từng có trong lịch sử.', 'Phim thành công nhận 11 đề cử Oscar và thắng 2 giải, trong đó có Nam chính xuất sắc nhất cho Joaquin Phoenix.', 'Lần này, Joker 2 trở lại, mang đến cho khán giả bộ đôi diễn viên trong mơ – Joaquin Phoenix tiếp tục trở thành Arthur Fleck còn vai diễn Harley Quinn thuộc về Lady Gaga. Chưa tham gia nhiều phim, nữ ca sĩ huyền thoại vẫn nhận được sự tin tưởng từ công chúng bởi diễn xuất chất lượng trong A Star Is Born (2018), House Of Gucci (2021).', 'Folie À Deux là căn bệnh rối loạn tâm thần chia sẻ. Chứng bệnh khiến cả hai người cùng tiếp xúc với nguồn năng lực tiêu cực trong tâm trí. Dường như, ở Joker 2, gã hề đã “lây lan” căn bệnh đến Harley Quinn, khiến cả hai người họ “điên có đôi”. Tên phim đã khắc họa được một phần nội dung, xoáy sâu vào mối quan hệ độc hại giữa Joker và Harley Quinn.', 'Ít nhất 15 bài hát nổi tiếng sẽ tái hiện lại trong Joker: Folie À Deux. Joker và Harley Quinn luôn đi kèm âm thanh từ bản nhạc bất hủ Close To You, What The World Needs Now,… Có lẽ, chỉ có âm nhạc mới thể hiện nổi sự điên loạn và chứng rối loạn ảo tưởng. Ngoài ra, âm nhạc còn giúp Joker: Folie À Deux khác biệt với tác phẩm thuộc DC Comic từ trước tới nay cũng như phát huy sở trường của Lady Gaga. Tất nhiên, dù hát ca nhiều bao nhiêu, phim vẫn dán nhãn R, tràn ngập bạo lực.', 16),
(2, 'Transformers Một là bộ phim hoạt hình Transformers đầu tiên sau 40 năm, và để kỷ niệm 40 năm thương hiệu Transformers, bộ phim là câu chuyện gốc về quá trình Optimus Prime và Megatron từ bạn thành thù.', 'Lấy chủ đề câu chuyện phiêu lưu hài hước tràn ngập tình đồng đội cùng những pha hành động và biến hình cực đã mắt, Transformer One hé lộ câu chuyện gốc được chờ đợi bấy lâu về cách các nhân vật mang tính biểu tượng nhất trong vũ trụ Transformers - Orion Pax và D-16 từ anh em chiến đấu trở thành Optimus Prime và Megatron - kẻ thù không đội trời chung.', 'Orion Pax và D-16 từng là robot công nhân “quèn” tại Cybertron. Hai robot “trẻ trâu” thường xuyên dính vào rắc rối. Những người máy thường bị cấm và chỉ được hoạt động dưới lòng đất vì bề mặt của hành tinh quê nhà là nơi cực kì nguy hiểm. Tuy nhiên, càng cấm thì càng tò mò! Orion, D-16 và các Cybertronians khác như Elita-1 và B-127 / Bumblebee quyết định thực hiện một chuyến phiêu lưu. Tại đây, họ đã chạm trán với nhiều dạng động thực vật cơ giới hóa xưa nay chưa từng thấy.', 'Cuộc chạm trán với Alpha Trion giúp cho robot công nhân cấp thấp trở thành người máy biến hình cấu hình “xịn đét”. Ngoài ra, dường như, cũng thay đổi cả cách họ nhìn nhận thế giới, trở thành tiền đề sự chia rẽ về sau...', 'Phim mới Transformers One / Transformers Một suất chiếu sớm 21-22.09 (Không áp dụng movie voucher), ra mắt tại các rạp chiếu phim toàn quốc từ 27.09.2024.', 1),
(3, 'Baridegi: The Abandoned Girl / Minh Hôn diễn ra sau khi mất vợ và con gái, Won Go Myeong – một pháp sư đầy hận thù, đã phát hiện ra gã tài phiệt đứng sau cái chết gia đình ông. Với ma thuật đen, Go Myeong đã gọi hồn, triệu vong vạch trần sự thật và khiến gã tài phiệt đền mạng. Thế nhưng, mọi chuyện chỉ là khởi đầu….', 'Phim mới Baridegi: The Abandoned Girl / Minh Hôn có suất chiếu sớm từ 26.09.2024 (Không áp dụng movie voucher) và khởi chiếu chính thức 27.09.2024 tại các rạp chiếu phim toàn quốc.', '', '', '', 2),
(4, 'Các thanh tra kỳ cựu nổi tiếng đã hoạt động trở lại!', 'Thám tử Seo Do-cheol (HWANG Jung-min) và đội điều tra tội phạm nguy hiểm của anh không ngừng truy lùng tội phạm cả ngày lẫn đêm, đặt cược cả cuộc sống cá nhân của họ.', 'Nhận một vụ án sát hại một giáo sư, đội thanh tra nhận ra những mối liên hệ với các vụ án trong quá khứ và nảy sinh những nghi ngờ về một kẻ giết người hàng loạt. Điều này đã khiến cả nước rơi vào tình trạng hỗn loạn. Khi đội thanh tra đi sâu vào cuộc điều tra, kẻ sát nhân đã chế nhạo họ bằng cách công khai tung ra một đoạn giới thiệu trực tuyến, chỉ ra nạn nhân tiếp theo và làm gia tăng sự hỗn loạn. ', 'Để giải quyết mối đe dọa ngày càng leo thang, nhóm đã kết nạp một sĩ quan tân binh trẻ Park Sun-woo (JUNG Hae-in), dẫn đến những khúc mắc và đầy rẫy bất ngờ trong vụ án.', 'Phim mới I, The Executioner / Đố Anh Còng Được Tôi có suất chiếu sớm từ 26.09.2024(không áp dụng movie voucher) và khởi chiếu chính thức 27.09.2024 tại các rạp chiếu phim toàn quốc. Cùng đặt lịch xem I, The Executioner / Đố Anh Còng Được Tôi. ', 3),
(5, 'Grave Of The Fireflies/ Mộ Đom Đóm là một trong những kiệt tác vĩ đại nhất của điện ảnh Nhật Bản, do hãng Ghibli lừng danh sản xuất. Bộ phim kể về nước Nhật thời hậu chiến, sau cuộc ném bom dữ dội của Mỹ. Anh em Seita và Setsuko mất mẹ, phải đấu tranh để tồn tại giữa cảnh đất nước điêu tàn. Thế nhưng, ở hoàn cảnh ngặt nghèo này, việc kiếm bữa ăn qua ngày vô cùng khó khăn…  \r\n', 'Phim hay Grave of the Fireflies/ Mộ Đom Đóm suất chiếu sớm 03.10.2024 (Không áp dụng Movie Voucher), khởi chiếu 04.10.2024 tại các rạp chiếu phim toàn quốc.', '', '', '', 4),
(6, 'Câu chuyện phim là dị bản kinh dị đẫm máu lấy cảm hứng từ truyện cổ tích nổi tiếng Tấm Cám, nội dung chính của phim xoay quanh Cám - em gái cùng cha khác mẹ của Tấm đồng thời sẽ có nhiều nhân vật và chi tiết sáng tạo, gợi cảm giác vừa lạ vừa quen cho khán giả.\r\n', 'Sau loạt tác phẩm kinh dị ăn khách như Tết Ở Làng Địa Ngục, Kẻ Ăn Hồn... bộ đôi nhà sản xuất Hoàng Quân - đạo diễn Trần Hữu Tấn đã tiếp tục với một dị bản của cổ tích Việt Nam mang tên Cám. Cùng dàn diễn viên tiềm năng, vai Tấm do diễn viên Rima Thanh Vy thủ vai, trong khi vai Cám được trao cho gương mặt rất quen thuộc - Lâm Thanh Mỹ. Ngoài ra vai mẹ kế của diễn viên Thúy Diễm và vai Hoàng tử do Hải Nam đảm nhận.', 'Dị bản sẽ cho một góc nhìn hoàn toàn khác về Tấm Cám khi sự thay đổi đến từ người nuôi cá bống lại là Cám. Cô bé có ngoại hình dị dạng, khiến cả gia đình bị dân làng cho là phù thủy. Cũng vì thế mà Cám mới là đứa con bị đối xử tệ bạc, bắt phải lựa gạo chứ không phải Tấm. Cùng với bài đồng dao về cá bống, giọng nói của Bụt trong phim mới cũng vang lên khi hỏi: “Vì sao con khóc?”. Thế nhưng, nó không mang màu sắc dịu hiền, thân thương của một vì thần tiên trong văn hóa Việt Nam mà đậm chất ma mị, kinh dị. Liệu đây có đúng là Bụt hay chính là ác quỷ đội lốt đã lừa dối Tấm và Cám từ lâu để đưa họ vào cái bẫy chết chóc? ', 'Phim mới Cám dự kiến ra mắt tại các rạp chiếu phim toàn quốc từ 20.09.2024.', '', 5),
(7, 'Được giải cứu và nuôi dạy bởi đàn cá heo sau một vụ tai nạn máy bay trên biển, Dolphin Boy / Cậu Bé Cá Heo dần lớn lên với một cuộc sống vô tư dưới những con sóng biển êm đềm cho đến khi một con quái vật độc ác nắm quyền cai trị thế giới dưới nước. Bị đày trở lại đất liền, cậu bé được người thuyền trưởng tốt bụng nhận về nuôi. Với sự giúp đỡ của người bạn đồng hành mới, cậu bé dấn thân vào cuộc hành trình giải quyết bí ẩn về danh tính thực sự của mình.Với mỗi chiến thắng, họ tiến gần hơn đến việc làm sáng tỏ ý định độc ác của tên quái vật xấu xa và khôi phục lại sự cân bằng cho thế giới dưới nước.', 'Phim mới Dolphin Boy / Cậu Bé Cá Heo dự kiến khởi chiếu 27.09.2024 tại các rạp chiếu phim toàn quốc. Cùng đặt lịch xem Dolphin Boy / Cậu Bé Cá Heo\r\n', '', '', '', 6),
(9, 'Phim mới Làm Giàu Với Ma kể về Lanh (Tuấn Trần) - con trai của ông Đạo làm nghề mai táng (Hoài Linh), lâm vào đường cùng vì cờ bạc. Trong cơn túng quẫn, “duyên tình” đẩy đưa anh gặp một ma nữ (Diệp Bảo Ngọc) và cùng nhau thực hiện những “kèo thơm\" để phục vụ mục đích của cả hai.\r\n', 'Suất chiếu sớm 29.08 (Không áp dụng Movie Voucher), dự kiến ra mắt tại các rạp chiếu phim toàn quốc từ 30.08.2024.', '', '', '', 8),
(10, 'Gracie And Pedro: Pets To The Rescue / Báo Thủ Đi Tìm Chủ kể về cún cưng Gracie và mèo Pedro tinh nghịch bị lạc khỏi chủ trong một lần chuyển nhà. Các “báo thủ” bắt đầu cuộc hành trình vượt ngàn chông gai, được cứu nguy bởi bài hát viral của chủ nhân, đối đầu với các nhân vật có tiếng trong giới mộ điệu cho đến khi đoàn tụ với Sophie và Gavin để tìm đường về nhà.', 'Phim mới Gracie And Pedro: Pets To The Rescue / Báo Thủ Đi Tìm Chủ dự kiến khởi chiếu 13.09.2024 tại các rạp chiếu phim toàn quốc.', '', '', '', 9),
(11, 'Vào năm 1972, một sự việc kinh hoàng nhất đã xảy ra. Một cô gái trẻ ở một ngôi làng hẻo lánh ở tỉnh Kanchanaburi đã qua đời một cách bí ẩn. Khi nghe thấy một giọng nói dựng tóc gáy \"Tee Yod... Tee Yod...\" vang lên trong đêm.Sau khi Yak (Nadech Kugimiya) xuất ngũ, anh trở về phụ giúp gia đình theo lời của Hia Hang và bà Bunyen. Mẹ của Yak, có 5 người em trạc tuổi nhau gồm Yos, Yod, Yad, Yam và Yi', 'Mọi chuyện phải kể từ lúc Yam (Mim Rattanawadee Wongthong) bị ốm thì những bí ẩn cũng bắt đầu xuất hiện. Yad (Denise Jelilcha) là người chứng kiến những sự việc tựa như một điềm báo. Nhưng vì còn trẻ, cô đã không suy nghĩ nhiều. Cho tới khi tình trạng của Yam dần xấu đi, với những biểu hiện khác lạ không thể giải đáp được. Và người ta tin rằng, Yam đã bị \"ma cà rồng\" nhập, nó ăn mòn nội tạng. Khiến cơ thể của Yam dần yếu đi. Cứ đêm xuống, là nghe thấy tiếng rên rỉ cùng với từ \"Tee Yod\". Dẫn đến một câu chuyện bí ẩn đầy ám ảnh, dù đã hơn 50 năm trôi qua nhưng vẫn khiến người nghe khiếp sợ.', 'Phim mới Tee Yod: Quỷ Ăn Tạng dự kiến ra mắt tại các rạp chiếu phim toàn quốc từ 29.12.2023.', '', '', 10),
(12, 'Sau khi cha bị kẻ ác sát hại, từ người ngoài cuộc, An (Thuận Nguyễn) từng bước bị kéo vào cuộc chiến của các phe đảng xã hội đen. An một mình sẽ phải đối mặt với những nguy hiểm đe dọa đến cả tính mạng.', 'Phim mới Domino: Lối Thoát Cuối Cùng dự kiến khởi chiếu 27.09.2024 tại các rạp chiếu phim toàn quốc. Cùng đặt lịch xem Domino: Lối Thoát Cuối Cùng.', '', '', '', 11),
(13, 'Bộ phim kể về cuộc hành trình trưởng thành của gấu trúc khổng lồ Fubao ở Hàn Quốc từ khi sinh ra đến khi quay trở về Trung Quốc. Đó là một hành trình đẹp đẽ và tràn ngập yêu thương của em bên gia đình, đặc biệt là hai ông. Bằng những thước phim chân thật, giản dị ghi lại hình ảnh chú gấu trúc nghịch ngợm dễ thương, bộ phim chắc chắn sẽ làm đổ gục những người yêu gấu trúc vì độ \"dưỡng thê\" của nó!', 'Phim mới My Dearest Fubao/ Fubao: Bảo Bối Của Ông suất chiếu sớm 10.10 (Không áp dụng Movie Voucher), dự kiến ra mắt tại các rạp chiếu phim toàn quốc từ 11.10.2024.', '', '', '', 12),
(14, 'Cậu bé Antoine Doinel không thể tìm được sự đồng cảm ở trường hay ở nhà. Quyết định trốn chạy khỏi tất cả, Antoine ăn cắp máy đánh chữ của bố định bán lấy tiền. Tuy nhiên, cậu bị bắt gặp vào giao nộp cho cảnh sát, ngủ một đêm ở đồn cạnh những tay trộm cắp và gái điếm. Những chuỗi ngày sau đó, từng mẩu chuyện về cuộc đời cô độc của cậu dần được hé lộ…', 'Phim mới Vị Thành Niên (400 Cú Đấm) dự kiến ra mắt tại rạp chiếu phim Galaxy Mipec Long Biên vào 05 & 09.10.2024.', '', '', '', 13),
(15, 'Cuộc phiêu lưu hoành tráng theo chân hành trình của một robot — đơn vị ROZZUM 7134, gọi tắt là Roz. Roz vô tình dạt vào hoang đảo sau một sự cố và nơi đây trở thành địa điểm sống mới của cô. Tại đây, Roz kết thân và nhận nuôi một chú ngỗng con, đặt tên là Brightbill. Roz và Brightbill dần dần thân thiết với các bạn thú trên đảo, song sau đó phải chống chọi, bảo vệ “nhà mới” trước sự xâm lăng của nhà máy từng sản xuất ra Roz.', 'Phim mới The Wild Robot / Robot Hoang Dã có suất chiếu đặc biệt từ 05 - 06.10.2024 (không áp dụng movie voucher) và khởi chiếu chính thức 11.10.2024 tại các rạp chiếu phim trên toàn quốc.\r\n', '', '', '', 14),
(16, 'Uyển Ân chính thức lên xe hoa trong thế giới thượng lưu của đạo diễn Vũ Ngọc Đãng qua bộ phim Cô Dâu Hào Môn.\r\n', 'Thừa thắng xông lên sau doanh thu trăm tỷ từ Chị Chị Em Em 2, nhà sản xuất Will Vũ và đạo diễn Vũ Ngọc Đãng bắt tay thực hiện dự án Cô Dâu Hào Môn. Bộ phim xoay quanh câu chuyện làm dâu nhà hào môn dưới góc nhìn hài hước và châm biếm, hé lộ những câu chuyện kén dâu chọn rể trong giới thượng lưu.', 'Phối hợp cùng Uyển Ân ở các phân đoạn tình cảm trong bộ phim lần này là diễn viên Samuel An. Anh được đạo diễn Vũ Ngọc Đãng “đo ni đóng giày” cho vai cậu thiếu gia Bảo Hoàng với ngoại hình điển trai, phong cách lịch lãm và gia thế khủng.', 'Cùng góp mặt với Uyển Ân trong bộ phim đình đám lần này là sự xuất hiện của những cái tên bảo chứng phòng vé như: Thu Trang, Kiều Minh Tuấn, Samuel An, Lê Giang, NSND Hồng Vân,...', 'Phim mới Cô Dâu Hào Môn suất chiếu sớm từ 16.10 (Không áp dụng Movie Voucher), dự kiến ra mắt tại các rạp chiếu phim từ 18.10.2024.\r\n', 15),
(18, 'Phần phim mới nhất của thương hiệu phim quái vật gây ám ảnh nhất lịch sử điện ảnh theo chân một nhóm người khai hoang lục địa, đang tìm kiếm những gì còn sót lại trên một trạm vũ trụ bỏ hoang. Thế nhưng mọi chuyện trở thành một thảm kịch khi họ phải đối mặt với những thực thể quái vật ghê tởm nhất, và chuyến đi đầy hi vọng lại trở thành cơn ác mộng đối với tất cả mọi người.', 'Phim mới Alien: Romulus / Quái Vật Không Gian: Romulus dự kiến khởi chiếu 16.08.2024 tại các rạp chiếu phim toàn quốc.', '', '', '', 17),
(19, 'Sau chuyến du lịch ngắn sang quê nhà của Spider-Man: No Way Home (2021), Eddie Brock (Tom Hardy) giờ đây cùng Venom “hành hiệp trượng nghĩa” và “nhai đầu” hết đám tội phạm trong thành phố. Tuy nhiên, đi đêm lắm cũng có ngày gặp ma, chính phủ Mỹ đã phát hiện ra sự tồn tại của con quái vật ngoài hành tinh này.\r\n', 'Anh chàng buộc phải trở thành kẻ đào tẩu, liên tục trốn chạy khỏi những cuộc truy quét liên tục. Thế nhưng, đây chưa phải là rắc rối lớn nhất…', 'Những con quái vật gớm ghiếc bất ngờ xuất hiện tại nhiều nơi. Hành tinh của chủng tộc Symbiote đã phát hiện ra Trái Đất và chuẩn bị cho cuộc xâm lăng tổng lực. \r\n', 'Phim mới Venom: The Last Dance / Venom: Kèo Cuối suất chiếu sớm 23-24.10.2024 (Không áp dụng Movie Voucher), dự kiến khởi chiếu 25.10.2024 tại các rạp chiếu phim toàn quốc.', '', 18),
(20, 'Sau khi gặp Tổng thống Hoa Kỳ mới đắc cử Thaddeus Ross, Sam phải đối mặt với một sự cố quy mô quốc tế. Anh phải tìm ra ra mục đích đằng sau trước khi kẻ chủ mưu thực sự khiến cả thế giới phải khiếp sợ.\r\n', 'Phim mới Captain America: Brave New World /  Captain America: Trật Tự Thế Giới Mới dự kiến ra mắt tại các rạp chiếu phim toàn quốc từ 14.02.2025.\r\n', '', '', '', 19),
(21, 'Gã nhập cư Nga Sergei Kravinoff đang thực hiện nhiệm vụ chứng minh rằng anh ta là thợ săn vĩ đại nhất thế giới.', 'Phim mới Kraven The Hunter khởi chiếu 06.10.2023 tại rạp chiếu phim toàn quốc.', '', '', '', 20);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `director`
--

CREATE TABLE `director` (
  `d_id` int(11) NOT NULL,
  `d_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `director`
--

INSERT INTO `director` (`d_id`, `d_name`) VALUES
(1, 'François Truffaut'),
(2, 'Seung-wan Ryoo'),
(3, 'Chris Sanders'),
(4, 'Taweewat Wantha'),
(5, 'Nguyễn Phúc Huy Cương'),
(6, 'Xian Lim'),
(7, 'Vũ Ngọc Đãng'),
(8, 'Kelly Marcel'),
(9, 'Todd Phillips'),
(10, 'J. C. Chandor'),
(11, 'Julius Onah'),
(12, 'Takahata Isao'),
(13, 'Lee Se Won'),
(14, 'Trần Hữu Tấn'),
(15, 'Mohammad Kheyrandish'),
(16, 'Kevin Donovan'),
(17, 'Gottfried Roodt'),
(18, 'Fede Alvarez'),
(19, 'Josh Cooley'),
(20, 'Trung Lùn');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `discount`
--

CREATE TABLE `discount` (
  `discount_id` varchar(10) NOT NULL,
  `discount_title` varchar(255) NOT NULL,
  `discount_img` varchar(255) NOT NULL,
  `discount_price` float NOT NULL,
  `status` tinyint(4) NOT NULL,
  `endDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `discount`
--

INSERT INTO `discount` (`discount_id`, `discount_title`, `discount_img`, `discount_price`, `status`, `endDate`) VALUES
('TTNP', 'Mừng 1 tuổi TTNP', 'anh2.jpg', 30000, 0, '2024-12-01'),
('TTNP1', 'Giáng sinh vui vẻ', 'anh3.jpg', 25000, 1, '2024-12-19'),
('TTNP2', 'Halloween', 'anh4.jpg', 20000, 1, '2024-12-23'),
('TTNP3', 'Chào Mừng Ngày 20/10', 'anh5.jpg', 20000, 0, '2024-10-20'),
('TTNP4', 'Khai Trương Cơ Sở 4', 'anh6.jpg', 30000, 1, '2024-12-10'),
('TTNP5', 'Siêu Sale Của Năm Black Friday', 'anh7.jpg', 30000, 1, '2024-12-24'),
('TTNP6', 'Sinh Nhật 2 Tuổi TTNP', 'anh8.jpg', 25000, 1, '2024-12-26');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `film_categories`
--

CREATE TABLE `film_categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `film_categories`
--

INSERT INTO `film_categories` (`cat_id`, `cat_name`) VALUES
(1, 'Đang chiếu'),
(2, 'Sắp chiếu'),
(3, 'Phim IMAX');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `food`
--

CREATE TABLE `food` (
  `food_id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `food_desc` varchar(255) NOT NULL,
  `food_price` int(11) NOT NULL,
  `food_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `food`
--

INSERT INTO `food` (`food_id`, `food_name`, `food_desc`, `food_price`, `food_image`) VALUES
(1, 'iCombo 1 Big Extra STD', '1 Ly nước ngọt size L + 01 Hộp bắp + 1 Snack', 109000, 'combo1.jpg'),
(3, 'iCombo 1 Big STD', '01 Ly nước ngọt size L + 01 Hộp bắp', 89000, 'combo2.jpg'),
(4, 'iCombo 2 Big Extra STD', '02 Ly nước ngọt size L + 01 Hộp bắp + 1 Snack', 129000, 'combo3.jpg'),
(5, 'iCombo 2 Big STD', '02 Ly nước ngọt size L + 01 Hộp bắp', 109000, 'combo4.jpg'),
(6, 'iCombo Optimus Prime 1 - Promotion 199', '01 OP Head + 01 ly nước ngọt size L + 1 Hộp bắp', 199000, 'combo5.jpg'),
(7, 'iCombo Wish 1 - Promotion 149', '1 Ly Wish Tumbler + 01 ly nước ngọt size L + 1 Hộp bắp', 149000, 'combo6.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `genre_film`
--

CREATE TABLE `genre_film` (
  `g_id` int(11) NOT NULL,
  `g_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `genre_film`
--

INSERT INTO `genre_film` (`g_id`, `g_name`) VALUES
(1, 'Hoạt Hình'),
(2, 'Kinh Dị'),
(3, 'Hành Động'),
(4, 'Giả Tưởng'),
(5, 'Hài Hước'),
(6, 'Phiêu Lưu'),
(7, 'Tài Liệu'),
(8, 'Tâm Lý'),
(9, 'Giật Gân'),
(10, 'Tình Cảm'),
(11, 'Nhạc Kịch');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date` datetime NOT NULL,
  `discount_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `booking_id`, `payment_id`, `amount`, `status`, `date`, `discount_id`) VALUES
(21, 25, 1, 50000, 1, '2024-12-15 10:16:50', ''),
(23, 27, 1, 279000, 1, '2024-12-19 17:46:05', ''),
(24, 28, 4, 159000, 1, '2024-12-19 20:29:59', 'KHAITRUONG');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `level_id`
--

CREATE TABLE `level_id` (
  `level_id` int(11) NOT NULL,
  `level_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `level_id`
--

INSERT INTO `level_id` (`level_id`, `level_name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `movie_name` varchar(255) NOT NULL,
  `movie_img` varchar(255) NOT NULL,
  `movie_minage` text NOT NULL,
  `movie_rating` float NOT NULL,
  `movie_ispremiere` tinyint(4) NOT NULL,
  `movie_time` smallint(6) NOT NULL,
  `movie_date` varchar(100) NOT NULL,
  `movie_nation` varchar(255) NOT NULL,
  `movie_manufacturer` varchar(255) NOT NULL,
  `movie_status` tinyint(4) NOT NULL,
  `movie_ishot` tinyint(4) NOT NULL,
  `movie_ad` tinyint(4) NOT NULL,
  `movie_trailer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `movies`
--

INSERT INTO `movies` (`movie_id`, `movie_name`, `movie_img`, `movie_minage`, `movie_rating`, `movie_ispremiere`, `movie_time`, `movie_date`, `movie_nation`, `movie_manufacturer`, `movie_status`, `movie_ishot`, `movie_ad`, `movie_trailer`) VALUES
(1, 'Transformers Một', 'transformersmot.jpg', 'T13', 8, 1, 104, '11/10/2024', 'Mỹ', 'Paramount Pictures', 0, 1, 1, 'https://www.youtube.com/embed/-OV2Fv-shro?si=2b1JU1IviRmGc1qe'),
(2, 'Minh Hôn', 'minhhon.jpg', 'T18', 7, 1, 120, '2/10/2024', 'Hàn Quốc', 'Đang cập nhật', 1, 1, 1, 'https://www.youtube.com/embed/x7hgcR3u5xM?si=MQ5kjreFbf5aIoqG'),
(3, 'Đố Anh Còng Được Tôi', 'doanhcongduoctoi.jpg', 'T18', 8.7, 1, 105, '11/9/2024', 'Hàn Quốc', 'CJ Entertainment', 0, 1, 1, 'https://www.youtube.com/embed/JgUWVooKSrA?si=qW6iRbbymBwa1MJR'),
(4, 'Mộ Đom Đóm', 'modomdom.jpg', 'K', 8.4, 1, 150, '1/10/2024', 'Nhật Bản', 'Studio Ghibli', 1, 0, 0, 'https://www.youtube.com/embed/HgDzVFMi238?si=4sM9QOPKCbVJ7EzH'),
(5, 'Cám', 'cam.jpg', 'T18', 7, 1, 130, '11/8/2024', 'Việt Nam', 'Hoàng Quân', 1, 0, 0, 'https://www.youtube.com/embed/_8qUFEmPQbc?si=aDX6FaO18fm66fDT'),
(6, 'Cậu Bé Cá Heo', 'caubecaheo.jpg', 'K', 7, 1, 127, '8/10/2024', 'Iran', 'Sky Frame', 1, 0, 0, 'https://www.youtube.com/embed/hCmAntZAK2I?si=4VQPyJnKzXkQ_3eY'),
(8, 'Làm Giàu Với Ma', 'lamgiauvoima.jpg', 'T16', 7.2, 1, 109, '1/9/2024', 'Việt Nam', 'Bluebells Studio', 1, 0, 0, 'https://www.youtube.com/embed/MtZ_hf7tLxk?si=NqE0f37PLipsklkh'),
(9, 'Báo Thủ Đi Tìm Chủ', 'baothuditimchu.jpg', 'K', 8.7, 1, 113, '1/11/2024', 'Canada', 'Second Chance Productions', 1, 0, 0, 'https://www.youtube.com/embed/mBvrpYQVMso?si=T4iKH_EoX46aNe8H'),
(10, 'Tee Yod: Quỷ Ăn Tạng Phần 2', 'quyantang.jpg', 'T18', 9.1, 2, 102, '1/10/2024', 'Thái Lan', 'Đang cập nhật', 1, 0, 0, 'https://www.youtube.com/embed/xVVZvSybaEc?si=xiHig7vPL8zv95VX'),
(11, 'Domino: Lối Thoát Cuối Cùng', 'loithoatcuoicung.jpg', 'T16', 7.6, 2, 115, '7/10/2024', 'Việt Nam', 'Đang cập nhật', 1, 0, 0, 'https://www.youtube.com/embed/f2FCeOxiEbo?si=Jg0lzPk1vYPrvXGU'),
(12, 'Fubao: Bảo Bối Của Ông', 'fubaobaoboicuaong.jpg', 'K', 10, 2, 123, '5/10/2024', 'Hàn Quốc', 'Đang cập nhật', 1, 0, 0, 'https://www.youtube.com/embed/6KxlC1Bt3C4?si=KqBJp6Y1P1SlW_Qi'),
(13, 'Vị Thành Niên (400 Cú Đấm)', 'vithanhnien.jpg', 'T13', 7, 2, 108, '21/9/2024', 'Pháp', 'Les Films du Carrosse', 1, 0, 0, 'https://www.youtube.com/embed/2mkZpXEoVB0?si=dvCeilU9GFa6xG3V'),
(14, 'Robot Hoang Dã', 'robothoangda.jpg', 'K', 8.7, 2, 110, '15/9/2024', 'Mỹ', 'DreamWorks Animation Dentsu', 1, 0, 0, 'https://www.youtube.com/embed/2l8_FNIBWLM?si=VpJeYS6yG91-UUc1'),
(15, 'Cô Dâu Hào Môn', 'codauhaomon.jpg', 'T18', 7.9, 2, 109, '7/9/2024', 'Việt Nam', 'Will Vũ', 1, 0, 0, 'https://www.youtube.com/embed/ZIz8QQBYcx0?si=CmZDo3X8854zKH95'),
(16, 'Joker: Folie À Deux Điên Có Đôi', 'joker.jpg', 'T18', 8.3, 1, 111, '10/10/2024', 'Mỹ', ' DC Entertainment, Warner Bros', 1, 0, 0, 'https://www.youtube.com/embed/n2k54qx9YkE?si=6FpKAuzuIRY922DG'),
(17, 'Alien: Romulus', 'alien.jpg', 'T18', 8.5, 2, 128, '28/09/2024', 'Mỹ', '20th Century Studios', 1, 0, 0, 'https://www.youtube.com/embed/GTNMt84KT0k?si=RphAL_TfYxnZV9C_'),
(18, 'Venom: The Last Dance', 'venom.jpg', 'T16', 8.9, 2, 150, '4/10/2024', 'Mỹ', 'Columbia Pictures, Marvel', 1, 0, 0, 'https://www.youtube.com/embed/__2bjWbetsA?si=x87y6pmzVUe8KibL'),
(19, 'Captain America: Brave New World', 'captain.jpg', 'T16', 8.3, 2, 111, '2/10/2024', 'Mỹ', 'Marvel Studios', 1, 0, 0, 'https://www.youtube.com/embed/1pHDWnXmK7Y?si=0a-P1XBtkm8LcJ3i'),
(20, 'Kraven The Hunter', 'kraven.jpg', 'K', 0, 1, 121, '11/10/2024', 'Mỹ', 'Sony Pictures', 1, 0, 0, 'https://www.youtube.com/embed/rze8QYwWGMs?si=ptz5kyGJTN2pI48X');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `movie__actor`
--

CREATE TABLE `movie__actor` (
  `a_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `movie__actor`
--

INSERT INTO `movie__actor` (`a_id`, `movie_id`) VALUES
(1, 15),
(2, 15),
(3, 15),
(4, 15),
(5, 8),
(5, 15),
(6, 15),
(7, 11),
(8, 5),
(8, 11),
(9, 11),
(13, 14),
(14, 14),
(15, 14),
(16, 18),
(17, 18),
(18, 18),
(19, 16),
(20, 16),
(21, 16),
(22, 20),
(23, 20),
(24, 20),
(25, 19),
(26, 19),
(27, 19),
(28, 19),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(34, 9),
(35, 9),
(36, 9),
(37, 3),
(38, 3),
(39, 4),
(40, 4),
(41, 8),
(42, 8),
(45, 6),
(46, 6),
(47, 6),
(48, 17),
(49, 17),
(50, 17),
(51, 5),
(53, 5),
(54, 5),
(55, 10),
(56, 10),
(58, 13),
(59, 13),
(60, 13),
(61, 2),
(62, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `movie__categories`
--

CREATE TABLE `movie__categories` (
  `movie_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `movie__categories`
--

INSERT INTO `movie__categories` (`movie_id`, `cat_id`) VALUES
(1, 1),
(1, 3),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(8, 1),
(9, 1),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 1),
(16, 3),
(17, 2),
(17, 3),
(18, 2),
(18, 3),
(19, 2),
(19, 3),
(20, 1),
(20, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `movie__director`
--

CREATE TABLE `movie__director` (
  `d_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `movie__director`
--

INSERT INTO `movie__director` (`d_id`, `movie_id`) VALUES
(1, 13),
(2, 3),
(3, 14),
(4, 10),
(5, 11),
(7, 15),
(8, 18),
(9, 16),
(10, 20),
(11, 19),
(12, 4),
(13, 2),
(14, 5),
(15, 6),
(16, 9),
(17, 9),
(18, 17),
(19, 1),
(20, 8);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `movie__genre`
--

CREATE TABLE `movie__genre` (
  `genre_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `movie__genre`
--

INSERT INTO `movie__genre` (`genre_id`, `movie_id`) VALUES
(1, 1),
(1, 4),
(1, 6),
(1, 9),
(1, 14),
(2, 2),
(2, 5),
(2, 10),
(3, 1),
(3, 3),
(3, 11),
(3, 17),
(3, 18),
(3, 19),
(3, 20),
(4, 5),
(4, 14),
(4, 17),
(4, 18),
(4, 19),
(4, 20),
(5, 3),
(5, 8),
(5, 9),
(6, 1),
(6, 14),
(6, 17),
(6, 19),
(7, 12),
(8, 11),
(8, 13),
(8, 16),
(9, 11),
(10, 15);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `paymethod`
--

CREATE TABLE `paymethod` (
  `pay_id` int(11) NOT NULL,
  `pay_name` varchar(255) NOT NULL,
  `pay_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `paymethod`
--

INSERT INTO `paymethod` (`pay_id`, `pay_name`, `pay_image`) VALUES
(1, 'Ví ShopeePay - Nhập mã: SPPCINE10 Giảm 10K cho đơn từ 100K', 'shopee.png'),
(2, 'Ví Điện Tử MoMo', 'momo.png'),
(3, 'VNPAY', 'vnpay.png'),
(4, 'Zalopay - Bạn mới Zalopay nhập mã GIAMSAU - Giảm 50% tối đa 40k', 'zalopay.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `poster`
--

CREATE TABLE `poster` (
  `mp_id` int(11) NOT NULL,
  `mv_imgposter` varchar(255) NOT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `poster`
--

INSERT INTO `poster` (`mp_id`, `mv_imgposter`, `movie_id`) VALUES
(1, 'transformersmot.jpg', 1),
(2, 'cam.jpg', 5),
(3, 'joker.jpg', 16),
(4, 'doanhcongduoctoi.jpg', 3),
(5, 'minhhon.jpg', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(255) NOT NULL,
  `seat_quantity` int(11) NOT NULL,
  `cinema_id` int(11) NOT NULL,
  `room_status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `room`
--

INSERT INTO `room` (`room_id`, `room_name`, `seat_quantity`, `cinema_id`, `room_status`) VALUES
(1, 'Room 1', 50, 1, 1),
(2, 'Room 2', 50, 1, 1),
(3, 'Room 3', 50, 1, 1),
(4, 'Room 4', 50, 1, 1),
(5, 'Room 1', 50, 2, 0),
(6, 'Room 2', 50, 2, 1),
(7, 'Room 3', 50, 2, 1),
(8, 'Room 1', 50, 3, 1),
(9, 'Room 2', 50, 3, 1),
(10, 'Room 3', 50, 3, 1),
(11, 'Room 1', 50, 4, 1),
(12, 'Room 2', 50, 4, 1),
(13, 'Room 3', 50, 4, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `schedules`
--

CREATE TABLE `schedules` (
  `schedule_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `show_date` date NOT NULL,
  `show_day` varchar(10) NOT NULL,
  `show_time` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `schedules`
--

INSERT INTO `schedules` (`schedule_id`, `movie_id`, `room_id`, `show_date`, `show_day`, `show_time`) VALUES
(9, 3, 1, '2024-11-11', 'Thứ Hai', '13:00'),
(10, 3, 6, '2024-11-11', 'Thứ Hai', '11:25'),
(11, 3, 8, '2024-11-11', 'Thứ Hai', '12:20'),
(12, 3, 11, '2024-11-11', 'Thứ Hai', '15:00'),
(13, 9, 4, '2024-11-11', 'Thứ Hai', '11:25'),
(14, 9, 7, '2024-11-11', 'Thứ Hai', '11:20'),
(15, 9, 10, '2024-11-11', 'Thứ Hai', '11:45'),
(16, 9, 13, '2024-11-11', 'Thứ Hai', '11:25'),
(17, 4, 1, '2024-11-11', 'Thứ Hai', '14:45'),
(18, 4, 6, '2024-11-11', 'Thứ Hai', '13:00'),
(19, 4, 8, '2024-11-11', 'Thứ Hai', '13:55'),
(20, 4, 12, '2024-11-11', 'Thứ Hai', '16:00'),
(21, 16, 3, '2024-11-11', 'Thứ Hai', '15:15'),
(22, 16, 6, '2024-11-11', 'Thứ Hai', '14:50'),
(23, 16, 8, '2024-11-11', 'Thứ Hai', '15:35'),
(24, 16, 13, '2024-11-11', 'Thứ Hai', '13:15'),
(25, 8, 1, '2024-11-11', 'Thứ Hai', '15:30'),
(26, 8, 6, '2024-11-11', 'Thứ Hai', '16:45'),
(27, 8, 10, '2024-11-11', 'Thứ Hai', '13:30'),
(28, 8, 13, '2024-11-11', 'Thứ Hai', '15:00'),
(29, 2, 4, '2024-11-11', 'Thứ Hai', '13:00'),
(30, 2, 6, '2024-11-11', 'Thứ Hai', '18:10'),
(31, 2, 10, '2024-11-11', 'Thứ Hai', '15:15'),
(32, 2, 12, '2024-11-11', 'Thứ Hai', '19:00'),
(33, 5, 1, '2024-11-11', 'Thứ Hai', '17:00'),
(34, 5, 6, '2024-11-11', 'Thứ Hai', '19:55'),
(35, 5, 10, '2024-11-11', 'Thứ Hai', '17:00'),
(36, 5, 13, '2024-11-11', 'Thứ Hai', '16:50'),
(37, 6, 2, '2024-11-11', 'Thứ Hai', '13:00'),
(38, 6, 7, '2024-11-11', 'Thứ Hai', '15:00'),
(39, 6, 8, '2024-11-11', 'Thứ Hai', '19:00'),
(40, 6, 12, '2024-11-11', 'Thứ Hai', '18:45'),
(41, 20, 2, '2024-11-11', 'Thứ Hai', '15:00'),
(42, 20, 7, '2024-11-11', 'Thứ Hai', '17:00'),
(43, 20, 10, '2024-11-11', 'Thứ Hai', '19:00'),
(44, 20, 11, '2024-11-11', 'Thứ Hai', '17:00'),
(45, 1, 2, '2024-11-11', 'Thứ Hai', '11:25'),
(46, 1, 7, '2024-11-11', 'Thứ Hai', '13:00'),
(47, 1, 8, '2024-11-11', 'Thứ Hai', '17:10'),
(48, 1, 12, '2024-11-11', 'Thứ Hai', '17:35'),
(55, 3, 1, '2024-11-12', 'Thứ Ba', '13:00'),
(56, 3, 6, '2024-11-12', 'Thứ Ba', '11:25'),
(57, 3, 8, '2024-11-12', 'Thứ Ba', '12:20'),
(58, 3, 11, '2024-11-12', 'Thứ Ba', '15:00'),
(59, 9, 4, '2024-11-12', 'Thứ Ba', '11:25'),
(60, 9, 7, '2024-11-12', 'Thứ Ba', '11:20'),
(61, 9, 10, '2024-11-12', 'Thứ Ba', '11:45'),
(62, 9, 13, '2024-11-12', 'Thứ Ba', '11:25'),
(63, 4, 1, '2024-11-12', 'Thứ Ba', '14:45'),
(64, 4, 6, '2024-11-12', 'Thứ Ba', '13:00'),
(65, 4, 8, '2024-11-12', 'Thứ Ba', '13:55'),
(66, 4, 12, '2024-11-12', 'Thứ Ba', '16:00'),
(67, 16, 3, '2024-11-12', 'Thứ Ba', '15:15'),
(68, 16, 6, '2024-11-12', 'Thứ Ba', '14:50'),
(69, 16, 8, '2024-11-12', 'Thứ Ba', '15:35'),
(70, 16, 13, '2024-11-12', 'Thứ Ba', '13:15'),
(71, 1, 2, '2024-11-12', 'Thứ Ba', '11:25'),
(72, 1, 7, '2024-11-12', 'Thứ Ba', '13:00'),
(73, 1, 8, '2024-11-12', 'Thứ Ba', '17:10'),
(74, 1, 12, '2024-11-12', 'Thứ Ba', '17:35'),
(75, 8, 1, '2024-11-12', 'Thứ Ba', '15:30'),
(76, 8, 6, '2024-11-12', 'Thứ Ba', '16:45'),
(77, 8, 10, '2024-11-12', 'Thứ Ba', '13:30'),
(78, 8, 13, '2024-11-12', 'Thứ Ba', '15:00'),
(79, 2, 4, '2024-11-12', 'Thứ Ba', '13:00'),
(80, 2, 6, '2024-11-12', 'Thứ Ba', '18:10'),
(81, 2, 10, '2024-11-12', 'Thứ Ba', '15:15'),
(82, 2, 12, '2024-11-12', 'Thứ Ba', '19:00'),
(83, 5, 1, '2024-11-12', 'Thứ Ba', '17:00'),
(84, 5, 6, '2024-11-12', 'Thứ Ba', '19:55'),
(85, 5, 10, '2024-11-12', 'Thứ Ba', '17:00'),
(86, 5, 12, '2024-11-12', 'Thứ Ba', '16:50'),
(87, 6, 2, '2024-11-12', 'Thứ Ba', '13:00'),
(88, 6, 7, '2024-11-12', 'Thứ Ba', '15:00'),
(89, 6, 8, '2024-11-12', 'Thứ Ba', '19:00'),
(90, 6, 12, '2024-11-12', 'Thứ Ba', '18:45'),
(91, 20, 2, '2024-11-12', 'Thứ Ba', '15:00'),
(92, 20, 7, '2024-11-12', 'Thứ Ba', '17:00'),
(93, 20, 10, '2024-11-12', 'Thứ Ba', '19:00'),
(94, 20, 11, '2024-11-12', 'Thứ Ba', '17:00'),
(101, 3, 1, '2024-11-13', 'Thứ Tư', '13:00'),
(102, 3, 6, '2024-11-13', 'Thứ Tư', '11:25'),
(103, 3, 8, '2024-11-13', 'Thứ Tư', '12:20'),
(104, 3, 11, '2024-11-13', 'Thứ Tư', '15:00'),
(105, 9, 4, '2024-11-13', 'Thứ Tư', '11:25'),
(106, 9, 7, '2024-11-13', 'Thứ Tư', '11:20'),
(107, 9, 10, '2024-11-13', 'Thứ Tư', '11:45'),
(108, 9, 13, '2024-11-13', 'Thứ Tư', '11:25'),
(109, 4, 1, '2024-11-13', 'Thứ Tư', '14:45'),
(110, 4, 6, '2024-11-13', 'Thứ Tư', '13:00'),
(111, 4, 8, '2024-11-13', 'Thứ Tư', '13:55'),
(112, 4, 12, '2024-11-13', 'Thứ Tư', '16:00'),
(113, 16, 3, '2024-11-13', 'Thứ Tư', '15:15'),
(114, 16, 6, '2024-11-13', 'Thứ Tư', '14:50'),
(115, 16, 8, '2024-11-13', 'Thứ Tư', '15:35'),
(116, 16, 13, '2024-11-13', 'Thứ Tư', '13:15'),
(117, 1, 2, '2024-11-13', 'Thứ Tư', '11:25'),
(118, 1, 7, '2024-11-13', 'Thứ Tư', '13:00'),
(119, 1, 8, '2024-11-13', 'Thứ Tư', '17:10'),
(120, 1, 12, '2024-11-13', 'Thứ Tư', '17:35'),
(121, 8, 1, '2024-11-13', 'Thứ Tư', '15:30'),
(122, 8, 6, '2024-11-13', 'Thứ Tư', '16:45'),
(123, 8, 10, '2024-11-13', 'Thứ Tư', '13:30'),
(124, 8, 13, '2024-11-13', 'Thứ Tư', '15:00'),
(125, 2, 4, '2024-11-13', 'Thứ Tư', '13:00'),
(126, 2, 6, '2024-11-13', 'Thứ Tư', '18:10'),
(127, 2, 10, '2024-11-13', 'Thứ Tư', '15:15'),
(128, 2, 12, '2024-11-13', 'Thứ Tư', '19:00'),
(129, 5, 1, '2024-11-13', 'Thứ Tư', '17:00'),
(130, 5, 6, '2024-11-13', 'Thứ Tư', '19:55'),
(131, 5, 10, '2024-11-13', 'Thứ Tư', '17:00'),
(132, 5, 12, '2024-11-13', 'Thứ Tư', '16:50'),
(133, 6, 2, '2024-11-13', 'Thứ Tư', '13:00'),
(134, 6, 7, '2024-11-13', 'Thứ Tư', '15:00'),
(135, 6, 8, '2024-11-13', 'Thứ Tư', '19:00'),
(136, 6, 12, '2024-11-13', 'Thứ Tư', '18:45'),
(137, 20, 2, '2024-11-13', 'Thứ Tư', '15:00'),
(138, 20, 7, '2024-11-13', 'Thứ Tư', '17:00'),
(139, 20, 10, '2024-11-13', 'Thứ Tư', '19:00'),
(140, 20, 11, '2024-11-13', 'Thứ Tư', '17:00'),
(147, 3, 1, '2024-11-14', 'Thứ Năm', '13:00'),
(148, 3, 6, '2024-11-14', 'Thứ Năm', '11:25'),
(149, 3, 8, '2024-11-14', 'Thứ Năm', '12:20'),
(150, 3, 11, '2024-11-14', 'Thứ Năm', '15:00'),
(151, 9, 4, '2024-11-14', 'Thứ Năm', '11:25'),
(152, 9, 7, '2024-11-14', 'Thứ Năm', '11:20'),
(153, 9, 10, '2024-11-14', 'Thứ Năm', '11:45'),
(154, 9, 13, '2024-11-14', 'Thứ Năm', '11:25'),
(155, 4, 1, '2024-11-14', 'Thứ Năm', '14:45'),
(156, 4, 6, '2024-11-14', 'Thứ Năm', '13:00'),
(157, 4, 8, '2024-11-14', 'Thứ Năm', '13:55'),
(158, 4, 12, '2024-11-14', 'Thứ Năm', '16:00'),
(159, 16, 3, '2024-11-14', 'Thứ Năm', '15:15'),
(160, 16, 6, '2024-11-14', 'Thứ Năm', '14:50'),
(161, 16, 8, '2024-11-14', 'Thứ Năm', '15:35'),
(162, 16, 13, '2024-11-14', 'Thứ Năm', '13:15'),
(163, 1, 2, '2024-11-14', 'Thứ Năm', '11:25'),
(164, 1, 7, '2024-11-14', 'Thứ Năm', '13:00'),
(165, 1, 8, '2024-11-14', 'Thứ Năm', '17:10'),
(166, 1, 12, '2024-11-14', 'Thứ Năm', '17:35'),
(167, 8, 1, '2024-11-14', 'Thứ Năm', '15:30'),
(168, 8, 6, '2024-11-14', 'Thứ Năm', '16:45'),
(169, 8, 10, '2024-11-14', 'Thứ Năm', '13:30'),
(170, 8, 13, '2024-11-14', 'Thứ Năm', '15:00'),
(171, 2, 4, '2024-11-14', 'Thứ Năm', '13:00'),
(172, 2, 6, '2024-11-14', 'Thứ Năm', '18:10'),
(173, 2, 10, '2024-11-14', 'Thứ Năm', '15:15'),
(174, 2, 12, '2024-11-14', 'Thứ Năm', '19:00'),
(175, 5, 1, '2024-11-14', 'Thứ Năm', '17:00'),
(176, 5, 6, '2024-11-14', 'Thứ Năm', '19:55'),
(177, 5, 10, '2024-11-14', 'Thứ Năm', '17:00'),
(178, 5, 12, '2024-11-14', 'Thứ Năm', '16:50'),
(179, 6, 2, '2024-11-14', 'Thứ Năm', '13:00'),
(180, 6, 7, '2024-11-14', 'Thứ Năm', '15:00'),
(181, 6, 8, '2024-11-14', 'Thứ Năm', '19:00'),
(182, 6, 12, '2024-11-14', 'Thứ Năm', '18:45'),
(183, 20, 2, '2024-11-14', 'Thứ Năm', '15:00'),
(184, 20, 7, '2024-11-14', 'Thứ Năm', '17:00'),
(185, 20, 10, '2024-11-14', 'Thứ Năm', '19:00'),
(186, 20, 11, '2024-11-14', 'Thứ Năm', '17:00'),
(193, 3, 1, '2024-11-15', 'Thứ Sáu', '13:00'),
(194, 3, 6, '2024-11-15', 'Thứ Sáu', '11:25'),
(195, 3, 8, '2024-11-15', 'Thứ Sáu', '12:20'),
(196, 3, 11, '2024-11-15', 'Thứ Sáu', '15:00'),
(197, 9, 4, '2024-11-15', 'Thứ Sáu', '11:25'),
(198, 9, 7, '2024-11-15', 'Thứ Sáu', '11:20'),
(199, 9, 10, '2024-11-15', 'Thứ Sáu', '11:45'),
(200, 9, 13, '2024-11-15', 'Thứ Sáu', '11:25'),
(201, 4, 1, '2024-11-15', 'Thứ Sáu', '14:45'),
(202, 4, 6, '2024-11-15', 'Thứ Sáu', '13:00'),
(203, 4, 8, '2024-11-15', 'Thứ Sáu', '13:55'),
(204, 4, 12, '2024-11-15', 'Thứ Sáu', '16:00'),
(205, 16, 3, '2024-11-15', 'Thứ Sáu', '15:15'),
(206, 16, 6, '2024-11-15', 'Thứ Sáu', '14:50'),
(207, 16, 8, '2024-11-15', 'Thứ Sáu', '15:35'),
(208, 16, 13, '2024-11-15', 'Thứ Sáu', '13:15'),
(209, 1, 2, '2024-11-15', 'Thứ Sáu', '11:25'),
(210, 1, 7, '2024-11-15', 'Thứ Sáu', '13:00'),
(211, 1, 8, '2024-11-15', 'Thứ Sáu', '17:10'),
(212, 1, 12, '2024-11-15', 'Thứ Sáu', '17:35'),
(213, 8, 1, '2024-11-15', 'Thứ Sáu', '15:30'),
(214, 8, 6, '2024-11-15', 'Thứ Sáu', '16:45'),
(215, 8, 10, '2024-11-15', 'Thứ Sáu', '13:30'),
(216, 8, 13, '2024-11-15', 'Thứ Sáu', '15:00'),
(217, 2, 4, '2024-11-15', 'Thứ Sáu', '13:00'),
(218, 2, 6, '2024-11-15', 'Thứ Sáu', '18:10'),
(219, 2, 10, '2024-11-15', 'Thứ Sáu', '15:15'),
(220, 2, 12, '2024-11-15', 'Thứ Sáu', '19:00'),
(221, 5, 1, '2024-11-15', 'Thứ Sáu', '17:00'),
(222, 5, 6, '2024-11-15', 'Thứ Sáu', '19:55'),
(223, 5, 10, '2024-11-15', 'Thứ Sáu', '17:00'),
(224, 5, 12, '2024-11-15', 'Thứ Sáu', '16:50'),
(225, 6, 2, '2024-11-15', 'Thứ Sáu', '13:00'),
(226, 6, 7, '2024-11-15', 'Thứ Sáu', '15:00'),
(227, 6, 8, '2024-11-15', 'Thứ Sáu', '19:00'),
(228, 6, 12, '2024-11-15', 'Thứ Sáu', '18:45'),
(229, 20, 2, '2024-11-15', 'Thứ Sáu', '15:00'),
(230, 20, 7, '2024-11-15', 'Thứ Sáu', '17:00'),
(231, 20, 10, '2024-11-15', 'Thứ Sáu', '19:00'),
(232, 20, 11, '2024-11-15', 'Thứ Sáu', '17:00'),
(239, 3, 1, '2024-11-16', 'Thứ Bảy', '13:00'),
(240, 3, 6, '2024-11-16', 'Thứ Bảy', '11:25'),
(241, 3, 8, '2024-11-16', 'Thứ Bảy', '12:20'),
(242, 3, 11, '2024-11-16', 'Thứ Bảy', '15:00'),
(243, 9, 4, '2024-11-16', 'Thứ Bảy', '11:25'),
(244, 9, 7, '2024-11-16', 'Thứ Bảy', '11:20'),
(245, 9, 10, '2024-11-16', 'Thứ Bảy', '11:45'),
(246, 9, 13, '2024-11-16', 'Thứ Bảy', '11:25'),
(247, 4, 1, '2024-11-16', 'Thứ Bảy', '14:45'),
(248, 4, 6, '2024-11-16', 'Thứ Bảy', '13:00'),
(249, 4, 8, '2024-11-16', 'Thứ Bảy', '13:55'),
(250, 4, 12, '2024-11-16', 'Thứ Bảy', '16:00'),
(251, 16, 3, '2024-11-16', 'Thứ Bảy', '15:15'),
(252, 16, 6, '2024-11-16', 'Thứ Bảy', '14:50'),
(253, 16, 8, '2024-11-16', 'Thứ Bảy', '15:35'),
(254, 16, 13, '2024-11-16', 'Thứ Bảy', '13:15'),
(255, 1, 2, '2024-11-16', 'Thứ Bảy', '11:25'),
(256, 1, 7, '2024-11-16', 'Thứ Bảy', '13:00'),
(257, 1, 8, '2024-11-16', 'Thứ Bảy', '17:10'),
(258, 1, 12, '2024-11-16', 'Thứ Bảy', '17:35'),
(259, 8, 1, '2024-11-16', 'Thứ Bảy', '15:30'),
(260, 8, 6, '2024-11-16', 'Thứ Bảy', '16:45'),
(261, 8, 10, '2024-11-16', 'Thứ Bảy', '13:30'),
(262, 8, 13, '2024-11-16', 'Thứ Bảy', '15:00'),
(263, 2, 4, '2024-11-16', 'Thứ Bảy', '13:00'),
(264, 2, 6, '2024-11-16', 'Thứ Bảy', '18:10'),
(265, 2, 10, '2024-11-16', 'Thứ Bảy', '15:15'),
(266, 2, 12, '2024-11-16', 'Thứ Bảy', '19:00'),
(267, 5, 1, '2024-11-16', 'Thứ Bảy', '17:00'),
(268, 5, 6, '2024-11-16', 'Thứ Bảy', '19:55'),
(269, 5, 10, '2024-11-16', 'Thứ Bảy', '17:00'),
(270, 5, 12, '2024-11-16', 'Thứ Bảy', '16:50'),
(271, 6, 2, '2024-11-16', 'Thứ Bảy', '13:00'),
(272, 6, 7, '2024-11-16', 'Thứ Bảy', '15:00'),
(273, 6, 8, '2024-11-16', 'Thứ Bảy', '19:00'),
(274, 6, 12, '2024-11-16', 'Thứ Bảy', '18:45'),
(275, 20, 2, '2024-11-16', 'Thứ Bảy', '15:00'),
(276, 20, 7, '2024-11-16', 'Thứ Bảy', '17:00'),
(277, 20, 10, '2024-11-16', 'Thứ Bảy', '19:00'),
(278, 20, 11, '2024-11-16', 'Thứ Bảy', '17:00'),
(285, 3, 1, '2024-11-17', 'Chủ Nhật', '13:00'),
(286, 3, 6, '2024-11-17', 'Chủ Nhật', '11:25'),
(287, 3, 8, '2024-11-17', 'Chủ Nhật', '12:20'),
(288, 3, 11, '2024-11-17', 'Chủ Nhật', '15:00'),
(289, 9, 4, '2024-11-17', 'Chủ Nhật', '11:25'),
(290, 9, 7, '2024-11-17', 'Chủ Nhật', '11:20'),
(291, 9, 10, '2024-11-17', 'Chủ Nhật', '11:45'),
(292, 9, 13, '2024-11-17', 'Chủ Nhật', '11:25'),
(293, 4, 1, '2024-11-17', 'Chủ Nhật', '14:45'),
(294, 4, 6, '2024-11-17', 'Chủ Nhật', '13:00'),
(295, 4, 8, '2024-11-17', 'Chủ Nhật', '13:55'),
(296, 4, 12, '2024-11-17', 'Chủ Nhật', '16:00'),
(297, 16, 3, '2024-11-17', 'Chủ Nhật', '15:15'),
(298, 16, 6, '2024-11-17', 'Chủ Nhật', '14:50'),
(299, 16, 8, '2024-11-17', 'Chủ Nhật', '15:35'),
(300, 16, 13, '2024-11-17', 'Chủ Nhật', '13:15'),
(301, 1, 2, '2024-11-17', 'Chủ Nhật', '11:25'),
(302, 1, 7, '2024-11-17', 'Chủ Nhật', '13:00'),
(303, 1, 8, '2024-11-17', 'Chủ Nhật', '17:10'),
(304, 1, 12, '2024-11-17', 'Chủ Nhật', '17:35'),
(305, 8, 1, '2024-11-17', 'Chủ Nhật', '15:30'),
(306, 8, 6, '2024-11-17', 'Chủ Nhật', '16:45'),
(307, 8, 10, '2024-11-17', 'Chủ Nhật', '13:30'),
(308, 8, 13, '2024-11-17', 'Chủ Nhật', '15:00'),
(309, 2, 4, '2024-11-17', 'Chủ Nhật', '13:00'),
(310, 2, 6, '2024-11-17', 'Chủ Nhật', '18:10'),
(311, 2, 10, '2024-11-17', 'Chủ Nhật', '15:15'),
(312, 2, 12, '2024-11-17', 'Chủ Nhật', '19:00'),
(313, 5, 1, '2024-11-17', 'Chủ Nhật', '17:00'),
(314, 5, 6, '2024-11-17', 'Chủ Nhật', '19:55'),
(315, 5, 10, '2024-11-17', 'Chủ Nhật', '17:00'),
(316, 5, 12, '2024-11-17', 'Chủ Nhật', '16:50'),
(317, 6, 2, '2024-11-17', 'Chủ Nhật', '13:00'),
(318, 6, 7, '2024-11-17', 'Chủ Nhật', '15:00'),
(319, 6, 8, '2024-11-17', 'Chủ Nhật', '19:00'),
(320, 6, 12, '2024-11-17', 'Chủ Nhật', '18:45'),
(321, 20, 2, '2024-11-17', 'Chủ Nhật', '15:00'),
(322, 20, 7, '2024-11-17', 'Chủ Nhật', '17:00'),
(323, 20, 10, '2024-11-17', 'Chủ Nhật', '19:00'),
(324, 20, 11, '2024-11-17', 'Chủ Nhật', '17:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `seats`
--

CREATE TABLE `seats` (
  `seat_id` int(11) NOT NULL,
  `row` varchar(26) NOT NULL,
  `seat_number` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `room_id` int(11) NOT NULL,
  `seat_price` int(11) NOT NULL,
  `seat_type` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `seats`
--

INSERT INTO `seats` (`seat_id`, `row`, `seat_number`, `status`, `room_id`, `seat_price`, `seat_type`) VALUES
(52, 'A', 1, 0, 1, 50000, 0),
(53, 'A', 2, 0, 1, 50000, 0),
(54, 'A', 3, 0, 1, 50000, 0),
(55, 'A', 4, 0, 1, 50000, 0),
(56, 'A', 5, 0, 1, 50000, 0),
(57, 'A', 6, 0, 1, 50000, 0),
(58, 'A', 7, 0, 1, 50000, 0),
(59, 'A', 8, 0, 1, 50000, 0),
(60, 'A', 9, 0, 1, 50000, 0),
(61, 'A', 10, 0, 1, 50000, 0),
(62, 'B', 1, 0, 1, 50000, 0),
(63, 'B', 2, 0, 1, 50000, 0),
(64, 'B', 3, 0, 1, 50000, 0),
(65, 'B', 4, 0, 1, 50000, 0),
(66, 'B', 5, 0, 1, 50000, 0),
(67, 'B', 6, 0, 1, 50000, 0),
(68, 'B', 7, 0, 1, 50000, 0),
(69, 'B', 8, 0, 1, 50000, 0),
(70, 'B', 9, 0, 1, 50000, 0),
(71, 'B', 10, 0, 1, 50000, 0),
(72, 'C', 1, 0, 1, 50000, 0),
(73, 'C', 2, 0, 1, 50000, 0),
(74, 'C', 3, 0, 1, 50000, 0),
(75, 'C', 4, 0, 1, 85000, 1),
(76, 'C', 5, 0, 1, 85000, 1),
(77, 'C', 6, 0, 1, 85000, 1),
(78, 'C', 7, 0, 1, 85000, 1),
(79, 'C', 8, 0, 1, 50000, 0),
(80, 'C', 9, 0, 1, 50000, 0),
(81, 'C', 10, 0, 1, 50000, 0),
(82, 'D', 1, 0, 1, 50000, 0),
(83, 'D', 2, 0, 1, 50000, 0),
(84, 'D', 3, 0, 1, 50000, 0),
(85, 'D', 4, 0, 1, 85000, 1),
(86, 'D', 5, 0, 1, 85000, 1),
(87, 'D', 6, 0, 1, 85000, 1),
(88, 'D', 7, 0, 1, 85000, 1),
(89, 'D', 8, 0, 1, 50000, 0),
(90, 'D', 9, 0, 1, 50000, 0),
(91, 'D', 10, 0, 1, 50000, 0),
(92, 'E', 1, 0, 1, 50000, 0),
(93, 'E', 2, 0, 1, 50000, 0),
(94, 'E', 3, 0, 1, 50000, 0),
(95, 'E', 4, 0, 1, 50000, 0),
(96, 'E', 5, 0, 1, 50000, 0),
(97, 'E', 6, 0, 1, 50000, 0),
(98, 'E', 7, 0, 1, 50000, 0),
(99, 'E', 8, 0, 1, 50000, 0),
(100, 'E', 9, 0, 1, 50000, 0),
(101, 'E', 10, 0, 1, 50000, 0),
(102, 'A', 1, 0, 3, 50000, 0),
(103, 'A', 2, 0, 3, 50000, 0),
(104, 'A', 3, 0, 3, 50000, 0),
(105, 'A', 4, 0, 3, 50000, 0),
(106, 'A', 5, 0, 3, 50000, 0),
(107, 'A', 6, 0, 3, 50000, 0),
(108, 'A', 7, 0, 3, 50000, 0),
(109, 'A', 8, 0, 3, 50000, 0),
(110, 'A', 9, 0, 3, 50000, 0),
(111, 'A', 10, 0, 3, 50000, 0),
(112, 'B', 1, 0, 3, 50000, 0),
(113, 'B', 2, 0, 3, 50000, 0),
(114, 'B', 3, 0, 3, 50000, 0),
(115, 'B', 4, 0, 3, 50000, 0),
(116, 'B', 5, 0, 3, 50000, 0),
(117, 'B', 6, 0, 3, 50000, 0),
(118, 'B', 7, 0, 3, 50000, 0),
(119, 'B', 8, 0, 3, 50000, 0),
(120, 'B', 9, 0, 3, 50000, 0),
(121, 'B', 10, 0, 3, 50000, 0),
(122, 'C', 1, 0, 3, 50000, 0),
(123, 'C', 2, 0, 3, 50000, 0),
(124, 'C', 3, 0, 3, 50000, 0),
(125, 'C', 4, 0, 3, 50000, 0),
(126, 'C', 5, 0, 3, 50000, 0),
(127, 'C', 6, 0, 3, 50000, 0),
(128, 'C', 7, 0, 3, 50000, 0),
(129, 'C', 8, 0, 3, 50000, 0),
(130, 'C', 9, 0, 3, 50000, 0),
(131, 'C', 10, 0, 3, 50000, 0),
(132, 'D', 1, 0, 3, 50000, 0),
(133, 'D', 2, 0, 3, 50000, 0),
(134, 'D', 3, 0, 3, 50000, 0),
(135, 'D', 4, 0, 3, 50000, 0),
(136, 'D', 5, 0, 3, 50000, 0),
(137, 'D', 6, 0, 3, 50000, 0),
(138, 'D', 7, 0, 3, 50000, 0),
(139, 'D', 8, 0, 3, 50000, 0),
(140, 'D', 9, 0, 3, 50000, 0),
(141, 'D', 10, 0, 3, 50000, 0),
(142, 'E', 1, 0, 3, 50000, 0),
(143, 'E', 2, 0, 3, 50000, 0),
(144, 'E', 3, 0, 3, 50000, 0),
(145, 'E', 4, 0, 3, 50000, 0),
(146, 'E', 5, 0, 3, 50000, 0),
(147, 'E', 6, 0, 3, 50000, 0),
(148, 'E', 7, 0, 3, 50000, 0),
(149, 'E', 8, 0, 3, 50000, 0),
(150, 'E', 9, 0, 3, 50000, 0),
(151, 'E', 10, 0, 3, 50000, 0),
(152, 'A', 1, 0, 2, 50000, 0),
(153, 'A', 2, 0, 2, 50000, 0),
(154, 'A', 3, 0, 2, 50000, 0),
(155, 'A', 4, 0, 2, 50000, 0),
(156, 'A', 5, 0, 2, 50000, 0),
(157, 'A', 6, 0, 2, 50000, 0),
(158, 'A', 7, 0, 2, 50000, 0),
(159, 'A', 8, 0, 2, 50000, 0),
(160, 'A', 9, 0, 2, 50000, 0),
(161, 'A', 10, 0, 2, 50000, 0),
(162, 'B', 1, 0, 2, 50000, 0),
(163, 'B', 2, 0, 2, 50000, 0),
(164, 'B', 3, 0, 2, 50000, 0),
(165, 'B', 4, 0, 2, 50000, 0),
(166, 'B', 5, 0, 2, 50000, 0),
(167, 'B', 6, 0, 2, 50000, 0),
(168, 'B', 7, 0, 2, 50000, 0),
(169, 'B', 8, 0, 2, 50000, 0),
(170, 'B', 9, 0, 2, 50000, 0),
(171, 'B', 10, 0, 2, 50000, 0),
(172, 'C', 1, 0, 2, 50000, 0),
(173, 'C', 2, 0, 2, 50000, 0),
(174, 'C', 3, 0, 2, 50000, 0),
(175, 'C', 4, 0, 2, 50000, 0),
(176, 'C', 5, 0, 2, 50000, 0),
(177, 'C', 6, 0, 2, 50000, 0),
(178, 'C', 7, 0, 2, 50000, 0),
(179, 'C', 8, 0, 2, 50000, 0),
(180, 'C', 9, 0, 2, 50000, 0),
(181, 'C', 10, 0, 2, 50000, 0),
(182, 'D', 1, 0, 2, 50000, 0),
(183, 'D', 2, 0, 2, 50000, 0),
(184, 'D', 3, 0, 2, 50000, 0),
(185, 'D', 4, 0, 2, 50000, 0),
(186, 'D', 5, 0, 2, 50000, 0),
(187, 'D', 6, 0, 2, 50000, 0),
(188, 'D', 7, 0, 2, 50000, 0),
(189, 'D', 8, 0, 2, 50000, 0),
(190, 'D', 9, 0, 2, 50000, 0),
(191, 'D', 10, 0, 2, 50000, 0),
(192, 'E', 1, 0, 2, 50000, 0),
(193, 'E', 2, 0, 2, 50000, 0),
(194, 'E', 3, 0, 2, 50000, 0),
(195, 'E', 4, 0, 2, 50000, 0),
(196, 'E', 5, 0, 2, 50000, 0),
(197, 'E', 6, 0, 2, 50000, 0),
(198, 'E', 7, 0, 2, 50000, 0),
(199, 'E', 8, 0, 2, 50000, 0),
(200, 'E', 9, 0, 2, 50000, 0),
(201, 'E', 10, 0, 2, 50000, 0),
(202, 'A', 1, 0, 4, 50000, 0),
(203, 'A', 2, 0, 4, 50000, 0),
(204, 'A', 3, 0, 4, 50000, 0),
(205, 'A', 4, 0, 4, 50000, 0),
(206, 'A', 5, 0, 4, 50000, 0),
(207, 'A', 6, 0, 4, 50000, 0),
(208, 'A', 7, 0, 4, 50000, 0),
(209, 'A', 8, 0, 4, 50000, 0),
(210, 'A', 9, 0, 4, 50000, 0),
(211, 'A', 10, 0, 4, 50000, 0),
(212, 'B', 1, 0, 4, 50000, 0),
(213, 'B', 2, 0, 4, 50000, 0),
(214, 'B', 3, 0, 4, 50000, 0),
(215, 'B', 4, 0, 4, 50000, 0),
(216, 'B', 5, 0, 4, 50000, 0),
(217, 'B', 6, 0, 4, 50000, 0),
(218, 'B', 7, 0, 4, 50000, 0),
(219, 'B', 8, 0, 4, 50000, 0),
(220, 'B', 9, 0, 4, 50000, 0),
(221, 'B', 10, 0, 4, 50000, 0),
(222, 'C', 1, 0, 4, 50000, 0),
(223, 'C', 2, 0, 4, 50000, 0),
(224, 'C', 3, 0, 4, 50000, 0),
(225, 'C', 4, 0, 4, 50000, 0),
(226, 'C', 5, 0, 4, 50000, 0),
(227, 'C', 6, 0, 4, 50000, 0),
(228, 'C', 7, 0, 4, 50000, 0),
(229, 'C', 8, 0, 4, 50000, 0),
(230, 'C', 9, 0, 4, 50000, 0),
(231, 'C', 10, 0, 4, 50000, 0),
(232, 'D', 1, 0, 4, 50000, 0),
(233, 'D', 2, 0, 4, 50000, 0),
(234, 'D', 3, 0, 4, 50000, 0),
(235, 'D', 4, 0, 4, 50000, 0),
(236, 'D', 5, 0, 4, 50000, 0),
(237, 'D', 6, 0, 4, 50000, 0),
(238, 'D', 7, 0, 4, 50000, 0),
(239, 'D', 8, 0, 4, 50000, 0),
(240, 'D', 9, 0, 4, 50000, 0),
(241, 'D', 10, 0, 4, 50000, 0),
(242, 'E', 1, 0, 4, 50000, 0),
(243, 'E', 2, 0, 4, 50000, 0),
(244, 'E', 3, 0, 4, 50000, 0),
(245, 'E', 4, 0, 4, 50000, 0),
(246, 'E', 5, 0, 4, 50000, 0),
(247, 'E', 6, 0, 4, 50000, 0),
(248, 'E', 7, 0, 4, 50000, 0),
(249, 'E', 8, 0, 4, 50000, 0),
(250, 'E', 9, 0, 4, 50000, 0),
(251, 'E', 10, 0, 4, 50000, 0),
(252, 'A', 1, 0, 5, 50000, 0),
(253, 'A', 2, 0, 5, 50000, 0),
(254, 'A', 3, 0, 5, 50000, 0),
(255, 'A', 4, 0, 5, 50000, 0),
(256, 'A', 5, 0, 5, 50000, 0),
(257, 'A', 6, 0, 5, 50000, 0),
(258, 'A', 7, 0, 5, 50000, 0),
(259, 'A', 8, 0, 5, 50000, 0),
(260, 'A', 9, 0, 5, 50000, 0),
(261, 'A', 10, 0, 5, 50000, 0),
(262, 'B', 1, 0, 5, 50000, 0),
(263, 'B', 2, 0, 5, 50000, 0),
(264, 'B', 3, 0, 5, 50000, 0),
(265, 'B', 4, 0, 5, 50000, 0),
(266, 'B', 5, 0, 5, 50000, 0),
(267, 'B', 6, 0, 5, 50000, 0),
(268, 'B', 7, 0, 5, 50000, 0),
(269, 'B', 8, 0, 5, 50000, 0),
(270, 'B', 9, 0, 5, 50000, 0),
(271, 'B', 10, 0, 5, 50000, 0),
(272, 'C', 1, 0, 5, 50000, 0),
(273, 'C', 2, 0, 5, 50000, 0),
(274, 'C', 3, 0, 5, 50000, 0),
(275, 'C', 4, 0, 5, 50000, 0),
(276, 'C', 5, 0, 5, 50000, 0),
(277, 'C', 6, 0, 5, 50000, 0),
(278, 'C', 7, 0, 5, 50000, 0),
(279, 'C', 8, 0, 5, 50000, 0),
(280, 'C', 9, 0, 5, 50000, 0),
(281, 'C', 10, 0, 5, 50000, 0),
(282, 'D', 1, 0, 5, 50000, 0),
(283, 'D', 2, 0, 5, 50000, 0),
(284, 'D', 3, 0, 5, 50000, 0),
(285, 'D', 4, 0, 5, 50000, 0),
(286, 'D', 5, 0, 5, 50000, 0),
(287, 'D', 6, 0, 5, 50000, 0),
(288, 'D', 7, 0, 5, 50000, 0),
(289, 'D', 8, 0, 5, 50000, 0),
(290, 'D', 9, 0, 5, 50000, 0),
(291, 'D', 10, 0, 5, 50000, 0),
(292, 'E', 1, 0, 5, 50000, 0),
(293, 'E', 2, 0, 5, 50000, 0),
(294, 'E', 3, 0, 5, 50000, 0),
(295, 'E', 4, 0, 5, 50000, 0),
(296, 'E', 5, 0, 5, 50000, 0),
(297, 'E', 6, 0, 5, 50000, 0),
(298, 'E', 7, 0, 5, 50000, 0),
(299, 'E', 8, 0, 5, 50000, 0),
(300, 'E', 9, 0, 5, 50000, 0),
(301, 'E', 10, 0, 5, 50000, 0),
(302, 'A', 1, 0, 6, 50000, 0),
(303, 'A', 2, 0, 6, 50000, 0),
(304, 'A', 3, 0, 6, 50000, 0),
(305, 'A', 4, 0, 6, 50000, 0),
(306, 'A', 5, 0, 6, 50000, 0),
(307, 'A', 6, 0, 6, 50000, 0),
(308, 'A', 7, 0, 6, 50000, 0),
(309, 'A', 8, 0, 6, 50000, 0),
(310, 'A', 9, 0, 6, 50000, 0),
(311, 'A', 10, 0, 6, 50000, 0),
(312, 'B', 1, 0, 6, 50000, 0),
(313, 'B', 2, 0, 6, 50000, 0),
(314, 'B', 3, 0, 6, 50000, 0),
(315, 'B', 4, 0, 6, 50000, 0),
(316, 'B', 5, 0, 6, 50000, 0),
(317, 'B', 6, 0, 6, 50000, 0),
(318, 'B', 7, 0, 6, 50000, 0),
(319, 'B', 8, 0, 6, 50000, 0),
(320, 'B', 9, 0, 6, 50000, 0),
(321, 'B', 10, 0, 6, 50000, 0),
(322, 'C', 1, 0, 6, 50000, 0),
(323, 'C', 2, 0, 6, 50000, 0),
(324, 'C', 3, 0, 6, 50000, 0),
(325, 'C', 4, 0, 6, 50000, 0),
(326, 'C', 5, 0, 6, 50000, 0),
(327, 'C', 6, 0, 6, 50000, 0),
(328, 'C', 7, 0, 6, 50000, 0),
(329, 'C', 8, 0, 6, 50000, 0),
(330, 'C', 9, 0, 6, 50000, 0),
(331, 'C', 10, 0, 6, 50000, 0),
(332, 'D', 1, 0, 6, 50000, 0),
(333, 'D', 2, 0, 6, 50000, 0),
(334, 'D', 3, 0, 6, 50000, 0),
(335, 'D', 4, 0, 6, 50000, 0),
(336, 'D', 5, 0, 6, 50000, 0),
(337, 'D', 6, 0, 6, 50000, 0),
(338, 'D', 7, 0, 6, 50000, 0),
(339, 'D', 8, 0, 6, 50000, 0),
(340, 'D', 9, 0, 6, 50000, 0),
(341, 'D', 10, 0, 6, 50000, 0),
(342, 'E', 1, 0, 6, 50000, 0),
(343, 'E', 2, 0, 6, 50000, 0),
(344, 'E', 3, 0, 6, 50000, 0),
(345, 'E', 4, 0, 6, 50000, 0),
(346, 'E', 5, 0, 6, 50000, 0),
(347, 'E', 6, 0, 6, 50000, 0),
(348, 'E', 7, 0, 6, 50000, 0),
(349, 'E', 8, 0, 6, 50000, 0),
(350, 'E', 9, 0, 6, 50000, 0),
(351, 'E', 10, 0, 6, 50000, 0),
(352, 'A', 1, 0, 7, 50000, 0),
(353, 'A', 2, 0, 7, 50000, 0),
(354, 'A', 3, 0, 7, 50000, 0),
(355, 'A', 4, 0, 7, 50000, 0),
(356, 'A', 5, 0, 7, 50000, 0),
(357, 'A', 6, 0, 7, 50000, 0),
(358, 'A', 7, 0, 7, 50000, 0),
(359, 'A', 8, 0, 7, 50000, 0),
(360, 'A', 9, 0, 7, 50000, 0),
(361, 'A', 10, 0, 7, 50000, 0),
(362, 'B', 1, 0, 7, 50000, 0),
(363, 'B', 2, 0, 7, 50000, 0),
(364, 'B', 3, 0, 7, 50000, 0),
(365, 'B', 4, 0, 7, 50000, 0),
(366, 'B', 5, 0, 7, 50000, 0),
(367, 'B', 6, 0, 7, 50000, 0),
(368, 'B', 7, 0, 7, 50000, 0),
(369, 'B', 8, 0, 7, 50000, 0),
(370, 'B', 9, 0, 7, 50000, 0),
(371, 'B', 10, 0, 7, 50000, 0),
(372, 'C', 1, 0, 7, 50000, 0),
(373, 'C', 2, 0, 7, 50000, 0),
(374, 'C', 3, 0, 7, 50000, 0),
(375, 'C', 4, 0, 7, 50000, 0),
(376, 'C', 5, 0, 7, 50000, 0),
(377, 'C', 6, 0, 7, 50000, 0),
(378, 'C', 7, 0, 7, 50000, 0),
(379, 'C', 8, 0, 7, 50000, 0),
(380, 'C', 9, 0, 7, 50000, 0),
(381, 'C', 10, 0, 7, 50000, 0),
(382, 'D', 1, 0, 7, 50000, 0),
(383, 'D', 2, 0, 7, 50000, 0),
(384, 'D', 3, 0, 7, 50000, 0),
(385, 'D', 4, 0, 7, 50000, 0),
(386, 'D', 5, 0, 7, 50000, 0),
(387, 'D', 6, 0, 7, 50000, 0),
(388, 'D', 7, 0, 7, 50000, 0),
(389, 'D', 8, 0, 7, 50000, 0),
(390, 'D', 9, 0, 7, 50000, 0),
(391, 'D', 10, 0, 7, 50000, 0),
(392, 'E', 1, 0, 7, 50000, 0),
(393, 'E', 2, 0, 7, 50000, 0),
(394, 'E', 3, 0, 7, 50000, 0),
(395, 'E', 4, 0, 7, 50000, 0),
(396, 'E', 5, 0, 7, 50000, 0),
(397, 'E', 6, 0, 7, 50000, 0),
(398, 'E', 7, 0, 7, 50000, 0),
(399, 'E', 8, 0, 7, 50000, 0),
(400, 'E', 9, 0, 7, 50000, 0),
(401, 'E', 10, 0, 7, 50000, 0),
(402, 'A', 1, 0, 8, 50000, 0),
(403, 'A', 2, 0, 8, 50000, 0),
(404, 'A', 3, 0, 8, 50000, 0),
(405, 'A', 4, 0, 8, 50000, 0),
(406, 'A', 5, 0, 8, 50000, 0),
(407, 'A', 6, 0, 8, 50000, 0),
(408, 'A', 7, 0, 8, 50000, 0),
(409, 'A', 8, 0, 8, 50000, 0),
(410, 'A', 9, 0, 8, 50000, 0),
(411, 'A', 10, 0, 8, 50000, 0),
(412, 'B', 1, 0, 8, 50000, 0),
(413, 'B', 2, 0, 8, 50000, 0),
(414, 'B', 3, 0, 8, 50000, 0),
(415, 'B', 4, 0, 8, 50000, 0),
(416, 'B', 5, 0, 8, 50000, 0),
(417, 'B', 6, 0, 8, 50000, 0),
(418, 'B', 7, 0, 8, 50000, 0),
(419, 'B', 8, 0, 8, 50000, 0),
(420, 'B', 9, 0, 8, 50000, 0),
(421, 'B', 10, 0, 8, 50000, 0),
(422, 'C', 1, 0, 8, 50000, 0),
(423, 'C', 2, 0, 8, 50000, 0),
(424, 'C', 3, 0, 8, 50000, 0),
(425, 'C', 4, 0, 8, 50000, 0),
(426, 'C', 5, 0, 8, 50000, 0),
(427, 'C', 6, 0, 8, 50000, 0),
(428, 'C', 7, 0, 8, 50000, 0),
(429, 'C', 8, 0, 8, 50000, 0),
(430, 'C', 9, 0, 8, 50000, 0),
(431, 'C', 10, 0, 8, 50000, 0),
(432, 'D', 1, 0, 8, 50000, 0),
(433, 'D', 2, 0, 8, 50000, 0),
(434, 'D', 3, 0, 8, 50000, 0),
(435, 'D', 4, 0, 8, 50000, 0),
(436, 'D', 5, 0, 8, 50000, 0),
(437, 'D', 6, 0, 8, 50000, 0),
(438, 'D', 7, 0, 8, 50000, 0),
(439, 'D', 8, 0, 8, 50000, 0),
(440, 'D', 9, 0, 8, 50000, 0),
(441, 'D', 10, 0, 8, 50000, 0),
(442, 'E', 1, 0, 8, 50000, 0),
(443, 'E', 2, 0, 8, 50000, 0),
(444, 'E', 3, 0, 8, 50000, 0),
(445, 'E', 4, 0, 8, 50000, 0),
(446, 'E', 5, 0, 8, 50000, 0),
(447, 'E', 6, 0, 8, 50000, 0),
(448, 'E', 7, 0, 8, 50000, 0),
(449, 'E', 8, 0, 8, 50000, 0),
(450, 'E', 9, 0, 8, 50000, 0),
(451, 'E', 10, 0, 8, 50000, 0),
(452, 'A', 1, 0, 9, 50000, 0),
(453, 'A', 2, 0, 9, 50000, 0),
(454, 'A', 3, 0, 9, 50000, 0),
(455, 'A', 4, 0, 9, 50000, 0),
(456, 'A', 5, 0, 9, 50000, 0),
(457, 'A', 6, 0, 9, 50000, 0),
(458, 'A', 7, 0, 9, 50000, 0),
(459, 'A', 8, 0, 9, 50000, 0),
(460, 'A', 9, 0, 9, 50000, 0),
(461, 'A', 10, 0, 9, 50000, 0),
(462, 'B', 1, 0, 9, 50000, 0),
(463, 'B', 2, 0, 9, 50000, 0),
(464, 'B', 3, 0, 9, 50000, 0),
(465, 'B', 4, 0, 9, 50000, 0),
(466, 'B', 5, 0, 9, 50000, 0),
(467, 'B', 6, 0, 9, 50000, 0),
(468, 'B', 7, 0, 9, 50000, 0),
(469, 'B', 8, 0, 9, 50000, 0),
(470, 'B', 9, 0, 9, 50000, 0),
(471, 'B', 10, 0, 9, 50000, 0),
(472, 'C', 1, 0, 9, 50000, 0),
(473, 'C', 2, 0, 9, 50000, 0),
(474, 'C', 3, 0, 9, 50000, 0),
(475, 'C', 4, 0, 9, 50000, 0),
(476, 'C', 5, 0, 9, 50000, 0),
(477, 'C', 6, 0, 9, 50000, 0),
(478, 'C', 7, 0, 9, 50000, 0),
(479, 'C', 8, 0, 9, 50000, 0),
(480, 'C', 9, 0, 9, 50000, 0),
(481, 'C', 10, 0, 9, 50000, 0),
(482, 'D', 1, 0, 9, 50000, 0),
(483, 'D', 2, 0, 9, 50000, 0),
(484, 'D', 3, 0, 9, 50000, 0),
(485, 'D', 4, 0, 9, 50000, 0),
(486, 'D', 5, 0, 9, 50000, 0),
(487, 'D', 6, 0, 9, 50000, 0),
(488, 'D', 7, 0, 9, 50000, 0),
(489, 'D', 8, 0, 9, 50000, 0),
(490, 'D', 9, 0, 9, 50000, 0),
(491, 'D', 10, 0, 9, 50000, 0),
(492, 'E', 1, 0, 9, 50000, 0),
(493, 'E', 2, 0, 9, 50000, 0),
(494, 'E', 3, 0, 9, 50000, 0),
(495, 'E', 4, 0, 9, 50000, 0),
(496, 'E', 5, 0, 9, 50000, 0),
(497, 'E', 6, 0, 9, 50000, 0),
(498, 'E', 7, 0, 9, 50000, 0),
(499, 'E', 8, 0, 9, 50000, 0),
(500, 'E', 9, 0, 9, 50000, 0),
(501, 'E', 10, 0, 9, 50000, 0),
(502, 'A', 1, 0, 10, 50000, 0),
(503, 'A', 2, 0, 10, 50000, 0),
(504, 'A', 3, 0, 10, 50000, 0),
(505, 'A', 4, 0, 10, 50000, 0),
(506, 'A', 5, 0, 10, 50000, 0),
(507, 'A', 6, 0, 10, 50000, 0),
(508, 'A', 7, 0, 10, 50000, 0),
(509, 'A', 8, 0, 10, 50000, 0),
(510, 'A', 9, 0, 10, 50000, 0),
(511, 'A', 10, 0, 10, 50000, 0),
(512, 'B', 1, 0, 10, 50000, 0),
(513, 'B', 2, 0, 10, 50000, 0),
(514, 'B', 3, 0, 10, 50000, 0),
(515, 'B', 4, 0, 10, 50000, 0),
(516, 'B', 5, 0, 10, 50000, 0),
(517, 'B', 6, 0, 10, 50000, 0),
(518, 'B', 7, 0, 10, 50000, 0),
(519, 'B', 8, 0, 10, 50000, 0),
(520, 'B', 9, 0, 10, 50000, 0),
(521, 'B', 10, 0, 10, 50000, 0),
(522, 'C', 1, 0, 10, 50000, 0),
(523, 'C', 2, 0, 10, 50000, 0),
(524, 'C', 3, 0, 10, 50000, 0),
(525, 'C', 4, 0, 10, 50000, 0),
(526, 'C', 5, 0, 10, 50000, 0),
(527, 'C', 6, 0, 10, 50000, 0),
(528, 'C', 7, 0, 10, 50000, 0),
(529, 'C', 8, 0, 10, 50000, 0),
(530, 'C', 9, 0, 10, 50000, 0),
(531, 'C', 10, 0, 10, 50000, 0),
(532, 'D', 1, 0, 10, 50000, 0),
(533, 'D', 2, 0, 10, 50000, 0),
(534, 'D', 3, 0, 10, 50000, 0),
(535, 'D', 4, 0, 10, 50000, 0),
(536, 'D', 5, 0, 10, 50000, 0),
(537, 'D', 6, 0, 10, 50000, 0),
(538, 'D', 7, 0, 10, 50000, 0),
(539, 'D', 8, 0, 10, 50000, 0),
(540, 'D', 9, 0, 10, 50000, 0),
(541, 'D', 10, 0, 10, 50000, 0),
(542, 'E', 1, 0, 10, 50000, 0),
(543, 'E', 2, 0, 10, 50000, 0),
(544, 'E', 3, 0, 10, 50000, 0),
(545, 'E', 4, 0, 10, 50000, 0),
(546, 'E', 5, 0, 10, 50000, 0),
(547, 'E', 6, 0, 10, 50000, 0),
(548, 'E', 7, 0, 10, 50000, 0),
(549, 'E', 8, 0, 10, 50000, 0),
(550, 'E', 9, 0, 10, 50000, 0),
(551, 'E', 10, 0, 10, 50000, 0),
(552, 'A', 1, 0, 11, 50000, 0),
(553, 'A', 2, 0, 11, 50000, 0),
(554, 'A', 3, 0, 11, 50000, 0),
(555, 'A', 4, 0, 11, 50000, 0),
(556, 'A', 5, 0, 11, 50000, 0),
(557, 'A', 6, 0, 11, 50000, 0),
(558, 'A', 7, 0, 11, 50000, 0),
(559, 'A', 8, 0, 11, 50000, 0),
(560, 'A', 9, 0, 11, 50000, 0),
(561, 'A', 10, 0, 11, 50000, 0),
(562, 'B', 1, 0, 11, 50000, 0),
(563, 'B', 2, 0, 11, 50000, 0),
(564, 'B', 3, 0, 11, 50000, 0),
(565, 'B', 4, 0, 11, 50000, 0),
(566, 'B', 5, 0, 11, 50000, 0),
(567, 'B', 6, 0, 11, 50000, 0),
(568, 'B', 7, 0, 11, 50000, 0),
(569, 'B', 8, 0, 11, 50000, 0),
(570, 'B', 9, 0, 11, 50000, 0),
(571, 'B', 10, 0, 11, 50000, 0),
(572, 'C', 1, 0, 11, 50000, 0),
(573, 'C', 2, 0, 11, 50000, 0),
(574, 'C', 3, 0, 11, 50000, 0),
(575, 'C', 4, 0, 11, 50000, 0),
(576, 'C', 5, 0, 11, 50000, 0),
(577, 'C', 6, 0, 11, 50000, 0),
(578, 'C', 7, 0, 11, 50000, 0),
(579, 'C', 8, 0, 11, 50000, 0),
(580, 'C', 9, 0, 11, 50000, 0),
(581, 'C', 10, 0, 11, 50000, 0),
(582, 'D', 1, 0, 11, 50000, 0),
(583, 'D', 2, 0, 11, 50000, 0),
(584, 'D', 3, 0, 11, 50000, 0),
(585, 'D', 4, 0, 11, 50000, 0),
(586, 'D', 5, 0, 11, 50000, 0),
(587, 'D', 6, 0, 11, 50000, 0),
(588, 'D', 7, 0, 11, 50000, 0),
(589, 'D', 8, 0, 11, 50000, 0),
(590, 'D', 9, 0, 11, 50000, 0),
(591, 'D', 10, 0, 11, 50000, 0),
(592, 'E', 1, 0, 11, 50000, 0),
(593, 'E', 2, 0, 11, 50000, 0),
(594, 'E', 3, 0, 11, 50000, 0),
(595, 'E', 4, 0, 11, 50000, 0),
(596, 'E', 5, 0, 11, 50000, 0),
(597, 'E', 6, 0, 11, 50000, 0),
(598, 'E', 7, 0, 11, 50000, 0),
(599, 'E', 8, 0, 11, 50000, 0),
(600, 'E', 9, 0, 11, 50000, 0),
(601, 'E', 10, 0, 11, 50000, 0),
(602, 'A', 1, 0, 12, 50000, 0),
(603, 'A', 2, 0, 12, 50000, 0),
(604, 'A', 3, 0, 12, 50000, 0),
(605, 'A', 4, 0, 12, 50000, 0),
(606, 'A', 5, 0, 12, 50000, 0),
(607, 'A', 6, 0, 12, 50000, 0),
(608, 'A', 7, 0, 12, 50000, 0),
(609, 'A', 8, 0, 12, 50000, 0),
(610, 'A', 9, 0, 12, 50000, 0),
(611, 'A', 10, 0, 12, 50000, 0),
(612, 'B', 1, 0, 12, 50000, 0),
(613, 'B', 2, 0, 12, 50000, 0),
(614, 'B', 3, 0, 12, 50000, 0),
(615, 'B', 4, 0, 12, 50000, 0),
(616, 'B', 5, 0, 12, 50000, 0),
(617, 'B', 6, 0, 12, 50000, 0),
(618, 'B', 7, 0, 12, 50000, 0),
(619, 'B', 8, 0, 12, 50000, 0),
(620, 'B', 9, 0, 12, 50000, 0),
(621, 'B', 10, 0, 12, 50000, 0),
(622, 'C', 1, 0, 12, 50000, 0),
(623, 'C', 2, 0, 12, 50000, 0),
(624, 'C', 3, 0, 12, 50000, 0),
(625, 'C', 4, 0, 12, 50000, 0),
(626, 'C', 5, 0, 12, 50000, 0),
(627, 'C', 6, 0, 12, 50000, 0),
(628, 'C', 7, 0, 12, 50000, 0),
(629, 'C', 8, 0, 12, 50000, 0),
(630, 'C', 9, 0, 12, 50000, 0),
(631, 'C', 10, 0, 12, 50000, 0),
(632, 'D', 1, 0, 12, 50000, 0),
(633, 'D', 2, 0, 12, 50000, 0),
(634, 'D', 3, 0, 12, 50000, 0),
(635, 'D', 4, 0, 12, 50000, 0),
(636, 'D', 5, 0, 12, 50000, 0),
(637, 'D', 6, 0, 12, 50000, 0),
(638, 'D', 7, 0, 12, 50000, 0),
(639, 'D', 8, 0, 12, 50000, 0),
(640, 'D', 9, 0, 12, 50000, 0),
(641, 'D', 10, 0, 12, 50000, 0),
(642, 'E', 1, 0, 12, 50000, 0),
(643, 'E', 2, 0, 12, 50000, 0),
(644, 'E', 3, 0, 12, 50000, 0),
(645, 'E', 4, 0, 12, 50000, 0),
(646, 'E', 5, 0, 12, 50000, 0),
(647, 'E', 6, 0, 12, 50000, 0),
(648, 'E', 7, 0, 12, 50000, 0),
(649, 'E', 8, 0, 12, 50000, 0),
(650, 'E', 9, 0, 12, 50000, 0),
(651, 'E', 10, 0, 12, 50000, 0),
(652, 'A', 1, 0, 13, 50000, 0),
(653, 'A', 2, 0, 13, 50000, 0),
(654, 'A', 3, 0, 13, 50000, 0),
(655, 'A', 4, 0, 13, 50000, 0),
(656, 'A', 5, 0, 13, 50000, 0),
(657, 'A', 6, 0, 13, 50000, 0),
(658, 'A', 7, 0, 13, 50000, 0),
(659, 'A', 8, 0, 13, 50000, 0),
(660, 'A', 9, 0, 13, 50000, 0),
(661, 'A', 10, 0, 13, 50000, 0),
(662, 'B', 1, 0, 13, 50000, 0),
(663, 'B', 2, 0, 13, 50000, 0),
(664, 'B', 3, 0, 13, 50000, 0),
(665, 'B', 4, 0, 13, 50000, 0),
(666, 'B', 5, 0, 13, 50000, 0),
(667, 'B', 6, 0, 13, 50000, 0),
(668, 'B', 7, 0, 13, 50000, 0),
(669, 'B', 8, 0, 13, 50000, 0),
(670, 'B', 9, 0, 13, 50000, 0),
(671, 'B', 10, 0, 13, 50000, 0),
(672, 'C', 1, 0, 13, 50000, 0),
(673, 'C', 2, 0, 13, 50000, 0),
(674, 'C', 3, 0, 13, 50000, 0),
(675, 'C', 4, 0, 13, 50000, 0),
(676, 'C', 5, 0, 13, 50000, 0),
(677, 'C', 6, 0, 13, 50000, 0),
(678, 'C', 7, 0, 13, 50000, 0),
(679, 'C', 8, 0, 13, 50000, 0),
(680, 'C', 9, 0, 13, 50000, 0),
(681, 'C', 10, 0, 13, 50000, 0),
(682, 'D', 1, 0, 13, 50000, 0),
(683, 'D', 2, 0, 13, 50000, 0),
(684, 'D', 3, 0, 13, 50000, 0),
(685, 'D', 4, 0, 13, 50000, 0),
(686, 'D', 5, 0, 13, 50000, 0),
(687, 'D', 6, 0, 13, 50000, 0),
(688, 'D', 7, 0, 13, 50000, 0),
(689, 'D', 8, 0, 13, 50000, 0),
(690, 'D', 9, 0, 13, 50000, 0),
(691, 'D', 10, 0, 13, 50000, 0),
(692, 'E', 1, 0, 13, 50000, 0),
(693, 'E', 2, 0, 13, 50000, 0),
(694, 'E', 3, 0, 13, 50000, 0),
(695, 'E', 4, 0, 13, 50000, 0),
(696, 'E', 5, 0, 13, 50000, 0),
(697, 'E', 6, 0, 13, 50000, 0),
(698, 'E', 7, 0, 13, 50000, 0),
(699, 'E', 8, 0, 13, 50000, 0),
(700, 'E', 9, 0, 13, 50000, 0),
(701, 'E', 10, 0, 13, 50000, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `seat_booking`
--

CREATE TABLE `seat_booking` (
  `seat_booking_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `seat_booking`
--

INSERT INTO `seat_booking` (`seat_booking_id`, `schedule_id`, `seat_id`, `booking_id`, `status`) VALUES
(21, 9, 66, 25, 1),
(24, 9, 76, 27, 1),
(25, 9, 77, 27, 1),
(26, 13, 226, 28, 1),
(27, 13, 227, 28, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `gender` tinyint(4) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level_id` int(4) NOT NULL,
  `date` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` text NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `fullname`, `gender`, `username`, `password`, `level_id`, `date`, `email`, `phone`, `status`) VALUES
(4, 'Lê Nho Tiệp', 1, 'tieptieptiep', 'tiepbn04', 1, '2004-09-19', 'lenhotiep1992004@gmail.com', '0337335791', 1),
(5, 'Cù Đình Thanh', 1, 'thanhthanhthanh', 'thanh123', 2, '2004-12-23', 'thanhhuce@gmail.com', '0836473827', 1),
(6, 'Nguyễn Thị Bình', 0, 'binh', 'binh123', 2, '2008-12-09', 'binh@gmail.com', '0735462736', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `actor`
--
ALTER TABLE `actor`
  ADD PRIMARY KEY (`a_id`);

--
-- Chỉ mục cho bảng `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `fk_booking_user` (`user_id`),
  ADD KEY `fk_booking_sche` (`schedule_id`);

--
-- Chỉ mục cho bảng `booking_food`
--
ALTER TABLE `booking_food`
  ADD PRIMARY KEY (`booking_id`,`food_id`),
  ADD KEY `fk_food` (`food_id`);

--
-- Chỉ mục cho bảng `cinema`
--
ALTER TABLE `cinema`
  ADD PRIMARY KEY (`cinema_id`);

--
-- Chỉ mục cho bảng `content_film`
--
ALTER TABLE `content_film`
  ADD PRIMARY KEY (`content_id`),
  ADD KEY `fk_movie_content` (`movie_id`);

--
-- Chỉ mục cho bảng `director`
--
ALTER TABLE `director`
  ADD PRIMARY KEY (`d_id`);

--
-- Chỉ mục cho bảng `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`discount_id`);

--
-- Chỉ mục cho bảng `film_categories`
--
ALTER TABLE `film_categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Chỉ mục cho bảng `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`food_id`);

--
-- Chỉ mục cho bảng `genre_film`
--
ALTER TABLE `genre_film`
  ADD PRIMARY KEY (`g_id`);

--
-- Chỉ mục cho bảng `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `fk_invoi_booking` (`booking_id`),
  ADD KEY `fk_discount` (`discount_id`) USING BTREE,
  ADD KEY `fk_invoi_payment` (`payment_id`);

--
-- Chỉ mục cho bảng `level_id`
--
ALTER TABLE `level_id`
  ADD PRIMARY KEY (`level_id`);

--
-- Chỉ mục cho bảng `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`);

--
-- Chỉ mục cho bảng `movie__actor`
--
ALTER TABLE `movie__actor`
  ADD PRIMARY KEY (`a_id`,`movie_id`),
  ADD KEY `fk_actor_movie` (`movie_id`);

--
-- Chỉ mục cho bảng `movie__categories`
--
ALTER TABLE `movie__categories`
  ADD PRIMARY KEY (`movie_id`,`cat_id`),
  ADD KEY `fk_cat_id` (`cat_id`);

--
-- Chỉ mục cho bảng `movie__director`
--
ALTER TABLE `movie__director`
  ADD PRIMARY KEY (`d_id`,`movie_id`),
  ADD KEY `fk_director_movie` (`movie_id`);

--
-- Chỉ mục cho bảng `movie__genre`
--
ALTER TABLE `movie__genre`
  ADD PRIMARY KEY (`genre_id`,`movie_id`),
  ADD KEY `fk_movie` (`movie_id`);

--
-- Chỉ mục cho bảng `paymethod`
--
ALTER TABLE `paymethod`
  ADD PRIMARY KEY (`pay_id`);

--
-- Chỉ mục cho bảng `poster`
--
ALTER TABLE `poster`
  ADD PRIMARY KEY (`mp_id`),
  ADD KEY `fk_movie_poster` (`movie_id`);

--
-- Chỉ mục cho bảng `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `fk_room_cinema` (`cinema_id`);

--
-- Chỉ mục cho bảng `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `fk_schedule_movie` (`movie_id`),
  ADD KEY `fk_schedule_room` (`room_id`);

--
-- Chỉ mục cho bảng `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`seat_id`),
  ADD KEY `fk_room` (`room_id`);

--
-- Chỉ mục cho bảng `seat_booking`
--
ALTER TABLE `seat_booking`
  ADD PRIMARY KEY (`seat_booking_id`),
  ADD KEY `fk_sb_sche` (`schedule_id`),
  ADD KEY `fk_sb_seat` (`seat_id`),
  ADD KEY `fk_sb_booking` (`booking_id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_levelid` (`level_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `actor`
--
ALTER TABLE `actor`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT cho bảng `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `cinema`
--
ALTER TABLE `cinema`
  MODIFY `cinema_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `content_film`
--
ALTER TABLE `content_film`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `director`
--
ALTER TABLE `director`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `film_categories`
--
ALTER TABLE `film_categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `food`
--
ALTER TABLE `food`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `genre_film`
--
ALTER TABLE `genre_film`
  MODIFY `g_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `level_id`
--
ALTER TABLE `level_id`
  MODIFY `level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `paymethod`
--
ALTER TABLE `paymethod`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `poster`
--
ALTER TABLE `poster`
  MODIFY `mp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `schedules`
--
ALTER TABLE `schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=325;

--
-- AUTO_INCREMENT cho bảng `seats`
--
ALTER TABLE `seats`
  MODIFY `seat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=702;

--
-- AUTO_INCREMENT cho bảng `seat_booking`
--
ALTER TABLE `seat_booking`
  MODIFY `seat_booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `fk_booking_sche` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`schedule_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_booking_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `booking_food`
--
ALTER TABLE `booking_food`
  ADD CONSTRAINT `fk_booking` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_food` FOREIGN KEY (`food_id`) REFERENCES `food` (`food_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `content_film`
--
ALTER TABLE `content_film`
  ADD CONSTRAINT `fk_movie_content` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `fk_invoi_booking` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_invoi_payment` FOREIGN KEY (`payment_id`) REFERENCES `paymethod` (`pay_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `movie__actor`
--
ALTER TABLE `movie__actor`
  ADD CONSTRAINT `fk_actor` FOREIGN KEY (`a_id`) REFERENCES `actor` (`a_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_actor_movie` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `movie__categories`
--
ALTER TABLE `movie__categories`
  ADD CONSTRAINT `fk_cat_id` FOREIGN KEY (`cat_id`) REFERENCES `film_categories` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_movie_id` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `movie__director`
--
ALTER TABLE `movie__director`
  ADD CONSTRAINT `fk_director` FOREIGN KEY (`d_id`) REFERENCES `director` (`d_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_director_movie` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `movie__genre`
--
ALTER TABLE `movie__genre`
  ADD CONSTRAINT `fk_genre` FOREIGN KEY (`genre_id`) REFERENCES `genre_film` (`g_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_movie` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `poster`
--
ALTER TABLE `poster`
  ADD CONSTRAINT `fk_movie_poster` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `fk_room_cinema` FOREIGN KEY (`cinema_id`) REFERENCES `cinema` (`cinema_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `fk_schedule_movie` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_schedule_room` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `fk_room` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `seat_booking`
--
ALTER TABLE `seat_booking`
  ADD CONSTRAINT `fk_sb_booking` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sb_sche` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`schedule_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sb_seat` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`seat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_levelid` FOREIGN KEY (`level_id`) REFERENCES `level_id` (`level_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
