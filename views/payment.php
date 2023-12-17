<?php include 'header.php'; ?>
<?php

//Thêm
if (isset($_GET['add'])) {
    $id = $_GET['add'];
    $sql_room_total = "SELECT COALESCE(SUM(room.price), 0) AS total_price, reservation.no_day 
            FROM chosen_room 
            INNER JOIN room ON chosen_room.room_id = room.id 
            INNER JOIN reservation ON chosen_room.reservation_id = reservation.id 
            WHERE reservation.id = '$id'";
    $result_room_total = mysqli_query($conn, $sql_room_total);
    $row_room_total = mysqli_fetch_assoc($result_room_total);
    $room_total = $row_room_total['total_price'] * $row_room_total['no_day'];

    $sql_service_total = "SELECT COALESCE(SUM(service.price), 0) AS total_price, reservation.no_guess  
            FROM chosen_service 
            INNER JOIN service ON chosen_service.service_id = service.id 
            INNER JOIN reservation ON chosen_service.reservation_id = reservation.id 
            WHERE reservation.id = '$id'";
    $result_service_total = mysqli_query($conn, $sql_service_total);
    $row_service_total = mysqli_fetch_assoc($result_service_total);
    $service_total = $row_service_total['total_price'] * $row_service_total['no_guess'];

    $method = $_GET['method'];
    $final_total = $room_total + $service_total;
    $sql = "UPDATE reservation SET status = 1 WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    // TODO: Sửa cái này
    $update_status_sql = "UPDATE room
    JOIN chosen_room ON room.id = chosen_room.room_id
    JOIN reservation ON chosen_room.reservation_id = reservation.id
    SET room.status = 1
    WHERE reservation.id = '$id';";
    $update_status_result = mysqli_query($conn, $update_status_sql);

    if ($result) {
        $result_delete_payment = "DELETE FROM payment WHERE reservation_id = $id";
        $result_delete_payment = mysqli_query($conn, $result_delete_payment);
    }
    $sql_insert_payment = "INSERT INTO payment (reservation_id, room_total, service_total, final_total, method) 
    VALUES ('$id', '$room_total', '$service_total', '$final_total', '$method')";
    $result_insert_payment = mysqli_query($conn, $sql_insert_payment);

    if ($result_insert_payment) {
        echo "<script>alert('Tạo hóa đơn thành công');</script>";
        // header("Location:reservation.php");
    } else {
        echo "<script>alert('Lỗi khi tạo hóa đơn');</script>";
    }
}
    //Xóa
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $deletesql = "DELETE FROM payment WHERE reservation_id = $id";
        $result = mysqli_query($conn, $deletesql) or die($conn->error);
        // header("Location:payment.php");
    }
?>
<?php include('sidebar.php')?>
  <div class="main-content">
	<div class="searchsection">
        <input type="text" name="search_bar" id="search_bar" placeholder="Nhập từ khóa tìm kiếm..." onkeyup="searchFun()">
    </div>

    <div class="room">
        <?php
            $paymanttablesql = "SELECT * FROM payment 
                                JOIN reservation ON reservation.id=payment.reservation_id 
                                ORDER BY payment.created_at DESC";
            $paymantresult = mysqli_query($conn, $paymanttablesql);

            $nums = mysqli_num_rows($paymantresult);
        ?>
        <table class="table table-bordered" id="table-data">
            <thead>
                <tr>
                    <th scope="col">Id đặt phòng</th>
                    <!-- <th scope="col">Tên khách hàng</th>
                    <th scope="col">Ngày đến</th>
                    <th scope="col">Ngày đi</th> -->
                    <th scope="col">Tên khách hàng</th>
                    <th scope="col">Tiền phòng</th>
                    <th scope="col">Tiền dịch vụ</th>
					<th scope="col">Tổng</th>
					<th scope="col">Phương thức</th>
                    <th scope="col">Ngày thanh toán</th>
                    <th scope="col">Hành động</th>
                    <!-- <th>Delete</th> -->
                </tr>
            </thead>

            <tbody>
            <?php
            while ($res = mysqli_fetch_array($paymantresult)) {
            ?>
            <!-- TODO: Hiện mã, user, total -->
                <tr>
                    <td><?php echo $res['reservation_id'] ?></td>
                    <td><?php echo $res['name'] ?></td>
                    <td><?php echo $res['room_total'] ?></td>
					<td><?php echo $res['service_total'] ?></td>
					<td><?php echo $res['final_total'] ?></td>
                    <td><?php echo $res['method'] ?></td>
					<td><?php echo date('H:i:s d/m/Y', strtotime($res["created_at"])) ?></td>
                    <td class="action">
                        <a href="invoiceprint.php?id=<?php echo $res['reservation_id']?>"><button class="btn btn-primary ">In</button></a>
						<a href="payment.php?delete=<?php echo $res['reservation_id']?>"  onclick="return confirm('Bạn có chắc muốn xóa hóa đơn #<?php echo $res['id']?> không?')"><button class="btn btn-danger">Xóa</button></a>
                    </td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
  </div>
<?php include('footer.php') ?>
<?php
include '../controllers/paymentController.php';

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $controller = new paymentController();
    $controller->delete($id);
}
?>