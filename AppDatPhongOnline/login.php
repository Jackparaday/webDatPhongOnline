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

// Xử lý đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM Taikhoan WHERE Email = '$email' AND MatKhau = '$password'";
    $result = $conn->query($sql);
    
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    // Lưu các thông tin cần thiết vào session
    $_SESSION['loggedin'] = true;
    $_SESSION['email'] = $email;
    $_SESSION['quyenTruyCap'] = $row['QuyenTruyCap']; // Lấy giá trị quyền truy cập từ cơ sở dữ liệu


        header("Location: XemPhong.php"); // Chuyển hướng đến trang chào mừng
    } else {
        $login_error = "Đăng nhập không thành công. Vui lòng kiểm tra email và mật khẩu.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-bottom: 10px;
        }

        input {
            padding: 10px;
            margin-bottom: 15px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            color: #fff;
            background-color: #3498db;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }

        .success {
            color: green;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Đăng nhập</h2>
    <form method="post" action="">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" required><br>

        <button type="submit" name="login">Đăng nhập</button>
    </form>

    <?php
    if (isset($login_error)) {
        echo "<div class='error'>$login_error</div>";
    }
    ?>
<h3>Chưa có tài khoản? <a href="register.php">Đăng ký ngay!</a></h3>
<h4>Bỏ qua<a href="XemPhong.php"> Xem phòng</a></h4>

</body>
</html>
