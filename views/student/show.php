<?php include 'app/views/shares/header.php'; ?>

<h1>Thông tin sinh viên</h1>

<?php if (!empty($student) && is_object($student)): ?>
    <div class="card">
        <div class="card-body">
            <h2 class="card-title"><?php echo htmlspecialchars((string) $student->HoTen, ENT_QUOTES, 'UTF-8'); ?></h2>
            <p><strong>Mã sinh viên:</strong> <?php echo htmlspecialchars((string) $student->MaSV, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Giới tính:</strong> <?php echo htmlspecialchars((string) $student->GioiTinh, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Ngày sinh:</strong> <?php echo htmlspecialchars((string) $student->NgaySinh, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Ngành học:</strong> <?php echo htmlspecialchars((string) $TenNganh, ENT_QUOTES, 'UTF-8'); ?></p>

            <p><strong>Hình ảnh:</strong></p>
            <img width="50%" src="<?php echo htmlspecialchars((string) $student->Hinh, ENT_QUOTES, 'UTF-8'); ?>"
                alt="<?php echo htmlspecialchars((string) $student->HoTen, ENT_QUOTES, 'UTF-8'); ?>">

            <a href="/webdangkyhocphan/student/list" class="btn btn-secondary mt-3">Quay lại danh sách</a>
        </div>
    </div>
<?php else: ?>
    <p class="alert alert-warning">Không tìm thấy sinh viên hoặc dữ liệu bị lỗi!</p>
    <a href="/webdangkyhocphan/student/list" class="btn btn-secondary mt-3">Quay lại danh sách</a>
<?php endif; ?>

<?php include 'app/views/shares/footer.php'; ?>