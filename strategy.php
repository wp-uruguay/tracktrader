<?php
require 'functions.php';
requireLogin();

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

$isFake = intval($id) >= 999000;
$stats = $history = $dailyGain = [];

if ($isFake) {
    // Simulada
    $stats = [
        'name' => 'Demo Strategy A',
        'gain' => 18.2,
        'drawdown' => 4.5,
        'trades' => 134,
        'balance' => '1200 USD',
        'monthlyGain' => [1.2, 2.5, 1.8, 2.1, 3.3, 2.9],
        'growth' => [2, 4.5, 5.3, 6.1, 7.0, 9.3],
        'history' => [
            ['01/05/2025', 'EURUSD', 'Buy', 0.1, 3.4],
            ['02/05/2025', 'EURUSD', 'Sell', 0.1, -1.2],
            ['03/05/2025', 'EURUSD', 'Buy', 0.1, 2.1],
        ]
    ];
} else {
    // Cuenta real conectada
    $acc = callMyfxbookAPI('get-account-statistics', ['session' => $_SESSION['session'], 'id' => intval($id)]);
    if (empty($acc['name'])) {
        header("Location: index.php");
        exit;
    }
    $stats = [
        'name' => $acc['name'],
        'gain' => $acc['gain'],
        'drawdown' => $acc['drawdown'],
        'trades' => $acc['trades'],
        'balance' => $acc['balance'] . ' ' . $acc['currency'],
        'monthlyGain' => [$acc['monthly'],0,0,0,0,0],
        'growth' => [$acc['gain'] * 0.2, $acc['gain'] * 0.4, $acc['gain'] * 0.5, $acc['gain'] * 0.6, $acc['gain'] * 0.8, $acc['gain']],
    ];
    $res = callMyfxbookAPI('get-history', ['session' => $_SESSION['session'], 'id' => $id]);
    $history = $res['history'] ?? [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?php echo $stats['name']; ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <style>body { font-family: 'Montserrat', sans-serif; }</style>
</head>
<body class="bg-gray-100 min-h-screen">
<?php include 'header.php'; ?>

<div class="max-w-5xl mx-auto bg-white p-6 rounded-[10px] shadow space-y-6">
  <a href="index.php" class="text-blue-600 text-sm">← Volver</a>
  <h1 class="text-2xl font-bold"><?php echo $stats['name']; ?></h1>

  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-gray-100 p-4 rounded-[10px]"><p class="text-sm text-gray-500">Ganancia</p><p class="font-bold text-xl"><?php echo $stats['gain']; ?>%</p></div>
    <div class="bg-gray-100 p-4 rounded-[10px]"><p class="text-sm text-gray-500">Drawdown</p><p class="font-bold text-xl"><?php echo $stats['drawdown']; ?>%</p></div>
    <div class="bg-gray-100 p-4 rounded-[10px]"><p class="text-sm text-gray-500">Trades</p><p class="font-bold text-xl"><?php echo $stats['trades']; ?></p></div>
    <div class="bg-gray-100 p-4 rounded-[10px]"><p class="text-sm text-gray-500">Balance</p><p class="font-bold text-xl"><?php echo $stats['balance']; ?></p></div>
  </div>

  <h3 class="font-semibold mb-2">Crecimiento</h3>
  <canvas id="growthChart"></canvas>

  <h3 class="font-semibold mt-6 mb-2">Ganancia mensual</h3>
  <canvas id="monthlyChart"></canvas>

  <h3 class="font-semibold mt-6 mb-2">Historial de operaciones</h3>
  <table id="historyTable" class="display w-full text-sm">
    <thead>
      <tr><th>Fecha</th><th>Par</th><th>Tipo</th><th>Lotes</th><th>Resultado</th></tr>
    </thead>
    <tbody>
      <?php foreach ($isFake ? $stats['history'] : $history as $op): ?>
        <tr>
          <td><?= $isFake ? $op[0] : $op['closeTime'] ?></td>
          <td><?= $isFake ? $op[1] : $op['symbol'] ?></td>
          <td><?= $isFake ? $op[2] : $op['action'] ?></td>
          <td><?= $isFake ? $op[3] : $op['sizing']['value'] ?></td>
          <td><?= $isFake ? $op[4] : $op['profit'] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
  new DataTable('#historyTable');

  new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
      labels: ['Ene','Feb','Mar','Abr','May','Jun'],
      datasets: [{
        label: 'Ganancia mensual (%)',
        data: <?php echo json_encode($stats['monthlyGain']); ?>,
        backgroundColor: '#3b82f6'
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true } }
    }
  });

  new Chart(document.getElementById('growthChart'), {
    type: 'line',
    data: {
      labels: ['Ene','Feb','Mar','Abr','May','Jun'],
      datasets: [{
        label: 'Crecimiento (%)',
        data: <?php echo json_encode($stats['growth']); ?>,
        backgroundColor: 'rgba(34,197,94,0.2)',
        borderColor: '#22c55e',
        fill: true,
        tension: 0.3
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true } }
    }
  });
</script>
</body>
</html>
