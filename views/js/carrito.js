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
        });
    }

    // Cerrar carrito
    if (closeCartButton && cartSection) {
        closeCartButton.addEventListener('click', () => {
            cartSection.style.display = 'none';
        });
    }

    // Pagar: enviar carrito JSON a API con fetch
    if (checkoutButton) {
        checkoutButton.addEventListener('click', () => {
            if (Object.keys(cart).length === 0) {
                alert("El carrito está vacío.");
                return;
            }

            console.log('Enviando carrito a la API...');
            console.log(JSON.stringify(cart, null, 2)); // Para depuración

            fetch('https://tu-api.com/endpoint', {  // Cambia esta URL por la de tu API real
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(cart)
            })
            .then(response => {
                if (!response.ok) throw new Error('Error en la respuesta de la API');
                return response.json();
            })
            .then(data => {
                console.log('Respuesta de la API:', data);
                alert('Pago procesado con éxito.');
                // Opcional: limpiar carrito después de pagar
                cart = {};
                updateCartUI();
            })
            .catch(error => {
                console.error('Error al enviar carrito:', error);
                alert('Hubo un error al procesar el pago.');
            });
        });
    }

    // Inicializa la UI (oculta carrito al cargar)
    if (cartSection) {
        cartSection.style.display = 'none';
    }
});
