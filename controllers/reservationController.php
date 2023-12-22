<?php
include '../models/reservation.php';
include '../models/room.php';
include '../models/payment.php';

class reservationController {
    public function deleteReservation($id)
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
        $result = reservation::validateDates($cin, $cout);

        if (!$result) {
            echo "<script>alert('Ngày nhận phòng không được hơn ngày trả phòng.');";
            echo "window.location.href='reservation_modal_1.php';</script>";
            exit();
        }

        $total_bed = room::getTotalBeds();
        var_dump($total_bed);
        if ($no_guess > $total_bed) {
            echo "<script>alert('Xin lỗi, khách sạn hiện không đủ phòng cho " . $no_guess . " khách trong khoảng thời gian bạn chọn. Vui lòng chọn lại hoặc thay đổi số lượng khách.');";
            echo "window.location.href='reservation_modal_1.php?&cin=$cin&cout=$cout';</script>";
            exit();
        }

        $rooms = room::getAvailableRooms();
        return $rooms;
    
    }

    public function addRoom($cin, $cout, $no_guess, $selected_rooms, $total_price_room) {
        if (isset($selected_rooms) && is_array($selected_rooms) &&count($selected_rooms) > 0) {
            $total_selected_beds = room::getNoGuessForRooms($selected_rooms);

            if ($total_selected_beds < $no_guess) {
                echo "<script>alert('Số giường bạn chọn ít hơn số hành khách đã chọn. Vui lòng chọn thêm phòng hoặc giảm số hành khách.');</script>";
            } else {
                $room_ids = implode(',', $selected_rooms);
                header("Location: reservation_modal_2.php?cin=$cin&cout=$cout&no_guess=$no_guess&no_room=" . count($selected_rooms) . "&room_ids=$room_ids&total_price_room=$total_price_room");
                exit();
            }
        } else {
            echo "<script>alert('Vui lòng chọn ít nhất một phòng.');</script>";
        }
    }

    public function submitReservation($name, $phone, $email, $address, $note, $noRoom, $noGuess, $cin, $cout, $status, $room_ids, $service_ids) {
        $resultID = reservation::submitReservation1($name, $phone, $email, $address, $note, $noRoom, $noGuess, $cin, $cout, $status);
        if ($resultID) {
            $roomInsertResult = reservation::addChosenRooms($resultID, $room_ids);
            if (!$roomInsertResult) {
                echo "<script>alert('Có lỗi xảy ra khi thêm phòng');</script>";
            }
    
            $roomStatusUpdateResult = reservation::updateRoomStatus($resultID, $room_ids);
            if (!$roomStatusUpdateResult) {
                echo "<script>alert('Có lỗi xảy ra khi cập nhật phòng');</script>";
            }
    
            $serviceInsertResult = reservation::addChosenServices($resultID, $service_ids);
            if (!$serviceInsertResult) {
                echo "<script>alert('Có lỗi xảy ra khi thêm dịch vụ');</script>";
            }

            echo "<script>alert('Thêm đơn đặt phòng thành công');";
            echo "window.location.href='reservation.php';</script>";

        }
        else {
            echo "<script>alert('Có lỗi xảy ra');</script>";
        }
        
    }
    public function getAllReservation() {
        $reservationModel = new reservation();
        $reservations = $reservationModel->getAllReservation();
        return $reservations;
    }
    public function findReservation($keyword) {
        $reservationModel = new reservation();
        $reservations = $reservationModel->findReservation($keyword);
        return $reservations;
    }

    // TODO: SAI
    public function updateReservation($id, $name, $phone, $email, $address, $noRoom, $noGuess, $cin, $cout, $note, $status, $room_ids, $service_ids){
        $result = reservation::validateDates($cin, $cout);
        if (!$result) {
            echo "<script>alert('Ngày nhận phòng không được hơn ngày trả phòng');";
            echo "window.location.href='reservationedit.php?id=$id';</script>";
            exit();
        }
        $result = reservation::updateReservation($id, $name, $phone, $email, $address, $noRoom, $noGuess, $cin, $cout, $note, $status);
        if (!$result) {
            echo "<script>alert('Có lỗi xảy ra khi sửa đơn đặt phòng');</script>";
            exit();
        }

        $result = reservation::updateChosenRooms($id, $room_ids);
        if (!$result) {
            echo "<script>alert('Có lỗi xảy ra khi thêm phòng');</script>";
            exit();
        }
        $result = reservation::updateChosenServices($id, $service_ids);
        if (!$result) {
            echo "<script>alert('Có lỗi xảy ra khi thêm dịch vụ');</script>";
            exit();
        }

        echo "<script>alert('Sửa phòng thành công');";
            echo "window.location.href='reservation.php';</script>";
    }

    public function viewStatistic() {
        $roombookrow = room::getRoomDashboard1();
        $roomrow = room::getRoomDashboard2();
        $reservationrow = reservation::getAllKindOfReservation();
        $chartData = payment::getProfitChart();
        $statusData = reservation::getDoughnutChart();
        
        return array(
            'roombookrow' => $roombookrow,
            'roomrow' => $roomrow,
            'reservationrow' => $reservationrow,
            'chartData' => $chartData,
            'statusData' => $statusData
        );
    }
}
?>
