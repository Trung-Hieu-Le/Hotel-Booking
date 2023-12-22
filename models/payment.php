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

    public static function getRoomTotal($id) {
        global $conn;
        $sql_room_total = "SELECT COALESCE(SUM(room.price), 0) AS total_price, reservation.no_day 
        FROM chosen_room 
        INNER JOIN room ON chosen_room.room_id = room.id 
        INNER JOIN reservation ON chosen_room.reservation_id = reservation.id 
        WHERE reservation.id = '$id'";
        $result_room_total = mysqli_query($conn, $sql_room_total);
        $row_room_total = mysqli_fetch_assoc($result_room_total);
        $room_total = $row_room_total['total_price'] * $row_room_total['no_day'];
        return ($room_total) ? $room_total : 0;
    }

    public static function getServiceTotal($id) {
        global $conn;
        $sql_service_total = "SELECT COALESCE(SUM(service.price), 0) AS total_price, reservation.no_guess  
        FROM chosen_service 
        INNER JOIN service ON chosen_service.service_id = service.id 
        INNER JOIN reservation ON chosen_service.reservation_id = reservation.id 
        WHERE reservation.id = '$id'";
        $result_service_total = mysqli_query($conn, $sql_service_total);
        $row_service_total = mysqli_fetch_assoc($result_service_total);
        $service_total = $row_service_total['total_price'] * $row_service_total['no_guess'];
        return ($service_total) ? $service_total : 0;

    }

    public static function updateReservationStatus($id) {
        global $conn;
        $update_status_sql = "UPDATE room 
        JOIN chosen_room ON chosen_room.room_id = room.id
        JOIN reservation ON chosen_room.reservation_id = reservation.id
        SET room.status= 1 WHERE reservation.id = '$id' 
        AND reservation.status = 0";
        $result = mysqli_query($conn, $update_status_sql);

        $sql = "UPDATE reservation SET status = 1 WHERE id = '$id'";
        $result2 = mysqli_query($conn, $sql);

        return ($result && $result2) ? true : false;
    }

    public static function deletePreviousPayment($id) {
        global $conn;
        $result_delete_payment = "DELETE FROM payment WHERE reservation_id = $id";
        $result_delete_payment = mysqli_query($conn, $result_delete_payment);    }

    public static function insertPayment($id, $roomTotal, $serviceTotal, $finalTotal, $method) {
        global $conn;
        $sql_insert_payment = "INSERT INTO payment (reservation_id, room_total, service_total, final_total, method) 
        VALUES ('$id', '$roomTotal', '$serviceTotal', '$finalTotal', '$method')";
        $result = mysqli_query($conn, $sql_insert_payment);
        return ($result) ? true : false;
    }

    public static function getPayment($id){
        global $conn;
        $sql = "SELECT payment.*, reservation.*, payment.created_at as payed_at
        FROM payment
        JOIN reservation ON reservation.id = payment.reservation_id
        WHERE reservation.id = $id";
		$result = $conn->query($sql) or die($conn->error);
        return $result;
    }
    public static function getRoom($id){
        global $conn;
        $sql = "SELECT room.room_name, room.room_type
        FROM room 
        JOIN chosen_room ON room.id = chosen_room.room_id
        JOIN reservation ON reservation.id = chosen_room.reservation_id
        WHERE reservation.id = $id";
		$result = $conn->query($sql) or die($conn->error);
        return $result;
    }

    public static function getProfitChart()
    {
        global $conn;
        $query = "SELECT payment.* FROM payment ORDER BY created_at";
        $result = mysqli_query($conn, $query);
        $chart_data = '';
        $tot = 0;
        while ($row = mysqli_fetch_array($result)) {
            $chart_data .= "{ date:'" . date('d-m-Y', strtotime($row["created_at"])) . "', profit:" . $row["final_total"] . "}, ";
            $tot = $tot + $row["final_total"];
        }
        $chart_data = substr($chart_data, 0, -2);
        $data = array(
            'chart_data' => $chart_data,
            'tot' => $tot
        );

        return $data;
    }

    public static function getAllPayment(){
        global $conn;
        // TODO: drawio cái này
        $sql = "SELECT payment.*, reservation.name FROM payment 
        JOIN reservation ON reservation.id=payment.reservation_id 
        ORDER BY payment.created_at DESC";
        $result = mysqli_query($conn, $sql);
        
        $payments = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $payments[] = $row;
            }
        }
        
        return $payments;
    
    }

    public static function findPayment($keyword){
        global $conn;
        
        $sql = "SELECT payment.*, reservation.name FROM payment 
        JOIN reservation ON reservation.id=payment.reservation_id 
        -- TODO: not only name
        WHERE reservation.id LIKE '%$keyword%' OR reservation.name LIKE '%$keyword%'
        ORDER BY payment.created_at DESC";
        $result = mysqli_query($conn, $sql);
        
        $payments = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $payments[] = $row;
            }
        }
        
        return $payments;
    
    }
}
?>
