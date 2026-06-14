<?php
require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente = trim($_POST["cliente"] ?? '');
    $equipo = trim($_POST["equipo"] ?? '');
    $problema = trim($_POST["problema"] ?? '');

    if (!empty($cliente) && !empty($equipo) && !empty($problema)) {
        try {
            // El ID no se incluye en la consulta INSERT para que la base de datos
            // lo autoincremente automáticamente utilizando la secuencia SERIAL (nextval).
            $sql = "INSERT INTO ordenes (cliente, equipo, problema) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$cliente, $equipo, $problema]);

            // Redirigimos a index.php con un indicador de éxito
            header("Location: index.php?status=success");
            exit;
        } catch (\PDOException $e) {
            // Si hay un error, lo mostramos en pantalla
            die("Error al insertar los datos en PostgreSQL: " . $e->getMessage());
        }
    } else {
        die("Error: Todos los campos del formulario son obligatorios.");
    }
} else {
    // Si acceden directamente a este archivo, redirigir a index.php
    header("Location: index.php");
    exit;
}
?>
