<?php include 'header.php'; ?>
<?php


if (isset($_POST['nextModal2'])) {
    if (isset($_POST['selected_room']) && is_array($_POST['selected_room']) && count($_POST['selected_room']) > 0) {
        $room_ids = $_POST['selected_room'];
        $total_selected_beds = 0;
        foreach ($room_ids as $room_id) {
            // Thực hiện truy vấn để lấy số giường từng phòng
            $sql_bed_count = "SELECT no_guess FROM room WHERE id = $room_id";
            $result_bed_count = $conn->query($sql_bed_count) or die($conn->error);
            $row_bed_count = $result_bed_count->fetch_assoc();
            $total_selected_beds += $row_bed_count['no_guess'];
        }

        if ($total_selected_beds < $no_guess) {
            echo "<script>alert('Số giường bạn chọn ít hơn số hành khách đã chọn. Vui lòng chọn thêm phòng hoặc giảm số hành khách.');</script>";
        } else {
            header("Location: reservation_modal_2.php?cin=$cin&cout=$cout&no_guess=$no_guess&no_room=" . count($room_ids) . "&room_ids=" . implode(',', $room_ids) . "&total_price_room=$total_price_room");
        }
    } else {
        echo "<script>alert('Vui lòng chọn ít nhất một phòng.');</script>";
    }
}
?>

<?php include('sidebar.php')?>
  <div class="main-content">
        <div>
            <div>
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">ĐẶT PHÒNG - CHỌN PHÒNG:</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <form action="" method="GET">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-3">
                                <label for="cin" class="form-label">Ngày nhận phòng</label>
                                <input name="cin" type="date" class="form-control" value="<?php echo $cin; ?>" <?php echo ($modal1) ? 'readonly' : 'required'; ?>>
                            </div>
                            <div class="col-3">
                                <label for="cout" class="form-label">Ngày trả phòng</label>
                                <input name="cout" type="date" class="form-control" value="<?php echo $cout; ?>" <?php echo ($modal1) ? 'readonly' : 'required'; ?>>
                            </div>
                            <div class="col-3">
                                <label for="no_guess" class="form-label">Số hành khách:</label>
                                <select name="no_guess" id="no_guess" class="form-select" <?php echo ($modal1) ? 'disabled' : 'required'; ?>>
                                    <option value="" disabled <?php echo (!isset($no_guess)) ? 'selected' : ''; ?>>Chọn số hành khách</option>
                                    <?php
                                    for ($i = 1; $i <= 20; $i++) {
                                        $selected = ($no_guess == $i) ? 'selected' : '';
                                        echo "<option value='$i' $selected>$i</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-3 position-relative">
                                <div class="position-absolute bottom-0">
                                    <?php if (!$modal1) { ?>
                                        <button type="submit" class="btn btn-primary" name="modal1">Tìm kiếm phòng</button>
                                    <?php } else { ?>
                                        <a href="reservation_modal_1.php" class="btn btn-primary">Quay lại</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <form action="" method="POST">
                <div id="availableRoomsList" class="ms-3">
                    <?php if ($modal1 <> "") { ?>
                        <br>
                        <table align=center width=100%>
                            <tr>
                                <th>Tên phòng</th>
                                <th>Ảnh</th>
                                <th>Giá</th>
                                <th>Số giường</th>
                                <th>Phân loại</th>
                                <th>Lựa chọn</th>
                            </tr>
                            <?php
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $row["room_name"] ?></td>
                                    <td><?php echo $row["price"]; ?></td>
                                    <td><?php echo $row["no_guess"]; ?></td>
                                    <td><?php echo $row["room_type"]; ?></td>
                                    <td><input type='checkbox' name='selected_room[]' value=<?php echo $row["id"]?> data-price='<?php echo $row["price"] ?>'></td>
                                </tr>
                            <?php
                            }
                            ?>

                        </table>
                       
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <div>
                        <p class="text-danger mb-0">Tiền phòng: <span id="totalPriceRoom">0</span></p>
                        <input type="hidden" id="hiddenTotalRoom" name="total_price_room" value="">
                    </div>
                    <a href="reservation.php" class="btn btn-secondary">
                        Quay lại trang chính
                    </a>
                    <button type="submit" class="btn btn-primary" name="nextModal2">Tiếp</button>
                </div>
            </form>
               
            </div>

        </div>
    </div>
</body>
<!-- <script src="./javascript/roombook.js"></script> -->
<script>
    const checkboxes = document.querySelectorAll('input[name="selected_room[]"]');
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', updateTotalRoom);
    });

    function updateTotalRoom() {
        let totalRoom = 0;
        checkboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                totalRoom += parseInt(checkbox.getAttribute('data-price'));
            }
        });
        document.getElementById('totalPriceRoom').textContent = totalRoom;
        document.getElementById('hiddenTotalRoom').value = totalRoom;
    }
</script>
</html>

<?php
    include '../controllers/reservationController.php';

    $controller = new reservationController();

    $cin = isset($_REQUEST["cin"]) ? $_REQUEST["cin"] : "";
    $cout = isset($_REQUEST["cout"]) ? $_REQUEST["cout"] : "";
    $no_guess = isset($_REQUEST["no_guess"]) ? $_REQUEST["no_guess"] : "";
    $total_price_room = isset($_REQUEST["total_price_room"]) ? $_REQUEST["total_price_room"] : 0;
    if (!isset($_REQUEST["modal1"])) {
        $modal1 = "";
    } else {
        $modal1 = $_REQUEST["modal1"];
    }
    $controller->findRoom($cin, $cout, $no_guess, $modal1);

if (isset($_POST['nextModal2'])) {
    $controller->addRoom();
}
?>