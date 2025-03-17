<?php include 'app/views/shares/header.php'; ?>

<h2>Đăng Nhập Sinh Viên</h2>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

<form method="POST" action="/webdangkyhocphan/auth/checkLogin">
    <div class="form-group">
        <label for="MaSV">Mã sinh viên:</label>
        <input type="text" id="MaSV" name="MaSV" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Đăng nhập</button>
</form>

<?php include 'app/views/shares/footer.php'; ?>