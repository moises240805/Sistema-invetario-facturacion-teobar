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

    // Mostrar u ocultar carrito
    if (cartButton && cartSection) {
        cartButton.addEventListener('click', function() {
            cartSection.style.display = (cartSection.style.display === 'block') ? 'none' : 'block';
        });
    }

    // Agregar producto al carrito
    function addToCart(productId, productName, productPrice, unidades, unidadSeleccionadaId) {
        if (cart[productId]) {
            cart[productId].quantity++;
        } else {
            cart[productId] = {
                name: productName,
                price: parseFloat(productPrice),
                unidades: unidades,
                unidad_seleccionada: unidadSeleccionadaId || (unidades.length > 0 ? unidades[0].id : null),
                quantity: 1
            };
        }
        updateCartUI();
    }

    // Actualizar UI del carrito
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

            const unidadSelectHTML = `
                <label>Unidad:
                    <select class="unidad-select" data-id="${productId}">
                        ${product.unidades.map(u =>
                            `<option value="${u.id}" ${u.id == product.unidad_seleccionada ? 'selected' : ''}>${u.nombre}</option>`
                        ).join('')}
                    </select>
                </label>
            `;

            const productHTML = `
                <div class="cart-item">
                    <div class="cart-item-name">${product.name}</div>
                    <div class="cart-item-unidad">${unidadSelectHTML}</div>
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

        cartSection.style.display = totalProducts > 0 ? 'block' : 'none';

        // Eventos eliminar producto
        document.querySelectorAll('.remove-from-cart').forEach(button => {
            button.onclick = () => {
                const id = button.getAttribute('data-id');
                delete cart[id];
                updateCartUI();
            };
        });

        // Eventos aumentar cantidad
        document.querySelectorAll('.quantity-button.increase').forEach(button => {
            button.onclick = () => {
                const id = button.getAttribute('data-id');
                cart[id].quantity++;
                updateCartUI();
            };
        });

        // Eventos disminuir cantidad
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

        // Cambiar cantidad manualmente
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.onchange = () => {
                const id = input.getAttribute('data-id');
                let val = parseInt(input.value);
                if (isNaN(val) || val < 1) val = 1;
                cart[id].quantity = val;
                updateCartUI();
            };
        });

        // Cambiar unidad seleccionada
        document.querySelectorAll('.unidad-select').forEach(select => {
            select.onchange = () => {
                const id = select.getAttribute('data-id');
                cart[id].unidad_seleccionada = select.value;
            };
        });
    }

    // Agregar evento a botones "Agregar al carrito"
    addToCartButtons.forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const price = button.getAttribute('data-price');
            const unidades = JSON.parse(button.getAttribute('data-unidades'));
            const unidadSeleccionadaId = button.getAttribute('data-presentation');
            addToCart(id, name, price, unidades, unidadSeleccionadaId);
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

    // Checkout
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

            Swal.fire({
    title: 'Ingrese su cédula y seleccione modalidad de pago',
    html:
        '<input id="swal-input-cedula" class="swal2-input" placeholder="Cédula">' +
        '<select id="swal-select-pago" class="swal2-select" style="width:60%; padding:0.375rem 0.75rem; font-size:1rem; line-height:1.5; border:1px solid #d9d9d9; border-radius:0.25rem; margin-bottom:10px;">' +
            '<option value="" disabled selected>Seleccione modalidad de pago</option>' +
            '<option value="3">Pago móvil</option>' +
            '<option value="4">Transferencia</option>' +
            '<option value="2">Efectivo</option>' +
        '</select>' +
        '<select id="swal-select-banco" class="swal2-select" style="width:60%; padding:0.375rem 0.75rem; font-size:1rem; line-height:1.5; border:1px solid #d9d9d9; border-radius:0.25rem; margin-bottom:10px;">' +
            '<option value="" disabled selected>Seleccione banco</option>' +
            '<option value="102">Venezuela</option>' +
            '<option value="104">Venezolano de Credito</option>' +
            '<option value="105">Mercantil</option>' +
            '<option value="108">Provincial</option>' +
            '<option value="114">Bancaribe</option>' +
            '<option value="115">Exteriror</option>' +
            '<option value="116">Occidental de Descuento</option>' +
            '<option value="128">Banco Caroni</option>' +
            '<option value="134">Banesco</option>' +
            '<option value="137">Banco Sofitasa</option>' +
            '<option value="138">Banco Plaza</option>' +
            '<option value="151">Banco Fondo Comun</option>' +
            '<option value="156">100% Banco</option>' +
            '<option value="157">Banco del Sur</option>' +
            '<option value="163">Banco del Tesoro</option>' +
            '<option value="166">Banco Agricola de Venezuela</option>' +
            '<option value="168">Bancrecer</option>' +
            '<option value="169">Mi Banco</option>' +
            '<option value="172">Bancamiga</option>' +
            '<option value="174">Banplus</option>' +
            '<option value="175">Bicentenario del Pueblo</option>' +
            '<option value="177">Banfanb</option>' +
            '<option value="191">Banco Nacional de Credito</option>' +
        '</select>' +
        '<input id="swal-input-tlf" class="swal2-input" placeholder="Tlf o nro de referencia">',
    focusConfirm: false,
    showCancelButton: true,
    confirmButtonText: 'Confirmar',
    cancelButtonText: 'Cancelar',
    preConfirm: () => {
        const cedula = document.getElementById('swal-input-cedula').value.trim();
        const tlf = document.getElementById('swal-input-tlf').value.trim();
        const modalidadPago = document.getElementById('swal-select-pago').value;
        const rifBanco = document.getElementById('swal-select-banco').value;

        if (!cedula) {
            Swal.showValidationMessage('Por favor ingrese su cédula');
        }
        if (!tlf) {
            Swal.showValidationMessage('Por favor ingrese su tlf o nro de referencia');
        }
        if (!modalidadPago) {
            Swal.showValidationMessage('Por favor seleccione modalidad de pago');
        }
        if (!rifBanco) {
            Swal.showValidationMessage('Por favor seleccione un banco');
        }
        return { cedula, modalidadPago, tlf, rif_banco: rifBanco };
    }
            }).then((result) => {
                if (result.isConfirmed) {
                    const { cedula, modalidadPago, tlf, rif_banco } = result.value;

                    // Calcular subtotal, impuestos y total
                    let subtotal = 0;
                    for (let productId in cart) {
                        const product = cart[productId];
                        subtotal += product.price * product.quantity;
                    }
                    const taxes = subtotal * 0.10;
                    const total = subtotal + taxes;

                    // Preparar productos para enviar
                    const productos = Object.entries(cart).map(([id, item]) => ({
                        id: id,
                        nombre: item.name,
                        precio: item.price,
                        cantidad: item.quantity,
                        unidad_seleccionada: item.unidad_seleccionada,
                        nombre_unidad: (item.unidades.find(u => u.id == item.unidad_seleccionada) || {}).nombre || ''
                    }));

                    const cartWithCedula = {
                        cedula: cedula,
                        modalidad_pago: modalidadPago,
                        tlf: tlf,
                        rif_banco:rif_banco,
                        total: total.toFixed(2),
                        productos: productos
                    };

                    console.log('JSON a enviar:', JSON.stringify(cartWithCedula, null, 2));

                    Swal.fire({
                        title: 'Procesando pago...',
                        didOpen: () => {
                            Swal.showLoading();
                        },
                        allowOutsideClick: false
                    });

                    fetch('index.php?action=pedido&a=agregar', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
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

    // Inicializar UI
    if (cartSection) {
        cartSection.style.display = 'none';
    }
});
