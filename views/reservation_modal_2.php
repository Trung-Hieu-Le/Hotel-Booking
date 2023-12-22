<?php include 'header.php'; ?>

<?php

//Thêm vào bảng reservation
if (isset($_POST['reservationSubmit'])) {
    include '../controllers/reservationController.php';
    $controller = new reservationController();
    $roomIds = isset($_GET['room_ids']) ? explode(',', $_GET['room_ids']) : [];
    $services = isset($_POST['service']) ? $_POST['service'] : [];

    $controller->submitReservation($_POST['name'],$_POST['phone'],$_POST['email'],$_POST['address'],$_POST['note'],$_GET['no_room'],$_GET['no_guess'],$_GET['cin'],$_GET['cout'],$_POST['status'],$roomIds,$services);


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
                            <label for="name">Tên: <span class="text-danger">(*)</span></label>
                            <input class="form-control" type="text" id="name" name="name" required>
                        </div>

                        <div>
                            <label for="phone">Số điện thoại: <span class="text-danger">(*)</span></label>
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
                            <label for="note" class="form-label">Ghi chú:</label>
                            <input type="text" class="form-control" id="note" name="note" placeholder="Ghi chú">
                        </div>
                        <div>
                            <label>Trạng thái: <span class="text-danger">(*)</span></label>
                            <select name="status" class="form-select">
                                <option value="2">Hủy đặt phòng</option>
                                <option value="1">Đã thanh toán</option>
                                <option value="0" selected>Chưa thanh toán</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    
                    <a href="reservation_modal_1.php" class="btn btn-secondary">
                        Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary" name="reservationSubmit">Hoàn thành</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php' ?>

