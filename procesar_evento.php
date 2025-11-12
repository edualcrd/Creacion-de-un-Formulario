<?php
// --- Validación de Datos en Servidor [cite: 94] ---
$errores = [];

// Usamos la superglobal $_POST para acceder a los datos [cite: 12]
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validar campos obligatorios
    if (empty(trim($_POST['nombre']))) $errores[] = "El nombre es obligatorio.";
    if (empty(trim($_POST['email']))) $errores[] = "El email es obligatorio.";
    if (empty($_POST['fecha_nacimiento'])) $errores[] = "La fecha de nacimiento es obligatoria.";
    if (empty($_POST['fecha_evento'])) $errores[] = "La fecha del evento es obligatoria.";
    if (empty($_POST['password'])) $errores[] = "La contraseña es obligatoria.";
    if ($_POST['password'] !== $_POST['confirmar']) $errores[] = "Las contraseñas no coinciden.";
    if (empty($_POST['terminos'])) $errores[] = "Debe aceptar los términos.";

} else {
    $errores[] = "Acceso no válido.";
}

// --- Renderizado de la Página de Recibo [cite: 93] ---
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Recibo de Registro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card">
      <div class="card-header"><h1 class="text-center">Resumen del Registro</h1></div>
      <div class="card-body">

        <?php if (!empty($errores)) : ?>
          <div class="alert alert-danger">
            <h4>Error al procesar:</h4>
            <ul>
              <?php foreach ($errores as $error) : ?>
                <li><?php echo htmlspecialchars($error); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <a href="javascript:history.back()" class="btn btn-warning">Volver al formulario</a>

        <?php else : ?>
          <div class="alert alert-success">
            <strong>¡Gracias, <?php echo htmlspecialchars($_POST['nombre']); ?>!</strong> Registro procesado.
          </div>
          
          <h3 class="mt-4">Datos Registrados:</h3>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($_POST['email']); ?></li>
            <li class="list-group-item"><strong>Teléfono:</strong> <?php echo htmlspecialchars($_POST['telefono'] ?? 'N/A'); ?></li>
            <li class="list-group-item"><strong>Género:</strong> <?php echo htmlspecialchars($_POST['genero'] ?? 'N/A'); ?></li>
            <li class="list-group-item"><strong>Tipo de Entrada:</strong> <?php echo htmlspecialchars($_POST['entrada'] ?? 'N/A'); ?></li>
            
            <?php
            [cite_start]// Los checkboxes se reciben como un array [cite: 9]
            $preferencias = 'Ninguna';
            if (!empty($_POST['comida'])) {
                $preferencias = implode(", ", $_POST['comida']);
            }
            ?>
            <li class="list-group-item"><strong>Preferencias Comida:</strong> <?php echo htmlspecialchars($preferencias); ?></li>
            
            <li class="list-group-item"><strong>Calificación:</strong> <?php echo htmlspecialchars($_POST['calificacion'] ?? 'N/A'); ?></li>
            <li class="list-group-item"><strong>Comentarios:</strong> <?php echo nl2br(htmlspecialchars($_POST['comentarios'] ?? 'N/A')); ?></li>
            
            <?php
            // Manejo del archivo
            $archivo = 'No se subió archivo.';
            if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
                $archivo = "Recibido: " . htmlspecialchars($_FILES['archivo']['name']);
            }
            ?>
            <li class="list-group-item"><strong>Archivo:</strong> <?php echo $archivo; ?></li>
          </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>