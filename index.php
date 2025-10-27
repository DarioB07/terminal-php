<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexión (opcional, ya que la página principal puede funcionar sin BD)
require __DIR__ . '/config/db.php';
// Hacer una consulta
$sql = "SELECT * FROM company";
$companies = $conn->query($sql);

$sqlschedule = "select * from travel t
join vehicle v on t.vehicle_id = v.id 
join `path` p on t.path_id = p.id 
join schedule s on t.schedule_id = s.id";

$travels = $conn->query($sqlschedule);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_company') {

  // 2. Recolección y saneamiento de datos
  $name = trim(htmlspecialchars($_POST['name']));
  $email = trim(htmlspecialchars($_POST['email']));
  $phone = trim(htmlspecialchars($_POST['phone']));
  $web = trim(htmlspecialchars($_POST['web']));

  // 3. Ejecución de la Inserción (USANDO DECLARACIONES PREPARADAS)
  try {
    // Asumiendo que tu tabla se llama 'companies'
    $sql = "INSERT INTO companies (name, email, phone, web) VALUES (:name, :email, :phone, :web)";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
      ':name' => $name,
      ':email' => $email,
      ':phone' => $phone,
      ':web' => $web
    ]);

    // 4. Redirección al home para ver el resultado
    header('Location: /');
    exit;
  } catch (PDOException $e) {
    // Manejo de error (p. ej., registrarlo o mostrar un mensaje al usuario)
    // echo "Error al guardar: " . $e->getMessage();
  }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Terminal de Transportes Pasto</title>
  <meta name="description" content="Consulta empresas vinculadas, rutas, horarios, costos y cotiza en línea en la Terminal de Transportes Pasto." />
  <link rel="stylesheet" href="css/styles.css" />
  <style>
    /* --- ESTILOS PARA LA VISTA PRINCIPAL (index.php) --- */

    body {
      font-family: sans-serif;
      margin: 0;
      padding: 20px;
      background-color: #f4f4f9;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
    }

    /* Estilo para el botón "Crear Nueva Empresa" */
    .btn-create-company {
      display: inline-block;
      background-color: #28a745;
      /* Verde */
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 5px;
      margin-bottom: 20px;
      font-weight: bold;
      transition: background-color 0.3s;
    }

    .btn-create-company:hover {
      background-color: #218838;
    }

    /* Estilos para el grid de empresas */
    .companies-grid {
      display: grid;
      /* Dos columnas de igual tamaño */
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      /* Espacio entre las tarjetas */
    }

    .company-card {
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s;
    }

    .company-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .company-card h3 {
      margin-top: 0;
      color: #007bff;
      /* Azul */
      font-size: 1.5em;
      border-bottom: 2px solid #f8f9fa;
      padding-bottom: 10px;
      margin-bottom: 10px;
    }

    .company-card p {
      margin: 5px 0;
      color: #555;
    }

    .company-card strong {
      color: #333;
    }

    /* Media query para hacer una sola columna en pantallas pequeñas */
    @media (max-width: 768px) {
      .companies-grid {
        grid-template-columns: 1fr;
        /* Una sola columna */
      }
    }
  </style>
</head>

<body class="theme-azul">

  <!-- Header -->
  <header class="wrap">
    <nav class="nav card" aria-label="Navegación principal">
      <div class="brand" aria-label="Marca">
        <div class="logo">
          <img src="img/logo.png" alt="Logo Terminal Pasto " />
        </div>
        <span>Terminal de Transportes Pasto</span>
      </div>

      <div class="grow"></div>

      <!-- Botón hamburguesa -->
      <button class="hamburger" aria-label="Abrir menú" id="btnMenu"
        aria-expanded="false" aria-controls="menu">☰</button>

      <!-- Menú principal -->
      <ul id="menu" class="menu" role="menubar">
        <li role="none"><a role="menuitem" href="index.php">Inicio</a></li>
        <li role="none"><a role="menuitem" href="rutas.php">Rutas</a></li>
        <li role="none"><a role="menuitem" href="empresas.php">Empresas</a></li>
        <li role="none"><a role="menuitem" href="contacto.php">Contacto</a></li>
        <li role="none"><a role="menuitem" href="reservar.php">Reservar</a></li>
        <li role="none"><a role="menuitem" href="cotizacion.php">Cotizar</a></li>
      </ul>

      <!-- CTA -->
      <button class="cta" type="button"
        onclick="document.getElementById('costos')?.scrollIntoView({behavior:'smooth'})">
        Cotizar ahora
      </button>
    </nav>
  </header>

  <!-- Hero -->
  <main id="inicio" class="wrap card hero" aria-labelledby="hero-title">
    <section>
      <h1 id="hero-title">Viaja seguro y a tiempo</h1>
      <p class="muted">
        Consulta empresas vinculadas, rutas, horarios y costos. <br />
        Solicita tu cotización en línea de forma rápida.
      </p>
      <div class="hero-cta">
        <button class="btn" type="button"
          onclick="document.getElementById('rutas').scrollIntoView({behavior:'smooth'})">
          Ver rutas disponibles
        </button>
        <!-- Accesos directos a páginas dinámicas -->
        <a class="btn-link" href="rutas.php">Ver listado de rutas</a>
        <a class="btn-link" href="cotizacion.php">Ir a cotizar</a>
      </div>
    </section>

    <aside class="ph" aria-label="Imagen ilustrativa de la terminal">
      <img
        src="img/terminal.png"
        alt="Terminal de Transportes Pasto – "
        loading="lazy" />
    </aside>
  </main>

  <!-- Empresas -->

  <section id="empresas" class="wrap section card" aria-labelledby="empresas-title">
    <h2 id="empresas-title">Empresas vinculadas</h2>
    <a href="/create-company.php" class="btn-create-company">
      Crear Nueva Empresa
    </a>
    <div class="grid-emp">
      <?php foreach ($companies as $company): ?>
        <!-- Empresa 1 -->
        <article class="card emp-card" aria-label="Flota Pasto">
          <div class="header-actions">
          </div>
          <div class="emp-logo">
            <img src="<?= "img/{$company['name']}.png" ?>" alt="Logo de empresa">
          </div>
          <div class="emp-meta">
            <strong><?= (int)$company['id'] ?></strong>
            <strong><?= (string)$company['name'] ?></strong>
            <!--<small>Rutas: – Bogotá – Villavicencio</small><br /> -->
            <small>Tel: <?= (string)$company['phone'] ?> · <?= (string)$company['email'] ?></small>
          </div>
          <a class="btn-link" href="<?= "{$company['web']}" ?> " target="_blank" rel="noopener">Ver más</a>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Rutas -->
  <section id="rutas" class="wrap section card" aria-labelledby="rutas-title">
    <h2 id="rutas-title">Rutas y horarios</h2>
    <div class="table">
      <table role="table" aria-describedby="rutas-help">
        <thead>
          <tr>
            <th scope="col">Origen</th>
            <th scope="col">Destino</th>
            <th scope="col">Hora de salida</th>
            <th scope="col">Estado</th>
            <th scope="col">Costo</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($travels as $travel): ?>
            <tr>
              <td><?= "{$travel['origin']}" ?></td>
              <td><?= "{$travel['destination']}" ?></td>
              <td>08:30 AM</td>
              <td class="badge-ok">En horario</td>
              <td>$ <?= "{$travel['value']}" ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="muted" id="rutas-help">
      Ejemplo estático. Para listado completo, usa “Ver listado de rutas”.
    </div>
  </section>

  <!-- Costos y Contacto -->
  <section id="costos" class="wrap section">
    <div class="cols-2">
      <form class="card form" aria-labelledby="cot-title" action="cotizacion.php" method="post">
        <h2 id="cot-title">Costos y cotización</h2>
        <div class="field"><label for="origen">Origen</label><input id="origen" name="origen" required /></div>
        <div class="field"><label for="destino">Destino</label><input id="destino" name="destino" required /></div>
        <div class="field"><label for="fecha">Fecha</label><input id="fecha" name="fecha" type="date" required /></div>
        <div class="field"><label for="correo">Correo</label><input id="correo" name="correo" type="email" required /></div>
        <button class="btn" type="submit">Solicitar cotización</button>
        <div class="muted" style="margin-top:.5rem">
          ¿Prefieres la herramienta completa? <a href="cotizacion.php">Ir a cotizar</a>
        </div>
      </form>
    </div>
  </section>

  <!-- Footer -->
  <footer class="wrap">
    <div class="foot card">
      <div>© Terminal de Transportes Pasto – </div>
      <div><a href="#">Políticas de privacidad</a> • <a href="#">Términos y condiciones</a></div>
      <div style="margin-top:.5rem">
        <a href="<?= htmlspecialchars($BASE_URL, ENT_QUOTES) ?>">Volver al inicio</a>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="js/script.js"></script>
  <script>
    // Menú responsive
    const btn = document.getElementById('btnMenu');
    const menu = document.getElementById('menu');
    btn?.addEventListener('click', () => {
      const open = btn.getAttribute('aria-expanded') === 'true';
      btn.setAttribute('aria-expanded', String(!open));
      menu.classList.toggle('is-open', !open);
    });

    // Evitar error si validarContacto no existe en script.js
    function validarContacto(e) {
      return false;
    }
  </script>
</body>

</html>