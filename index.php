<?php
// Incluir el archivo de conexión
require_once 'conexion.php';

// Obtener todas las órdenes de la base de datos ordenadas por ID descendente
try {
    $stmt = $pdo->query("SELECT * FROM ordenes ORDER BY id DESC");
    $ordenes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    $ordenes = [];
    $error_db = "Error al obtener las órdenes de la base de datos: " . $e->getMessage();
}

$status = $_GET['status'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicio Técnico - Panel de Control</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Hojas de Estilo -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="app-container">
    
    <!-- Sección del Formulario -->
    <div class="form-section">
        <h2>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 8px;"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
            Registrar Equipo
        </h2>
        
        <?php if ($status === 'success'): ?>
            <div class="alert alert-success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>¡Orden guardada con éxito en la base de datos!</span>
            </div>
        <?php endif; ?>

        <?php if (isset($error_db)): ?>
            <div class="alert alert-error">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <span><?php echo htmlspecialchars($error_db); ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" action="test.php">
            <div class="form-group">
                <label for="cliente">Cliente</label>
                <input type="text" id="cliente" name="cliente" placeholder="Nombre completo del cliente" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="equipo">Equipo / Modelo</label>
                <input type="text" id="equipo" name="equipo" placeholder="Ej: iPhone 13, Laptop Asus ROG" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="problema">Descripción del Problema</label>
                <textarea id="problema" name="problema" placeholder="Detalle la falla del equipo..." required></textarea>
            </div>

            <button type="submit">
                Registrar Orden
            </button>
        </form>
    </div>

    <!-- Sección del Listado en Base de Datos -->
    <div class="list-section">
        <h2>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 8px;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="3" x2="9" y2="21"></line><line x1="15" y1="3" x2="15" y2="21"></line><line x1="3" y1="9" x2="21" y2="9"></line><line x1="3" y1="15" x2="21" y2="15"></line></svg>
            Ordenes en la Base de Datos
        </h2>
        
        <div class="list-container">
            <?php if (empty($ordenes)): ?>
                <div class="empty-state">
                    <div class="empty-icon">📂</div>
                    <p>No hay órdenes registradas en la base de datos aún.</p>
                </div>
            <?php else: ?>
                <?php foreach ($ordenes as $orden): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <span class="client-name">
                                #<?php echo $orden['id']; ?> - <?php echo htmlspecialchars($orden['cliente']); ?>
                            </span>
                            <span class="order-date">
                                <?php echo date("d/m/Y H:i", strtotime($orden['fecha_ingreso'] ?? 'now')); ?>
                            </span>
                        </div>
                        <div class="device-badge">
                            <?php echo htmlspecialchars($orden['equipo']); ?>
                        </div>
                        <p class="problem-desc">
                            <?php echo nl2br(htmlspecialchars($orden['problema'])); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

</div>

</body>
</html>
