<?php include 'app/views/shares/header.php'; ?>

<h1>Danh sách sinh viên</h1>
<a href="/webdangkyhocphan/student/add" class="btn btn-success mb-2">Thêm sinh viên</a>
<ul class="list-group">
    <?php foreach ($students as $student): ?>
        <li class="list-group-item">

            <h2><?php echo htmlspecialchars($student->MaSV, ENT_QUOTES, 'UTF-8'); ?></h2>
            <h2><?php echo htmlspecialchars($student->HoTen, ENT_QUOTES, 'UTF-8'); ?></h2>
            <p>Giới tính: <?php echo htmlspecialchars($student->GioiTinh, ENT_QUOTES, 'UTF-8'); ?></p>
            <p>Ngày sinh: <?php echo htmlspecialchars($student->NgaySinh, ENT_QUOTES, 'UTF-8'); ?></p>
            <p>Hình ảnh:</p> <img width="50%" src="<?php echo htmlspecialchars($student->Hinh, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($student->HoTen, ENT_QUOTES, 'UTF-8'); ?>">
            <p>Ngành học: <?php echo htmlspecialchars($student->TenNganh, ENT_QUOTES, 'UTF-8'); ?></p>
            <a href="/webdangkyhocphan/student/edit/<?php echo $student->MaSV; ?>" class="btn btn-warning">Sửa</a>
            <a href="/webdangkyhocphan/student/delete/<?php echo $student->MaSV; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?');">Xóa</a>
            <a href="/webdangkyhocphan/student/show/<?php echo $student->MaSV; ?>" class="btn btn-danger">xem chi tiết</a>
        </li>
    <?php endforeach; ?>
</ul>

<?php include 'app/views/shares/footer.php'; ?>