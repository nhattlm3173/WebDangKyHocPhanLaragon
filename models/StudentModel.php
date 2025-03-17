<?php
class StudentModel
{
    private $conn;
    private $table_name = "sinhvien";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getStudents()
    {
        $query = "SELECT p.MaSV, p.HoTen, p.GioiTinh, p.NgaySinh, p.Hinh, c.TenNganh as TenNganh 
                  FROM " . $this->table_name . " p
                  LEFT JOIN nganhhoc c ON p.MaNganh = c.MaNganh";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getStudentById($MaSV)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE MaSV = :MaSV";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':MaSV', $MaSV);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function addStudent($MaSV, $HoTen, $GioiTinh, $NgaySinh, $Hinh, $MaNganh)
    {
        $errors = [];
        if (empty($MaSV)) {
            $errors['MaSV'] = 'Mã sinh viên không được để trống';
        }
        if (empty($HoTen)) {
            $errors['HoTen'] = 'Họ tên không được để trống';
        }
        if (empty($GioiTinh)) {
            $errors['GioiTinh'] = 'Giới tính không được để trống';
        }
        if (empty($NgaySinh)) {
            $errors['NgaySinh'] = 'Ngày sinh không được để trống';
        }
        if (empty($Hinh) || $Hinh['error'] !== UPLOAD_ERR_OK) {
            $errors['Hinh'] = 'Vui lòng chọn file hợp lệ.';
        }
        if (count($errors) > 0) {
            return $errors;
        }

        $uploadDir = 'Content/images/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        $tmpName = $Hinh['tmp_name'];
        $name = $Hinh['name'];
        $type = $Hinh['type'];
        $size = $Hinh['size'];
        $error = $Hinh['error'];

        if ($error === UPLOAD_ERR_OK) {
            if (!in_array($type, $allowedTypes)) {
                $errors['Hinh'] = "File không hợp lệ!";
            } elseif ($size > $maxSize) {
                $errors['Hinh'] = "File quá lớn!";
            } else {
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $newName = time() . '_' . uniqid() . '.' . $ext;
                $destination = $uploadDir . $newName;

                if (move_uploaded_file($tmpName, $destination)) {
                    $query = "INSERT INTO " . $this->table_name . " (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) 
            VALUES (:MaSV, :HoTen, :GioiTinh, :NgaySinh, :Hinh, :MaNganh)";
                    $stmt = $this->conn->prepare($query);

                    $MaSV = htmlspecialchars(strip_tags($MaSV));
                    $HoTen = htmlspecialchars(strip_tags($HoTen));
                    $GioiTinh = htmlspecialchars(strip_tags($GioiTinh));
                    $NgaySinh = htmlspecialchars(strip_tags($NgaySinh));
                    $Hinh = htmlspecialchars(strip_tags($destination));
                    $MaNganh = htmlspecialchars(strip_tags($MaNganh));

                    $stmt->bindParam(':MaSV', $MaSV);
                    $stmt->bindParam(':HoTen', $HoTen);
                    $stmt->bindParam(':GioiTinh', $GioiTinh);
                    $stmt->bindParam(':NgaySinh', $NgaySinh);
                    $stmt->bindParam(':Hinh', $Hinh);
                    $stmt->bindParam(':MaNganh', $MaNganh);

                    if ($stmt->execute()) {
                        return true;
                    }
                    return false;
                } else {
                    $errors['Hinh'] = "Lỗi khi lưu file!";
                }
            }
        }
    }

    public function updateStudent($MaSV, $HoTen, $GioiTinh, $NgaySinh, $Hinh, $MaNganh)
    {
        $errors = [];
        if (empty($HoTen)) {
            $errors['HoTen'] = 'Họ tên không được để trống';
        }
        if (empty($GioiTinh)) {
            $errors['GioiTinh'] = 'Giới tính không được để trống';
        }
        if (empty($NgaySinh)) {
            $errors['NgaySinh'] = 'Ngày sinh không được để trống';
        }
        if (empty($Hinh) || $Hinh['error'] !== UPLOAD_ERR_OK) {
            $errors['Hinh'] = 'Vui lòng chọn file hợp lệ.';
        }
        if (count($errors) > 0) {
            return $errors;
        }

        $uploadDir = 'Content/images/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        $tmpName = $Hinh['tmp_name'];
        $name = $Hinh['name'];
        $type = $Hinh['type'];
        $size = $Hinh['size'];
        $error = $Hinh['error'];

        if ($error === UPLOAD_ERR_OK) {
            if (!in_array($type, $allowedTypes)) {
                $errors['Hinh'] = "File không hợp lệ!";
            } elseif ($size > $maxSize) {
                $errors['Hinh'] = "File quá lớn!";
            } else {
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $newName = time() . '_' . uniqid() . '.' . $ext;
                $destination = $uploadDir . $newName;

                if (move_uploaded_file($tmpName, $destination)) {
                    $query = "UPDATE " . $this->table_name . " 
                  SET HoTen=:HoTen, GioiTinh=:GioiTinh, NgaySinh=:NgaySinh, Hinh=:Hinh, MaNganh=:MaNganh 
                  WHERE MaSV=:MaSV";
                    $stmt = $this->conn->prepare($query);

                    $HoTen = htmlspecialchars(strip_tags($HoTen));
                    $GioiTinh = htmlspecialchars(strip_tags($GioiTinh));
                    $NgaySinh = htmlspecialchars(strip_tags($NgaySinh));
                    $Hinh = htmlspecialchars(strip_tags($destination));
                    $MaNganh = htmlspecialchars(strip_tags($MaNganh));

                    $stmt->bindParam(':HoTen', $HoTen);
                    $stmt->bindParam(':GioiTinh', $GioiTinh);
                    $stmt->bindParam(':NgaySinh', $NgaySinh);
                    $stmt->bindParam(':Hinh', $Hinh);
                    $stmt->bindParam(':MaNganh', $MaNganh);
                    $stmt->bindParam(':MaSV', $MaSV);

                    if ($stmt->execute()) {
                        return true;
                    }
                    return false;
                } else {
                    $errors['Hinh'] = "Lỗi khi lưu file!";
                }
            }
        }
    }

    public function deleteStudent($MaSV)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE MaSV=:MaSV";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':MaSV', $MaSV);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // Lấy danh sách học phần
    public function getAllCourses()
    {
        $sql = "SELECT * FROM HocPhan";
        return $this->conn->query($sql);
    }

    // Kiểm tra sinh viên đã có mã đăng ký chưa, nếu chưa thì tạo mới
    public function getOrCreateMaDK($MaSV)
    {
        $check_sql = "SELECT MaDK FROM DangKy WHERE MaSV='$MaSV'";
        $check_result = $this->conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            $row = $check_result->fetch_assoc();
            return $row['MaDK'];
        }

        $NgayDK = date('Y-m-d');
        $insert_dk = "INSERT INTO DangKy (NgayDK, MaSV) VALUES ('$NgayDK', '$MaSV')";

        if ($this->conn->query($insert_dk) === TRUE) {
            return $this->conn->insert_id;
        }

        return false;
    }

    // Kiểm tra học phần đã được đăng ký chưa
    public function isCourseRegistered($MaDK, $MaHP)
    {
        $check_hp = "SELECT * FROM ChiTietDangKy WHERE MaDK='$MaDK' AND MaHP='$MaHP'";
        $result_hp = $this->conn->query($check_hp);
        return $result_hp->num_rows > 0;
    }

    // Thêm học phần vào danh sách đăng ký
    public function registerCourse($MaDK, $MaHP)
    {
        $sql = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES ('$MaDK', '$MaHP')";
        return $this->conn->query($sql);
    }

    // Lấy danh sách học phần đã đăng ký của sinh viên
    public function getRegisteredCourses($MaSV)
    {
        $sql = "SELECT HocPhan.MaHP, HocPhan.TenHP, HocPhan.SoTinChi, ChiTietDangKy.MaDK 
                FROM ChiTietDangKy 
                JOIN DangKy ON ChiTietDangKy.MaDK = DangKy.MaDK 
                JOIN HocPhan ON ChiTietDangKy.MaHP = HocPhan.MaHP 
                WHERE DangKy.MaSV = '$MaSV'";
        return $this->conn->query($sql);
    }

    // Xóa một học phần
    public function deleteCourse($MaDK, $MaHP)
    {
        $sql = "DELETE FROM ChiTietDangKy WHERE MaDK='$MaDK' AND MaHP='$MaHP'";
        return $this->conn->query($sql);
    }

    // Xóa toàn bộ học phần của sinh viên
    public function deleteAllCourses($MaSV)
    {
        $sql = "DELETE FROM ChiTietDangKy WHERE MaDK IN (SELECT MaDK FROM DangKy WHERE MaSV='$MaSV')";
        return $this->conn->query($sql);
    }
}
