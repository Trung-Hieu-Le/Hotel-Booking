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

   
}
?>
