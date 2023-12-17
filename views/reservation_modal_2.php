<?php include 'header.php'; ?>

<?php

//Thêm vào bảng reservation
if (isset($_POST['reservationSubmit'])) {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $note = $_POST['note'];
    $noRoom = $_GET['no_room'];
    $noGuess = $_GET['no_guess'];
    $cin = $_GET['cin'];
    $cout = $_GET['cout'];
    $status = $_POST['status'];

    $sql = "INSERT INTO reservation(name, phone, email, address ,no_room,no_guess,check_in,check_out,no_day,status,note)
                 VALUES ('$name','$phone','$email','$address','$noRoom','$noGuess','$cin','$cout',datediff('$cout','$cin')+1,$status,'$note')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $reservationId = mysqli_insert_id($conn);

        if (isset($_GET['room_ids'])) {
            $room_ids = $_GET['room_ids'];
            $room_ids_array = explode(',', $room_ids);
            foreach ($room_ids_array as $room_id) {
                $sql = "INSERT INTO chosen_room (reservation_id, room_id) VALUES ('$reservationId', '$room_id')";
                $result2 = mysqli_query($conn, $sql);
                // if (!$result2) {
                //     echo "<script>console.error('Lỗi khi chọn phòng: " . mysqli_error($conn) . "');</script>";
                // }
                if (!$result2) {
                    echo "<script>alert('Có lỗi xảy ra khi thêm phòng');</script>";
                } else {
                    $update_status_sql = "UPDATE room
                        JOIN chosen_room ON room.id = chosen_room.room_id
                        JOIN reservation ON chosen_room.reservation_id = reservation.id
                        SET room.status = 
                        CASE 
                            WHEN reservation.status = 0 THEN 2
                            WHEN reservation.status IN (1, 2) THEN 1
                            ELSE room.status
                        END
                        WHERE room.id = '$room_id' AND reservation.id = '$reservationId';";
                    $update_status_result = mysqli_query($conn, $update_status_sql);
                    if (!$update_status_result) {
                        echo "<script>alert('Có lỗi xảy ra khi cập nhật phòng');</script>";
                    }
                }
            }
        }
        if (isset($_POST['service']) && is_array($_POST['service'])) {
            foreach ($_POST['service'] as $service_id) {
                $sql = "INSERT INTO chosen_service (reservation_id, service_id) VALUES ('$reservationId', '$service_id')";
                $result3 = mysqli_query($conn, $sql);
                if (!$result3) {
                    echo "<script>alert('Có lỗi xảy ra khi thêm dịch vụ');</script>";
                }
            }
        }

        echo "<script>swal({
                            title: 'Đặt phòng thành công',
                            icon: 'success',
                        });
                    </script>";
        header("Location: reservation.php");
    } else {
        echo "<script>alert('Có lỗi xảy ra');</script>";
    }
}
?>
<?php include('sidebar.php') ?>
<div class="main-content">
    <div>
        <div>
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">ĐẶT PHÒNG - ĐIỀN THÔNG TIN:</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <form action="" method="POST">
                <div class="row modal-body m-auto">
                    <div class="col">
                        <h4><u>Thông tin khách hàng:</u></h4>
                        <div>
                            <label for="name">Tên:</label>
                            <input class="form-control" type="text" id="name" name="name" required>
                        </div>

                        <div>
                            <label for="phone">Số điện thoại:</label>
                            <input class="form-control" type="tel" id="phone" name="phone" pattern="[0-9]+" title="Nhập số từ 0-9" required>
                        </div>

                        <div>
                            <label for="address">Địa chỉ:</label>
                            <input class="form-control" type="text" id="address" name="address">
                        </div>

                        <div>
                            <label for="email">Email:</label>
                            <input class="form-control" type="email" id="email" name="email">
                        </div>
                    </div>


                    <div class="col">
                        <h4><u>Thông tin chi tiết đặt phòng:</u></h4>
                        <?php
                        echo "<p>Ngày nhận phòng: " . date('d-m-Y', strtotime($_GET["cin"])) . "</p>";
                        echo "<p>Ngày trả phòng: " . date('d-m-Y', strtotime($_GET["cout"])) . "</p>";
                        echo "<p>Số hành khách: " . $_GET["no_guess"] . "</p>";
                        echo "<p>Số phòng: " . $_GET["no_room"] . "</p>";


                        ?>
                        <!-- TODO: Sửa multi select -->
                        <div>
                            <label for="serviceSelect" class="form-label">Dịch vụ:</label>
                            <select name="service[]" class="select multiselect" id="multiService" style="width:100%;" multiple multiselect-search="true" multiselect-select-all="true">
                                <!-- <option value="" disabled>Dịch vụ</option> -->
                                <?php
                                $servicesql = "SELECT id, name, price FROM service WHERE status = 1";
                                $serviceresult = mysqli_query($conn, $servicesql);
                                if (mysqli_num_rows($serviceresult) > 0) {
                                    while ($row = mysqli_fetch_assoc($serviceresult)) {
                                        echo "<option value='" . $row["id"] . "' data-price='" . $row["price"] . "'>" . $row["name"] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="note" class="form-label">Ghi chú</label>
                            <input type="text" class="form-control" id="note" name="note" placeholder="Ghi chú">
                        </div>
                        <div>
                            <label>Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="2">Hủy đặt phòng</option>
                                <option value="1">Đã thanh toán</option>
                                <option value="0" selected>Chưa thanh toán</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="float-left">
                        <p class="text-danger mb-0">Tiền phòng: <span><?php echo $_GET["total_price_room"] ?></span></p>
                        <p class="text-danger mb-0">Tiền dịch vụ: <span id="totalPriceService">0</span></p>
                        <hr style="margin: 0.25rem 0; color:red;">
                        <p class="text-danger mb-0">Tổng tiền dự tính: <span id="totalPrice">0</span></p>
                    </div>
                    <a href="reservation_modal_1.php" class="btn btn-secondary">
                        Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary" name="reservationSubmit">Hoàn thành</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- <script src="./javascript/roombook.js"></script> -->
<!-- <script>
    document.getElementById('addCustomerBtn').addEventListener('click', function() {
        window.location.href = 'user.php?showAddUserModal=true';
    });
</script> -->
<?php include 'footer.php' ?>

<script>
    const totalRoom = parseInt("<?php echo $_GET['total_price_room']; ?>");
    const multiService = document.getElementById('multiService');
    let total = totalRoom;
    document.getElementById('totalPrice').textContent = total;
    multiService.addEventListener('change', updateTotalService);

    function updateTotalService() {
        const selectedServices = multiService.selectedOptions;
        let totalService = 0;
        for (const option of selectedServices) {
            totalService += parseInt(option.getAttribute('data-price'));
        }
        const noGuess = parseInt("<?php echo $_GET['no_guess']; ?>");
        const totalServiceWithGuest = totalService * noGuess;
        console.log(totalServiceWithGuest);
        const total = totalRoom + totalServiceWithGuest;
        document.getElementById('totalPriceService').textContent = totalServiceWithGuest;
        document.getElementById('totalPrice').textContent = total;
    }
</script>