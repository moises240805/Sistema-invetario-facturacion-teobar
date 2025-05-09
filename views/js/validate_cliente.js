$(document).ready(function() {
    // Solo números en campos numeric
    $('.numeric').on('input', function() {
        this.value = this.value.replace(/\D/g, '');
    });

    // Solo letras y ciertos caracteres en campos alpha
    $('.alpha').on('input', function() {
        this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúñÑüÜ\s-]/g, '');
    });


    
        // Validaciones para formulario AGREGAR (#miFormulario)
        $('#id').on('input', validateIdAgregar);
        $('#nombre').on('input', validateNameAgregar);
        $('#numero_tlf2').on('input', validatePhoneAgregar);
        $('#email2').on('input', validateEmailAgregar);
        $('#direccion2').on('input', validateAddressAgregar);
    
        $('#miFormulario').on('submit', function(e) {
            const valid = [
                validateIdAgregar.call($('#id')[0]),
                validateNameAgregar.call($('#nombre')[0]),
                validatePhoneAgregar.call($('#numero_tlf2')[0]),
                validateEmailAgregar.call($('#email2')[0]),
                validateAddressAgregar.call($('#direccion2')[0])
            ].every(Boolean);
    
            if (!valid) {
                e.preventDefault();
                $('.is-invalid').first().focus();
            }
        });
    
        // Validaciones para formulario MODIFICAR (sin id, con clase .entrada)
        $('#id_cliente2').on('input', validateIdModificar);
        $('#nombre_cliente').on('input', validateNameModificar);
        $('#numero_tlf').on('input', validatePhoneModificar);
        $('#email').on('input', validateEmailModificar);
        $('#direccion').on('input', validateAddressModificar);
    
        $('form[name="form"]').not('#miFormulario').on('submit', function(e) {
            const valid = [
                validateIdModificar.call($('#id_cliente2')[0]),
                validateNameModificar.call($('#nombre_cliente')[0]),
                validatePhoneModificar.call($('#numero_tlf')[0]),
                validateEmailModificar.call($('#email')[0]),
                validateAddressModificar.call($('#direccion')[0])
            ].every(Boolean);
    
            if (!valid) {
                e.preventDefault();
                $('.is-invalid').first().focus();
            }
        });
    
        // Funciones para AGREGAR
        function validateIdAgregar() {
            const $input = $(this);
            const val = $input.val();
            const isValid = val.length >= 6 && val.length <= 8;
    
            $input.toggleClass('is-invalid', !isValid).toggleClass('is-valid', isValid);
            $('#idError').toggleClass('show', !isValid).text(isValid ? '' : 'Entre 6 y 8 dígitos');
            return isValid;
        }
    
        function validateNameAgregar() {
            const $input = $(this);
            const val = $input.val();
            const regex = /^[A-Za-zÁÉÍÓÚáéíóúñÑüÜ\s-]+$/;
            const isValid = regex.test(val) && val.trim() !== '';
    
            $input.toggleClass('is-invalid', !isValid).toggleClass('is-valid', isValid);
            $('#nameError').toggleClass('show', !isValid).text(isValid ? '' : 'Solo letras y guiones');
            return isValid;
        }
    
        function validatePhoneAgregar() {
            const $input = $(this);
            const val = $input.val();
            const isValid = val.length === 7;
    
            $input.toggleClass('is-invalid', !isValid).toggleClass('is-valid', isValid);
            $('#phoneError').toggleClass('show', !isValid).text(isValid ? '' : '7 dígitos requeridos');
            return isValid;
        }
    
        function validateEmailAgregar() {
            const $input = $(this);
            const val = $input.val();
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const isValid = regex.test(val);
    
            $input.toggleClass('is-invalid', !isValid).toggleClass('is-valid', isValid);
            $('#emailError').toggleClass('show', !isValid).text(isValid ? '' : 'Formato inválido');
            return isValid;
        }
    
        function validateAddressAgregar() {
            const $input = $(this);
            const val = $input.val().trim();
            const isValid = val !== '';
    
            $input.toggleClass('is-invalid', !isValid).toggleClass('is-valid', isValid);
            $('#addressError').toggleClass('show', !isValid).text(isValid ? '' : 'Dirección requerida');
            return isValid;
        }
    
        // Funciones para MODIFICAR
        function validateIdModificar() {
            const $input = $(this);
            const val = $input.val();
            const isValid = val.length >= 6 && val.length <= 8;
    
            $input.toggleClass('is-invalid', !isValid).toggleClass('is-valid', isValid);
            // No tienes un span para error aquí, puedes agregar uno si quieres
            return isValid;
        }
    
        function validateNameModificar() {
            const $input = $(this);
            const val = $input.val();
            const regex = /^[A-Za-zÁÉÍÓÚáéíóúñÑüÜ\s-]+$/;
            const isValid = regex.test(val) && val.trim() !== '';
    
            $input.toggleClass('is-invalid', !isValid).toggleClass('is-valid', isValid);
            return isValid;
        }
    
        function validatePhoneModificar() {
            const $input = $(this);
            const val = $input.val();
            const isValid = val.length === 7;
    
            $input.toggleClass('is-invalid', !isValid).toggleClass('is-valid', isValid);
            return isValid;
        }
    
        function validateEmailModificar() {
            const $input = $(this);
            const val = $input.val();
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const isValid = regex.test(val);
    
            $input.toggleClass('is-invalid', !isValid).toggleClass('is-valid', isValid);
            return isValid;
        }
    
        function validateAddressModificar() {
            const $input = $(this);
            const val = $input.val().trim();
            const isValid = val !== '';
    
            $input.toggleClass('is-invalid', !isValid).toggleClass('is-valid', isValid);
            return isValid;
        }
    });
    