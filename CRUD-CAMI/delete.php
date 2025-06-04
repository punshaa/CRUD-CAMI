<?php
include 'auth.php';
include 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

// Obtener información del proyecto antes de eliminarlo
$proyecto = $conn->query("SELECT * FROM proyectos WHERE id=$id")->fetch_assoc();

if (!$proyecto) {
    header("Location: index.php");
    exit;
}

// Eliminar el proyecto
$sql = "DELETE FROM proyectos WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Eliminar la imagen del servidor si existe
    if (!empty($proyecto['imagen']) && file_exists("uploads/" . $proyecto['imagen'])) {
        unlink("uploads/" . $proyecto['imagen']);
    }
}

// Redirigir al index
header("Location: index.php?deleted=1");
exit;
?>