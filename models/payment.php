<?php
// include '../views/config.php';

class payment {
    // public function __construct($reservation_id, $room_total, $service_total, $final_total, $method, $created_at) {
    //     $this->reservation_id = $reservation_id;
    //     $this->room_total = $room_total;
    //     $this->service_total = $service_total;
    //     $this->final_total = $final_total;
    //     $this->method = $method;
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
        $deletesql = "DELETE FROM payment WHERE reservation_id = $id";
        $result = mysqli_query($conn, $deletesql) or die($conn->error);

        return ($result) ? true : false;
    }
}
?>
