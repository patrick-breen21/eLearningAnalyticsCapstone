<?php
  
  $metrics = [];

  $metrics['goal'] = [
    'heading' => 'Logged Time And Goal Time Per Week',
    'file' => 'metrics-goal.php',
  ];
  
  $metrics['grade'] = [
    'heading' => 'Logged Time And Other Students time per grade',
    'file' => 'metrics-grade.php',
  ];
  
  if (isset($_GET['chart']) && $_GET['chart'] != '' && $metrics[$_GET['chart']]) $metric = $metrics[$_GET['chart']];
  else $metric = $metrics['goal'];
  
  $heading = $metric['heading'];
?>
  <script src="https://d3js.org/d3.v4.min.js"></script>

  <h2 class="">Metrics</h2>
<?php include 'form-goal.php' ?>
<?php include 'form-logging.php' ?>

<?php include $metrics['goal']['file']; ?>
<?php include $metrics['grade']['file']; ?>