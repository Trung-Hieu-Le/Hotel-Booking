<?php
include '../models/payment.php';

class paymentController {
    public function delete($id)
    {
        $paymentModel = new payment();
        $deleteResult = $paymentModel->delete($id);

        if ($deleteResult) {
            echo "<script>
            alert('Xóa thành công!');
        </script>";
        } else {
            echo "<script>
                    alert('Xóa không thành công!');
                    // window.location.href = 'payment.php';
                </script>";
        }
    }
}
?>
