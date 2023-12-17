<?php
include '../views/config.php';

class staff {
 
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

    public function loginAction($username, $password) {
        global $conn;
        $sql = "SELECT * FROM staff WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            return mysqli_fetch_array($result);
        } else {
            return false;
        }
    }
}
?>
