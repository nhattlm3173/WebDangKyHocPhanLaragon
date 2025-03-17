<?php include 'app/views/shares/header.php'; ?>

<h2>DANH SÁCH HỌC PHẦN</h2>
<table>
    <tr>
        <th>Mã HP</th>
        <th>Tên Học Phần</th>
        <th>Số Tín Chỉ</th>
        <th>Hành động</th>
    </tr>
    <?php foreach ($result as $course) { ?>
        <tr>
            <td><?= htmlspecialchars($course['MaHP']) ?></td>
            <td><?= htmlspecialchars($course['TenHP']) ?></td>
            <td><?= htmlspecialchars($course['SoTinChi']) ?></td>
            <td>
                <a href="app/controllers/StudentController.php?action=register&MaHP=<?= $course['MaHP'] ?>" class="btn btn-success">Đăng Ký</a>
            </td>
        </tr>
    <?php } ?>
</table>

<?php include 'app/views/shares/footer.php'; ?>