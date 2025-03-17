<?php
include '../config/database.php';
session_start();

if (!isset($_SESSION['MaSV'])) {
    header("Location: ../login.php");
    exit();
}

$MaSV = $_SESSION['MaSV'];
$MaHP = $_GET['MaHP'];
$NgayDK = date('Y-m-d');

// Kiểm tra xem sinh viên đã có đăng ký chưa
$check_sql = "SELECT MaDK FROM DangKy WHERE MaSV='$MaSV'";
$check_result = $conn->query($check_sql);

if ($check_result->num_rows > 0) {
    // Lấy mã đăng ký hiện tại của sinh viên
    $row = $check_result->fetch_assoc();
    $MaDK = $row['MaDK'];
} else {
    // Tạo mới đăng ký cho sinh viên
    $insert_dk = "INSERT INTO DangKy (NgayDK, MaSV) VALUES ('$NgayDK', '$MaSV')";
    if ($conn->query($insert_dk) === TRUE) {
        $MaDK = $conn->insert_id; // Lấy ID mới tạo
    } else {
        echo "<p class='error'>Lỗi đăng ký: " . $conn->error . "</p>";
        exit();
    }
}

// Kiểm tra xem học phần đã được đăng ký chưa
$check_hp = "SELECT * FROM ChiTietDangKy WHERE MaDK='$MaDK' AND MaHP='$MaHP'";
$result_hp = $conn->query($check_hp);

if ($result_hp->num_rows > 0) {
    echo "<script>alert('Học phần này đã được đăng ký!'); window.location='giohang.php';</script>";
    exit();
}

// Thêm học phần vào giỏ hàng
$sql = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES ('$MaDK', '$MaHP')";
if ($conn->query($sql) === TRUE) {
    header("Location: giohang.php");
    exit();
} else {
    echo "<p class='error'>Lỗi đăng ký học phần: " . $conn->error . "</p>";
}
