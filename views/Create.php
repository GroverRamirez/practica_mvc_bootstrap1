
<div class="p-3">
    <div class="text-center mb-4">
        <h2>Registro de Nuevo Producto</h2>
        <!-- Botón para volver -->
        <a href="?action=listar" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left-short"></i> Volver a la Lista
        </a>
    </div>

    <!-- Formulario -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <!-- Encabezado -->
                <div class="card-header bg-primary text-white text-center">
                    <h3>Formulario de Registro</h3>
                </div>
                <!-- Cuerpo -->
                <div class="card-body">
                     <form method="POST" action="?action=crear">
                        <!-- Nombre -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">
                                <i class="bi bi-tag"></i> Nombre del Producto *
                            </label>
                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                   placeholder="Ej: Laptop Dell" required>
                        </div>
                        
                        <!-- Precio -->
                        <div class="mb-3">
                            <label for="precio" class="form-label">
                                <i class="bi bi-currency-dollar"></i> Precio *
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">Bs</span>
                                <input type="number" class="form-control" id="precio" name="precio" 
                                       step="0.01" min="0" placeholder="1500.00" required>
                            </div>
                        </div>
                        
                        <!-- Descripción -->
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">
                                <i class="bi bi-card-text"></i> Descripción *
                            </label>
                            <textarea class="form-control" id="descripcion" name="descripcion" 
                                      rows="3" placeholder="Describe las características del producto" required></textarea>
                        </div>
                        
                        <!-- Botones -->
                        <div class="d-grid gap-2">
                            <!-- Enviar -->
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-save"></i> Registrar Producto
                            </button>
                            <!-- Cancelar -->
                            <a href="?action=listar" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>