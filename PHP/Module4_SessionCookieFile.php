<?php


// ============================================
// BÀI 1: SỬ DỤNG INCLUDE()/REQUIRE() ĐỂ XUẤT NGÀY THÁNG
// ============================================
echo "<h2>BÀI 1: SỬ DỤNG INCLUDE()/REQUIRE() ĐỂ XUẤT NGÀY THÁNG</h2>";
echo "<hr>";

echo "<h3>File: hayphp.inc</h3>";
echo "<pre>";
echo htmlspecialchars('<?php
function xuatNgayThang($format) {
    $date = date("Y/m/d");
    switch ($format) {
        case 1:
            return date("Y/m/d");
        case 2:
            return date("m.d.Y");
        case 3:
            return date("d-m-Y");
        default:
            return date("Y/m/d");
    }
}
?>');
echo "</pre>";

echo "<h3>File: dateFormat.php</h3>";
echo "<pre>";
echo htmlspecialchars('<!DOCTYPE html>
<html>
<head>
    <title>Xuất ngày tháng</title>
</head>
<body>
    <h1>Xuất ngày tháng hiện tại</h1>
    <?php
    require("hayphp.inc");
    
    echo "<p>Định dạng 1: " . xuatNgayThang(1) . "</p>";
    echo "<p>Định dạng 2: " . xuatNgayThang(2) . "</p>";
    echo "<p>Định dạng 3: " . xuatNgayThang(3) . "</p>";
    ?>
</body>
</html>');
echo "</pre>";

echo "<br><br>";

// ============================================
// BÀI 2: UPLOAD FILE VỚI RÀNG BUỘC
// ============================================
echo "<h2>BÀI 2: UPLOAD FILE VỚI RÀNG BUỘC</h2>";
echo "<hr>";

echo "<h3>File: uploadFile.php</h3>";
echo "<pre>";
echo htmlspecialchars('<!DOCTYPE html>
<html>
<head>
    <title>Upload File</title>
</head>
<body>
    <h1>Upload dữ liệu lên thư mục DATA</h1>
    <p><strong>Yêu cầu:</strong> Chỉ upload file hình ảnh và có dung lượng < 1MB</p>
    
    <form action="uploadFile.php" method="POST" enctype="multipart/form-data">
        <label>Chọn file:</label>
        <input type="file" name="file" accept="image/*" required><br><br>
        <input type="submit" name="upload" value="Upload">
    </form>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["upload"])) {
        $targetDir = "DATA/";
        
        // Tạo thư mục DATA nếu chưa tồn tại
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
            $fileName = $_FILES["file"]["name"];
            $fileSize = $_FILES["file"]["size"];
            $fileTmp = $_FILES["file"]["tmp_name"];
            $fileType = $_FILES["file"]["type"];
            
            // Kiểm tra dung lượng (< 1MB = 1048576 bytes)
            if ($fileSize > 1048576) {
                echo "<p style=\"color: red;\">Lỗi: File có dung lượng lớn hơn 1MB!</p>";
            } else {
                // Kiểm tra file có phải là hình ảnh không
                $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowedTypes = array("jpg", "jpeg", "png", "gif", "bmp");
                
                if (in_array($imageFileType, $allowedTypes)) {
                    $targetFile = $targetDir . basename($fileName);
                    
                    if (move_uploaded_file($fileTmp, $targetFile)) {
                        echo "<p style=\"color: green;\">File đã được upload thành công!</p>";
                        echo "<p>Tên file: $fileName</p>";
                        echo "<p>Kích thước: " . round($fileSize / 1024, 2) . " KB</p>";
                        echo "<img src=\"$targetFile\" style=\"max-width: 500px; max-height: 500px;\">";
                    } else {
                        echo "<p style=\"color: red;\">Lỗi khi upload file.</p>";
                    }
                } else {
                    echo "<p style=\"color: red;\">Lỗi: Chỉ cho phép upload file hình ảnh!</p>";
                }
            }
        } else {
            echo "<p style=\"color: red;\">Lỗi: Không có file được chọn hoặc có lỗi xảy ra.</p>";
        }
    }
    ?>
</body>
</html>');
echo "</pre>";

echo "<br><br>";

// ============================================
// BÀI 3: LÀM VIỆC VỚI COOKIE
// ============================================
echo "<h2>BÀI 3: LÀM VIỆC VỚI COOKIE</h2>";
echo "<hr>";

echo "<h3>File: setCookie.php</h3>";
echo "<pre>";
echo htmlspecialchars('<?php
// Thiết lập cookie với tên là "ten_sinh_vien" và giá trị là họ tên đầy đủ
$tenSinhVien = "Nguyễn Văn A";
$cookieName = "ten_sinh_vien";
$cookieValue = $tenSinhVien;

// Thiết lập thời gian tồn tại là 1 giờ (3600 giây)
setcookie($cookieName, $cookieValue, time() + 3600, "/");

echo "<h1>Cookie đã được thiết lập</h1>";
echo "<p>Cookie \"$cookieName\" với giá trị \"$cookieValue\" đã được lưu.</p>";
echo "<p>Thời gian tồn tại: 1 giờ</p>";
echo "<a href=\"displayCookie.php\">Xem cookie</a>";
?>');
echo "</pre>";

echo "<h3>File: displayCookie.php</h3>";
echo "<pre>";
echo htmlspecialchars('<!DOCTYPE html>
<html>
<head>
    <title>Hiển thị Cookie</title>
</head>
<body>
    <h1>Hiển thị Cookie</h1>
    <?php
    $cookieName = "ten_sinh_vien";
    
    if (isset($_COOKIE[$cookieName])) {
        echo "<p><strong>Tên sinh viên:</strong> " . $_COOKIE[$cookieName] . "</p>";
    } else {
        echo "<p>Cookie không tồn tại hoặc đã hết hạn.</p>";
        echo "<a href=\"setCookie.php\">Thiết lập cookie</a>";
    }
    ?>
</body>
</html>');
echo "</pre>";

echo "<br><br>";

// ============================================
// BÀI 4: LÀM VIỆC VỚI SESSION (ĐĂNG NHẬP)
// ============================================
echo "<h2>BÀI 4: LÀM VIỆC VỚI SESSION (ĐĂNG NHẬP)</h2>";
echo "<hr>";

echo "<h3>File: sessionLogin.php</h3>";
echo "<pre>";
echo htmlspecialchars('<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
</head>
<body>
    <h1>Đăng nhập</h1>
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" required><br><br>
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Đăng nhập">
    </form>
    
    <?php
    session_start();
    
    $defaultUsername = "admin";
    $defaultPassword = "123456";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"] ?? "";
        $password = $_POST["password"] ?? "";
        
        if ($username == $defaultUsername && $password == $defaultPassword) {
            $_SESSION["logged_in"] = true;
            $_SESSION["username"] = $username;
            header("Location: sessionSuccess.php");
            exit();
        } else {
            echo "<p style=\"color: red;\">Đăng nhập không thành công. Vui lòng đăng nhập lại.</p>";
        }
    }
    ?>
</body>
</html>');
echo "</pre>";

echo "<h3>File: sessionSuccess.php</h3>";
echo "<pre>";
echo htmlspecialchars('<?php
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập, chuyển hướng về trang đăng nhập
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: sessionLogin.php");
    exit();
}

echo "<h1>Đăng nhập thành công!</h1>";
echo "<p>Chào mừng, " . $_SESSION["username"] . "!</p>";
echo "<a href=\"sessionLogout.php\">Đăng xuất</a>";
?>');
echo "</pre>";

echo "<h3>File: sessionLogout.php</h3>";
echo "<pre>";
echo htmlspecialchars('<?php
session_start();
session_destroy();
header("Location: sessionLogin.php");
exit();
?>');
echo "</pre>";

echo "<br><br>";

// ============================================
// BÀI 5: LÀM VIỆC VỚI FILE
// ============================================
echo "<h2>BÀI 5: LÀM VIỆC VỚI FILE</h2>";
echo "<hr>";

echo "<h3>File: writeFile.php</h3>";
echo "<pre>";
echo htmlspecialchars('<?php
// Ghi đoạn văn vào file filetext.txt
$poem = "Why is my verse so barren of new pride,
So far from variation or quick change?
Why with the time do I not glance aside
To new-found methods, and to compounds strange?
Why write I still all one, ever the same,
And keep invention in a noted weed,
That every word doth almost tell my name,
Showing their birth, and where they did proceed?
O! know sweet love I always write of you,
And you and love are still my argument;
So all my best is dressing old words new,
Spending again what is already spent:
For as the sun is daily new and old,
So is my love still telling what is told.";

$file = fopen("filetext.txt", "w");
if ($file) {
    fwrite($file, $poem);
    fclose($file);
    echo "<h1>Đã ghi file thành công!</h1>";
    echo "<p>Nội dung đã được ghi vào filetext.txt</p>";
} else {
    echo "Lỗi: Không thể mở file để ghi.";
}
?>');
echo "</pre>";

echo "<h3>File: appendFile.php</h3>";
echo "<pre>";
echo htmlspecialchars('<?php
// Mở file và ghi thêm nội dung
$file = fopen("filetext.txt", "a");
if ($file) {
    fwrite($file, "\n\nFaculty of CSE");
    fclose($file);
    echo "<h1>Đã thêm nội dung vào file thành công!</h1>";
    echo "<p>Đã thêm \"Faculty of CSE\" vào filetext.txt</p>";
} else {
    echo "Lỗi: Không thể mở file để ghi thêm.";
}
?>');
echo "</pre>";

echo "<h3>File: readFile.php</h3>";
echo "<pre>";
echo htmlspecialchars('<!DOCTYPE html>
<html>
<head>
    <title>Đọc file</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .file-content {
            background-color: #f5f5f5;
            padding: 20px;
            border: 1px solid #ddd;
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
    <h1>Nội dung file filetext.txt</h1>
    <?php
    $fileName = "filetext.txt";
    
    if (file_exists($fileName)) {
        $content = file_get_contents($fileName);
        echo "<div class=\"file-content\">" . htmlspecialchars($content) . "</div>";
    } else {
        echo "<p>File không tồn tại.</p>";
    }
    ?>
</body>
</html>');
echo "</pre>";

echo "<br><br>";

// ============================================
// BÀI 6: ĐẾM SỐ LẦN TRUY CẬP WEBSITE
// ============================================
echo "<h2>BÀI 6: ĐẾM SỐ LẦN TRUY CẬP WEBSITE</h2>";
echo "<hr>";

echo "<h3>File: visitCounter.php</h3>";
echo "<pre>";
echo htmlspecialchars('<?php
function demSoLanTruyCap() {
    $counterFile = "visit_counter.txt";
    $count = 0;
    
    // Đọc số lần truy cập hiện tại từ file
    if (file_exists($counterFile)) {
        $count = (int)file_get_contents($counterFile);
    }
    
    // Tăng số lần truy cập
    $count++;
    
    // Ghi lại vào file
    file_put_contents($counterFile, $count);
    
    return $count;
}

// Gọi hàm đếm số lần truy cập
$visitCount = demSoLanTruyCap();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Đếm số lần truy cập</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .counter {
            font-size: 48px;
            color: #009879;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Website Visit Counter</h1>
    <p>Số lần truy cập:</p>
    <div class="counter"><?php echo $visitCount; ?></div>
    <p>Kết quả được lưu trong file visit_counter.txt</p>
</body>
</html>');
echo "</pre>";

?>

