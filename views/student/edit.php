<?php include 'app/views/shares/header.php'; ?>
<h1>Sửa sản phẩm</h1>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="POST" action="/webdangkyhocphan/student/update" enctype="multipart/form-data" onsubmit="return validateForm();">
    <input type="hidden" name="MaSV" value="<?php echo $student->MaSV; ?>">
    <div class="form-group">
        <label for="HoTen">Tên sinh viên:</label>
        <input type="text" id="HoTen" name="HoTen" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="GioiTinh">Giới tính:</label>
        <select name="GioiTinh" id="GioiTinh" class="form-control">
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
        </select>
    </div>
    <div class="form-group">
        <label for="NgaySinh">Ngày sinh:</label>
        <input type="date" id="NgaySinh" name="NgaySinh" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="Hinh">Hình ảnh:</label>
        <input type="file" name="Hinh" multiple class="form-control" id="Hinh" required>
    </div>
    <div class="form-group">
        <label for="MaNganh">Ngành:</label>
        <select id="MaNganh" name="MaNganh" class="form-control" required>
            <?php foreach ($nganhHoc as $nganh): ?>
                <option value="<?php echo $nganh->MaNganh; ?>"><?php echo htmlspecialchars($nganh->TenNganh, ENT_QUOTES, 'UTF-8'); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
</form>
<a href="/webbanhang/Product/list" class="btn btn-secondary mt-2">Quay lại danh sách sản phẩm</a>
<?php include 'app/views/shares/footer.php'; ?>