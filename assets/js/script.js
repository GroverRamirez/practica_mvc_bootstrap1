// Script personalizado para el proyecto MVC de Productos

document.addEventListener('DOMContentLoaded', function() {
    // Auto-ocultar alertas después de 5 segundos
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        if (alert.classList.contains('alert-success') || alert.classList.contains('alert-danger')) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        }
    });

    // Validación del formulario de productos
    const forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            const nombre = form.querySelector('input[name="nombre"]');
            const precio = form.querySelector('input[name="precio"]');
            const descripcion = form.querySelector('textarea[name="descripcion"]');

            // Limpiar mensajes de error previos
            clearValidationErrors(form);

            let isValid = true;

            // Validar nombre
            if (nombre && nombre.value.trim() === '') {
                showValidationError(nombre, 'El nombre del producto es obligatorio.');
                isValid = false;
            }

            // Validar precio
            if (precio && (precio.value === '' || parseFloat(precio.value) <= 0)) {
                showValidationError(precio, 'El precio debe ser mayor a 0.');
                isValid = false;
            }

            // Validar descripción
            if (descripcion && descripcion.value.trim() === '') {
                showValidationError(descripcion, 'La descripción es obligatoria.');
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    });

    // Confirmación para eliminar productos
    const deleteLinks = document.querySelectorAll('a[href*="action=delete"]');
    deleteLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            if (!confirm('¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.')) {
                event.preventDefault();
            }
        });
    });

    // Mejorar la experiencia de usuario con animaciones
    const cards = document.querySelectorAll('.card');
    cards.forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});

// Función para mostrar errores de validación
function showValidationError(field, message) {
    const formGroup = field.closest('.mb-3');
    const existingError = formGroup.querySelector('.invalid-feedback');
    
    if (existingError) {
        existingError.remove();
    }

    const errorDiv = document.createElement('div');
    errorDiv.className = 'invalid-feedback d-block';
    errorDiv.textContent = message;
    
    field.classList.add('is-invalid');
    formGroup.appendChild(errorDiv);
}

// Función para limpiar errores de validación
function clearValidationErrors(form) {
    const invalidFields = form.querySelectorAll('.is-invalid');
    invalidFields.forEach(function(field) {
        field.classList.remove('is-invalid');
    });

    const errorMessages = form.querySelectorAll('.invalid-feedback');
    errorMessages.forEach(function(message) {
        message.remove();
    });
}

// Función para formatear precios
function formatPrice(price) {
    return new Intl.NumberFormat('es-BO', {
        style: 'currency',
        currency: 'BOB',
        minimumFractionDigits: 2
    }).format(price);
}

// Función para mostrar notificaciones toast (si se implementa Bootstrap Toast)
function showToast(message, type = 'info') {
    // Esta función se puede usar si se implementan notificaciones toast
    console.log(`${type.toUpperCase()}: ${message}`);
}

// Función para validar formularios en tiempo real
function setupRealTimeValidation() {
    const inputs = document.querySelectorAll('input, textarea');
    inputs.forEach(function(input) {
        input.addEventListener('blur', function() {
            validateField(this);
        });
    });
}

// Función para validar un campo individual
function validateField(field) {
    const formGroup = field.closest('.mb-3');
    const existingError = formGroup.querySelector('.invalid-feedback');
    
    if (existingError) {
        existingError.remove();
    }

    field.classList.remove('is-invalid', 'is-valid');

    if (field.hasAttribute('required') && field.value.trim() === '') {
        field.classList.add('is-invalid');
        return false;
    }

    if (field.type === 'number' && field.value !== '' && parseFloat(field.value) <= 0) {
        field.classList.add('is-invalid');
        return false;
    }

    if (field.value.trim() !== '') {
        field.classList.add('is-valid');
    }

    return true;
}

// Inicializar validación en tiempo real
document.addEventListener('DOMContentLoaded', function() {
    setupRealTimeValidation();
});

