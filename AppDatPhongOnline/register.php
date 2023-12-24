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

// Xử lý đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $new_email = $_POST["new_email"];
    $new_password = $_POST["new_password"];

    // Kiểm tra xem email đã tồn tại chưa
    $check_email_sql = "SELECT * FROM Taikhoan WHERE Email = '$new_email'";
    $check_email_result = $conn->query($check_email_sql);

    if ($check_email_result->num_rows > 0) {
        $register_error = "Email đã tồn tại. Vui lòng chọn email khác.";
    } else {
        // Thêm tài khoản mới vào cơ sở dữ liệu
        $insert_sql = "INSERT INTO Taikhoan (Email, MatKhau) VALUES ('$new_email', '$new_password')";
        if ($conn->query($insert_sql) === TRUE) {
            $register_success = "Đăng ký thành công. Bạn có thể đăng nhập ngay bây giờ.";
        } else {
            $register_error = "Đã có lỗi xảy ra. Vui lòng thử lại.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
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
    <h2>Đăng ký tài khoản mới</h2>
    <form method="post" action="">
        <label for="new_email">Email:</label>
        <input type="email" name="new_email" required><br>

        <label for="new_password">Mật khẩu:</label>
        <input type="password" name="new_password" required><br>

        <button type="submit" name="register">Đăng ký</button>
    </form>

    <?php
    if (isset($register_error)) {
        echo "<div class='error'>$register_error</div>";
    }

    if (isset($register_success)) {
        echo "<div class='success'>$register_success</div>";
   }
?>
<h3><a href="login.php">Quay lại</a></h3>
<h4>Bỏ qua<a href="XemPhong.php">Xem phòng</a></h4>
</body>
</html>