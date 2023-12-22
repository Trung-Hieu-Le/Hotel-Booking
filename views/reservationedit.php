<?php include 'header.php'; ?>
<?php


// fetch room data
$id = $_GET['id'];

$sql = "SELECT * FROM reservation WHERE id = '$id'";
$re = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($re)) {
    $name = $row['name'];
    $phone = $row['phone'];
    $email = $row['email'];
    $address = $row['address'];
    $no_room = $row['no_room'];
    $no_guess = $row['no_guess'];
    $cin = $row['check_in'];
    $cout = $row['check_out'];
    $note = $row['note'];
    $status = $row['status'];
}
$room_array = array();
$service_array = array();

$sql = "SELECT room_id FROM chosen_room WHERE reservation_id = '$id'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $room_array[] = $row['room_id'];
    }
}
$sql = "SELECT service_id FROM chosen_service WHERE reservation_id = '$id'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $service_array[] = $row['service_id'];
    }
}

include '../controllers/reservationController.php';
$controller = new reservationController();

if (isset($_POST['guestdetailedit'])) {
    $roomIds = isset($_POST['room']) ?  $_POST['room'] : [];
    $services = isset($_POST['service']) ? $_POST['service'] : [];

    $controller->updateReservation($_GET['id'], $_POST['Name'],$_POST['Phone'],$_POST['Email'],$_POST['Address'], count($_POST['room']), $_POST['no_guess'], $_POST['cin'], $_POST['cout'], $_POST['note'], $_POST['status'], $roomIds, $services);

}
?>

<?php include('sidebar.php')?>
  <div class="main-content">
    <div style="max-width:1000px; border: 1px solid black; margin: 50px auto;">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">ĐẶT PHÒNG - SỬA THÔNG TIN:</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <form action="" method="POST">
                    <div class="row modal-body">
                        <div class="col">
                        <div>
                            <label for="name">Tên:</label>
                            <input class="form-control" type="text" id="name" name="Name" required value="<?php echo $name?>">
                        </div>

                        <div>
                            <label for="phone">Số điện thoại:</label>
                            <input class="form-control" type="tel" id="phone" name="Phone" pattern="[0-9]+" title="Nhập số từ 0-9" required value="<?php echo $phone?>">
                        </div>

                        <div>
                            <label for="address">Địa chỉ:</label>
                            <input class="form-control" type="text" id="address" name="Address" value="<?php echo $address?>">
                        </div>

                        <div>
                            <label for="email">Email:</label>
                            <input class="form-control" type="email" id="email" name="Email" value="<?php echo $email?>">
                        </div>
                            <div>
                                <label for="no_guess" class="form-label">Số hành khách:</label>
                                <select name="no_guess" id="no_guess" class="form-select" required>
                                    <option value="" disabled>Chọn số hành khách</option>
                                    <?php
                                        for ($i = 1; $i <= 20; $i++) {
                                            $selected = ($no_guess == $i) ? 'selected' : '';
                                            echo "<option value='$i' $selected>$i</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div>
                                <label for="cin" class="form-label">Ngày nhận phòng:</label>
                                <input name="cin" type="date" class="form-control" value="<?php echo $cin; ?>" required>
                            </div>
                            <div>
                                <label for="cout" class="form-label">Ngày trả phòng:</label>
                                <input name="cout" type="date" class="form-control" value="<?php echo $cout; ?>" required>
                            </div>
                            <!-- <div class="col-lg-3">
                                <label>Chưa có tài khoản khách hàng?</label><br>
                                <button type="button" class="btn btn-primary mt-2" id="addCustomerBtn">Thêm khách hàng</button>
                            </div> -->
                            
                        </div>


                        <div class="col">
                            <!-- Dropdown -->
                            <div>
                                <label for="roomSelect" class="form-label">Phòng:</label>
                                <select name="room[]" class="select multiselect" required style="width:100%;"
                                multiple multiselect-search="true" multiselect-select-all="true">
                                    <!-- <option value="" disabled>Phòng</option> -->
                                    <?php
                                    // $roomsql = "SELECT id, name FROM room WHERE status <> 0";
                                    $roomsql = "SELECT room.id, room.room_name, room.room_type, room.no_guess 
                                    FROM room 
                                    WHERE room.status = 1 
                                    OR room.id IN (
                                        SELECT chosen_room.room_id 
                                        FROM chosen_room 
                                        INNER JOIN reservation ON chosen_room.reservation_id = reservation.id 
                                        WHERE reservation.id = $id
                                    )";

                                    $roomresult = mysqli_query($conn, $roomsql);
                                    if (mysqli_num_rows($roomresult) > 0) {
                                        while ($row = mysqli_fetch_assoc($roomresult)) {
                                            $selected = in_array($row["id"], $room_array) ? 'selected' : '';
                                            echo "<option value='" . $row["id"] . "' $selected>" . $row["room_name"] . " - kiểu: " . $row["room_type"] . " - số giường: " . $row["no_guess"] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>   
                            </div>
                            <div>
                                <label for="serviceSelect" class="form-label">Dịch vụ:</label>
                                <select name="service[]" class="select multiselect" id="multiService" style="width:100%;"
                                multiple multiselect-search="true" multiselect-select-all="true">
                                    <?php
                                    $servicesql = "SELECT id, name FROM service WHERE status = 1";
                                    $serviceresult = mysqli_query($conn, $servicesql);
                                    if (mysqli_num_rows($serviceresult) > 0) {
                                        while ($row = mysqli_fetch_assoc($serviceresult)) {
                                            $selected = in_array($row["id"], $service_array) ? 'selected' : '';
                                            echo "<option value='" . $row["id"] . "' $selected>" . $row["name"] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div>
                                <label for="note" class="form-label">Ghi chú</label>
                                <input type="text" class="form-control" id="note" name="note" placeholder="Ghi chú" value="<?php echo $note ?>">
                            </div>
                            <div>
                                <label class="form-label">Trạng thái</label>
                                <select name="status" class="form-select">
                                    <option value="2" <?php if ($status == 2) {echo "selected";} ?>>Hủy đặt phòng</option>
                                    <option value="1" <?php if ($status == 1) {echo "selected";} ?>>Đã thanh toán</option>
                                    <option value="0" <?php if ($status == 0) {echo "selected";} ?>>Chưa thanh toán</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="reservation.php" class="btn btn-secondary">
                            Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary" name="guestdetailedit">Hoàn thành</button>
                    </div>
                </form>
            </div>
  </div>
<?php include 'footer.php'; ?>
