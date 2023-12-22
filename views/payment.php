<?php include 'header.php'; ?>
<?php
include '../controllers/paymentController.php';
$controller = new paymentController();

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $controller->deletePayment($id);
}
//Thêm
if (isset($_GET['add'])) {
    $controller->createPayment($_GET['add']);
}

//Tìm kiếm
$keyword = isset($_REQUEST["keyword"]) ? $_REQUEST["keyword"] : "";
if (isset($_GET['keyword'])){
    $result = $controller->findPayment($keyword);
}
else {
    $result = $controller->getAllPayment();
}

    
?>
<?php include('sidebar.php')?>
  <div class="main-content">
	<div class="searchsection">
    <form action="" method="GET" class="w-75">
        <center>
            <input type="text" name="keyword" id="search_bar" placeholder="Nhập từ khóa tìm kiếm..." value="<?php echo $keyword ?>">
            <button class="btn btn-secondary" type="submit">Tìm kiếm</button>
        </center>
    </form>
    <!-- <input type="text" name="search_bar" id="search_bar" placeholder="Nhập từ khóa tìm kiếm..." onkeyup="searchFun()"> -->

    </div>

    <div class="room">
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
            if (!empty($result)) {
                foreach ($result as $res) {
            ?>
                <tr>
                    <td><?php echo $res['reservation_id'] ?></td>
                    <td><?php echo $res['name'] ?></td>
                    <td><?php echo number_format($res['room_total']) ?>đ</td>
					<td><?php echo number_format($res['service_total']) ?>đ</td>
					<td><?php echo number_format($res['final_total']) ?>đ</td>
                    <td><?php echo $res['method'] ?></td>
					<td><?php echo date('H:i:s d/m/Y', strtotime($res["created_at"])) ?></td>
                    <td class="action">
                        <a href="invoiceprint.php?id=<?php echo $res['reservation_id']?>"><button class="btn btn-primary ">In</button></a>
                        <?php if(isset($_SESSION['staffRole']) && $_SESSION['staffRole']=='Admin'){ ?>
						<a href="payment.php?delete=<?php echo $res['reservation_id']?>"  onclick="return confirm('Bạn có chắc muốn xóa hóa đơn #<?php echo $res['reservation_id']?> không?')"><button class="btn btn-danger">Xóa</button></a>
                        <?php } ?>
                    </td>
                </tr>
            <?php
             } 
            } else {
                echo "<tr><td colspan='8' style='text-align: center;'>Không tìm thấy kết quả phù hợp.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
  </div>
<?php include('footer.php') ?>
