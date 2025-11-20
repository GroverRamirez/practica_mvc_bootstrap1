<div class="p-3">
    <!-- Encabezado -->
    <div class="text-center mb-4">
        <h2>Lista de Productos</h2>
        <?php if(isset($usuario) && !empty($usuario)): ?>
            <div class="alert alert-info d-inline-block mb-3">
                <i class="bi bi-person-circle me-2"></i>
                <strong>Usuario:</strong> <?php echo htmlspecialchars($usuario['nombre'] ?? $usuario['username'] ?? 'Usuario'); ?>
                <?php if(isset($usuario['email'])): ?>
                    <span class="text-muted">(<?php echo htmlspecialchars($usuario['email']); ?>)</span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <!-- Mensajes de éxito/error -->
        <?php if(isset($mensaje) && isset($tipoMensaje)): ?>
        <div class="alert alert-<?php echo $tipoMensaje; ?> alert-dismissible fade show" role="alert">
            <i class="bi bi-<?php echo $tipoMensaje === 'success' ? 'check-circle' : ($tipoMensaje === 'danger' ? 'exclamation-triangle' : 'info-circle'); ?> me-2"></i>
            <?php echo htmlspecialchars($mensaje); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
        <div class="mb-3">
            <a href="?action=create" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle"></i> Registrar Nuevo Producto
            </a>
            <a href="?action=logout" class="btn btn-outline-danger">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
            </a>
        </div>
    </div>

    <!-- Tabla de productos -->
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col" class="text-center">Nro</th>
                    <th scope="col" class="text-center">Imagen</th>
                    <th scope="col">Nombre</th>
                    <th scope="col" class="text-center">Precio</th>
                    <th scope="col">Descripción</th>
                    <th scope="col" class="text-center">Fecha</th>
                    <th scope="col" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $contador=1; foreach ($productos as $producto): ?>
                <tr>
                    <td class="text-center fw-bold"><?php echo $contador; ?></td>
                    <td class="text-center">
                        <?php if(!empty($producto['imagen']) && file_exists($producto['imagen'])): ?>
                            <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" 
                                 alt="<?php echo htmlspecialchars($producto['nombre']); ?>" 
                                 class="img-thumbnail" 
                                 style="max-width: 80px; max-height: 80px; object-fit: cover;">
                        <?php else: ?>
                            <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                        <?php endif; ?>
                    </td>
                    <td>
                        <i class="bi bi-box-seam"></i>
                        <?php echo htmlspecialchars($producto['nombre']); ?>
                    </td>
                    <td class="text-center text-success fw-bold">
                        <?php echo number_format($producto['precio'], 2); ?> Bs.
                    </td>
                    <td>
                        <small><?php echo htmlspecialchars($producto['descripcion']); ?></small>
                    </td>
                    <td class="text-center">
                        <small class="text-muted">
                            <?php echo date('d/m/Y', strtotime($producto['fecha_creacion'])); ?>
                        </small>
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="?action=editar&id=<?php echo $producto['id']; ?>" 
                               class="btn btn-outline-primary" 
                               title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="?action=eliminar&id=<?php echo $producto['id']; ?>" 
                               class="btn btn-outline-danger" 
                               title="Eliminar"
                               onclick="return confirm('¿Estás seguro de eliminar este producto?');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php $contador++; endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Contador -->
    <div class="text-muted text-center mt-3">
        <small>
            <i class="bi bi-info-circle"></i>
            Total de productos: <strong><?php echo $totalProductos; ?></strong>
        </small>
    </div>
</div>
