<?php
// include '../views/config.php';

class room {
    public function __construct($room_name, $room_type, $price, $no_guess, $note, $status) {
        $this->room_name = $room_name;
        $this->room_type = $room_type;
        $this->price = $price;
        $this->no_guess = $no_guess;
        $this->note = $note;
        $this->status = $status;

    }

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
                $room = [
                    'id' => $row['id'],
                    'room_name' => $row['room_name'],
                    'price' => $row['price'],
                    'no_guess' => $row['no_guess'],
                    'room_type' => $row['room_type']
                ];
                $rooms[] = $room;
            }
        }
    
        return $rooms;
    }

    public static function getNoGuessForRooms($room_ids) {
        $total_selected_beds = 0;
        foreach ($room_ids as $room_id) {
            $room = self::getRoomById($room_id);
            $total_selected_beds += $room['no_guess'];
        }
        return $total_selected_beds;
    }

    public static function getRoomById($room_id)
    {
        global $conn;
        $sql = "SELECT * FROM room WHERE id = $room_id";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $room = $result->fetch_assoc(); 
            return $room;
        } else {
            return null;
        }
    }

    public static function getRoomDashboard1()
    {
        global $conn;
        $roombooksql ="Select * from room join chosen_room on chosen_room.room_id=room.id
                                      join reservation on chosen_room.reservation_id=reservation.id
                                      where reservation.status=0";
        $roombookre = mysqli_query($conn, $roombooksql);
        $roombookrow = mysqli_num_rows($roombookre);
        return ($roombookrow) ? $roombookrow : 0;
    }

    public static function getRoomDashboard2()
    {
        global $conn;
        $roomsql ="Select * from room where status <> 0";
        $roomre = mysqli_query($conn, $roomsql);
        $roomrow = mysqli_num_rows($roomre);
        return ($roomrow) ? $roomrow : 0;
    }
}
?>
