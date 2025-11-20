<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-person-circle me-2"></i>
                    Iniciar Sesión
                </h4>
            </div>
            
            <div class="card-body p-4">
                <!-- Mensajes de error -->
                <?php if(isset($mensaje) && isset($tipoMensaje)): ?>
                <div class="alert alert-<?php echo $tipoMensaje; ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-<?php echo $tipoMensaje === 'success' ? 'check-circle' : ($tipoMensaje === 'danger' ? 'exclamation-triangle' : 'info-circle'); ?> me-2"></i>
                    <?php echo $mensaje; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <!-- Formulario de login -->
                <form method="POST" action="?action=login">
                    <div class="mb-3">
                        <label for="username" class="form-label">
                            <i class="bi bi-person me-1"></i>
                            Usuario o Email
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="username" 
                               name="username" 
                               placeholder="Ingresa tu usuario o email"
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                               required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock me-1"></i>
                            Contraseña
                        </label>
                        <input type="password" 
                               class="form-control" 
                               id="password" 
                               name="password" 
                               placeholder="Ingresa tu contraseña"
                               required>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Iniciar Sesión
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="card-footer text-center bg-light">
                <small class="text-muted">
                    ¿No tienes cuenta? 
                    <a href="?action=registrar" class="text-decoration-none">
                        <i class="bi bi-person-plus me-1"></i>
                        Crear Cuenta
                    </a>
                </small>
                <hr class="my-2">
                <small class="text-muted">
                    <i class="bi bi-shield-check me-1"></i>
                    Sistema de Gestión de Productos
                </small>
            </div>
        </div>
        
        <!-- Información de credenciales de prueba -->
        <div class="card mt-3">
            <div class="card-body text-center">
                <h6 class="card-title text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Credenciales de Prueba
                </h6>
                <p class="card-text small text-muted mb-1">
                    <strong>Usuario:</strong> admin<br>
                    <strong>Contraseña:</strong> admin123
                </p>
            </div>
        </div>
    </div>
</div>