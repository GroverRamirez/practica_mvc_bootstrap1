<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap-5.3.8-dist/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="assets/bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">
    
    <!-- CSS personalizado -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h1>Gestión de Productos</h1>
                    </div>
                    
                    <div class="card-body">
                        <?php if (isset($contenido)): ?>
                            <?php echo $contenido; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div> 
    </div>

    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap-5.3.8-dist/bootstrap.bundle.min.js"></script>
    
    <!-- JavaScript personalizado -->
    <script src="assets/js/script.js"></script>
</body>
</html>          