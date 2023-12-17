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
        $deleteSql1 = "DELETE FROM reservation WHERE id = $id";
        $deleteSql2 = "DELETE FROM chosen_room WHERE reservation_id = $id";
        $deleteSql3 = "DELETE FROM chosen_service WHERE reservation_id = $id";

        $result1 = mysqli_query($conn, $deleteSql1);
        $result2 = mysqli_query($conn, $deleteSql2);
        $result3 = mysqli_query($conn, $deleteSql3);

        return ($result1 && $result2 && $result3) ? true : false;
    }

    public static function validateDates($cin, $cout)
    {
        return (strtotime($cin) > strtotime($cout)) ? false : true;
    }

    public static function getTotalBeds()
    {
        global $conn;
        $sql_count_beds = "SELECT SUM(room.no_guess) AS total_beds FROM room WHERE room.status = 1";
        $result_count_beds = $conn->query($sql_count_beds) or die($conn->error);
        $total_bed_row = $result_count_beds->fetch_assoc();
        return $total_bed_row['total_beds'];
    }

    public static function getAvailableRooms()
    {
        global $conn;
        $sql = "SELECT * FROM room WHERE room.status = 1 ORDER BY no_guess DESC, price DESC, room.room_name";
        $result = $conn->query($sql) or die($conn->error);
        $rooms = [];
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Xử lý và gán thông tin phòng vào mảng $rooms
                $room = [
                    'id' => $row['id'],
                    'room_name' => $row['room_name'],
                    'no_guess' => $row['no_guess'],
                    'room_type' => $row['room_type']
                ];
                $rooms[] = $room;
            }
        }
    
        return $rooms;
    }
}
?>
