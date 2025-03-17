<?php include 'app/views/shares/header.php'; ?>

<h2>DANH SÁCH HỌC PHẦN</h2>
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
                <a href="app/controllers/StudentController.php?action=register&MaHP=<?= $row['MaHP'] ?>" class="btn btn-success">Đăng Ký</a>
            </td>
        </tr>
    <?php } ?>
</table>

<?php include 'app/views/shares/footer.php'; ?>