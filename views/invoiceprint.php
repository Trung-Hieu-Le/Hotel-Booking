<?php include 'header.php'; ?>
<?php
$id = $_GET['id'];
include '../controllers/paymentController.php';
$controller = new paymentController();
$result = $controller->printPayment($id);
$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}
$res = $rows[0];
?>
<!-- TODO: sửa giống dashboard -->
<?php include('sidebar.php')?>
  <div class="main-content">
<div style="max-width: 850px; margin:auto; border:1px solid black; padding:10px">
	<center>
		<h1>Khách Sạn Xanh - Hóa đơn #<?php echo $id ?></h1><hr>
	</center>
	<div>
		<h3 class="fw-bolder">Thông tin khách hàng</h3>
		<?php
		
		
				echo '<div class="row">';
				echo '<div class="col-6">';
				echo '<p>Họ tên: ' . $res["name"] . '</p>';
				echo '<p>Số điện thoại: ' . $res["phone"] . '</p>';
				echo '</div>';

				echo '<div class="col-6">';
				echo '<p>Địa chỉ: ' . $res["address"] . '</p>';
				echo '<p>Email: ' . $res["email"] . '</p>';
				echo '</div>';

				echo '</div>';
			
		?>
			<h3 class="fw-bolder">Thông tin chi tiết đơn đặt hàng</h3>
		<?php
		
				echo '<div class="row">';
				echo '<div class="col-6">';
				echo '<p>Ngày nhận phòng: ' . date('d-m-Y', strtotime($res["check_in"])) . '</p>';
				echo '<p>Ngày trả phòng: ' . date('d-m-Y', strtotime($res["check_out"])) . '</p>';
				echo '<p>Thời gian lưu trú: ' . $res["no_day"] . ' ngày</p>';
				echo '</div>';
				
				echo '<div class="col-6">';
				echo '<p>Số phòng: ' . $res["no_room"] . '</p>';
				echo '<p>Số hành khách: ' . $res["no_guess"] . '</p>';
				echo '<p>Ghi chú: ' . $res["note"] . '</p>';
				echo '</div>';

				echo '</div>';
				// echo "<p>Ngày đặt phòng: " . date('H:m:s d-m-Y', strtotime($row["created_at"])) . "</p>";
			
			$sql = "SELECT room.room_name, room.room_type, room.price
            FROM room 
            JOIN chosen_room ON room.id = chosen_room.room_id
            JOIN reservation ON reservation.id = chosen_room.reservation_id
            WHERE reservation.id = $id";

			$result = $conn->query($sql) or die($conn->error);

			if (
				mysqli_num_rows($result) > 0
			) {
				echo "<h3 class='fw-bolder'>Danh sách các phòng đã đặt:</h3>";
				echo "<ul>";
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<li>Phòng " . $row["room_name"] . " - Loại phòng: " . $row["room_type"] . " - Giá: " . number_format($row["price"]) . "đ/ngày</li>";
				}
				echo "</ul>";
			} else {
				echo "Không có phòng được đặt.";
			}
			$sql = "SELECT service.name, service.price
        FROM service
        JOIN chosen_service ON service.id = chosen_service.service_id
        JOIN reservation ON chosen_service.reservation_id = reservation.id
        WHERE reservation.id = $id";

			$result = $conn->query($sql) or die($conn->error);

			if (
				mysqli_num_rows($result) > 0
			) {
				echo "<h3 class='fw-bolder'>Danh sách các dịch vụ đã sử dụng:</h3>";
				// $services = array();
				// while ($row = mysqli_fetch_assoc($result)) {
				// 	$services[] = $row["name"];
				// }
				// echo implode(", ", $services);
				echo "<ul>";
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<li>Dịch vụ: " . $row["name"] . " - Giá: " . number_format($row["price"]) . "đ/người</li>";
				}
				echo "</ul>";
			} else {
				echo "Không có dịch vụ sử dụng.";
			}
		?>
		<h3 class='fw-bolder'>Thông tin hóa đơn</h3>
		<?php
		
	
				echo '<div class="row">';
				echo '<div class="col-6">';
				echo '<p>Phương thức: ' . $res["method"] . '</p>';
				echo '<p>Ngày thanh toán: ' . date('H:i:s d/m/Y', strtotime($res["payed_at"])) . '</p>';
				echo '</div>';

				echo '<div class="col-6">';
				echo '<p class="text-danger">Tiền phòng: ' . number_format($res["room_total"]) . 'đ</p>';
				echo '<p class="text-danger">Tiền dịch vụ: ' . number_format($res["service_total"]) . 'đ</p>';
				echo '<p class="text-danger">Tổng cộng: ' . number_format($res["final_total"]) . 'đ</p>';
				echo '</div>';

				echo '</div>';
		
		?>
	</div>
	<hr>
	<div class="d-flex justify-content-end" style="margin-bottom:70px;">
		<a href="payment.php" class="btn btn-secondary me-2">
			Quay lại
		</a>
		<button class="btn btn-primary">In</button>
	</div>
</div>
</div>
</body>

</html>