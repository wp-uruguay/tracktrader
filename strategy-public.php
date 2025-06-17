<?php
$id = $_GET['id'] ?? null;

if (!$id || !str_starts_with($id, 'public_')) {
    header("Location: index.php");
    exit;
}

$jsonPath = __DIR__ . '/strategy_public_data.json';
if (!file_exists($jsonPath)) {
    die("No se encontró el archivo de estrategias públicas.");
}
$data = json_decode(file_get_contents($jsonPath), true);
$strategy = $data[$id] ?? null;

if (!$strategy) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?php echo $strategy['name']; ?> | Estrategia Pública</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <style>body { font-family: 'Montserrat', sans-serif; }</style>
</head>
<body class="bg-gray-100 min-h-screen">
<?php include 'header.php'; ?>

<div class="max-w-7xl mx-auto p-6 bg-white rounded-[10px] shadow">
  <a href="index.php" class="text-blue-600 text-sm">← Volver</a>
  <div class="mb-4">
    <h1 class="text-2xl font-bold"><?php echo $strategy['name']; ?></h1>
    <p class="text-sm text-gray-500"><?php echo $strategy['type']; ?> · <?php echo $strategy['platform']; ?></p>
    <span class="text-xs bg-yellow-200 text-yellow-800 px-2 py-1 rounded">Estrategia pública</span>
  </div>

  <div class="grid md:grid-cols-2 gap-6 mb-6">
    <div class="bg-white p-4 rounded-[10px] border">
      <h3 class="font-semibold mb-2">Stats</h3>
      <div class="space-y-1 text-sm text-gray-700">
        <p>Gain: <strong class="text-green-600">+<?php echo $strategy['gain']; ?>%</strong></p>
        <p>Abs. Gain: +<?php echo $strategy['absGain']; ?>%</p>
        <p>Daily: <?php echo $strategy['daily']; ?>%</p>
        <p>Monthly: <?php echo $strategy['monthly']; ?>%</p>
        <p>Drawdown: <?php echo $strategy['drawdown']; ?>%</p>
        <p>Balance: <?php echo $strategy['balance']; ?></p>
        <p>Equity: <?php echo $strategy['equity']; ?></p>
        <p>Highest: <?php echo $strategy['highest']; ?></p>
        <p>Profit: <span class="text-green-600"><?php echo $strategy['profit']; ?></span></p>
        <p>Interest: <?php echo $strategy['interest']; ?></p>
        <p>Deposits: <?php echo $strategy['deposits']; ?></p>
        <p>Withdrawals: <?php echo $strategy['withdrawals']; ?></p>
        <p>Updated: <?php echo $strategy['updated']; ?></p>
        <p>Tracking: <?php echo $strategy['tracking']; ?></p>
      </div>
    </div>

    <div class="bg-white p-4 rounded-[10px] border">
      <h3 class="font-semibold mb-2">Growth</h3>
      <canvas id="growthChart" height="200"></canvas>
    </div>
  </div>

  <div class="mb-6">
    <h3 class="font-semibold mb-2">Monthly Analytics</h3>
    <canvas id="monthlyChart" height="100"></canvas>
  </div>

  <div class="mb-6 overflow-x-auto">
    <h3 class="font-semibold mb-2">Trading Periods</h3>
    <table class="w-full text-sm text-left border">
      <thead class="bg-gray-100 text-gray-700">
        <tr>
          <th class="px-3 py-2">Periodo</th>
          <th class="px-3 py-2">Gain</th>
          <th class="px-3 py-2">Profit</th>
          <th class="px-3 py-2">Pips</th>
          <th class="px-3 py-2">Win%</th>
          <th class="px-3 py-2">Trades</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($strategy['periods'] as $period => $info): ?>
          <tr class="border-t">
            <td class="px-3 py-2 font-medium"><?php echo ucfirst($period); ?></td>
            <td class="px-3 py-2"><?php echo $info['gain']; ?>%</td>
            <td class="px-3 py-2"><?php echo $info['profit']; ?></td>
            <td class="px-3 py-2"><?php echo $info['pips']; ?></td>
            <td class="px-3 py-2"><?php echo $info['win']; ?>%</td>
            <td class="px-3 py-2"><?php echo $info['trades']; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="mb-6">
    <h3 class="font-semibold mb-2">Trading Activity</h3>
    <table id="historyTable" class="display w-full text-sm">
      <thead>
        <tr><th>Fecha</th><th>Par</th><th>Tipo</th><th>Lotes</th><th>Resultado</th></tr>
      </thead>
      <tbody>
        <tr><td>06/09/2025</td><td>EURUSD</td><td>Buy</td><td>0.02</td><td>0.52</td></tr>
        <tr><td>06/09/2025</td><td>EURUSD</td><td>Sell</td><td>0.03</td><td>-0.13</td></tr>
        <tr><td>06/09/2025</td><td>EURUSD</td><td>Buy</td><td>0.02</td><td>0.59</td></tr>
      </tbody>
    </table>
  </div>

  <div class="grid md:grid-cols-2 gap-6">
    <div class="bg-gray-50 p-4 rounded-[10px]">
      <h3 class="font-semibold mb-2">Advanced Stats</h3>
      <p class="text-sm">Total Trades: <strong><?php echo $strategy['advanced']['totalTrades']; ?></strong></p>
      <p class="text-sm">Win Rate: <?php echo $strategy['advanced']['winRate']; ?>%</p>
      <p class="text-sm">Longs Won: <?php echo $strategy['advanced']['longs']; ?>%</p>
      <p class="text-sm">Shorts Won: <?php echo $strategy['advanced']['shorts']; ?>%</p>
      <p class="text-sm">Avg Win: <?php echo $strategy['advanced']['avgWin']; ?> pips</p>
      <p class="text-sm">Avg Loss: <?php echo $strategy['advanced']['avgLoss']; ?> pips</p>
      <p class="text-sm">Best: <?php echo $strategy['advanced']['best']; ?></p>
      <p class="text-sm">Worst: <?php echo $strategy['advanced']['worst']; ?></p>
    </div>
    <div class="bg-gray-50 p-4 rounded-[10px]">
      <h3 class="font-semibold mb-2">Metrics</h3>
      <p class="text-sm">Profit Factor: <?php echo $strategy['advanced']['profitFactor']; ?></p>
      <p class="text-sm">Z-Score: <?php echo $strategy['advanced']['zscore']; ?></p>
      <p class="text-sm">Expectancy: <?php echo $strategy['advanced']['expectancy']; ?></p>
      <p class="text-sm">AHPR: <?php echo $strategy['advanced']['ahpr']; ?></p>
      <p class="text-sm">GHPR: <?php echo $strategy['advanced']['ghpr']; ?></p>
      <p class="text-sm">Lots: <?php echo $strategy['advanced']['lots']; ?></p>
      <p class="text-sm">Comisiones: <?php echo $strategy['advanced']['commissions']; ?></p>
      <p class="text-sm">Avg Trade Length: <?php echo $strategy['advanced']['avgLength']; ?></p>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
  new DataTable('#historyTable');
  new Chart(document.getElementById('growthChart'), {
    type: 'line',
    data: {
      labels: Array.from({length: 30}, (_, i) => `Día ${i+1}`),
      datasets: [{
        label: 'Crecimiento',
        data: Array.from({length: 30}, () => Math.random() * 100),
        borderColor: '#f59e0b',
        fill: false
      }]
    }
  });
  new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
      labels: ['Ene','Feb','Mar','Abr','May','Jun'],
      datasets: [{
        label: 'Ganancia mensual (%)',
        data: <?php echo json_encode($strategy['monthlyGain']); ?>,
        backgroundColor: '#3b82f6'
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
