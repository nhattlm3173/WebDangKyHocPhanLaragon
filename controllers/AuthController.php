<?php
require_once 'app/models/StudentModel.php';

class AuthController
{
    private $studentModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->studentModel = new StudentModel($this->db);
    }

    public function login()
    {
        include 'app/views/login.php'; // Hiển thị form đăng nhập
    }

    public function checkLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $MaSV = $_POST['MaSV'] ?? '';

            if (empty($MaSV)) {
                $error = "Vui lòng nhập mã sinh viên!";
                include 'app/views/auth/login.php';
                return;
            }

            $student = $this->studentModel->getStudentById($MaSV);

            if ($student) {
                session_start();
                $_SESSION['MaSV'] = $student->MaSV; // Lưu vào session
                header("Location: /webdangkyhocphan/student/");
                exit;
            } else {
                $error = "Mã sinh viên không tồn tại!";
                include 'app/views/login.php';
            }
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: /webdangkyhocphan/login");
        exit;
    }
}
