<?php include 'header.php'; ?>
<?php
$id = $_GET['id'];
?>
<?php include('sidebar.php')?>
  <div class="main-content">
<div style="max-width: 850px; margin:auto; border:1px solid black; padding:10px">
	<center>
		<h1>SPARROW HOTEL - Hóa đơn #<?php echo $id ?></h1><hr>
	</center>
	<div>
		<h3 class="fw-bolder">Thông tin khách hàng</h3>
		<?php
		$sql = "SELECT * FROM reservation  WHERE reservation.id = $id";
		$result = $conn->query($sql) or die($conn->error);
		if (mysqli_num_rows($result) > 0) {
			// echo "<p>Tên:</p>";

			while ($row = mysqli_fetch_assoc($result)) {
				echo '<div class="row">';
				echo '<div class="col-6">';
				echo '<p>Họ tên: ' . $row["name"] . '</p>';
				echo '<p>Số điện thoại: ' . $row["phone"] . '</p>';
				echo '</div>';

				echo '<div class="col-6">';
				echo '<p>Địa chỉ: ' . $row["address"] . '</p>';
				echo '<p>Email: ' . $row["email"] . '</p>';
				echo '</div>';

				echo '</div>';
			}
		} else {
			echo "Không tìm thấy thông tin người dùng";
		}
		?>
		<h3 class="fw-bolder">Thông tin chi tiết đơn đặt hàng</h3>
		<?php
		$sql = "SELECT * FROM reservation WHERE id = $id";
		$result = $conn->query($sql) or die($conn->error);
		if (mysqli_num_rows($result) > 0) {
			// echo "<p>Tên:</p>";

			while ($row = mysqli_fetch_assoc($result)) {
				echo '<div class="row">';
				echo '<div class="col-6">';
				echo '<p>Ngày nhận phòng: ' . date('d-m-Y', strtotime($row["check_in"])) . '</p>';
				echo '<p>Ngày trả phòng: ' . date('d-m-Y', strtotime($row["check_out"])) . '</p>';
				echo '<p>Thời gian lưu trú: ' . $row["no_day"] . ' ngày</p>';
				echo '</div>';
				
				echo '<div class="col-6">';
				echo '<p>Số phòng: ' . $row["no_room"] . '</p>';
				echo '<p>Số hành khách: ' . $row["no_guess"] . '</p>';
				echo '<p>Ghi chú: ' . $row["note"] . '</p>';
				echo '</div>';

				echo '</div>';
				// echo "<p>Ngày đặt phòng: " . date('H:m:s d-m-Y', strtotime($row["created_at"])) . "</p>";
			}
			$sql = "SELECT room.room_name, room.room_type
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
					echo "<li>Phòng " . $row["room_name"] . " - Loại phòng: " . $row["room_type"] . "</li>";
				}
				echo "</ul>";
			} else {
				echo "Không có phòng được đặt.";
			}
			$sql = "SELECT service.name
        FROM service
        JOIN chosen_service ON service.id = chosen_service.service_id
        JOIN reservation ON chosen_service.reservation_id = reservation.id
        WHERE reservation.id = $id";

			$result = $conn->query($sql) or die($conn->error);

			if (
				mysqli_num_rows($result) > 0
			) {
				echo "<h3 class='fw-bolder'>Danh sách các dịch vụ đã sử dụng:</h3>";
				$services = array();
				while ($row = mysqli_fetch_assoc($result)) {
					$services[] = $row["name"];
				}
				echo implode(", ", $services);
			} else {
				echo "Không có dịch vụ sử dụng.";
			}
		} else {
			echo "Không tìm thấy thông tin chi tiết đơn đặt hàng";
		}
		?>
		<h3 class='fw-bolder'>Thông tin hóa đơn</h3>
		<?php
		$sql = "SELECT * FROM payment WHERE reservation_id = $id";
		$result = $conn->query($sql) or die($conn->error);
		if (mysqli_num_rows($result) > 0) {
			// echo "<p>Tên:</p>";

			while ($row = mysqli_fetch_assoc($result)) {
				echo '<div class="row">';
				echo '<div class="col-6">';
				echo '<p>Phương thức: ' . $row["method"] . '</p>';
				echo '<p>Ngày thanh toán: ' . date('H:i:s d/m/Y', strtotime($row["created_at"])) . '</p>';
				echo '</div>';

				echo '<div class="col-6">';
				echo '<p class="text-danger">Tiền phòng: ' . $row["room_total"] . '</p>';
				echo '<p class="text-danger">Tiền dịch vụ: ' . $row["service_total"] . '</p>';
				echo '<p class="text-danger">Tổng cộng: ' . $row["final_total"] . '</p>';
				echo '</div>';

				echo '</div>';
			}
		} else {
			echo "Không tìm thấy thông tin người dùng";
		}
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