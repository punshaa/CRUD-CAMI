<?php
include 'auth.php';
include 'db.php';

$success_message = '';
$error_message = '';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$proyecto = $conn->query("SELECT * FROM proyectos WHERE id=$id")->fetch_assoc();

if (!$proyecto) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $titulo = trim($_POST['titulo']);
  $descripcion = trim($_POST['descripcion']);
  $url_github = trim($_POST['url_github']);
  $url_produccion = trim($_POST['url_produccion']);

  // Validar campos requeridos
  if (empty($titulo) || empty($descripcion)) {
    $error_message = "El título y la descripción son campos obligatorios.";
  } else {
    $img_sql = "";
    
    // Procesar imagen si se subió una nueva
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
      $imagen = $_FILES['imagen']['name'];
      $tmp = $_FILES['imagen']['tmp_name'];
      $extension = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));
      
      // Validar tipo de archivo
      $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
      if (in_array($extension, $allowed_types)) {
        // Generar nombre único para la imagen
        $imagen_nueva = uniqid() . '.' . $extension;
        
        if (move_uploaded_file($tmp, "uploads/$imagen_nueva")) {
          // Eliminar imagen anterior si existe
          if (!empty($proyecto['imagen']) && file_exists("uploads/" . $proyecto['imagen'])) {
            unlink("uploads/" . $proyecto['imagen']);
          }
          $img_sql = ", imagen='$imagen_nueva'";
        } else {
          $error_message = "Error al subir la nueva imagen.";
        }
      } else {
        $error_message = "Tipo de archivo no permitido. Solo se aceptan JPG, PNG, GIF y WebP.";
      }
    }
    
    if (empty($error_message)) {
      $sql = "UPDATE proyectos SET titulo=?, descripcion=?, url_github=?, url_produccion=? $img_sql WHERE id=?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssssi", $titulo, $descripcion, $url_github, $url_produccion, $id);
      
      if ($stmt->execute()) {
        $success_message = "Proyecto actualizado exitosamente.";
        // Recargar datos del proyecto
        $proyecto = $conn->query("SELECT * FROM proyectos WHERE id=$id")->fetch_assoc();
      } else {
        $error_message = "Error al actualizar el proyecto en la base de datos.";
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proyecto - Portafolio Camila</title>
    <!-- Bootstrap CSS 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-code me-2"></i>
                <span>Portafolio Camila</span>
            </a>
            <div class="ms-auto">
                <a href="index.php" class="btn btn-outline-custom">
                    <i class="fas fa-arrow-left me-2"></i>Volver al Dashboard
                </a>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <section class="page-header" style="margin-top: 76px;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="animate-fade-in">
                        <h1 class="page-title">
                            <i class="fas fa-edit me-3"></i>
                            Editar Proyecto
                        </h1>
                        <p class="page-subtitle">
                            Actualiza la información de "<?= htmlspecialchars($proyecto['titulo']) ?>"
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="animate-fade-in animate-delay-1">
                        <div class="icon-badge">
                            <i class="fas fa-edit"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container mb-5">
        <div class="row">
            <!-- Formulario -->
            <div class="col-lg-8">
                <div class="form-container animate-fade-in animate-delay-2">
                    <!-- Success/Error Messages -->
                    <?php if(!empty($success_message)): ?>
                        <div class="alert alert-success border-0 rounded-3 mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-2"></i>
                                <div><?= htmlspecialchars($success_message) ?></div>
                            </div>
                            <div class="mt-2">
                                <a href="index.php" class="btn btn-success btn-sm">
                                    <i class="fas fa-eye me-1"></i>Ver mis proyectos
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if(!empty($error_message)): ?>
                        <div class="alert alert-danger border-0 rounded-3 mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <div><?= htmlspecialchars($error_message) ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Form -->
                    <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <div class="row">
                            <!-- Título del Proyecto -->
                            <div class="col-12 mb-4">
                                <label for="titulo" class="form-label form-label-custom">
                                    <i class="fas fa-heading me-2"></i>Título del Proyecto *
                                </label>
                                <input type="text" 
                                       name="titulo" 
                                       id="titulo"
                                       class="form-control form-control-custom" 
                                       placeholder="Ej: Sistema de Gestión de Inventarios"
                                       value="<?= htmlspecialchars($proyecto['titulo']) ?>"
                                       maxlength="100"
                                       required>
                                <div class="invalid-feedback">
                                    Por favor ingresa un título para tu proyecto.
                                </div>
                                <div class="form-text">
                                    <small class="text-muted">Máximo 100 caracteres</small>
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="col-12 mb-4">
                                <label for="descripcion" class="form-label form-label-custom">
                                    <i class="fas fa-align-left me-2"></i>Descripción *
                                </label>
                                <textarea name="descripcion" 
                                          id="descripcion"
                                          class="form-control form-control-custom" 
                                          rows="4"
                                          placeholder="Describe tu proyecto, tecnologías utilizadas, características principales..."
                                          maxlength="500"
                                          required><?= htmlspecialchars($proyecto['descripcion']) ?></textarea>
                                <div class="invalid-feedback">
                                    Por favor ingresa una descripción para tu proyecto.
                                </div>
                                <div class="form-text">
                                    <small class="text-muted">
                                        <span id="charCount">0</span>/500 caracteres
                                    </small>
                                </div>
                            </div>

                            <!-- URLs -->
                            <div class="col-md-6 mb-4">
                                <label for="url_github" class="form-label form-label-custom">
                                    <i class="fab fa-github me-2"></i>URL de GitHub
                                </label>
                                <input type="url" 
                                       name="url_github" 
                                       id="url_github"
                                       class="form-control form-control-custom" 
                                       placeholder="https://github.com/usuario/proyecto"
                                       value="<?= htmlspecialchars($proyecto['url_github']) ?>">
                                <div class="form-text">
                                    <small class="text-muted">Enlace al repositorio de código</small>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="url_produccion" class="form-label form-label-custom">
                                    <i class="fas fa-external-link-alt me-2"></i>URL de Producción
                                </label>
                                <input type="url" 
                                       name="url_produccion" 
                                       id="url_produccion"
                                       class="form-control form-control-custom" 
                                       placeholder="https://miproyecto.com"
                                       value="<?= htmlspecialchars($proyecto['url_produccion']) ?>">
                                <div class="form-text">
                                    <small class="text-muted">Enlace al proyecto en vivo</small>
                                </div>
                            </div>

                            <!-- Imagen -->
                            <div class="col-12 mb-4">
                                <label for="imagen" class="form-label form-label-custom">
                                    <i class="fas fa-image me-2"></i>Imagen del Proyecto
                                </label>
                                <input type="file" 
                                       name="imagen" 
                                       id="imagen"
                                       class="form-control form-control-custom" 
                                       accept="image/*">
                                <div class="form-text">
                                    <small class="text-muted">
                                        Deja vacío para mantener la imagen actual. Formatos: JPG, PNG, GIF, WebP. Máximo: 5MB
                                    </small>
                                </div>
                                <!-- Preview de imagen nueva -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px; max-height: 200px;">
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-3 justify-content-end">
                                    <a href="index.php" class="btn btn-outline-custom">
                                        <i class="fas fa-times me-2"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary-custom">
                                        <i class="fas fa-save me-2"></i>Actualizar Proyecto
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Vista Previa Actual -->
            <div class="col-lg-4">
                <div class="form-container animate-fade-in animate-delay-3">
                    <h5 class="text-primary-custom mb-3">
                        <i class="fas fa-eye me-2"></i>Vista Actual
                    </h5>
                    
                    <div class="project-card">
                        <img src="uploads/<?= htmlspecialchars($proyecto['imagen']) ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($proyecto['titulo']) ?>"
                             style="height: 200px; object-fit: cover;">
                        
                        <div class="card-body p-3">
                            <h6 class="card-title text-primary-custom mb-2">
                                <?= htmlspecialchars($proyecto['titulo']) ?>
                            </h6>
                            <p class="card-text text-muted small">
                                <?= htmlspecialchars(substr($proyecto['descripcion'], 0, 100)) ?>...
                            </p>
                            
                            <div class="d-flex gap-2 mb-3">
                                <?php if(!empty($proyecto['url_github'])): ?>
                                    <a href="<?= htmlspecialchars($proyecto['url_github']) ?>" 
                                       class="btn btn-outline-success btn-sm" 
                                       target="_blank">
                                        <i class="fab fa-github me-1"></i>Código
                                    </a>
                                <?php endif; ?>
                                
                                <?php if(!empty($proyecto['url_produccion'])): ?>
                                    <a href="<?= htmlspecialchars($proyecto['url_produccion']) ?>" 
                                       class="btn btn-primary-custom btn-sm" 
                                       target="_blank">
                                        <i class="fas fa-external-link-alt me-1"></i>Demo
                                    </a>
                                <?php endif; ?>
                            </div>
                            
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt me-1"></i>
                                <?= date('d/m/Y', strtotime($proyecto['created_at'])) ?>
                            </small>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <div class="d-grid gap-2">
                            <a href="delete.php?id=<?= $proyecto['id'] ?>" 
                               class="btn btn-danger-custom"
                               onclick="return confirm('¿Estás seguro de eliminar este proyecto? Esta acción no se puede deshacer.')">
                                <i class="fas fa-trash-alt me-2"></i>Eliminar Proyecto
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // Character counter for description
        const descripcion = document.getElementById('descripcion');
        const charCount = document.getElementById('charCount');
        
        descripcion.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
        
        // Set initial character count
        charCount.textContent = descripcion.value.length;

        // Image preview
        document.getElementById('imagen').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });

        // Smooth animations on load
        document.addEventListener('DOMContentLoaded', function() {
            const animatedElements = document.querySelectorAll('.animate-fade-in');
            animatedElements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    el.style.transition = 'all 0.6s ease-out';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });

        // Auto focus on title field
        document.getElementById('titulo').focus();
    </script>
</body>
</html>