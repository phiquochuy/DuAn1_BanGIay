<?php
function  insert_hoadon($iduser,$name,$mahoadon,$sdt,$email,$address,$soluonghh1,$pttt,$date,$tong,$trangthai){
    $sql = "INSERT INTO hoadon(iduser,hoten,mahoadon,sdt,email,address,PT_TT,datebuy,soluonghh,tongprice,trangthai) 
    VALUE('$iduser','$name','$mahoadon','$sdt','$email','$address','$pttt','$date','$soluonghh1','$tong','$trangthai')";
    pdo_execute($sql);
}


    function  results_mycart($id){
        $sql = "SELECT * FROM hoadon WHERE iduser=".$id;
        $result = pdo_query($sql);
        return $result;
    }

function select_all_donhang($start,$limit){
    $sql ="SELECT * FROM hoadon ORDER BY id DESC LIMIT $start,$limit";
    $result = pdo_query($sql);
    return $result;
}   
function all_row_hd(){
    $sql ="SELECT COUNT(hoadon.id) FROM hoadon";
    $result = pdo_query($sql);
    return $result;
}
function phuongthucthanhtoan($pttt){
    switch($pttt){
        case "0":
            $pt = 'thanh toan khi nhan hang !';
            break;
        case '1':
            $pt = 'thanh toan ngan hang !';
            break;
    }
    return $pt;
}
function updateTrangThai($id,$trangthai){
    $sql="UPDATE hoadon SET trangthai = '$trangthai' WHERE id = '$id'";
    pdo_execute($sql); 
}
 function loadAllTT(){
    $sql = "SELECT * FROM donhang ";
    $donHang = pdo_query($sql);
    return $donHang;
 }
 function huyDonHang($id){
    $sql = "DELETE FROM hoadon WHERE id = '$id'";
    pdo_execute($sql);
 }
function  hoadon_email($email,$name,$mahoadon,$sdt,$address,$phuongthuc,$date, $tong, $soluonghh1){
require './sendEmail/PHPMailer/src/Exception.php';
require './sendEmail/PHPMailer/src/PHPMailer.php';
require './sendEmail/PHPMailer/src/SMTP.php';

$mail = new PHPMailer\PHPMailer\PHPMailer(true);
try {
//Server settings
$mail->SMTPDebug =  PHPMailer\PHPMailer\SMTP::DEBUG_OFF;
$mail->isSMTP(); // Sử dụng SMTP để gửi mail
$mail->Host = 'smtp.gmail.com'; // Server SMTP của gmail
$mail->SMTPAuth = true; // Bật xác thực SMTP
$mail->Username = 'nguyenminhkhong2004@gmail.com'; // Tài khoản email
$mail->Password = 'xqrm bdvw fght jmpr'; // Mật khẩu ứng dụng ở bước 1 hoặc mật khẩu email
$mail->SMTPSecure = 'ssl'; // Mã hóa SSL
$mail->Port = 465; // Cổng kết nối SMTP là 465

//Recipients
$mail->setFrom('nguyenminhkhong2004@gmail.com', 'Admin'); // Địa chỉ email và tên người gửi
$mail->addAddress($email, $name); // Địa chỉ mail và tên người nhận

//Content
$mail->isHTML(true); // Set email format to HTML
$mail->Subject = 'Preseden Thong Bao Don Hang Cua Ban !'; 
$mail->Body = "
<h1>Preseden</h1>
<h2>Đơn Hàng Của Bạn </h2>
<hr>
<p>Xin chào '".$name."'</p>
<p>Bạn có một đơn hàng : EXXPRESHER '".$mahoadon."'</p>
<p> Số lượng đơn hàng là : '".$soluonghh1."' </p>
<p> Tổng số tiền đơn hàng là : '".$tong."$' </p>
<p> Phương thức thanh toán : '".$phuongthuc."' </p>
<p> Số điện thoại : '".$sdt."' </p>
<p> Địa chỉ nhận hàng : '".$address."' </p>
<p>  Ngày đặt hàng: '".$date."' </p>
<p style='font-weight:bold;'> Cảm ơn bạn đã tin tưởng Preseden ! </p>
<p style='font-weight:bold;'> Trân Trọng </p>

"
;
$mail->send();
// echo 'Message has been sent';
} catch (Exception $e) {
echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;}
header('location:'.$_SERVER['HTTP_REFERER']);
}
function pttt( $pttt){
    switch($pttt){
        case '0':
            $tt = 'Thanh toán khi nhận hàng ';
            break;
        case '1':
            $tt = 'Thanh toán Qua App Ngân Hàng ';
            break;
    }
    return $tt;
}

?>
