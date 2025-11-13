<?php
// Procesar los datos enviados por el formulario

function limpiar($valor) {
  return htmlspecialchars(stripslashes(trim($valor)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = limpiar($_POST["nombre"]);
  $email = limpiar($_POST["email"]);
  $telefono = limpiar($_POST["telefono"]);
  $nacimiento = limpiar($_POST["nacimiento"]);
  $genero = limpiar($_POST["genero"]);
  $fecha_evento = limpiar($_POST["fecha_evento"]);
  $tipo_entrada = limpiar($_POST["tipo_entrada"]);
  $usuario = limpiar($_POST["usuario"]);
  $calificacion = limpiar($_POST["calificacion"]);
  $comentarios = limpiar($_POST["comentarios"]);
  
  $comida = isset($_POST["comida"]) ? implode(", ", $_POST["comida"]) : "Ninguna seleccionada";
  $notificaciones = isset($_POST["notificaciones"]) ? "Sí" : "No";
  $terminos = isset($_POST["terminos"]) ? "Aceptados" : "No aceptados";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Datos del Registro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h1 class="text-center text-primary mb-4">Recibo de Registro</h1>

    <div class="card shadow">
      <div class="card-body">
        <h4 class="text-secondary mb-3">Información Personal</h4>
        <p><strong>Nombre:</strong> <?= $nombre ?></p>
        <p><strong>Email:</strong> <?= $email ?></p>
        <p><strong>Teléfono:</strong> <?= $telefono ?></p>
        <p><strong>Fecha de nacimiento:</strong> <?= $nacimiento ?></p>
        <p><strong>Género:</strong> <?= $genero ?></p>

        <hr>
        <h4 class="text-secondary mb-3">Información del Evento</h4>
        <p><strong>Fecha del evento:</strong> <?= $fecha_evento ?></p>
        <p><strong>Tipo de entrada:</strong> <?= $tipo_entrada ?></p>
        <p><strong>Preferencias de comida:</strong> <?= $comida ?></p>

        <hr>
        <h4 class="text-secondary mb-3">Información de Acceso</h4>
        <p><strong>Usuario:</strong> <?= $usuario ?></p>

        <hr>
        <h4 class="text-secondary mb-3">Preferencias</h4>
        <p><strong>Desea recibir notificaciones:</strong> <?= $notificaciones ?></p>
        <p><strong>Términos y condiciones:</strong> <?= $terminos ?></p>

        <hr>
        <h4 class="text-secondary mb-3">Encuesta</h4>
        <p><strong>Calificación:</strong> <?= $calificacion ?>/10</p>
        <p><strong>Comentarios:</strong> <?= $comentarios ?></p>
      </div>
    </div>

    <div class="text-center mt-4">
      <a href="index.html" class="btn btn-secondary">Volver al formulario</a>
    </div>
  </div>
</body>
</html>
