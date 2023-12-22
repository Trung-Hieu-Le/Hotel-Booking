<?php include('header.php') ?>
<?php
include '../controllers/reservationController.php';
$controller = new reservationController();
$result = $controller->viewStatistic();
?>

<?php include('sidebar.php') ?>
<div class="main-content">
<?php if(isset($_SESSION['staffRole']) && $_SESSION['staffRole']=='Admin'){ ?>
  <div class="databox">
    <div class="box roombookbox">
      <h3>Tổng số phòng được đặt</h1>
        <h1><?php echo $result['roombookrow'] ?> / <?php echo $result['roomrow'] ?></h1>
    </div>
    <div class="box guestbox">
      <h3>Tổng số đơn đặt phòng</h1>
        <h1><?php echo $result['reservationrow'] ?></h1>
    </div>
    <div class="box profitbox">
      <h3>Doanh thu</h1>
        <h1><?php echo number_format($result['chartData']['tot']) ?>đ</h1>
    </div>
  </div>
  <div class="chartbox">
    <div class="profitchart">
      <div id="profitchart"></div>
      <h3 style="text-align: center;margin:10px 0;">Doanh thu</h3>
    </div>
    <div class="bookroomchart">
      <canvas id="bookroomchart"></canvas>
      <h3 style="text-align: center;margin:10px 0;">Tỉ lệ đặt phòng</h3>
    </div>
  </div>

<?php } else { ?>
  <div>
    <center class="mt-5"><h2>Bạn không được cấp quyền để xem các số liệu thống kê</h2></center>
  </div>

<?php } ?>  
</div>
</body>

<script>
  const labels = Object.keys(<?php echo json_encode($result['statusData']); ?>);
  const data = {
    labels: labels,
    datasets: [{
      label: 'Số đơn đặt phòng',
      backgroundColor: [
        'rgba(51, 153, 225, 1)',
        'rgba(51, 255, 51, 1)',
        'rgba(255, 51, 51, 1)',
      ],
      borderColor: 'black',
      data: Object.values(<?php echo json_encode($result['statusData']); ?>),
    }]
  };
  const doughnutChart = {
    type: 'doughnut',
    data: data,
    options: {}
  };
  const myChart = new Chart(
    document.getElementById('bookroomchart'),
    doughnutChart
  );
</script>
<script>
  Morris.Bar({
    element: 'profitchart',
    data: [<?php echo $result['chartData']['chart_data']; ?>],
    xkey: 'date',
    ykeys: ['profit'],
    labels: ['Profit'],
    hideHover: 'auto',
    stacked: true,
    barColors: [
      'rgba(153, 102, 255, 1)',
    ]
  });
</script>
</html>