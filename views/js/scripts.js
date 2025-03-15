document.addEventListener('DOMContentLoaded', function() {
    const addToCartButtons = document.querySelectorAll('.add-to-cart-button');
    const cartContent = document.getElementById('cart-content');
    const cartSummary = document.getElementById('cart-summary');
    const subtotalElement = document.getElementById('subtotal');
    const taxesElement = document.getElementById('taxes');
    const totalElement = document.getElementById('total');
    const clearCartButton = document.getElementById('clear-cart');
    const checkoutButton = document.getElementById('checkout');
    const closeCartButton = document.getElementById('close-cart');
    const cartSection = document.getElementById('cart');
    const cartCountElement = document.getElementById('cart-count');

    // Objeto para almacenar los productos en el carrito
    let cart = {};

    // Función para agregar un producto al carrito
    function addToCart(productId, productName, productPrice, productPresentation) {
        if (cart[productId]) {
            cart[productId].quantity++;
        } else {
            cart[productId] = {
                name: productName,
                price: parseFloat(productPrice),
                presentation: productPresentation,
                quantity: 1
            };
        }
        updateCartUI();
    }

    // Función para actualizar la interfaz del carrito
    function updateCartUI() {
        cartContent.innerHTML = '';
        let subtotal = 0;
        let taxes = 0;
        let total = 0;
        let totalProducts = 0;

        for (let productId in cart) {
            const product = cart[productId];
            const productTotal = product.price * product.quantity;
            subtotal += productTotal;
            totalProducts += product.quantity;

            const productHTML = `
                <div>
                    <p>${product.name} (${product.presentation}) x${product.quantity} - $${productTotal.toFixed(2)}</p>
                    <input type="number" class="quantity-input" data-id="${productId}" value="${product.quantity}" min="1">
                    <button class="remove-from-cart" data-id="${productId}">Eliminar</button>
                </div>
            `;
            cartContent.insertAdjacentHTML('beforeend', productHTML);
        }

        taxes = subtotal * 0.10;
        total = subtotal + taxes;

        subtotalElement.textContent = `Subtotal: $${subtotal.toFixed(2)}`;
        taxesElement.textContent = `Impuestos (10%): $${taxes.toFixed(2)}`;
        totalElement.textContent = `Total: $${total.toFixed(2)}`;

        cartCountElement.textContent = totalProducts;

        // Mostrar el carrito si hay productos
        if (Object.keys(cart).length > 0) {
            cartSection.style.display = 'block';
        } else {
            cartSection.style.display = 'none';
        }

        // Agregar evento para eliminar productos del carrito
        const removeFromCartButtons = document.querySelectorAll('.remove-from-cart');
        removeFromCartButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = button.getAttribute('data-id');
                delete cart[productId];
                updateCartUI();
            });
        });

        // Agregar evento para actualizar la cantidad de productos
        const quantityInputs = document.querySelectorAll('.quantity-input');
        quantityInputs.forEach(input => {
            input.addEventListener('change', function() {
                const productId = input.getAttribute('data-id');
                const newQuantity = parseInt(input.value);
                if (newQuantity < 1) {
                    input.value = 1;
                    newQuantity = 1;
                }
                cart[productId].quantity = newQuantity;
                updateCartUI();
            });
        });
    }

    // Agregar evento a los botones de agregar al carrito
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = button.getAttribute('data-id');
            const productName = button.getAttribute('data-name');
            const productPrice = button.getAttribute('data-price');
            const productPresentation = button.getAttribute('data-presentation');

            addToCart(productId, productName, productPrice, productPresentation);
        });
    });

    // Agregar evento al botón de vaciar carrito
    clearCartButton.addEventListener('click', function() {
        cart = {};
        updateCartUI();
    });

    // Agregar evento al botón de cerrar carrito
    closeCartButton.addEventListener('click', function() {
        cartSection.style.display = 'none';
    });

    // Agregar evento al botón de pagar (puedes implementar la lógica de pago aquí)
    checkoutButton.addEventListener('click', function() {
        console.log('Procesar pago...');
        // Aquí puedes hacer una petición AJAX para procesar el pago en el servidor
    });

    // Agregar evento al botón del carrito para mostrar el carrito
    document.getElementById('cart-link').addEventListener('click', function() {
        if (cartSection.style.display === 'none') {
            cartSection.style.display = 'block';
        } else {
            cartSection.style.display = 'none';
        }
    });
});
