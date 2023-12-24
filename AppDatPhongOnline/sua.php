<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qldatphong";

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra quyền truy cập
$isAdmin = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] && isset($_SESSION['quyenTruyCap']) && $_SESSION['quyenTruyCap'] == 'admin';

// Biến để lưu thông báo lỗi (nếu có)
$error_message = "";

// Lấy ID của nhà nghỉ cần sửa
if (isset($_GET['id'])) {
    $nhaNghiID = $_GET['id'];

    // Xử lý khi người dùng nhấn nút "Lưu"
    if (isset($_POST['submit'])) {
        // Lấy dữ liệu từ form
        $tenNhaNghi = $_POST['tenNhaNghi'];
        $diaChi = $_POST['diaChi'];
        $soDienThoai = $_POST['soDienThoai'];
        $anh = $_POST['anh']; // Lưu đường dẫn ảnh vào cơ sở dữ liệu
        $giaPhong = $_POST['giaPhong'];

        // Thực hiện truy vấn để cập nhật thông tin nhà nghỉ
        $sql = "UPDATE NhaNghi SET TenNhaNghi='$tenNhaNghi', DiaChi='$diaChi', SoDienThoai='$soDienThoai', Anh='$anh', GiaPhong='$giaPhong' WHERE NhaNghiID=$nhaNghiID";

        if ($conn->query($sql) === TRUE) {
            // Chuyển hướng về trang XemPhong.php sau khi cập nhật thành công
            header("Location: XemPhong.php");
            exit();
        } else {
            $error_message = "Lỗi: " . $conn->error;
        }
    }

    // Truy vấn để lấy thông tin nhà nghỉ cần sửa
    $sql_select = "SELECT * FROM NhaNghi WHERE NhaNghiID=$nhaNghiID";
    $result = $conn->query($sql_select);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        $error_message = "Không tìm thấy nhà nghỉ cần sửa.";
    }
} else {
    $error_message = "Thiếu thông tin nhà nghỉ cần sửa.";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sửa Nhà Nghỉ</title>
</head>
<body>

<h2>Sửa Nhà Nghỉ</h2>

<form method="post" action="">
    <label for="tenNhaNghi">Tên Nhà Nghỉ:</label>
    <input type="text" name="tenNhaNghi" value="<?php echo $row['TenNhaNghi']; ?>" required><br>

    <label for="diaChi">Địa Chỉ:</label>
    <input type="text" name="diaChi" value="<?php echo $row['DiaChi']; ?>" required><br>

    <label for="soDienThoai">Số Điện Thoại:</label>
    <input type="text" name="soDienThoai" value="<?php echo $row['SoDienThoai']; ?>" required><br>

    <label for="anh">Ảnh (đường dẫn):</label>
    <input type="text" name="anh" value="<?php echo $row['Anh']; ?>" required><br>

    <label for="giaPhong">Giá Phòng:</label>
    <input type="text" name="giaPhong" value="<?php echo $row['GiaPhong']; ?>" required><br>

    <button type="submit" name="submit">Lưu</button>
</form>

<p><?php echo $error_message; ?></p>

<a href="XemPhong.php">Quay lại</a>

</body>
</html>
