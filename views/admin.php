<!-- 
    
<?php

include 'config.php';
session_start();

$staffID="";
$staffID=$_SESSION['staffID'];
if($staffID == true){

}else{
    header("Location: http://{$_SERVER['HTTP_HOST']}/Hotel-Booking/index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/admin.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Sparrow Hotel - Admin</title>
</head>

<body>
   
    <nav class="uppernav">
        <div class="logo">
            <img class="bluebirdlogo" src="../image/bluebirdlogo.png" alt="logo">
            <p>SPARROW HOTEL</p>
        </div>
        <div class="logout">
        <a href="../logout.php"><button class="btn btn-primary">Đăng xuất</button></a>
        </div>
    </nav>
    <nav class="sidenav">
        <ul>
            
            <li class="pagebtn active"><img src="../image/icon/dashboard.png">&nbsp&nbsp&nbsp Thống kê</li>
            <li class="pagebtn"><img src="../image/icon/bed.png">&nbsp&nbsp&nbsp Đặt phòng</li>
            <li class="pagebtn"><img src="../image/icon/wallet.png">&nbsp&nbsp&nbsp Thanh toán</li>            
            <li class="pagebtn"><img src="../image/icon/bedroom.png">&nbsp&nbsp&nbsp Phòng</li>
            <li class="pagebtn"><img src="../image/icon/bedroom.png">&nbsp&nbsp&nbsp Loại phòng</li>
            <li class="pagebtn"><img src="../image/icon/service.png">&nbsp&nbsp&nbsp Dịch vụ</li>
            <li class="pagebtn"><img src="../image/icon/service.png">&nbsp&nbsp&nbsp Phản hồi</li>
            <li class="pagebtn"><img src="../image/icon/user.png">&nbsp&nbsp&nbsp Người dùng</li>
            <li class="pagebtn"><img src="../image/icon/staff.png">&nbsp&nbsp&nbsp Nhân viên</li>
        </ul>
    </nav>

    <div class="mainscreen">
        <iframe class="frames frame1 active" src="./dashboard.php" frameborder="0"></iframe>
        <iframe class="frames frame2" src="./reservation.php" frameborder="0"></iframe>
        <iframe class="frames frame3" src="./payment.php" frameborder="0"></iframe>
        <iframe class="frames frame4" src="./room.php" frameborder="0"></iframe>
        <iframe class="frames frame4" src="./roomtype.php" frameborder="0"></iframe>
        <iframe class="frames frame4" src="./service.php" frameborder="0"></iframe>
        <iframe class="frames frame4" src="./feedback.php" frameborder="0"></iframe>
        <iframe class="frames frame4" src="./user.php" frameborder="0"></iframe>
        <iframe class="frames frame4" src="./staff.php" frameborder="0"></iframe>
    </div>
</body>

<script src="./javascript/script.js"></script>

</html> -->
