từ file đó qua bên dưới đây
<?php
include '../config/database.php';
session_start();

if (!isset($_SESSION['MaSV'])) {
    header("Location: ../login.php");
    exit();
}

$MaSV = $_SESSION['MaSV'];

// Truy vấn danh sách học phần đã đăng ký
$sql = "SELECT HocPhan.MaHP, HocPhan.TenHP, HocPhan.SoTinChi, ChiTietDangKy.MaDK 
        FROM ChiTietDangKy 
        JOIN DangKy ON ChiTietDangKy.MaDK = DangKy.MaDK 
        JOIN HocPhan ON ChiTietDangKy.MaHP = HocPhan.MaHP 
        WHERE DangKy.MaSV = '$MaSV'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Học Phần</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            margin-top: 20px;
        }

        .container {
            width: 80%;
            margin: auto;
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background: white;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background: #007BFF;
            color: white;
        }

        .btn {
            padding: 8px 12px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            font-size: 14px;
            display: inline-block;
            margin: 5px;
        }

        .btn-red {
            background: #dc3545;
        }

        .btn-red:hover {
            background: #c82333;
        }
    </style>
</head>

<body>
    <div class="container">
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
                        <a href="xoahp.php?MaDK=<?= $row['MaDK'] ?>&MaHP=<?= $row['MaHP'] ?>" class="btn btn-red">Xóa</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <br>
        <a href="xoatatca.php" class="btn btn-red">Xóa Tất Cả</a>
        <a href="../index.php" class="btn btn-red">Quay lại</a>
    </div>
</body>

</html>