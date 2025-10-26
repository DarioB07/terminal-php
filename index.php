<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexión (opcional, ya que la página principal puede funcionar sin BD)
require __DIR__ . '/config/db.php';

// Base URL: importante para que todas las rutas internas se resuelvan correctamente
$BASE_URL = '';
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Terminal de Transportes Libertadores – Yopal</title>
  <meta name="description" content="Consulta empresas vinculadas, rutas, horarios, costos y cotiza en línea en la Terminal de Transportes Libertadores – Yopal." />

  <!-- Hace que TODAS las rutas relativas apunten a /terminal_transporte/ -->
  <base href="<?= htmlspecialchars($BASE_URL, ENT_QUOTES) ?>">

  <link rel="stylesheet" href="css/styles.css" />
</head>

<body class="theme-azul">

  <!-- Header -->
  <header class="wrap">
    <nav class="nav card" aria-label="Navegación principal">
      <div class="brand" aria-label="Marca">
        <div class="logo">
          <img src="img/logo.png" alt="Logo Terminal Libertadores Yopal" />
        </div>
        <span>Terminal de Transportes Libertadores – Yopal</span>
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
        alt="Terminal de Transportes Libertadores – Yopal"
        loading="lazy" />
    </aside>
  </main>

  <!-- Empresas -->
  <section id="empresas" class="wrap section card" aria-labelledby="empresas-title">
    <h2 id="empresas-title">Empresas vinculadas</h2>

    <div class="grid-emp">
      <!-- Empresa 1 -->
      <article class="card emp-card" aria-label="Flota Libertadores">
        <div class="emp-logo">
          <img src="img/flota.png" alt="Logo Flota Libertadores" />
        </div>
        <div class="emp-meta">
          <strong>Flota Libertadores</strong>
          <small>Rutas: Yopal – Bogotá – Villavicencio</small><br />
          <small>Tel: (608) 634 4030 · contacto@flotalibertadores.com</small>
        </div>
        <a class="btn-link" href="https://www.flotalibertadores.com" target="_blank" rel="noopener">Ver más</a>
      </article>

      <!-- Empresa 2 -->
      <article class="card emp-card" aria-label="Transportes Morichal">
        <div class="emp-logo">
          <img src="img/morichal.png" alt="Logo Transportes Morichal" />
        </div>
        <div class="emp-meta">
          <strong>Transportes Morichal</strong>
          <small>Rutas: Yopal – Villavicencio – Bogotá</small><br />
          <small>Tel: (608) 634 2111 · atencion@morichal.com.co</small>
        </div>
        <a class="btn-link" href="https://morichal.com.co" target="_blank" rel="noopener">Ver más</a>
      </article>

      <!-- Empresa 3 -->
      <article class="card emp-card" aria-label="Sugamuxi S.A.">
        <div class="emp-logo">
          <img src="img/sugamuxi.png" alt="Logo Sugamuxi S.A." />
        </div>
        <div class="emp-meta">
          <strong>Sugamuxi S.A.</strong>
          <small>Rutas: Yopal – Sogamoso – Tunja – Bogotá</small><br />
          <small>Tel: (608) 770 2222 · contacto@sugamuxi.com</small>
        </div>
        <a class="btn-link" href="https://www.sugamuxi.com" target="_blank" rel="noopener">Ver más</a>
      </article>
    </div>
  </section>

  <!-- Rutas -->
  <section id="rutas" class="wrap section card" aria-labelledby="rutas-title">
    <h2 id="rutas-title">Rutas y horarios</h2>
    <div class="table">
      <table role="table" aria-describedby="rutas-help">
        <thead>
          <tr>
            <th scope="col">Destino</th>
            <th scope="col">Hora de salida</th>
            <th scope="col">Estado</th>
            <th scope="col">Costo</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Bogotá</td>
            <td>08:30 AM</td>
            <td class="badge-ok">En horario</td>
            <td>$ 120.000</td>
          </tr>
          <tr>
            <td>Tunja</td>
            <td>10:00 AM</td>
            <td class="badge-warn">Retrasado</td>
            <td>$ 80.000</td>
          </tr>
          <tr>
            <td>Villavicencio</td>
            <td>01:15 PM</td>
            <td class="badge-ok">En horario</td>
            <td>$ 95.000</td>
          </tr>
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

      <form id="contacto" class="card form" aria-labelledby="con-title" onsubmit="return validarContacto(event)">
        <h2 id="con-title">Contacto</h2>
        <div class="field"><label for="nombre">Nombre</label><input id="nombre" name="nombre" required /></div>
        <div class="field"><label for="email">Correo</label><input id="email" name="email" type="email" required /></div>
        <div class="field"><label for="mensaje">Mensaje</label><textarea id="mensaje" name="mensaje"></textarea></div>
        <button class="btn" type="submit">Enviar mensaje</button>
        <div class="muted" style="margin-top:.5rem">Formulario demostrativo</div>
      </form>
    </div>
  </section>

  <!-- Footer -->
  <footer class="wrap">
    <div class="foot card">
      <div>© Terminal de Transportes Libertadores – Yopal</div>
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