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

// Lấy thông tin nhà nghỉ cần xóa
if (isset($_GET['id'])) {
    $nhaNghiID = $_GET['id'];

    // Kiểm tra nếu là admin và người dùng đã xác nhận muốn xóa
    if ($isAdmin && isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
        // Thực hiện truy vấn xóa nhà nghỉ
        $sql = "DELETE FROM NhaNghi WHERE NhaNghiID = $nhaNghiID";

        if ($conn->query($sql) === TRUE) {
            echo "Xóa nhà nghỉ thành công!";
        } else {
            echo "Lỗi: " . $conn->error;
        }
    } else {
        // Nếu chưa xác nhận muốn xóa, hiển thị thông báo xác nhận
        echo "<p>Bạn có chắc chắn muốn xóa nhà nghỉ này?</p>";
        echo "<a href='xoa.php?id=$nhaNghiID&confirm=true'>Xác nhận xóa</a> | ";
        echo "<a href='XemPhong.php'>Quay lại</a>";
    }
} else {
    echo "Thiếu thông tin nhà nghỉ cần xóa.";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Xóa Nhà Nghỉ</title>
</head>
<body>

</body>
</html>
