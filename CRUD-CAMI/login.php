<?php
session_start();
include 'db.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = md5($_POST['password']);

  $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = $conn->query($sql);

  if ($result->num_rows === 1) {
    $_SESSION['user'] = $username;
    header("Location: index.php");
  } else {
    $error_message = "Credenciales incorrectas. Por favor, verifica tu usuario y contraseña.";
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Portafolio Camila</title>
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
    <div class="login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7 col-sm-9">
                    <div class="login-card animate-fade-in">
                        <!-- Logo/Brand -->
                        <div class="text-center mb-4">
                            <div class="icon-badge mx-auto mb-3">
                                <i class="fas fa-code"></i>
                            </div>
                            <h1 class="login-title">Portafolio Camila</h1>
                            <p class="login-subtitle">
                                Accede a tu portafolio de proyectos
                            </p>
                        </div>

                        <!-- Error Alert -->
                        <?php if(!empty($error_message)): ?>
                            <div class="alert alert-danger border-0 rounded-3 mb-4" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <div><?= htmlspecialchars($error_message) ?></div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Login Form -->
                        <form method="post" class="needs-validation" novalidate>
                            <div class="mb-4">
                                <label for="username" class="form-label form-label-custom">
                                    <i class="fas fa-user me-2"></i>Usuario
                                </label>
                                <input type="text" 
                                       name="username" 
                                       id="username"
                                       class="form-control form-control-custom" 
                                       placeholder="Ingresa tu usuario"
                                       value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
                                       required>
                                <div class="invalid-feedback">
                                    Por favor ingresa tu usuario.
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label form-label-custom">
                                    <i class="fas fa-lock me-2"></i>Contraseña
                                </label>
                                <div class="position-relative">
                                    <input type="password" 
                                           name="password" 
                                           id="password"
                                           class="form-control form-control-custom" 
                                           placeholder="Ingresa tu contraseña"
                                           required>
                                    <button type="button" 
                                            class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted border-0 bg-transparent"
                                            id="togglePassword"
                                            style="z-index: 5;">
                                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">
                                    Por favor ingresa tu contraseña.
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember">
                                    <label class="form-check-label text-muted" for="remember">
                                        Recordarme
                                    </label>
                                </div>
                                <a href="#" class="text-decoration-none text-primary-custom">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            </div>

                            <button type="submit" class="btn btn-primary-custom w-100 py-3 mb-4">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Iniciar Sesión
                            </button>
                        </form>

                        <!-- Additional Links -->
                        <div class="text-center">
                            <p class="text-muted mb-3">
                                ¿No tienes una cuenta?
                                <a href="#" class="text-primary-custom text-decoration-none fw-medium">
                                    Regístrate aquí
                                </a>
                            </p>
                            
                            <div class="border-top pt-3">
                                <small class="text-muted">
                                    <i class="fas fa-shield-alt me-1"></i>
                                    Conexión segura y cifrada
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="text-center mt-4">
                        <small class="text-white-50">© 2024 Portafolio Camila. Todos los derechos reservados.</small>
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

        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Smooth animations on load
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.login-card');
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });

        // Auto focus on username field
        document.getElementById('username').focus();
    </script>
</body>
</html>

