<?php
include '../models/staff.php';

class staffController
{
    public function loginAction($username, $password)
    {
        $staffModel = new staff();
        $userData = $staffModel->loginAction($username, $password);

        if ($userData) {
            $_SESSION['staffID'] = $userData['id'];
            $_SESSION['staffName'] = $username;
            $_SESSION['staffRole'] = $userData['role'];

            echo "<script>
                        swal({
                            title: 'Đăng nhập thành công',
                            icon: 'success',
                        }).then(function() {
                            window.location.href = 'dashboard.php';
                        });
                    </script>";
        } else {
            echo "<script>
                        swal({
                            title: 'Có lỗi xảy ra, xin vui lòng thử lại!',
                            icon: 'error',
                        });
                    </script>";
        }
    }
}
?>