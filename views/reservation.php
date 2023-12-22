<?php include 'header.php'; ?>
<?php
include '../controllers/reservationController.php';

$controller = new reservationController();
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $controller->deleteReservation($id);
}

$keyword = isset($_REQUEST["keyword"]) ? $_REQUEST["keyword"] : "";
if (isset($_GET['keyword'])){
    $result = $controller->findReservation($keyword);
}
else {
    $result = $controller->getAllReservation();
}
?>
    <!-- ================================================= -->
<?php include('sidebar.php')?>
  <div class="main-content">
  <div class="searchsection">
    <form action="" method="GET" class="w-75">
        <center>
            <input type="text" name="keyword" id="search_bar" placeholder="Nhập từ khóa tìm kiếm..." value="<?php echo $keyword ?>">
            <button class="btn btn-secondary" type="submit" >Tìm kiếm</button>
        </center>
    </form>
    <a href="reservation_modal_1.php" class="btn btn-primary">
        Đặt phòng
    </a>
    </div>
        <!-- Modal -->
        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Chọn phương thức thanh toán</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="paymentForm" action="payment.php" method="GET">
                            <input type="hidden" name="add" id="reservationIDInput">
                            <input type="hidden" name="method" id="methodInput">
                            <label for="paymentMethod">Chọn phương thức thanh toán:</label>
                            <select name="paymentMethod" id="paymentMethod" class="form-select mb-3">
                                <option value="Tiền mặt">Tiền mặt</option>
                                <option value="Chuyển khoản">Chuyển khoản</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Xác nhận</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="room">

       
        <!-- TODO: drawio searchPaging() -->
        <table class="table table-bordered" id="table-data">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Tên khách</th>
                    <!-- <th scope="col">Email</th> -->
                    <!-- <th scope="col">Địa chỉ</th> -->
                    <th scope="col">SĐT</th>
                    <!-- <th scope="col">Loại phòng</th> -->
                    <th scope="col">Số phòng</th>
                    <th scope="col">Số hành khách</th>
                    <th scope="col">Dịch vụ</th>
                    <th scope="col">Check-In</th>
                    <th scope="col">Check-Out</th>
                    <th scope="col">Số ngày</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Ghi chú</th>
                    <th scope="col" class="action">Hành động</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    if ($result->num_rows > 0) {
                    foreach ($result as $res){
                ?>
                    <tr>
                        <td><?php echo $res['id'] ?></td>
                        <td><?php echo $res['name'] ?></td>
                        <td><?php echo $res['phone'] ?></td>
                        <td><?php echo $res['no_room'] ?></td>
                        <td><?php echo $res['no_guess'] ?></td>
                        <td>
                            <?php
                            if (isset($res['listservice'])) {
                                echo $res['listservice'];
                            } else {
                                echo '';
                            }
                            ?>
                        </td>
                        <td><?php echo date('d-m-Y', strtotime($res['check_in'])) ?></td>
                        <td><?php echo date('d-m-Y', strtotime($res['check_out'])) ?></td>
                        <td><?php echo $res['no_day'] ?></td>
                        <td>
                            <?php
                            if ($res['status'] == 0) echo 'Chưa thanh toán';
                            elseif ($res['status'] == 1) echo 'Đã thanh toán';
                            elseif ($res['status'] == 2) echo 'Hủy đặt phòng';
                            else echo 'Chưa rõ trạng thái';
                            ?>
                        </td>
                        <td><?php echo $res['note'] ?></td>
                        <td class="action">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#paymentModal" onclick="setReservationID(<?php echo $res['id']; ?>)">
                                Bill
                            </button>
                            <?php if(isset($_SESSION['staffRole']) && $_SESSION['staffRole']=='Admin'){ ?>
                            <a href="reservationedit.php?id=<?php echo $res['id'] ?>"><button class="btn btn-primary">Sửa</button></a>
                            <a href="reservation.php?delete=<?php echo $res['id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa đơn #<?php echo $res['id']?> không?')"><button class='btn btn-danger'>Xóa</button></a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php
                }
            } else {
                echo "<tr><td colspan='12' style='text-align: center;'>Không tìm thấy kết quả phù hợp.</td></tr>";
            }
                ?>
            </tbody>
        </table>
    </div>
  </div>
<?php include 'footer.php'; ?>
<script>
    let reservationID = null;

    function setReservationID(id) {
        reservationID = id;
        document.getElementById('reservationIDInput').value = id;
    }

    function redirectToPayment() {
        const selectedMethod = document.getElementById('paymentMethod').value;
        document.getElementById('methodInput').value = selectedMethod;
    }
    document.getElementById('paymentForm').addEventListener('submit', redirectToPayment);
</script>
