<?php
?>
<!DOCTYPE html>
<html lang="en">
<!-- TODO: giao diện login -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- sweet alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- aos animation -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- loading bar -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script> -->
    <link rel="stylesheet" href="../css/flash.css">
    <title>Sparrow Hotel</title>
</head>

<body>
    <!--  carousel -->
    <section id="carouselExampleControls" class="carousel slide carousel_section" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="carousel-image" src="../image/hotel1.jpg">
            </div>
            <div class="carousel-item">
                <img class="carousel-image" src="../image/hotel2.jpg">
            </div>
            <div class="carousel-item">
                <img class="carousel-image" src="../image/hotel3.jpg">
            </div>
            <div class="carousel-item">
                <img class="carousel-image" src="../image/hotel4.jpg">
            </div>
        </div>
    </section>

    <!-- main section -->
    <section id="auth_section">

        <div class="logo">
            <img class="bluebirdlogo" src="../image/bluebirdlogo.png" alt="logo">
            <p>SPARROW HOTEL</p>
        </div>

        <div class="auth_container">
            <!--============ login =============-->

            <div id="Log_in">
                <h2>Đăng nhập</h2>
                
                <form class="employee_login authsection" id="employeelogin" action="" method="POST">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="emp_username" placeholder=" " required>
                        <label for="floatingInput">Tên đăng nhập</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" name="emp_password" placeholder=" " required>
                        <label for="floatingPassword">Mật khẩu</label>
                    </div>
                    <button type="submit" name="Emp_login_submit" class="auth_btn">Đăng nhập</button>
                </form>
            </div>

    </section>
</body>
<!-- <script src="./javascript/index.js"></script> -->
</html>


<?php
include '../controllers/staffController.php';

if (isset($_POST['Emp_login_submit'])) {
    $controller = new staffController();
    $controller->loginAction($_POST['emp_username'], $_POST['emp_password']);
}
?>