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

// Xử lý khi người dùng nhấn nút "Lưu"
if (isset($_POST['submit'])) {
    // Lấy dữ liệu từ form
    $id = $_POST['nhaNghiID'];
    $tenNhaNghi = $_POST['tenNhaNghi'];
    $diaChi = $_POST['diaChi'];
    $soDienThoai = $_POST['soDienThoai'];
    $anh = $_POST['anh']; // Lưu đường dẫn ảnh vào cơ sở dữ liệu
    $giaPhong = $_POST['giaPhong'];

    // Thực hiện truy vấn để thêm nhà nghỉ mới
    $sql = "INSERT INTO NhaNghi (NhaNghiID, TenNhaNghi, DiaChi, SoDienThoai, Anh, GiaPhong) VALUES ('$','$tenNhaNghi', '$diaChi', '$soDienThoai', '$anh', '$giaPhong')";

    if ($conn->query($sql) === TRUE) {
        // Chuyển hướng về trang XemPhong.php sau khi thêm thành công
        header("Location: XemPhong.php");
        exit();
    } else {
        $error_message = "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thêm Nhà Nghỉ</title>
</head>
<body>

<h2>Thêm Nhà Nghỉ</h2>

<form method="post" action="">
    <label for="nhaNghiID">ID Nhà Nghỉ:</label>
    <input type="text" name="nhaNghiID" required><br>

    <label for="tenNhaNghi">Tên Nhà Nghỉ:</label>
    <input type="text" name="tenNhaNghi" required><br>

    <label for="diaChi">Địa Chỉ:</label>
    <input type="text" name="diaChi" required><br>

    <label for="soDienThoai">Số Điện Thoại:</label>
    <input type="text" name="soDienThoai" required><br>

    <label for="anh">Ảnh:</label>
    <input type="file" id="anh" name="anh" accept="image/*" required><br>

    <input type="submit" value="Thêm Nhà Nghỉ">
    <label for="giaPhong">Giá Phòng:</label>
    <input type="text" name="giaPhong" required><br>

    <button type="submit" name="submit">Lưu</button>
</form>

<p><?php echo $error_message; ?></p>

<a href="XemPhong.php">Quay lại</a>

</body>
</html>
