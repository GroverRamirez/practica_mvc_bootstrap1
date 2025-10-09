<div class="p-3">
    <!-- Mensajes de éxito/error -->
    <?php if (isset($mensaje) && !empty($mensaje)): ?>
        <div class="alert alert-<?php echo $tipoMensaje === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
            <i class="bi bi-<?php echo $tipoMensaje === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill'; ?>"></i>
            <?php echo htmlspecialchars($mensaje); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="text-center mb-4">
        <h2>Lista de Productos</h2>
        <a href="?action=create" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Registrar Nuevo Producto
        </a>
    </div>

    <!-- Tabla de productos -->
    <?php if (!empty($productos)): ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="text-center">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col" class="text-center">Precio</th>
                        <th scope="col">Descripción</th>
                        <th scope="col" class="text-center">Fecha Creación</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td class="text-center fw-bold"><?php echo htmlspecialchars($producto['id']); ?></td>
                            <td>
                                <i class="bi bi-box-seam"></i>
                                <?php echo htmlspecialchars($producto['nombre']); ?>
                            </td>
                            <td class="text-center text-success fw-bold">
                                Bs <?php echo number_format($producto['precio'], 2); ?>
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
                                       title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Contador de productos -->
        <div class="text-muted text-center mt-3">
            <small>
                <i class="bi bi-info-circle"></i>
                Total de productos: <strong><?php echo count($productos); ?></strong>
            </small>
        </div>
    <?php else: ?>
        <!-- Mensaje cuando no hay productos -->
        <div class="text-center py-5">
            <i class="bi bi-inbox display-1 text-muted"></i>
            <h3 class="text-muted mt-3">No hay productos registrados</h3>
            <p class="text-muted">Comienza agregando tu primer producto.</p>
            <a href="?action=create" class="btn btn-primary mt-3">
                <i class="bi bi-plus-circle"></i> Agregar Primer Producto
            </a>
        </div>
    <?php endif; ?>
</div>
