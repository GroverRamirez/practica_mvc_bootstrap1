<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-person-plus me-2"></i>
                    Crear Cuenta
                </h4>
            </div>
            
            <div class="card-body p-4">
                <!-- Mensajes de error/éxito -->
                <?php if(isset($mensaje) && isset($tipoMensaje)): ?>
                <div class="alert alert-<?php echo $tipoMensaje; ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-<?php echo $tipoMensaje === 'success' ? 'check-circle' : ($tipoMensaje === 'danger' ? 'exclamation-triangle' : 'info-circle'); ?> me-2"></i>
                    <?php echo $mensaje; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <!-- Formulario de registro -->
                <form method="POST" action="?action=procesarRegistro" id="formRegistro">
                    <!-- Nombre completo -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label">
                            <i class="bi bi-person me-1"></i>
                            Nombre Completo *
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="nombre" 
                               name="nombre" 
                               placeholder="Ingresa tu nombre completo"
                               value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>"
                               required>
                    </div>
                    
                    <!-- Username -->
                    <div class="mb-3">
                        <label for="username" class="form-label">
                            <i class="bi bi-at me-1"></i>
                            Nombre de Usuario *
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="username" 
                               name="username" 
                               placeholder="Ej: juan123"
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                               required>
                        <div class="form-text">Solo letras, números y guiones bajos</div>
                    </div>
                    
                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope me-1"></i>
                            Correo Electrónico *
                        </label>
                        <input type="email" 
                               class="form-control" 
                               id="email" 
                               name="email" 
                               placeholder="tu@email.com"
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                               required>
                    </div>
                    
                    <!-- Contraseña -->
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock me-1"></i>
                            Contraseña *
                        </label>
                        <input type="password" 
                               class="form-control" 
                               id="password" 
                               name="password" 
                               placeholder="Mínimo 6 caracteres"
                               required>
                        <div class="form-text">Mínimo 6 caracteres</div>
                    </div>
                    
                    <!-- Confirmar contraseña -->
                    <div class="mb-4">
                        <label for="confirmar_password" class="form-label">
                            <i class="bi bi-lock-fill me-1"></i>
                            Confirmar Contraseña *
                        </label>
                        <input type="password" 
                               class="form-control" 
                               id="confirmar_password" 
                               name="confirmar_password" 
                               placeholder="Repite tu contraseña"
                               required>
                    </div>
                    
                    <!-- Botón de registro -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-person-plus me-2"></i>
                            Crear Cuenta
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="card-footer text-center bg-light">
                <small class="text-muted">
                    ¿Ya tienes cuenta? 
                    <a href="?action=login" class="text-decoration-none">
                        <i class="bi bi-box-arrow-in-right me-1"></i>
                        Iniciar Sesión
                    </a>
                </small>
            </div>
        </div>
        
        <!-- Información adicional -->
        <div class="card mt-3">
            <div class="card-body text-center">
                <h6 class="card-title text-muted">
                    <i class="bi bi-shield-check me-1"></i>
                    Información Segura
                </h6>
                <p class="card-text small text-muted mb-0">
                    Tus datos están protegidos con encriptación de contraseñas y conexión segura.
                </p>
            </div>
        </div>
    </div>
</div>
