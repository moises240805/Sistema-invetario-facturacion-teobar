document.addEventListener('DOMContentLoaded', function() {
    const cartButton = document.querySelector('.cart-button');
    const cartSection = document.getElementById('cart');
    const addToCartButtons = document.querySelectorAll('.add-to-cart-button');
    const cartContent = document.getElementById('cart-content');
    const subtotalElement = document.getElementById('subtotal');
    const taxesElement = document.getElementById('taxes');
    const totalElement = document.getElementById('total');
    const clearCartButton = document.getElementById('clear-cart');
    const checkoutButton = document.getElementById('checkout');
    const closeCartButton = document.getElementById('close-cart');
    const cartCountElement = document.getElementById('cart-count');

    let cart = {};

    // Mostrar u ocultar carrito al hacer clic en el botón del carrito
    if (cartButton && cartSection) {
        cartButton.addEventListener('click', function() {
            if (cartSection.style.display === 'none' || cartSection.style.display === '') {
                cartSection.style.display = 'block';
            } else {
                cartSection.style.display = 'none';
            }
        });
    }

    // Función para agregar producto al carrito
    function addToCart(productId, productName, productPrice, productPresentation,productPresentationM) {
        if (cart[productId]) {
            cart[productId].quantity++;
        } else {
            cart[productId] = {
                name: productName,
                price: parseFloat(productPrice),
                medida: productPresentation,
                nombre_medida: productPresentationM,
                quantity: 1
            };
        }
        updateCartUI();
    }

    // Función para actualizar la UI del carrito
    function updateCartUI() {
        if (!cartContent || !subtotalElement || !taxesElement || !totalElement || !cartCountElement || !cartSection) return;

        cartContent.innerHTML = '';
        let subtotal = 0;
        let totalProducts = 0;

        for (let productId in cart) {
            const product = cart[productId];
            const productTotal = product.price * product.quantity;
            subtotal += productTotal;
            totalProducts += product.quantity;

            const productHTML = `
                <div class="cart-item">
                    <div class="cart-item-name">${product.name} (${product.nombre_medida})</div>
                    <div class="cart-item-quantity">
                        <button class="quantity-button decrease" data-id="${productId}">-</button>
                        <input type="number" class="quantity-input" data-id="${productId}" value="${product.quantity}" min="1">
                        <button class="quantity-button increase" data-id="${productId}">+</button>
                    </div>
                    <button class="remove-from-cart" data-id="${productId}">Eliminar</button>
                </div>
            `;
            cartContent.insertAdjacentHTML('beforeend', productHTML);
        }

        const taxes = subtotal * 0.10;
        const total = subtotal + taxes;

        subtotalElement.textContent = `Subtotal: $${subtotal.toFixed(2)}`;
        taxesElement.textContent = `Impuestos (10%): $${taxes.toFixed(2)}`;
        totalElement.textContent = `Total: $${total.toFixed(2)}`;
        cartCountElement.textContent = totalProducts;

        // Mostrar u ocultar carrito según si hay productos
        cartSection.style.display = totalProducts > 0 ? 'block' : 'none';

        // Eventos para botones de eliminar
        document.querySelectorAll('.remove-from-cart').forEach(button => {
            button.onclick = () => {
                const id = button.getAttribute('data-id');
                delete cart[id];
                updateCartUI();
            };
        });

        // Eventos para botones aumentar cantidad
        document.querySelectorAll('.quantity-button.increase').forEach(button => {
            button.onclick = () => {
                const id = button.getAttribute('data-id');
                cart[id].quantity++;
                updateCartUI();
            };
        });

        // Eventos para botones disminuir cantidad
        document.querySelectorAll('.quantity-button.decrease').forEach(button => {
            button.onclick = () => {
                const id = button.getAttribute('data-id');
                if (cart[id].quantity > 1) {
                    cart[id].quantity--;
                } else {
                    delete cart[id];
                }
                updateCartUI();
            };
        });

        // Eventos para input de cantidad (cambio manual)
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.onchange = () => {
                const id = input.getAttribute('data-id');
                let newQty = parseInt(input.value);
                if (isNaN(newQty) || newQty < 1) {
                    newQty = 1;
                    input.value = 1;
                }
                cart[id].quantity = newQty;
                updateCartUI();
            };
        });
    }

    // Agregar evento a botones "Agregar al carrito"
    addToCartButtons.forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const price = button.getAttribute('data-price');
            const presentation = button.getAttribute('data-presentation');
            const presentationM = button.getAttribute('data-presentationM');
            addToCart(id, name, price, presentation, presentationM);
        });
    });

    // Vaciar carrito
    if (clearCartButton) {
        clearCartButton.addEventListener('click', () => {
            cart = {};
            updateCartUI();
            Swal.fire({
                icon: 'success',
                title: 'Carrito vaciado',
                timer: 1500,
                showConfirmButton: false
            });
        });
    }

    // Cerrar carrito
    if (closeCartButton && cartSection) {
        closeCartButton.addEventListener('click', () => {
            cartSection.style.display = 'none';
        });
    }

    // Pagar: enviar carrito JSON a API con fetch usando SweetAlert2 para mensajes
    if (checkoutButton) {
        checkoutButton.addEventListener('click', () => {
            if (Object.keys(cart).length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'El carrito está vacío',
                    text: 'Agrega productos antes de pagar.'
                });
                return;
            }

            // Modal con cédula y modalidad de pago
            Swal.fire({
                title: 'Ingrese su cédula y seleccione modalidad de pago',
                html:
                    '<input id="swal-input-cedula" class="swal2-input" placeholder="Cédula">' +
                    '<select id="swal-select-pago" class="swal2-select" style="width:60%; padding:0.375rem 0.75rem; font-size:1rem; line-height:1.5; border:1px solid #d9d9d9; border-radius:0.25rem;">' +
                        '<option value="" disabled selected>Seleccione modalidad de pago</option>' +
                        '<option value="3">Pago móvil</option>' +
                        '<option value="4">Transferencia</option>' +
                        '<option value="2">Efectivo</option>' +
                    '</select>'+
                    '<input id="swal-input-tlf" class="swal2-input" placeholder="Tlf o nro de referencia">' ,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const cedula = document.getElementById('swal-input-cedula').value.trim();
                    const tlf = document.getElementById('swal-input-tlf').value.trim();
                    const modalidadPago = document.getElementById('swal-select-pago').value;
                    if (!cedula) {
                        Swal.showValidationMessage('Por favor ingrese su cédula');
                    }
                    if (!tlf) {
                        Swal.showValidationMessage('Por favor ingrese su tlf o nro de referencia');
                    }
                    if (!modalidadPago) {
                        Swal.showValidationMessage('Por favor seleccione modalidad de pago');
                    }
                    return { cedula, modalidadPago, tlf };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const { cedula, modalidadPago, tlf } = result.value;

                    // Armar el JSON con toda la info del carrito y la modalidad de pago
                    const productos = Object.entries(cart).map(([id, item]) => ({
                        id: id,
                        nombre: item.name,
                        precio: item.price,
                        medida: item.medida,
                        nombre_medida: item.nombre_medida,
                        cantidad: item.quantity
                    }));

                    const cartWithCedula = {
                        cedula: cedula,
                        modalidad_pago: modalidadPago,
                        tlf: tlf,
                        productos: productos
                    };

                    // Imprimir el JSON en consola
                    console.log('JSON a enviar:', JSON.stringify(cartWithCedula, null, 2));

                    Swal.fire({
                        title: 'Procesando pago...',
                        didOpen: () => {
                            Swal.showLoading();
                        },
                        allowOutsideClick: false
                    });

                    fetch('index.php?action=pedido&a=agregar', {  // Cambia esta URL por la de tu API real
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(cartWithCedula)
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Error en la respuesta de la API');
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Pago procesado con éxito',
                            text: 'Gracias por su compra.'
                        });
                        cart = {};
                        updateCartUI();
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un error al procesar el pago.'
                        });
                        console.error('Error al enviar carrito:', error);
                    });
                }
            });
        });
    }

    // Inicializa la UI (oculta carrito al cargar)
    if (cartSection) {
        cartSection.style.display = 'none';
    }
});
