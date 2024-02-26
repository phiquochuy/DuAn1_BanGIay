<?php session_start();
ob_start();
include "./model/pdo.php";
include "./model/sanpham.php";
include './model/danhmuc.php';
include './model/giohang.php';
include './model/hoadon.php';
include './model/taikhoan.php';
include './user/header.php';


if (isset($_GET['act'])) {
    $act = $_GET['act'];
    switch ($act) {
        case 'card':
            include './user/card.php';
            break;
        case 'seach':
            if (isset($_POST['timkiem'])) {
                $kyw = $_POST['kyw'];
            } else {
                $kyw = "";
            }
            if (isset($_GET["iddm"])) {
                $iddm = $_GET["iddm"];
                $nameiddm = $_GET["name"];
            } else {

                $iddm = 0;
            }
            $seach = seachsp($iddm, $kyw);
            include './user/sanphamseach.php';
            break;
        case 'dangnhap':
            if (isset($_POST['submit'])) {
                $user =  $_POST['user'];
                $pass = $_POST['password'];
                $check = check_login($user, $pass);
                if (is_array($check)) {
                    var_dump($check);
                    $_SESSION['user'] = $check;
                    header('location:index.php');
                } else {
                    $thongbao = "<span style='color:red;'
                    > tài khoản hoặc mật khẩu sai</span>";
                }
            }
            include './user/dangnhap.php';
            break;
        case 'thoat':
            session_unset();
            header('Location: index.php');


            break;
        case 'dangki':
            if (isset($_POST['dangki']) && ($_POST['dangki'])) {
                $email = $_POST['email'];
                $user = $_POST['user'];
                $pass = $_POST['password'];
                $sdt = $_POST['sdt'];
                // checkvalidate
                $errors = [];
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $user = trim($_POST["user"]);
                    $pass = trim($_POST["password"]);
                    $email = trim($_POST["email"]);
                    $sdt = trim($_POST["sdt"]);
                    if (empty($user)) {
                        $errors[] = "Tên người dùng không được để trống.";
                    } elseif (!preg_match("/^[a-zA-Z0-9]+$/", $user)) {
                        $errors[] = "Tên người dùng chỉ được chứa chữ cái và số.";
                    }
                
                    if (empty($pass)) {
                        $errors[] = "Password không được để trống.";
                    } elseif (strlen($pass) < 6) {
                        $errors[] = "Password phải có ít nhất 6 ký tự.";
                    }
                
                    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = "Email không hợp lệ.";
                    }
                
                    if (empty($sdt) || !preg_match("/^[0-9]{10}$/", $sdt)) {
                        $errors[] = "Số điện thoại không hợp lệ.";
                    }
                
                    $existingUsernames = ['existingUser1', 'existingUser2', 'existingUser3'];
                
                    if (in_array($user, $existingUsernames)) {
                        $errors[] = "Tên người dùng đã tồn tại. Chọn tên khác.";
                    }
        
                    if (empty($errors)) {
                        $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
                        $thongbao = "Đăng kí thành công!";
                        sigin($user,$email,$pass,$sdt);
                    }
                }
                else{
                sigin($user,$email,$pass,$sdt);
                }
             
            }
            include './user/dangki.php';
            break;
        case 'giohang':
            if (isset($_SESSION['user'])) {
                if (isset($_POST['addgh'])) {
                    $idtk = $_SESSION['user']['id'];
                   $id = $_POST['id'];
                    $name = $_POST['name'];
                    $price = $_POST['price'];
                    $img = $_POST['img'];
                    $soluong = $_POST['soluong'];
                   
                    $tongtien = $price * $soluong;
                  
                   }
                 
                  
                   if(empty($_COOKIE['err'])){
                    insert_cart($name,$price,$tongtien,$img,$soluong,$id,$idtk);
                    header("location:index.php?act=viewgiohang&id=".$idtk);
                   }
                 
                   
                } else
            {
                header("location:" . $_SERVER['HTTP_REFERER']);
                $cookie = ' Bạn phải đăng nhập để thêm sản phẩm vào giỏ hàng';
                setcookie('tb', $cookie, time() + 5);
            }
            include('./user/sanphamct.php');
            break;

        case 'sanphamct':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $spct = sanphamct($id);
            }
            include('./user/sanphamct.php');
            break;
        case 'viewgiohang':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                if ($id > 0) {
                    $resultgh =  result_giohang($id);
                    $tongtiengh = result_tongtien($id);
                }
                $limit = 1;
                $rand = rand(1, 10);
                $resultspgh = resultsp_gh($limit, $rand);
            }
            include('./user/giohang.php');
            break;
            
        case 'xoagh':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                xoa_gh_id($id);
                header("location:" . $_SERVER['HTTP_REFERER']);
            }
            include('./user/giohang.php');
            break;
            case 'billthanhtoan':

                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
    
                    if ($id > 0) {
                        $resultgh =  result_giohang($id);
                        $tongtiengh = result_tongtien($id);
                    }
                }
    
                $soluonghh = sohanghoa($_SESSION['user']['id']);
                $tongsoluong = 0;
                foreach ($soluonghh as $soluonghang) {
                    $tongsoluong += $soluonghang['soluong'];
                }
                if (isset($_POST['dathang'])) {
                    $trangthai = $_POST['trangthai'];
                    $iduser = $_POST['id'];
                    $name = $_POST['name'];
                    $mahoadon = rand(1, 10000);
                    $sdt = $_POST['sdt'];
                    $email = $_POST['email'];
                    $address = $_POST['address'];
                    $pttt = $_POST['pttt'];
                    $date = date('Y-m-d');
                    $tong = $_POST['tongtien'];
                    $soluonghh1 = $_POST['soluongdh'];
                    $phuongthuc = pttt($pttt);
                    insert_hoadon($iduser, $name, $mahoadon, $sdt, $email, $address, $soluonghh1, $pttt, $date, $tong,$trangthai);
                    header("location:" . $_SERVER['HTTP_REFERER']);
                    // hoadon_email($email, $name, $mahoadon, $sdt, $address, $phuongthuc, $date, $tong, $soluonghh1);
                    $cookie = "Bạn Đã Đặt Hàng Thành Công ! Vui Lòng Xem Ở Mục Đơn Hàng Của Tôi Hoặc Hòm Thư Email! Mã Đơn Hàng Của Bạn Là :EXPRESSER" . $mahoadon;
                    setcookie('dathang', $cookie, time() + 10);
                    
    
                    deletegh($_SESSION['user']['id']);
                }
    
                include('./user/billthanhtoan.php');
                break;
            case 'mycart':
                if (isset($_GET['id'])) {
    
                    if ($_GET['id'] > 0) {
                        $id = $_GET['id'];
                        $resultsmycart = results_mycart($id);
                    }
                }
                include('./user/mycart.php');
                break;
        default:
            include './user/home.php';
    }
} else {
    include './user/home.php';
}

include './user/footer.php';

ob_end_flush();
