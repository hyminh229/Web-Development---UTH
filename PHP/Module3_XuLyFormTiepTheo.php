<?php


// ============================================
// BÀI 1: TRUYỀN DỮ LIỆU KHÔNG QUA FORM
// ============================================
echo "<h2>BÀI 1: TRUYỀN DỮ LIỆU KHÔNG QUA FORM</h2>";
echo "<hr>";

echo "<h3>File: linkDemo.php</h3>";
echo "<pre>";
echo htmlspecialchars('<!DOCTYPE html>
<html>
<head>
    <title>Link Demo</title>
</head>
<body>
    <h1>Link Demo</h1>
    <ul>
        <li><a href="auther.php?author=Elizabeth">To Elizabeth</a></li>
        <li><a href="auther.php?author=Lynda">To Lynda</a></li>
        <li><a href="auther.php?author=Andy">To Andy</a></li>
    </ul>
</body>
</html>');
echo "</pre>";

echo "<h3>File: auther.php</h3>";
echo "<pre>";
echo htmlspecialchars('<?php
$author = $_GET["author"] ?? "";
echo "<h1>Hi Author</h1>";
echo "<p>PHP program that receives a value from link</p>";
if ($author) {
    echo "<p>Hi there, $author!</p>";
} else {
    echo "<p>No author name provided.</p>";
}
?>');
echo "</pre>";

echo "<br><br>";

// ============================================
// BÀI 2: XUẤT BẢNG VỚI HÀNG ĐƯỢC NHẬP TỪ FORM
// ============================================
echo "<h2>BÀI 2: XUẤT BẢNG VỚI HÀNG ĐƯỢC NHẬP TỪ FORM</h2>";
echo "<hr>";

echo "<h3>File: tableForm.php</h3>";
echo "<pre>";
echo htmlspecialchars('<!DOCTYPE html>
<html>
<head>
    <title>Nhập thông tin bảng</title>
    <style>
        .styled-table {
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            font-family: sans-serif;
            min-width: 400px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }
        .styled-table thead tr {
            background-color: #009879;
            color: #ffffff;
            text-align: left;
        }
        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
        }
        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }
        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }
        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }
    </style>
</head>
<body>
    <h1>Nhập thông tin CPU</h1>
    <form method="POST">
        <label>Số hàng:</label>
        <input type="number" name="rows" min="1" max="10" value="3" required><br><br>
        <input type="submit" value="Tạo form nhập liệu">
    </form>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST["submit_data"])) {
        $rows = $_POST["rows"] ?? 3;
        echo "<h2>Nhập thông tin cho $rows hàng:</h2>";
        echo "<form method=\"POST\">";
        echo "<input type=\"hidden\" name=\"rows\" value=\"$rows\">";
        for ($i = 1; $i <= $rows; $i++) {
            echo "<h3>Hàng $i:</h3>";
            echo "<label>Loại CPU:</label>";
            echo "<input type=\"text\" name=\"cpu_type[]\" required><br>";
            echo "<label>Thông số kỹ thuật:</label>";
            echo "<input type=\"text\" name=\"specs[]\" required><br>";
            echo "<label>Giá thành:</label>";
            echo "<input type=\"text\" name=\"price[]\" required><br><br>";
        }
        echo "<input type=\"submit\" name=\"submit_data\" value=\"Xuất bảng\">";
        echo "</form>";
    }
    
    if (isset($_POST["submit_data"])) {
        $rows = $_POST["rows"] ?? 0;
        $cpuTypes = $_POST["cpu_type"] ?? [];
        $specs = $_POST["specs"] ?? [];
        $prices = $_POST["price"] ?? [];
        
        echo "<h2>Bảng thông tin CPU:</h2>";
        echo "<table class=\"styled-table\">";
        echo "<thead><tr><th>STT</th><th>Loại CPU</th><th>Thông số kỹ thuật</th><th>Giá thành</th></tr></thead>";
        echo "<tbody>";
        for ($i = 0; $i < $rows; $i++) {
            echo "<tr>";
            echo "<td>" . ($i + 1) . "</td>";
            echo "<td>" . htmlspecialchars($cpuTypes[$i] ?? "") . "</td>";
            echo "<td>" . htmlspecialchars($specs[$i] ?? "") . "</td>";
            echo "<td>" . htmlspecialchars($prices[$i] ?? "") . "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    }
    ?>
</body>
</html>');
echo "</pre>";

echo "<br><br>";

// ============================================
// BÀI 3: UPLOAD VÀ RESIZE HÌNH ẢNH
// ============================================
echo "<h2>BÀI 3: UPLOAD VÀ RESIZE HÌNH ẢNH</h2>";
echo "<hr>";

echo "<h3>File: img.php</h3>";
echo "<pre>";
echo htmlspecialchars('<!DOCTYPE html>
<html>
<head>
    <title>Upload và chọn kích thước hình ảnh</title>
</head>
<body>
    <h1>Upload hình ảnh</h1>
    <form action="showimg.php" method="POST" enctype="multipart/form-data">
        <label>Chọn hình ảnh:</label>
        <input type="file" name="image" accept="image/*" required><br><br>
        
        <label>Chọn kích thước:</label>
        <select name="size" required>
            <option value="200">200x200</option>
            <option value="300">300x300</option>
            <option value="400">400x400</option>
        </select><br><br>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>');
echo "</pre>";

echo "<h3>File: showimg.php</h3>";
echo "<pre>";
echo htmlspecialchars('<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $size = $_POST["size"] ?? 200;
        $targetDir = "uploads/";
        
        // Tạo thư mục nếu chưa tồn tại
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        $fileName = basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $fileName;
        
        // Kiểm tra file có phải là hình ảnh không
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = array("jpg", "jpeg", "png", "gif");
        
        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                echo "<h1>Hình ảnh đã được upload</h1>";
                echo "<p>Kích thước: {$size}x{$size} pixels</p>";
                echo "<img src=\"$targetFile\" style=\"width: {$size}px; height: {$size}px; object-fit: cover;\">";
            } else {
                echo "Lỗi khi upload file.";
            }
        } else {
            echo "Chỉ cho phép upload file hình ảnh (JPG, JPEG, PNG, GIF).";
        }
    } else {
        echo "Không có file được upload hoặc có lỗi xảy ra.";
    }
}
?>');
echo "</pre>";

echo "<br><br>";

// ============================================
// BÀI 4: BORDER MAKER
// ============================================
echo "<h2>BÀI 4: BORDER MAKER</h2>";
echo "<hr>";

echo "<h3>File: borderMaker.php</h3>";
echo "<pre>";
echo htmlspecialchars('<!DOCTYPE html>
<html>
<head>
    <title>Border Maker</title>
</head>
<body>
    <h1>Border Maker</h1>
    <p>Demonstrates how to read HTML form elements</p>
    
    <form method="POST">
        <h3>Text to modify:</h3>
        <textarea name="text" rows="10" cols="50">Four score and seven years ago our fathers brought forth on this continent a new nation, conceived in liberty and dedicated to the proposition that all men are created equal. Now we are engaged in a great civil war, testing whether that nation or any nation so conceived and so dedicated can long endure.</textarea><br><br>
        
        <h3>Border style Border Size</h3>
        <label>Border Style:</label>
        <input type="text" name="border_style" value="ridge"><br><br>
        
        <label>Border Size:</label>
        <input type="number" name="border_size" value="10" min="1"><br><br>
        
        <label>Unit:</label>
        <input type="radio" name="unit" value="px" checked> pixels
        <input type="radio" name="unit" value="pt"> points
        <input type="radio" name="unit" value="cm"> centimeters
        <input type="radio" name="unit" value="in"> inches<br><br>
        
        <input type="submit" value="Submit">
    </form>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $text = $_POST["text"] ?? "";
        $borderStyle = $_POST["border_style"] ?? "ridge";
        $borderSize = $_POST["border_size"] ?? 10;
        $unit = $_POST["unit"] ?? "px";
        
        echo "<h1>Your Output</h1>";
        echo "<div style=\"border: {$borderSize}{$unit} {$borderStyle}; padding: 20px; text-align: center;\">";
        echo nl2br(htmlspecialchars($text));
        echo "</div>";
    }
    ?>
</body>
</html>');
echo "</pre>";

?>

