<?php
include 'auth.php';
include 'db.php';
$result = $conn->query("SELECT * FROM proyectos ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portafolio de Proyectos - Dashboard</title>
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
            <a class="navbar-brand" href="#">
                <i class="fas fa-code me-2"></i>
                <span>Portafolio Camila</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto d-flex gap-2">
                    <a href="add.php" class="btn btn-new-project">
                        <i class="fas fa-plus me-2"></i>Nuevo Proyecto
                    </a>
                    <a href="logout.php" class="btn btn-danger-custom">
                        <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                    </a>
                </div>
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
                            <i class="fas fa-briefcase me-3"></i>
                            Mi Portafolio
                        </h1>
                        <p class="page-subtitle">
                            Gestiona y muestra tus proyectos de desarrollo de manera profesional
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="animate-fade-in animate-delay-1">
                        <div class="d-flex justify-content-lg-end justify-content-center gap-3 mt-3 mt-lg-0">
                            <div class="text-center">
                                <div class="h3 fw-bold mb-0"><?= $result->num_rows ?></div>
                                <small class="opacity-75">Proyectos</small>
                            </div>
                            <div class="text-center">
                                <div class="h3 fw-bold mb-0">100%</div>
                                <small class="opacity-75">Completado</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container mb-5">
        <?php if($result->num_rows == 0): ?>
            <!-- Empty State -->
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="py-5">
                        <div class="icon-badge mx-auto mb-4">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <h3 class="text-primary-custom mb-3">¡Comienza tu portafolio!</h3>
                        <p class="text-muted mb-4">
                            Aún no tienes proyectos en tu portafolio. Agrega tu primer proyecto para comenzar a mostrar tu trabajo.
                        </p>
                        <a href="add.php" class="btn btn-primary-custom btn-lg">
                            <i class="fas fa-plus me-2"></i>Agregar Primer Proyecto
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Projects Grid -->
            <div class="row g-4">
                <?php 
                $delay = 1;
                while($row = $result->fetch_assoc()): 
                ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="project-card h-100 animate-fade-in animate-delay-<?= $delay ?>">
                            <div class="position-relative">
                                <img src="uploads/<?= htmlspecialchars($row['imagen']) ?>" 
                                     class="card-img-top" 
                                     alt="<?= htmlspecialchars($row['titulo']) ?>"
                                     loading="lazy">
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-success rounded-pill">
                                        <i class="fas fa-check me-1"></i>Activo
                                    </span>
                                </div>
                            </div>
                            
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start justify-content-between mb-3">
                                    <h5 class="card-title mb-0"><?= htmlspecialchars($row['titulo']) ?></h5>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary border-0" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="edit.php?id=<?= $row['id'] ?>">
                                                <i class="fas fa-edit me-2"></i>Editar
                                            </a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="delete.php?id=<?= $row['id'] ?>" 
                                                   onclick="return confirm('¿Estás seguro de eliminar este proyecto?')">
                                                <i class="fas fa-trash-alt me-2"></i>Eliminar
                                            </a></li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <p class="card-text text-muted"><?= htmlspecialchars($row['descripcion']) ?></p>
                                
                                <div class="d-flex gap-2 mb-4">
                                    <?php if(!empty($row['url_github'])): ?>
                                        <a href="<?= htmlspecialchars($row['url_github']) ?>" 
                                           class="btn btn-outline-custom btn-sm" 
                                           target="_blank" rel="noopener">
                                            <i class="fab fa-github me-1"></i>Código
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if(!empty($row['url_produccion'])): ?>
                                        <a href="<?= htmlspecialchars($row['url_produccion']) ?>" 
                                           class="btn btn-primary-custom btn-sm" 
                                           target="_blank" rel="noopener">
                                            <i class="fas fa-external-link-alt me-1"></i>Demo
                                        </a>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="d-flex align-items-center justify-content-between">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        <?= date('d/m/Y', strtotime($row['created_at'])) ?>
                                    </small>
                                    <div class="d-flex gap-1">
                                        <a href="edit.php?id=<?= $row['id'] ?>" 
                                           class="btn btn-outline-success btn-sm" 
                                           title="Editar proyecto">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php 
                    $delay = $delay < 3 ? $delay + 1 : 1;
                    endwhile; 
                ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="bg-primary-custom text-white py-4 mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">
                        <i class="fas fa-code me-2"></i>
                        © 2024 PortaDev. Desarrollado con <i class="fas fa-heart text-danger"></i>
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="d-flex justify-content-md-end justify-content-center gap-3 mt-2 mt-md-0">
                        <a href="#" class="text-white text-decoration-none">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="#" class="text-white text-decoration-none">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="text-white text-decoration-none">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Animaciones suaves al cargar
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

        // Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
</body>
</html>