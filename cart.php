<?php
require_once 'header.php';

$cartItems = getCartItems($pdo);
$cartTotal = getCartTotal($pdo);

// Handle quantity updates and removals
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_quantity'])) {
        $productId = intval($_POST['product_id']);
        $quantity = intval($_POST['quantity']);
        updateCartQuantity($productId, $quantity);
        header('Location: cart.php');
        exit;
    } elseif (isset($_POST['remove_item'])) {
        $productId = intval($_POST['product_id']);
        removeFromCart($productId);
        header('Location: cart.php');
        exit;
    }
}
?>

<section class="cart-page">
    <div class="container">
        <div class="section-header">
            <h2>Shopping Cart</h2>
        </div>
        
        <?php if (empty($cartItems)): ?>
        <div class="empty-cart">
            <h3>Your cart is empty</h3>
            <p>Browse our products and add items to your cart</p>
            <a href="products.php" class="btn btn-primary">Continue Shopping</a>
        </div>
        <?php else: ?>
        <div class="cart-layout">
            <div class="cart-items">
                <?php foreach ($cartItems as $item): ?>
                <div class="cart-item">
                    <div class="item-image">
                        <img src="uploads/products/<?php echo $item['product']['image']; ?>" alt="<?php echo htmlspecialchars($item['product']['name']); ?>">
                    </div>
                    <div class="item-details">
                        <h3 class="item-title"><?php echo htmlspecialchars($item['product']['name']); ?></h3>
                        <div class="item-category"><?php echo htmlspecialchars($item['product']['category_name']); ?></div>
                        <div class="item-price">$<?php echo number_format($item['product']['price'], 2); ?></div>
                    </div>
                    <div class="item-quantity">
                        <form method="POST" class="quantity-form">
                            <input type="hidden" name="product_id" value="<?php echo $item['product']['id']; ?>">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo $item['product']['stock']; ?>">
                            <button type="submit" name="update_quantity" class="btn-update">Update</button>
                        </form>
                    </div>
                    <div class="item-total">
                        $<?php echo number_format($item['product']['price'] * $item['quantity'], 2); ?>
                    </div>
                    <div class="item-remove">
                        <form method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $item['product']['id']; ?>">
                            <button type="submit" name="remove_item" class="btn-remove">×</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="cart-summary">
                <h3>Order Summary</h3>
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span>$<?php echo number_format($cartTotal, 2); ?></span>
                </div>
                <div class="summary-row">
                    <span>Shipping:</span>
                    <span>$5.00</span>
                </div>
                <div class="summary-row">
                    <span>Tax:</span>
                    <span>$<?php echo number_format($cartTotal * 0.1, 2); ?></span>
                </div>
                <div class="summary-row total">
                    <span>Total:</span>
                    <span>$<?php echo number_format($cartTotal + 5 + ($cartTotal * 0.1), 2); ?></span>
                </div>
                
                <div class="cart-actions">
                    <a href="products.php" class="btn btn-outline">Continue Shopping</a>
                    <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<link rel="stylesheet" href="assets/css/cart.css">

<?php
require_once 'footer.php';
?>