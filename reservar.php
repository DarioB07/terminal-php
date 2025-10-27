<?php
error_reporting(E_ALL);

// Conexión a la base de datos
require_once('./config/db.php');

// Consultas para llenar los Dropdowns
$sql = "SELECT * FROM company";
$companies = $conn->query($sql);

$sqltravels = "SELECT * from travel t join vehicle v on t.vehicle_id = v.id join path p on t.path_id = p.id join schedule s on t.schedule_id = s.id";
$travels = $conn->query($sqltravels);

$sqlclients = "select * from client";
$clients = $conn->query($sqlclients);

//logica paara guardar la reserva insert en 'quotes'

$error_db = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reservar'])) {

    // Recoger y limpiar/validar los datos
    $id_travel = isset($_POST['id_ruta']) ? (int)$_POST['id_ruta'] : 0;
    $id_client = isset($_POST['id_cliente']) ? (int)$_POST['id_cliente'] : 0;
    $pasajeros = isset($_POST['asientos']) ? (int)$_POST['asientos'] : 1;
    $fecha_reserva = date('Y-m-d H:i:s');

    if ($id_travel > 0 && $id_client > 0) {

        // Consulta INSERT a 'quotes' (Asumiendo que SOLO tiene id, date, client_id, travel_id)
        $sql_insert = "INSERT INTO quotes (date, client_id, travel_id, asientos) VALUES (?, ?, ?, ?)";

        // SI YA AGREGASTE LA COLUMNA 'ASIENTOS' A TU TABLA 'QUOTES', usa este INSERT en su lugar:
        // $sql_insert = "INSERT INTO quotes (date, client_id, travel_id, asientos) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql_insert)) {

            // Asumiendo 3 parámetros: s=string, i=int, i=int
            $stmt->bind_param("siii", $fecha_reserva, $id_client, $id_travel, $pasajeros);

            // Si usaste 4 parámetros (con asientos):
            // $stmt->bind_param("siii", $fecha_reserva, $id_client, $id_travel, $pasajeros);

            if ($stmt->execute()) {
                // Éxito: Redirigir para mostrar el mensaje de éxito y actualizar la tabla
                header("Location: reservar.php?success=1&p=" . $pasajeros);
                exit();
            } else {
                $error_db = "❌ Error al guardar la reserva: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error_db = "❌ Error preparando la consulta: " . $conn->error;
        }
    } else {
        $error_db = "❌ Por favor, selecciona una ruta y un cliente válidos.";
    }
}

// ----------------------------------------------
// 2. CONSULTA CORREGIDA PARA OBTENER EL LISTADO DE RESERVAS
// ----------------------------------------------

// ----------------------------------------------
// CONSULTA FINAL PARA OBTENER EL LISTADO REAL DE RESERVAS Y ASIENTOS
// ----------------------------------------------

$sqlreservas = "
    SELECT
        q.id AS reserva_id,
        c.name AS client_name,
        pa.origin,
        pa.destination,
        t.value,
        q.asientos AS asientos_reservados  -- <<-- AHORA TOMAMOS EL VALOR REAL DE ASIENTOS
    FROM
        quotes q
    JOIN client c ON c.id = q.client_id
    JOIN travel t ON t.id = q.travel_id
    JOIN path pa ON pa.id = t.path_id
    ORDER BY q.id ASC
";
$reservas_resultado = $conn->query($sqlreservas);
// ... el resto de tu código PHP

function esc($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 30px;
            /* Aumentamos el padding para más espacio blanco */
            background-color: #e4e4e4ff;
            /* Fondo blanco */
            border: 2px solid #000000ff;
            /* Borde azul primario de Bootstrap */
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(84, 118, 227, 0.98);
            /* Sombra suave */
        }

        /* Estilo para los títulos */
        h2 {
            color: #000000ff;
            /* Azul oscuro para los encabezados */
            padding-bottom: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }

        /* Ajustar el color de las etiquetas (labels) */
        label {
            color: #000000ff;
            /* Gris oscuro para el texto */
            font-weight: bold;
        }
    </style>
    <title>Reservar</title>

</head>

<body>

    <div class="container form-container">
        <h2>Realizar Cotizacion</h2>

        <form method="post" action="" class="form">
            <div class="row mb-3">
                <label for="id_ruta">Ruta</label>
                <select name="id_ruta" id="id_ruta" class="form-control" required>
                    <option value="">Seleccione una ruta</option>
                    <?php foreach ($travels as $r): ?>
                        <option value="<?php echo esc($r['id']); ?>">
                            <?php echo esc($r['origin']) . ' &rarr; ' . esc($r['destination']); ?>
                            — $<?php echo number_format((float)$r['value'], 0, ',', '.'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row mb-3">
                <label for="id_cliente">Cliente</label>
                <select name="id_cliente" id="id_cliente" class="form-control" required>
                    <option value="">Seleccione un cliente</option>
                    <?php foreach ($clients as $r): ?>
                        <option value="<?php echo esc($r['id']); ?>">
                            <?php echo esc($r['name']) . ' &rarr; ' . esc($r['email']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row mb-3">
                <label for="fecha">Fecha del viaje</label>
                <input type="date" name="fecha" id="fecha" class="form-control" required>
            </div>

            <div class="row mb-3">
                <label for="asientos">Cantidad de pasajeros</label>
                <input type="number" name="asientos" id="asientos" class="form-control" min="1" value="1" required>
            </div>

            <div class="row">
                <button type="submit" name="reservar" value="1" class="btn btn-primary mr-2">Cotizar</button>
                <a href="rutas.php" class="btn btn-link">Ver listado de rutas</a>
            </div>
        </form>

        <hr>

        <?php if (!empty($error_db)): ?>
            <div class="alert alert-danger mt-3" role="alert">
                **Error de Base de Datos:** <?php echo $error_db; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div class="alert alert-success mt-3" role="alert">
                <h4 class="alert-heading">Cotizacion Guardada con Exito</h4>
                <p>Se ha registrado tu solicitud de reserva para <?php echo esc($_GET['p']); ?> pasajeros.</p>
                <hr>
            </div>
        <?php endif; ?>
        <hr>

        <hr>

        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>

            <div class="row">
                <h2>Listado de Reservas</h2>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ruta</th>
                            <th>Cliente</th>
                            <th>Asientos</th>
                            <th>Valor Unitario</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Aseguramos que la consulta se ejecute antes de la tabla
                        // (Aunque ya está en la parte superior, no está de más)
                        $reservas_resultado = $conn->query($sqlreservas);

                        if ($reservas_resultado && $reservas_resultado->num_rows > 0) {
                            while ($reserva = $reservas_resultado->fetch_assoc()):
                                $total = $reserva['value'] * $reserva['asientos_reservados'];
                        ?>
                                <tr>
                                    <td><?php echo $reserva['reserva_id']; ?></td>
                                    <td><?php echo esc($reserva['origin']) . ' &rarr; ' . esc($reserva['destination']); ?></td>
                                    <td><?php echo esc($reserva['client_name']); ?></td>
                                    <td><?php echo esc($reserva['asientos_reservados']); ?></td>
                                    <td>$<?php echo number_format($reserva['value'], 0, ',', '.'); ?></td>
                                    <td>**$<?php echo number_format($total, 0, ',', '.'); ?>**</td>
                                </tr>
                        <?php endwhile;
                        } else {
                            echo '<tr><td colspan="6">No hay reservas registradas en la tabla quotes.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>
        </tbody>
        </table>
    </div>
    </div>

</body>

</html>