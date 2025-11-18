// Add to cart functionality
document.querySelector('.add-to-cart-btn').addEventListener('click', function() {
    const productId = this.getAttribute('data-product-id');
    const quantity = document.getElementById('quantity').value;
    
    // Send AJAX request to add to cart
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'add-to-cart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Update cart count
            const cartCount = document.querySelector('.cart-count');
            cartCount.textContent = parseInt(cartCount.textContent) + parseInt(quantity);
            
            // Show success message
            alert('Product added to cart successfully!');
        }
    };
    xhr.send('product_id=' + productId + '&quantity=' + quantity);
});

// Related products add to cart
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        
        // Send AJAX request to add to cart
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'add-to-cart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Update cart count
                const cartCount = document.querySelector('.cart-count');
                cartCount.textContent = parseInt(cartCount.textContent) + 1;
                
                // Bounce animation
                const button = event.target;
                button.classList.add('bounce');
                setTimeout(() => {
                    button.classList.remove('bounce');
                }, 500);
            }
        };
        xhr.send('product_id=' + productId + '&quantity=1');
    });
});