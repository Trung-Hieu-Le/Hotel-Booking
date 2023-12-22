<?php
include '../models/payment.php';


class paymentController {
    public function deletePayment($id)
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
                </script>";
        }
    }

    public function createPayment($id) {
        $roomTotal = payment::getRoomTotal($id);
        $serviceTotal = payment::getServiceTotal($id);
        $method = $_GET['method'];
        $finalTotal = $roomTotal + $serviceTotal;
        $updateStatus = payment::updateReservationStatus($id);
        if ($updateStatus) {
            payment::deletePreviousPayment($id);
            $resultInsertPayment = payment::insertPayment($id, $roomTotal, $serviceTotal, $finalTotal, $method);
            if ($resultInsertPayment) {
                echo "<script>alert('Tạo hóa đơn thành công');</script>";
            } else {
                echo "<script>alert('Lỗi khi tạo hóa đơn');</script>";
            }
        } else {
            echo "<script>alert('Lỗi khi cập nhật trạng thái đặt phòng');</script>";
        }
    }

    public function printPayment($id){
        $payment = payment::getPayment($id);
        return $payment;
    }

    public function findPayment($keyword) {
        $payment = payment::findPayment($keyword);
        return $payment;
    }

    public function getAllPayment() {
        $payment = payment::getAllPayment();
        return $payment;
    }
}
?>
