<?php
// include '../views/config.php';

class reservation {
    // public function __construct($name, $address, $phone, $email, $no_room, $no_guess, $check_in, $check_out, $no_day, $status, $note, $created_at) {
    //     $this->name = $name;
    //     $this->address = $address;
    //     $this->phone = $phone;
    //     $this->email = $email;
    //     $this->no_room = $no_room;
    //     $this->no_guess = $no_guess;
    //     $this->check_in = $check_in;
    //     $this->check_out = $check_out;
    //     $this->no_day = $no_day;
    //     $this->status = $status;
    //     $this->note = $note;
    //     $this->created_at = $created_at;
    // }

    // Getter và Setter tự động (magic methods)
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
        return $this;
    }

    public function delete($id) {
        global $conn;
        $sql_delete_room = "UPDATE room JOIN chosen_room ON chosen_room.room_id = room.id
                            JOIN reservation ON chosen_room.reservation_id = reservation.id
                            SET room.status= 1 WHERE reservation.id = '$id' AND reservation.status = 0";
        $deleteSql1 = "DELETE FROM reservation WHERE id = $id";
        $deleteSql2 = "DELETE FROM chosen_room WHERE reservation_id = $id";
        $deleteSql3 = "DELETE FROM chosen_service WHERE reservation_id = $id";
        
        $result_delete_room = mysqli_query($conn, $sql_delete_room);
        $result1 = mysqli_query($conn, $deleteSql1);
        $result2 = mysqli_query($conn, $deleteSql2);
        $result3 = mysqli_query($conn, $deleteSql3);

        return ($result1 && $result2 && $result3 && $result_delete_room) ? true : false;
    }

    public static function validateDates($cin, $cout)
    {
        return (strtotime($cin) > strtotime($cout)) ? false : true;
    }

    public static function submitReservation1($name, $phone, $email, $address, $note, $noRoom, $noGuess, $cin, $cout, $status){
        global $conn;
        $sql = "INSERT INTO reservation(name, phone, email, address ,no_room,no_guess,check_in,check_out,no_day,status,note)
        VALUES ('$name','$phone','$email','$address','$noRoom','$noGuess','$cin','$cout',datediff('$cout','$cin')+1,$status,'$note')";
        $result = mysqli_query($conn, $sql); 
        $reservationId = mysqli_insert_id($conn);  
        return ($result) ? $reservationId : false;
    }
    public static function addChosenRooms($reservationId, $roomIds) {
        global $conn;
        foreach ($roomIds as $roomId) {
            $sql = "INSERT INTO chosen_room (reservation_id, room_id) VALUES ('$reservationId', '$roomId')";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                return false; 
            }
        }
        return true;
    }

    public static function updateRoomStatus($reservationId, $roomIds) {
        global $conn;
        foreach ($roomIds as $roomId) {
            $update_status_sql = "UPDATE room
                JOIN chosen_room ON room.id = chosen_room.room_id
                JOIN reservation ON chosen_room.reservation_id = reservation.id
                SET room.status = 
                CASE 
                    WHEN reservation.status = 0 THEN 2
                    WHEN reservation.status IN (1, 2) THEN 1
                    ELSE room.status
                END
                WHERE room.id = '$roomId' AND reservation.id = '$reservationId';";
            $update_status_result = mysqli_query($conn, $update_status_sql);
            if (!$update_status_result) {
                return false;
            }
        }
        return true; 
    }

    public static function addChosenServices($reservationId, $serviceIds) {
        global $conn;
        foreach ($serviceIds as $serviceId) {
            $sql = "INSERT INTO chosen_service (reservation_id, service_id) VALUES ('$reservationId', '$serviceId')";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                return false;
            }
        }
        return true;
    }

    public static function getAllReservation(){
        global $conn;
        $roombooktablesql = "SELECT reservation.*, GROUP_CONCAT(service.name SEPARATOR ', ') AS listservice
    FROM reservation
    -- JOIN user ON reservation.user_id = user.id
    -- JOIN room_type ON reservation.room_type = room_type.id
    LEFT JOIN chosen_service ON reservation.id = chosen_service.reservation_id
    LEFT JOIN service ON chosen_service.service_id = service.id
    GROUP BY reservation.id ORDER BY reservation.id DESC";
        $roombookresult = mysqli_query($conn, $roombooktablesql);
        return $roombookresult;    
    }

    public static function findReservation($keyword){
        global $conn;
        $roombooktablesql = "SELECT reservation.*, GROUP_CONCAT(service.name SEPARATOR ', ') AS listservice
    FROM reservation
    -- JOIN user ON reservation.user_id = user.id
    -- JOIN room_type ON reservation.room_type = room_type.id
    LEFT JOIN chosen_service ON reservation.id = chosen_service.reservation_id
    LEFT JOIN service ON chosen_service.service_id = service.id
    -- TODO: not only name
    WHERE reservation.id LIKE '%$keyword%' OR reservation.name LIKE '%$keyword%' OR reservation.phone LIKE '%$keyword%'
    GROUP BY reservation.id ORDER BY reservation.id DESC";
        $roombookresult = mysqli_query($conn, $roombooktablesql);
        return $roombookresult;    
    }

    public static function updateReservation($id, $name, $phone, $email, $address, $noRoom, $noGuess, $cin, $cout, $note, $status){
        global $conn;
        $sql = "UPDATE reservation SET name = '$name', phone = '$phone', email = '$email', address = '$address', no_room = '$noRoom', no_guess = '$noGuess', check_in = '$cin', check_out = '$cout', no_day = datediff('$cout', '$cin')+1, note = '$note', status = '$status' WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            return false;
        }
        return true;
    }

    public static function updateChosenRooms($id, $roomIds) {
        global $conn;
        if (isset($roomIds) && is_array($roomIds)) {
            $sql_delete_room = "UPDATE room 
            JOIN chosen_room ON chosen_room.room_id = room.id
            JOIN reservation ON chosen_room.reservation_id = reservation.id
            SET room.status= 1 WHERE reservation.id = '$id' 
            AND reservation.status = 0";
            $result_delete_room = mysqli_query($conn, $sql_delete_room);
    
            $sql_delete = "DELETE FROM chosen_room WHERE reservation_id = '$id'";
            $result_delete = mysqli_query($conn, $sql_delete);
        
            foreach ($roomIds as $room_id) {
                $sql = "INSERT INTO chosen_room (reservation_id, room_id) VALUES ('$id', '$room_id')";
                $result2 = mysqli_query($conn, $sql);
        
                $update_status_sql = "UPDATE room
                JOIN chosen_room ON room.id = chosen_room.room_id
                JOIN reservation ON chosen_room.reservation_id = reservation.id
                SET room.status = 
                CASE 
                    WHEN reservation.status = 0 THEN 2
                    WHEN reservation.status IN (1, 2) THEN 1
                    ELSE room.status
                END
                WHERE room.id = '$room_id' AND reservation.id = '$id';";
                $result3 = mysqli_query($conn, $update_status_sql);
            }
            if ($result_delete_room && $result_delete && $result2 && $result3){
                return true;
            }
        }
        return false;
    }

    public static function updateChosenServices($id, $serviceIds) {
        global $conn;
            $sql_delete = "DELETE FROM chosen_service WHERE reservation_id = '$id'";
            $result_delete = mysqli_query($conn, $sql_delete);
            foreach ($serviceIds as $service_id) {
                $sql = "INSERT INTO chosen_service (reservation_id, service_id) VALUES ('$id', '$service_id')";
                $result = mysqli_query($conn, $sql);
            } 
            if (!$result && !$result_delete) {
                return false;
            }
        return true; 
    }

    public static function getAllKindOfReservation() {
        global $conn;
        $reservationsql ="Select * from reservation";
        $reservationre = mysqli_query($conn, $reservationsql);
        $reservationrow = mysqli_num_rows($reservationre);
        return $reservationrow ? $reservationrow : false;
    }   

    public static function getDoughnutChart(){
        global $conn;
        $query = "SELECT status, COUNT(*) as total FROM reservation GROUP BY status";
        $result = mysqli_query($conn, $query);
        
        $statusData = [];
        while ($row = mysqli_fetch_assoc($result)) {
            switch ($row['status']) {
                case 0:
                    $statusData['Chưa thanh toán'] = $row['total'];
                    break;
                case 1:
                    $statusData['Đã thanh toán'] = $row['total'];
                    break;
                case 2:
                    $statusData['Hủy đặt phòng'] = $row['total'];
                    break;
                default:
                    break;
            }
        }
        return $statusData ? $statusData : false;
    }
}
?>
