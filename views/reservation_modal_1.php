<?php include 'header.php'; ?>
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
    // TODO: drawio findRoom
    $rooms = $controller->findRoom($cin, $cout, $no_guess, $modal1);

?>
<?php

$selected_room = isset($_POST['selected_room']) ? $_POST['selected_room'] : [];
if (isset($_POST['nextModal2'])) {
    $controller->addRoom($cin, $cout, $no_guess, $selected_room, $total_price_room);
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
                                <label for="cin" class="form-label">Ngày nhận phòng <span class="text-danger">(*)</span></label>
                                <input name="cin" type="date" class="form-control" value="<?php echo $cin; ?>" <?php echo ($modal1) ? 'readonly' : 'required'; ?>>
                            </div>
                            <div class="col-3">
                                <label for="cout" class="form-label">Ngày trả phòng <span class="text-danger">(*)</span></label>
                                <input name="cout" type="date" class="form-control" value="<?php echo $cout; ?>" <?php echo ($modal1) ? 'readonly' : 'required'; ?>>
                            </div>
                            <div class="col-3">
                                <label for="no_guess" class="form-label">Số hành khách: <span class="text-danger">(*)</span></label>
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
                                        <button type="submit" class="btn btn-primary" name="modal1" value="tk">Tìm kiếm phòng</button>
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
                                <th>Giá</th>
                                <th>Số giường</th>
                                <th>Phân loại</th>
                                <th>Lựa chọn</th>
                            </tr>
                            <?php
                                foreach ($rooms as $row){
                            ?>
                                <tr>
                                    <td><?php echo $row["room_name"] ?><hr></td>
                                    <td><?php echo number_format($row["price"]); ?>đ<hr></td>
                                    <td><?php echo $row["no_guess"]; ?><hr></td>
                                    <td><?php echo $row["room_type"]; ?><hr></td>
                                    <td><input type='checkbox' name='selected_room[]' value=<?php echo $row["id"]?> data-price='<?php echo $row["price"] ?>'></td>
                                </tr>
                            <?php
                            }
                            ?>

                        </table>
                       
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    
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
</html>

