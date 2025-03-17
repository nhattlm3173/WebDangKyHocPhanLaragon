<?php
include '../config/database.php';
session_start();

if (!isset($_SESSION['MaSV'])) {
    header("Location: ../login.php");
    exit();
}

$MaSV = $_SESSION['MaSV'];
$sql = "SELECT HocPhan.MaHP, HocPhan.TenHP, HocPhan.SoTinChi, ChiTietDangKy.MaDK 
        FROM ChiTietDangKy 
        JOIN DangKy ON ChiTietDangKy.MaDK = DangKy.MaDK 
        JOIN HocPhan ON ChiTietDangKy.MaHP = HocPhan.MaHP 
        WHERE DangKy.MaSV = '$MaSV'";
$result = $conn->query($sql);
?>

<h2>Học Phần Đã Đăng Ký</h2>
<table>
    <tr>
        <th>Mã HP</th>
        <th>Tên Học Phần</th>
        <th>Số Tín Chỉ</th>
        <th>Hành động</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['MaHP']) ?></td>
            <td><?= htmlspecialchars($row['TenHP']) ?></td>
            <td><?= htmlspecialchars($row['SoTinChi']) ?></td>
            <td>
                <a href="../controllers/StudentController.php?action=delete&MaDK=<?= $row['MaDK'] ?>&MaHP=<?= $row['MaHP'] ?>" class="btn btn-red">Xóa</a>
            </td>
        </tr>
    <?php } ?>
</table>
<a href="../controllers/StudentController.php?action=delete_all" class="btn btn-red">Xóa Tất Cả</a>
<a href="../index.php" class="btn btn-primary">Quay lại</a>