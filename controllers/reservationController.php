<?php
include '../models/reservation.php';

class reservationController {
    public function delete($id)
    {
        $reservationModel = new reservation();
        $deleteResult = $reservationModel->delete($id);

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

    public function findRoom($cin, $cout, $no_guess, $modal1) {
        $result = reservation::validateDates($cin, $cout); // Kiểm tra ngày hợp lệ

        if (!$result) {
            // Xử lý khi ngày nhận phòng không hợp lệ
            echo "<script>alert('Ngày nhận phòng không được hơn ngày trả phòng.');";
            echo "window.location.href='reservation_modal_1.php';</script>";
            exit();
        }

        $total_bed = reservation::getTotalBeds(); // Lấy tổng số giường

        if ($no_guess > $total_bed) {
            // Xử lý khi số hành khách lớn hơn tổng số giường
            echo "<script>alert('Xin lỗi, khách sạn hiện không đủ phòng cho " . $no_guess . " khách trong khoảng thời gian bạn chọn. Vui lòng chọn lại hoặc thay đổi số lượng khách.');";
            echo "window.location.href='reservation_modal_1.php?&cin=$cin&cout=$cout';</script>";
            exit();
        }

        // Lấy thông tin phòng
        $rooms = reservation::getAvailableRooms();

        // Xử lý khi nhấn nút "nextModal2"
        if (isset($_POST['nextModal2'])) {
            // ... (Xử lý khi nhấn nút "nextModal2")
        }

        
    }
    public function addRoom(){}
}


?>
