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

?>

<!DOCTYPE html>
<html>
<head>
    <title>Xem phòng online</title>
    <style>
        /* CSS để phóng to ảnh */
        #phongTo {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
        }

        #overlay {
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1;
        }

        /* CSS để hiển thị ô tích và nút Đặt Phòng */
        .checkbox-container {
            display: flex;
            align-items: center;
        }

        .checkbox {
            margin-right: 10px;
        }

        .dat-phong-button {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<?php
// Hiển thị chức năng thêm, sửa, xóa nếu là admin
if ($isAdmin) {
    echo "<a href='them.php'>Thêm Nhà Nghỉ</a>";
}

// Truy vấn để lấy danh sách nhà nghỉ
$sql = "SELECT * FROM NhaNghi";
$result = $conn->query($sql);

// Kiểm tra kết quả truy vấn
if ($result->num_rows > 0) {
    echo "<h2>Danh sách Nhà Nghỉ</h2>";
    echo "<div class='checkbox-container'>";
    echo "<input type='checkbox' class='checkbox' id='phongCheckbox' onclick='handleCheckboxChange(this)'>";
    echo "<label for='phongCheckbox'>Chọn phòng để đặt</label>";
    echo "</div>";
    echo "<div id='phongTo'>";
    echo "<img src='' alt='Ảnh phòng' id='phongToImg' style='width: 80%; height: 80%;'>";
    echo "<button onclick='closePhongTo()'>Đóng</button>";
    echo "</div>";
    echo "<div id='overlay' onclick='closePhongTo()'></div>";
    echo "<table border='1'>";
    echo "<tr><th>ID Nhà Nghỉ</th><th>Tên Nhà Nghỉ</th><th>Địa chỉ</th><th>Số điện thoại</th><th>Ảnh</th><th>Giá phòng</th>";

    // Hiển thị tiêu đề nút
    if ($isAdmin) {
        echo "<th>Chức năng</th>";
    }

    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['NhaNghiID']}</td>";
        echo "<td>{$row['TenNhaNghi']}</td>";
        echo "<td>{$row['DiaChi']}</td>";
        echo "<td>{$row['SoDienThoai']}</td>";
        echo "<td><img src='{$row['Anh']}' alt='Ảnh Nhà Nghỉ' style='width:100px;height:100px;' onclick='phongTo(\"{$row['Anh']}\")'></td>";
        echo "<td>{$row['GiaPhong']}</td>";

        // Hiển thị ô tích và nút Đặt Phòng nếu là người dùng
        if (!$isAdmin) {
            echo "<td class='checkbox-container'>";
            echo "<input type='checkbox' class='checkbox' id='phongCheckbox_{$row['NhaNghiID']}' name='phongCheckbox[]' value='{$row['NhaNghiID']}'>";
            echo "</td>";
            echo "<td>";
            echo "<button class='dat-phong-button' onclick='chuyenTrangDatPhong()'>Đặt Phòng</button>";
            echo "</td>";
        }

        // Hiển thị nút sửa và xóa nếu là admin
        if ($isAdmin) {
            echo "<td>";
            echo "<a href='sua.php?id={$row['NhaNghiID']}'>Sửa</a> | ";
            echo "<a href='xoa.php?id={$row['NhaNghiID']}'>Xóa</a>";
            echo "</td>";
        }

        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Không có nhà nghỉ nào được tìm thấy.";
}

$conn->close();
?>

<script>
    // JavaScript để xử lý phóng to ảnh
    function phongTo(anh) {
        document.getElementById('phongToImg').src = anh;
        document.getElementById('phongTo').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
    }

    function closePhongTo() {
        document.getElementById('phongTo').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }

    // JavaScript để xử lý ô tích và nút Đặt Phòng
    function handleCheckboxChange(checkbox) {
        var phongCheckboxes = document.getElementsByName('phongCheckbox[]');
        for (var i = 0; i < phongCheckboxes.length; i++) {
            phongCheckboxes[i].checked = checkbox.checked;
        }
    }

    function chuyenTrangDatPhong() {
        var phongCheckboxes = document.getElementsByName('phongCheckbox[]');
        var selectedPhongIDs = [];
        for (var i = 0; i < phongCheckboxes.length; i++) {
            if (phongCheckboxes[i].checked) {
                selectedPhongIDs.push(phongCheckboxes[i].value);
            }
        }
        if (selectedPhongIDs.length > 0) {
            // Chuyển hướng đến trang DatPhong.php với danh sách ID phòng được chọn
            window.location.href = 'DatPhong.php?phongIDs=' + selectedPhongIDs.join(',');
        } else {
            alert('Vui lòng chọn ít nhất một phòng để đặt.');
        }
    }
</script>
<h1><a href='DatPhongOnline.php'>Quay lại trang chủ </a></h1>
</body>
</html>
