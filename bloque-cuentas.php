<?php
// Obtener cuentas reales desde la API si hay token
$cuentas = [];
if (isset($_SESSION['session'])) {
    $apiUrl = 'https://www.myfxbook.com/api/get-my-accounts.json?session=' . urlencode($_SESSION['session']);
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);
    if ($data && isset($data['accounts'])) {
        $cuentas = $data['accounts'];
    }
}

// Agregar cuentas demo almacenadas en la sesión
if (isset($_SESSION['demo_accounts'])) {
    $cuentas = array_merge($cuentas, $_SESSION['demo_accounts']);
}

$tieneCuentas = count($cuentas) > 0;
?>

<?php if ($tieneCuentas): ?>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
    <?php foreach ($cuentas as $cuenta): ?>
      <?php
        $isDemo = isset($cuenta['accountType']) && $cuenta['accountType'] === 'Demo';
        $claseCard = $isDemo 
            ? 'bg-white' 
            : 'bg-green-50 border border-green-200';
      ?>
      <div class="<?php echo $claseCard; ?> rounded-[10px] p-4 shadow flex flex-col justify-between">
        <div>
          <div class="flex justify-between items-center mb-2">
            <h4 class="font-semibold text-lg"><?php echo $cuenta['name']; ?></h4>
            <?php if ($isDemo): ?>
              <span class="text-xs px-2 py-1 rounded bg-yellow-200 text-yellow-800">DEMO</span>
            <?php endif; ?>
          </div>
          <p class="text-sm text-gray-500"><?php echo $cuenta['broker'] ?? 'Sin broker'; ?></p>
          <p class="text-sm mt-2"><strong>Ganancia:</strong> <?php echo round($cuenta['gain'] ?? 0, 2); ?>%</p>
          <p class="text-sm"><strong>Drawdown:</strong> <?php echo round($cuenta['drawdown'] ?? 0, 2); ?>%</p>
        </div>
        <div class="pt-4 flex justify-between items-center">
          <a href="strategy.php?id=<?php echo urlencode($cuenta['id']); ?>" class="text-blue-600 text-sm">Ver estrategia</a>
          <?php if ($isDemo): ?>
            <form method="post" action="eliminar-cuenta-demo.php" onsubmit="return confirm('¿Eliminar esta cuenta demo?');">
              <input type="hidden" name="id" value="<?php echo $cuenta['id']; ?>">
              <button type="submit" title="Eliminar" class="text-red-500 hover:text-red-700"><i class='fas fa-trash-alt'></i></button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-[10px]">
    <p>No tienes cuentas conectadas. Puedes conectar una o agregar una cuenta demo para aprender a utilizar el sistema de analisis de trading.</p>
  </div>
<?php endif; ?>
