<?php
// --- 1. Validación de Datos en Servidor  ---

$errores = [];

// Solo procesamos si el método es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validar campos obligatorios
    if (empty(trim($_POST['nombre']))) {
        $errores[] = "El nombre completo es obligatorio.";
    }
    if (empty(trim($_POST['email'])) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo electrónico no es válido.";
    }
    if (empty($_POST['fecha_nacimiento'])) {
        $errores[] = "La fecha de nacimiento es obligatoria."; [cite: 91]
    }
    if (empty($_POST['genero'])) {
        $errores[] = "El género es obligatorio.";
    }
    if (empty($_POST['fecha_evento'])) {
        $errores[] = "La fecha del evento es obligatoria."; [cite: 91]
    }
    if (empty($_POST['entrada'])) {
        $errores[] = "El tipo de entrada es obligatorio.";
    }
    if (empty($_POST['usuario'])) {
        $errores[] = "El usuario es obligatorio.";
    }
    if (empty($_POST['password']) || empty($_POST['confirmar'])) {
        $errores[] = "La contraseña y su confirmación son obligatorias."; [cite: 89]
    } elseif ($_POST['password'] !== $_POST['confirmar']) {
        $errores[] = "Las contraseñas no coinciden."; [cite: 71]
    }
    if (empty($_POST['terminos'])) {
        $errores[] = "Debe aceptar los términos y condiciones."; [cite: 92]
    }

    // Validación del archivo (opcional, pero buena práctica)
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
        if ($_FILES['archivo']['size'] > 5000000) { // 5MB
            $errores[] = "El archivo es demasiado grande (máx 5MB).";
        }
    }

} else {
    // Si no es POST, es un acceso no válido
    $errores[] = "Acceso no válido. Por favor, envía el formulario.";
}

// --- 2. Renderizado de la Página de Recibo  ---
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recibo de Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-10 col-lg-8">
        <div class="card">
          <div class="card-header bg-primary text-white">
            <h1 class="text-center mb-0">Resumen del Registro</h1>
          </div>
          <div class="card-body p-4">

            <?php
            // --- 3. Mostrar Errores o Recibo ---

            // Si hay errores de validación del servidor, los mostramos
            if (!empty($errores)) :
            ?>
              <div class="alert alert-danger">
                <h4 class="alert-heading">Error al procesar el formulario:</h4>
                <ul class="mb-0">
                  <?php foreach ($errores as $error) : ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <div class="text-center">
                <a href="javascript:history.back()" class="btn btn-danger">Volver al formulario</a>
              </div>

            <?php
            // Si NO hay errores, mostramos el recibo con los datos
            else :
            ?>
              <div class="alert alert-success">
                <strong>¡Gracias, <?php echo htmlspecialchars($_POST['nombre']); ?>!</strong> Tu registro ha sido procesado correctamente.
              </div>
              
              <h3 class="mt-4 mb-3">Datos Registrados:</h3>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($_POST['email']); ?></li>
                <li class="list-group-item"><strong>Teléfono:</strong> <?php echo htmlspecialchars($_POST['telefono'] ?? 'No especificado'); ?></li>
                <li class="list-group-item"><strong>F. Nacimiento:</strong> <?php echo htmlspecialchars($_POST['fecha_nacimiento']); ?></li>
                <li class="list-group-item"><strong>Género:</strong> <?php echo htmlspecialchars($_POST['genero']); ?></li>
                <li class="list-group-item"><strong>Fecha Evento:</strong> <?php echo htmlspecialchars($_POST['fecha_evento']); ?></li>
                <li class="list-group-item"><strong>Tipo de Entrada:</strong> <?php echo htmlspecialchars($_POST['entrada']); ?></li>
                
                <?php
                [cite_start]// Manejo especial para las casillas de verificación (array 'comida[]') [cite: 67]
                $preferencias = 'Ninguna seleccionada';
                if (!empty($_POST['comida'])) {
                    // Usamos htmlspecialchars en cada item antes de unirlos
                    $comidasLimpias = array_map('htmlspecialchars', $_POST['comida']);
                    $preferencias = implode(", ", $comidasLimpias);
                }
                echo '<li class="list-group-item"><strong>Preferencias Comida:</strong> ' . $preferencias . '</li>';
                ?>
                
                <li class="list-group-item"><strong>Usuario:</strong> <?php echo htmlspecialchars($_POST['usuario']); ?></li>
                <li class="list-group-item"><strong>Notificaciones:</strong> <?php echo isset($_POST['notificaciones']) ? 'Sí' : 'No'; ?></li>
<li class="list-group-item"><strong>Calificación:</strong> <?php echo htmlspecialchars($_POST['calificacion'] ?? 'No calificado'); ?></li>
                <li class="list-group-item"><strong>Comentarios:</strong> <?php echo nl2br(htmlspecialchars($_POST['comentarios'] ?? 'Sin comentarios')); ?></li>

                <?php
                [cite_start]// Manejo del archivo adjunto [cite: 80]
                $archivoMsg = 'No se adjuntó archivo.';
                if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
                    $archivoMsg = htmlspecialchars($_FILES['archivo']['name']) . ' (' . round($_FILES['archivo']['size'] / 1024, 2) . ' KB)';
                }
                echo '<li class="list-group-item"><strong>Archivo Adjunto:</strong> ' . $archivoMsg . '</li>';
                ?>
              </ul>

            <?php endif; // Fin del bloque else (no hay errores) ?>

          </div> </div> </div> </div>   </div> </body>
</html>