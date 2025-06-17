<!-- Filtro de categoría -->
<div class="mb-4">
  <label for="filtroCategoria" class="text-sm font-medium block mb-1">Filtrar por categoría:</label>
  <select id="filtroCategoria" class="w-full md:w-64 p-2 border rounded-[10px] text-sm">
    <option value="todas">Todas</option>
    <option value="tecnica">Técnica</option>
    <option value="automatizada">Automatizada</option>
    <option value="fundamental">Fundamental</option>
  </select>
</div>

<!-- Lista de estrategias públicas -->
<div id="listaEstrategiasPublicas" class="space-y-3">
  <?php
  $estrategias = [
    ['id' => 'public_1', 'nombre' => 'Euro Dollar', 'estado' => 'Activo', 'categoria' => 'tecnica'],
    ['id' => 'public_2', 'nombre' => 'FxCanadian', 'estado' => 'Activo', 'categoria' => 'fundamental'],
    ['id' => 'public_3', 'nombre' => 'FxTrend', 'estado' => 'Activo', 'categoria' => 'automatizada'],
    ['id' => 'public_4', 'nombre' => 'EUR/USD II (VIP)', 'estado' => 'Activo', 'categoria' => 'tecnica'],
    ['id' => 'public_5', 'nombre' => 'CryptoVector (coming soon)', 'estado' => 'Coming soon', 'categoria' => 'automatizada'],
  ];
  foreach ($estrategias as $e): ?>
    <a href="strategy-public.php?id=<?php echo $e['id']; ?>"
       data-categoria="<?php echo $e['categoria']; ?>"
       class="estrategia-publica flex items-center justify-between bg-white p-4 rounded-[10px] shadow hover:bg-gray-50 transition">
      <div class="flex items-center gap-4">
        <div class="bg-yellow-500 text-white w-10 h-10 flex items-center justify-center rounded-full">
          <!-- ícono gráfico de barras -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3v18h18M9 17V9m4 8V5m4 12v-6"/>
          </svg>
        </div>
        <div>
          <h4 class="text-md font-semibold"><?php echo $e['nombre']; ?></h4>
          <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded mt-1 inline-block">
            <?php echo ucfirst($e['categoria']); ?>
          </span>
        </div>
      </div>
      <span class="text-sm px-3 py-1 rounded-full <?php echo $e['estado'] === 'Activo' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600'; ?>">
        <?php echo $e['estado']; ?>
      </span>
    </a>
  <?php endforeach; ?>
</div>

<!-- Script del filtro -->
<script>
  document.getElementById('filtroCategoria').addEventListener('change', function () {
    const categoria = this.value;
    document.querySelectorAll('.estrategia-publica').forEach(el => {
      el.style.display = (categoria === 'todas' || el.dataset.categoria === categoria) ? 'flex' : 'none';
    });
  });
</script>
