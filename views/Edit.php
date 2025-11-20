<div class="p-3">
    <div class="text-center mb-4">
        <h2>Editar Producto</h2>
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
                    <h3>Editar Producto</h3>
                </div>
                <!-- Cuerpo -->
                <div class="card-body">
                    <form method="POST" action="?action=actualizar" enctype="multipart/form-data">
                        <!-- Campo oculto para el ID -->
                        <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                        
                        <!-- Nombre -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">
                                <i class="bi bi-tag"></i> Nombre del Producto *
                            </label>
                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                   placeholder="Ej: Laptop Dell"
                                   value="<?php echo $producto['nombre'];?>" required>
                        </div>
                        
                        <!-- Precio -->
                        <div class="mb-3">
                            <label for="precio" class="form-label">
                                <i class="bi bi-currency-dollar"></i> Precio *
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">Bs</span>
                                <input type="number" class="form-control" id="precio" name="precio" 
                                       step="0.01" min="0" placeholder="1500.00" 
                                       value="<?php echo $producto['precio'];?>" required>
                            </div>
                        </div>
                        
                        <!-- Descripción -->
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">
                                <i class="bi bi-card-text"></i> Descripción *
                            </label>
                            <textarea class="form-control" 
                                      id="descripcion" 
                                      name="descripcion" 
                                      rows="3" 
                                      placeholder="Describe las características del producto"
                                      required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
                        </div>

                        <!-- Imagen Actual -->
                        <?php if(!empty($producto['imagen']) && file_exists($producto['imagen'])): ?>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-image me-1"></i>
                                Imagen Actual
                            </label>
                            <div>
                                <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" 
                                     alt="Imagen del producto" 
                                     class="img-thumbnail" 
                                     style="max-width: 200px; max-height: 200px;">
                            </div>
                            <div class="form-text">Imagen actual del producto</div>
                        </div>
                        <?php endif; ?>

                        <!-- Nueva Imagen -->
                        <div class="mb-4">
                            <label for="imagen" class="form-label">
                                <i class="bi bi-image me-1"></i>
                                <?php echo !empty($producto['imagen']) ? 'Cambiar Imagen del Producto' : 'Imagen del Producto'; ?>
                            </label>
                            <input type="file"
                                   class="form-control"
                                   id="imagen"
                                   name="imagen"
                                   accept="image/jpeg, image/png, image/webp">
                            <div class="form-text">
                                Formatos permitidos: JPG, PNG o WEBP. Máx. recomendado: 2 MB. 
                                <?php if(!empty($producto['imagen'])): ?>
                                Dejar vacío para mantener la imagen actual.
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Botones -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-save"></i> Actualizar Producto
                            </button>
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
