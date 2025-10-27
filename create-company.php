<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Empresa</title>
    <style>
        /* --- ESTILOS PARA LA VISTA DE FORMULARIO (create-company.php) --- */
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        /* Botón de Volver al Inicio */
        .btn-home {
            text-decoration: none;
            color: #007bff;
            /* Azul */
            font-weight: bold;
            font-size: 1em;
            transition: color 0.3s;
        }

        .btn-home:hover {
            color: #0056b3;
        }

        h1 {
            color: #333;
            font-size: 1.8em;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            /* Asegura que el padding no aumente el ancho total */
            font-size: 1em;
        }

        .btn-submit {
            background-color: #007bff;
            /* Azul */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="wrap-form">
        <a href="home.php" class="back-link">
            &leftarrow; Volver al Inicio
        </a>
        <h2>Registrar Nueva Empresa</h2>

        <form action="index.php" method="POST">

            <label for="nombre_empresa">Nombre de la Empresa:</label>
            <input type="text" id="nombre_empresa" name="nombre_empresa" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>

            <label for="web">Web (URL):</label>
            <input type="url" id="web" name="web">
            <button type="submit" class="btn-submit">
                Crear Empresa
            </button>
        </form>
    </div>
    </form>
    </div>

</body>

</html>