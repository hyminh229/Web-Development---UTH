<?php


// ============================================
// BÀI 1: TRANG WHATSNAME.PHP
// ============================================
echo "<h2>BÀI 1: TRANG WHATSNAME.PHP</h2>";
echo "<hr>";
echo "<h3>File: whatsName.php</h3>";
echo "<pre>";
echo htmlspecialchars('<?php
$list = array("alpha", "beta", "gamma", "delta", "epsilon");
echo "<h1>Forreach Demo</h1>";
echo "<ul>";
foreach ($list as $value) {
    echo "<li>$value</li>";
}
echo "</ul>";
?>');
echo "</pre>";

echo "<br><br>";

// ============================================
// BÀI 1B: FORM NHẬP TÊN VÀ HIỂN THỊ LỜI CHÀO
// ============================================
echo "<h2>BÀI 1B: FORM NHẬP TÊN VÀ HIỂN THỊ LỜI CHÀO</h2>";
echo "<hr>";

echo "<h3>File: whatsName.html</h3>";
echo "<pre>";
echo htmlspecialchars('<!DOCTYPE html>
<html>
<head>
    <title>What\'s your name?</title>
</head>
<body>
    <h1>What\'s your name?</h1>
    <p>Writing a form for user input</p>
    <form action="hiUser.php" method="GET">
        <label>Please type your name:</label>
        <input type="text" name="whatsName" value="Matthew">
        <input type="submit" value="Submit Query">
    </form>
</body>
</html>');
echo "</pre>";

echo "<h3>File: hiUser.php</h3>";
echo "<pre>";
echo htmlspecialchars('<?php
echo "<h1>Hi User</h1>";
echo "<p>PHP program that receives a value from \"whatsName\"</p>";
$userName = $_REQUEST["whatsName"] ?? $_GET["whatsName"] ?? "";
echo "<p>Hi there, $userName!</p>";
?>');
echo "</pre>";

echo "<br><br>";

// ============================================
// BÀI 2: TRANG ĐĂNG NHẬP
// ============================================
echo "<h2>BÀI 2: TRANG ĐĂNG NHẬP</h2>";
echo "<hr>";

echo "<h3>File: login.php</h3>";
echo "<pre>";
echo htmlspecialchars('<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Đăng nhập</h1>
    <form action="dologin.php" method="POST">
        <label>User Name:</label>
        <input type="text" name="userName" required><br><br>
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        <input type="button" value="Hủy" onclick="window.location.href=\'login.php\'">
        <input type="submit" value="Đăng nhập">
    </form>
</body>
</html>');
echo "</pre>";

echo "<h3>File: dologin.php</h3>";
echo "<pre>";
echo htmlspecialchars('<?php
$defaultUserName = "admin";
$defaultPassword = "123456";

$userName = $_POST["userName"] ?? "";
$password = $_POST["password"] ?? "";

if ($userName == $defaultUserName && $password == $defaultPassword) {
    echo "<h1>Welcome Admin!</h1>";
} else {
    echo "<h1>You are not Admin!</h1>";
    echo "<a href=\"login.php\">Quay lại trang đăng nhập</a>";
}
?>');
echo "</pre>";

echo "<br><br>";

// ============================================
// BÀI 3: MÁY TÍNH VỚI FORM
// ============================================
echo "<h2>BÀI 3: MÁY TÍNH VỚI FORM</h2>";
echo "<hr>";

echo "<h3>File: input.php</h3>";
echo "<pre>";
echo htmlspecialchars('<!DOCTYPE html>
<html>
<head>
    <title>Calculator</title>
</head>
<body>
    <h1>Máy tính</h1>
    <form action="process.php" method="POST">
        <label>a = </label>
        <input type="number" name="a" step="any" required>
        <label>b = </label>
        <input type="number" name="b" step="any" required><br><br>
        
        <input type="submit" name="operation" value="+">
        <input type="submit" name="operation" value="-">
        <input type="submit" name="operation" value="*">
        <input type="submit" name="operation" value="/">
    </form>
    
    <?php
    if (isset($_GET["result"])) {
        echo "<p><strong>Kết quả:</strong> " . $_GET["result"] . "</p>";
    }
    ?>
</body>
</html>');
echo "</pre>";

echo "<h3>File: process.php</h3>";
echo "<pre>";
echo htmlspecialchars('<?php
$a = $_POST["a"] ?? 0;
$b = $_POST["b"] ?? 0;
$operation = $_POST["operation"] ?? "";

function cong($a, $b) {
    return $a + $b;
}

function tru($a, $b) {
    return $a - $b;
}

function nhan($a, $b) {
    return $a * $b;
}

function chia($a, $b) {
    if ($b == 0) {
        return "Không thể chia cho 0";
    }
    return $a / $b;
}

$result = "";
switch ($operation) {
    case "+":
        $result = "$a+$b=" . cong($a, $b);
        break;
    case "-":
        $result = "$a-$b=" . tru($a, $b);
        break;
    case "*":
        $result = "$a*$b=" . nhan($a, $b);
        break;
    case "/":
        $result = "$a/$b=" . chia($a, $b);
        break;
}

header("Location: input.php?result=" . urlencode($result));
exit();
?>');
echo "</pre>";

echo "<br><br>";

// ============================================
// BÀI 4: TÍNH TỔNG DÃY SỐ 1+2+3+...+N
// ============================================
echo "<h2>BÀI 4: TÍNH TỔNG DÃY SỐ 1+2+3+...+N</h2>";
echo "<hr>";

echo "<h3>File: sumSeries.php</h3>";
echo "<pre>";
echo htmlspecialchars('<!DOCTYPE html>
<html>
<head>
    <title>Tính tổng dãy số</title>
</head>
<body>
    <h1>Tính tổng dãy số 1+2+3+...+n</h1>
    <form method="POST">
        <label>Nhập n:</label>
        <input type="number" name="n" min="1" required>
        <input type="submit" value="Tính">
    </form>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $n = $_POST["n"] ?? 0;
        $tong = 0;
        for ($i = 1; $i <= $n; $i++) {
            $tong += $i;
        }
        echo "<h2>Kết quả:</h2>";
        echo "<p>Tổng từ 1 đến $n = $tong</p>";
    }
    ?>
</body>
</html>');
echo "</pre>";

echo "<br><br>";

// ============================================
// BÀI 5: TÍNH GIAI THỪA
// ============================================
echo "<h2>BÀI 5: TÍNH GIAI THỪA</h2>";
echo "<hr>";

echo "<h3>File: factorial.php</h3>";
echo "<pre>";
echo htmlspecialchars('<!DOCTYPE html>
<html>
<head>
    <title>Tính giai thừa</title>
</head>
<body>
    <h1>Tính giai thừa của một số</h1>
    <form method="POST">
        <label>Nhập số n:</label>
        <input type="number" name="n" min="0" required>
        <input type="submit" value="Tính">
    </form>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $n = $_POST["n"] ?? 0;
        
        function tinhGiaiThua($n) {
            if ($n == 0 || $n == 1) {
                return 1;
            }
            $giaiThua = 1;
            for ($i = 2; $i <= $n; $i++) {
                $giaiThua *= $i;
            }
            return $giaiThua;
        }
        
        $ketQua = tinhGiaiThua($n);
        echo "<h2>Kết quả:</h2>";
        echo "<p>$n! = $ketQua</p>";
    }
    ?>
</body>
</html>');
echo "</pre>";

?>

