<?php
if (!isset($_SESSION['session'])) {
    echo '<p class="text-gray-500">Conecta tu cuenta de Myfxbook para ver el sentimiento del mercado.</p>';
    return;
}

$session = $_SESSION['session'];
$url = 'https://www.myfxbook.com/api/get-community-outlook.json?session=' . urlencode($session);
$response = @file_get_contents($url);
$data = json_decode($response, true);

if (!isset($data['symbols']) || !is_array($data['symbols']) || count($data['symbols']) === 0) {
    // Fallback con datos simulados
    $data = [
        'symbols' => [
            ['name' => 'EURUSD', 'longPercentage' => 55.1, 'shortPercentage' => 44.9],
            ['name' => 'GBPUSD', 'longPercentage' => 48.3, 'shortPercentage' => 51.7],
            ['name' => 'USDJPY', 'longPercentage' => 62.7, 'shortPercentage' => 37.3],
            ['name' => 'AUDUSD', 'longPercentage' => 40.2, 'shortPercentage' => 59.8],
            ['name' => 'USDCAD', 'longPercentage' => 51.5, 'shortPercentage' => 48.5],
            ['name' => 'USDCHF', 'longPercentage' => 46.8, 'shortPercentage' => 53.2]
        ]
    ];
}

$symbols = array_slice($data['symbols'], 0, 6);
?>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
  <?php foreach ($symbols as $symbol): ?>
    <?php
      $long = round($symbol['longPercentage'], 1);
      $short = round($symbol['shortPercentage'], 1);
    ?>
    <div class="bg-white rounded-[10px] p-4 shadow">
      <h4 class="text-md font-semibold mb-2"><?php echo $symbol['name']; ?></h4>
      <div class="text-sm text-gray-600 mb-1">
        Compradores (Long): <strong><?php echo $long; ?>%</strong><br>
        Vendedores (Short): <strong><?php echo $short; ?>%</strong>
      </div>
      <div class="w-full bg-gray-200 rounded h-3 overflow-hidden flex">
        <div class="bg-green-400 h-full" style="width: <?php echo $long; ?>%"></div>
        <div class="bg-red-400 h-full" style="width: <?php echo $short; ?>%"></div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
