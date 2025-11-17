<?php


// ============================================
// BÀI 1: XUẤT THÔNG TIN SINH VIÊN
// ============================================
echo "<h2>BÀI 1: XUẤT THÔNG TIN SINH VIÊN</h2>";
echo "<hr>";

$hoTen = "Nguyễn Văn A";
$ngaySinh = "15/05/2000";
$lop = "CNTT2020";

echo "<h3>Thông tin sinh viên:</h3>";
echo "<p><strong>Họ và tên:</strong> $hoTen</p>";
echo "<p><strong>Ngày tháng năm sinh:</strong> $ngaySinh</p>";
echo "<p><strong>Lớp:</strong> $lop</p>";

echo "<br><br>";

// ============================================
// BÀI 2: THỰC HIỆN CÁC PHÉP TÍNH
// ============================================
echo "<h2>BÀI 2: THỰC HIỆN CÁC PHÉP TÍNH</h2>";
echo "<hr>";

$x = 3;
$y = 5;

echo "<h3>Với x = $x và y = $y:</h3>";
echo "<p>$x + $y = " . ($x + $y) . "</p>";
echo "<p>$x - $y = " . ($x - $y) . "</p>";
echo "<p>$x * $y = " . ($x * $y) . "</p>";
echo "<p>$x / $y = " . ($x / $y) . "</p>";

echo "<br><br>";

// ============================================
// BÀI 3: XỬ LÝ MẢNG VỚI CÁC HÀM
// ============================================
echo "<h2>BÀI 3: XỬ LÝ MẢNG VỚI CÁC HÀM</h2>";
echo "<hr>";

// Hàm nhập mảng với n phần tử ngẫu nhiên
function nhapMang($n) {
    $mang = array();
    for ($i = 0; $i < $n; $i++) {
        $mang[] = rand(1, 100); // Tạo số ngẫu nhiên từ 1 đến 100
    }
    return $mang;
}

// Hàm xuất mảng lên trang Web
function xuatMang($mang) {
    echo "<p><strong>Mảng:</strong> ";
    echo implode(", ", $mang);
    echo "</p>";
}

// Hàm đếm tổng số chẵn
function demTongSoChan($mang) {
    $tong = 0;
    foreach ($mang as $giaTri) {
        if ($giaTri % 2 == 0) {
            $tong += $giaTri;
        }
    }
    return $tong;
}

// Hàm đếm tổng số lẻ
function demTongSoLe($mang) {
    $tong = 0;
    foreach ($mang as $giaTri) {
        if ($giaTri % 2 != 0) {
            $tong += $giaTri;
        }
    }
    return $tong;
}

// Hàm xuất giá trị lớn nhất và nhỏ nhất
function xuatMaxMin($mang) {
    $max = max($mang);
    $min = min($mang);
    echo "<p><strong>Giá trị lớn nhất:</strong> $max</p>";
    echo "<p><strong>Giá trị nhỏ nhất:</strong> $min</p>";
}

// Hàm xuất đảo ngược mảng
function xuatDaoNguoc($mang) {
    $mangDaoNguoc = array_reverse($mang);
    echo "<p><strong>Mảng đảo ngược:</strong> ";
    echo implode(", ", $mangDaoNguoc);
    echo "</p>";
}

// Thực hiện các hàm với mảng mẫu
$n = 10;
$mang = nhapMang($n);

echo "<h3>Mảng có $n phần tử:</h3>";
xuatMang($mang);
echo "<p><strong>Tổng các số chẵn:</strong> " . demTongSoChan($mang) . "</p>";
echo "<p><strong>Tổng các số lẻ:</strong> " . demTongSoLe($mang) . "</p>";
xuatMaxMin($mang);
xuatDaoNguoc($mang);

echo "<br><br>";

// ============================================
// BÀI 4: SỬ DỤNG FOREACH ĐỂ DUYỆT MẢNG
// ============================================
echo "<h2>BÀI 4: SỬ DỤNG FOREACH ĐỂ DUYỆT MẢNG</h2>";
echo "<hr>";

$list = array("alpha", "beta", "gamma", "delta", "epsilon");

echo "<h3>Duyệt mảng bằng foreach:</h3>";
echo "<ul>";
foreach ($list as $giaTri) {
    echo "<li>$giaTri</li>";
}
echo "</ul>";

?>

