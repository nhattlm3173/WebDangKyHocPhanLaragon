<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/StudentModel.php');
require_once('app/models/NganhHocModel.php');
session_start();
class StudentController
{

    private $studentModel;
    private $db;
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->studentModel = new StudentModel($this->db);
    }

    public function index()
    {
        $students = $this->studentModel->getStudents();
        include 'app/views/student/list.php';
    }

    public function show($id)
    {
        $student = $this->studentModel->getStudentById($id);
        $TenNganh = (new NganhHocModel($this->db))->getNganhHocById($student->MaNganh)->TenNganh;
        if ($student) {
            include 'app/views/student/show.php';
        } else {
            echo "Không thấy sinh viên.";
        }
    }

    public function add()
    {
        $nganhHoc = (new NganhHocModel($this->db))->getAllNganhHoc();
        include_once 'app/views/student/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $MaSV = $_POST['MaSV'] ?? '';
            $HoTen = $_POST['HoTen'] ?? '';
            $GioiTinh = $_POST['GioiTinh'] ?? '';
            $NgaySinh = $_POST['NgaySinh'] ?? '';
            $Hinh = $_FILES['Hinh'] ?? null;
            $MaNganh = $_POST['MaNganh'] ?? null;
            $result = $this->studentModel->addStudent($MaSV, $HoTen, $GioiTinh, $NgaySinh, $Hinh, $MaNganh);

            if (is_array($result)) {
                $errors = $result;
                $categories = (new NganhHocModel($this->db))->getAllNganhHoc();
                include 'app/views/student/add.php';
            } else {
                header('Location: /webdangkyhocphan/student');
            }
        }
    }

    public function edit($MaSV)
    {
        $student = $this->studentModel->getStudentById($MaSV);
        $nganhHoc = (new NganhHocModel($this->db))->getAllNganhHoc();

        if ($student) {
            include 'app/views/student/edit.php';
        } else {
            echo "Không thấy sinh viên.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $MaSV = $_POST['MaSV'] ?? '';
            $HoTen = $_POST['HoTen'] ?? '';
            $GioiTinh = $_POST['GioiTinh'] ?? '';
            $NgaySinh = $_POST['NgaySinh'] ?? '';
            $Hinh = $_FILES['Hinh'] ?? null;
            $MaNganh = $_POST['MaNganh'] ?? null;

            $edit = $this->studentModel->updateStudent($MaSV, $HoTen, $GioiTinh, $NgaySinh, $Hinh, $MaNganh);

            if ($edit) {
                header('Location: /webdangkyhocphan/student');
            } else {
                echo "Đã xảy ra lỗi khi lưu sinh viên.";
            }
        }
    }

    public function delete($id)
    {
        if ($this->studentModel->deleteStudent($id)) {
            header('Location: /webdangkyhocphan/student');
        } else {
            echo "Đã xảy ra lỗi khi xóa sinh viên.";
        }
    }

    // Hiển thị danh sách học phần
    public function showCourses()
    {
        $result = $this->studentModel->getAllCourses();
        include 'app/views/student/course_list.php';
    }

    // Xử lý đăng ký học phần
    public function registerCourse($MaHP)
    {
        if (!isset($_SESSION['MaSV'])) {
            header("Location: /webdangkyhocphan/auth/login");
            // echo $_SESSION['MaSV'];
            exit();
        }

        $MaSV = $_SESSION['MaSV'];
        $MaDK = $this->studentModel->getOrCreateMaDK($MaSV);

        if (!$MaDK) {
            die("Lỗi khi tạo mã đăng ký.");
        }

        if ($this->studentModel->isCourseRegistered($MaDK, $MaHP)) {
            echo "<script>alert('Học phần đã được đăng ký!'); window.location='app/views/student/cart.php';</script>";
            exit();
        }

        if ($this->studentModel->registerCourse($MaDK, $MaHP)) {
            header("Location: app/views/student/cart.php");
        } else {
            die("Lỗi khi đăng ký học phần.");
        }
    }

    // Hiển thị danh sách học phần đã đăng ký
    public function showRegisteredCourses()
    {
        if (!isset($_SESSION['MaSV'])) {
            header("Location: app/login.php");
            exit();
        }

        $result = $this->studentModel->getRegisteredCourses($_SESSION['MaSV']);
        include 'app/views/student/cart.php';
    }

    // Xóa một học phần
    public function deleteCourse($MaDK, $MaHP)
    {
        if ($this->studentModel->deleteCourse($MaDK, $MaHP)) {
            header("Location: app/views/student/cart.php");
        } else {
            die("Lỗi khi xóa học phần.");
        }
    }

    // Xóa toàn bộ học phần
    public function deleteAllCourses($MaSV)
    {
        if ($this->studentModel->deleteAllCourses($MaSV)) {
            header("Location: app/views/student/cart.php");
        } else {
            die("Lỗi khi xóa toàn bộ học phần.");
        }
    }
}

// Instantiate the controller
$controller = new StudentController();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'register':
            $controller->registerCourse($_GET['MaHP']);
            break;
        case 'delete':
            $controller->deleteCourse($_GET['MaDK'], $_GET['MaHP']);
            break;
        case 'delete_all':
            $controller->deleteAllCourses($_SESSION['MaSV']);
            break;
        case 'list':
            $controller->showCourses();
            break;
        case 'cart':
            $controller->showRegisteredCourses();
            break;
    }
}
