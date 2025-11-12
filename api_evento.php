<?php
// Decirle al navegador que la respuesta es JSON
header('Content-Type: application/json');

// --- Validación de Datos en Servidor [cite: 94] ---
$errores = [];
$datosRecibidos = [];

// Como JS envió con FormData, PHP los recibe en $_POST y $_FILES
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validar campos
    if (empty(trim($_POST['nombre']))) $errores[] = "El nombre es obligatorio.";
    if (empty(trim($_POST['email']))) $errores[] = "El email es obligatorio.";
    if (empty($_POST['terminos'])) $errores[] = "Debe aceptar los términos.";
    // ... (añadir todas las demás validaciones)

    // Si NO hay errores, preparamos la respuesta de éxito
    if (empty($errores)) {
        
        // Preparamos los datos para el "recibo" JSON
        $datosRecibidos['nombre'] = $_POST['nombre'] ?? 'N/A';
        $datosRecibidos['email'] = $_POST['email'] ?? 'N/A';
        $datosRecibidos['entrada'] = $_POST['entrada'] ?? 'N/A';
        
        // Manejo de arrays (checkboxes)
        if (!empty($_POST['comida'])) {
            $datosRecibidos['comida'] = implode(", ", $_POST['comida']);
        } else {
            $datosRecibidos['comida'] = 'Ninguna';
        }
        
        // Manejo de archivo
        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
            $datosRecibidos['archivo'] = "Recibido: " . htmlspecialchars($_FILES['archivo']['name']);
        } else {
            $datosRecibidos['archivo'] = 'No se subió archivo.';
        }

        // Crear la respuesta de éxito
        $respuesta = [
            'status' => 'success',
            'message' => '¡Registro recibido con éxito!',
            'data_recibida' => $datosRecibidos
        ];
        
        // Enviar respuesta JSON con código 200 (OK)
        http_response_code(200);
        echo json_encode($respuesta);

    } else {
        // Si HAY errores, crear respuesta de error
        $respuesta = [
            'status' => 'error',
            'message' => 'Fallaron las validaciones del servidor.',
            'errors' => $errores
        ];
        
        // Enviar respuesta JSON con código 400 (Bad Request)
        http_response_code(400);
        echo json_encode($respuesta);
    }

} else {
    // Si alguien intenta acceder con GET
    $respuesta = [
        'status' => 'error',
        'message' => 'Método no permitido. Use POST.'
    ];
    http_response_code(405); // Method Not Allowed
    echo json_encode($respuesta);
}

// El script termina aquí. No hay NADA de HTML.
?>