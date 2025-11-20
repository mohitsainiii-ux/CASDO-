<?php
require_once 'db.php';
require_once 'functions.php';

// Redirect if cart is empty
$cartItems = getCartItems($pdo);
if (empty($cartItems)) {
    header('Location: cart.php');
    exit;
}

$cartTotal = getCartTotal($pdo);
$shipping = 5.00;
$tax = $cartTotal * 0.1;
$finalTotal = $cartTotal + $shipping + $tax;

// Handle order submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        $shippingAddress = $_POST['address'] . ', ' . $_POST['city'] . ', ' . $_POST['state'] . ' ' . $_POST['zip'];
        $paymentMethod = $_POST['payment_method'];
        
        try {
            $pdo->beginTransaction();
            
            // Create order
            $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, shipping_address, payment_method) VALUES (?, ?, ?, ?)");
            $stmt->execute([$userId, $finalTotal, $shippingAddress, $paymentMethod]);
            $orderId = $pdo->lastInsertId();
            
            // Add order items
            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            foreach ($cartItems as $item) {
                $stmt->execute([$orderId, $item['product']['id'], $item['quantity'], $item['product']['price']]);
                
                // Update product stock
                $updateStmt = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
                $updateStmt->execute([$item['quantity'], $item['product']['id']]);
            }
            
            $pdo->commit();
            
            // Clear cart
            $_SESSION['cart'] = [];
            
            // Redirect to success page
            header('Location: order-success.php?order_id=' . $orderId);
            exit;
            
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "There was an error processing your order. Please try again.";
        }
    } else {
        $error = "Please log in to complete your order.";
    }
}
?>

<?php require_once 'header.php'; ?>

<section class="checkout-page">
    <div class="container">
        <div class="section-header">
            <h2>Checkout</h2>
        </div>
        
        <?php if (isset($error)): ?>
        <div class="alert alert-error">
            <?php echo $error; ?>
        </div>
        <?php endif; ?>
        
        <form method="POST" class="checkout-form">
            <div class="checkout-layout">
                <div class="checkout-details">
                    <h3>Shipping Information</h3>
                    
                    <div class="form-group">
                        <label for="full_name">Full Name *</label>
                        <input type="text" id="full_name" name="full_name" required 
                               value="<?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required
                               value="<?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Address *</label>
                        <input type="text" id="address" name="address" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">City *</label>
                            <input type="text" id="city" name="city" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="state">State *</label>
                            <input type="text" id="state" name="state" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="zip">ZIP Code *</label>
                            <input type="text" id="zip" name="zip" required>
                        </div>
                    </div>
                    
                    <h3>Payment Method</h3>
                    
                    <div class="payment-methods">
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="credit_card" checked>
                            <span>Credit Card</span>
                        </label>
                        
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="paypal">
                            <span>PayPal</span>
                        </label>
                        
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="cash_on_delivery">
                            <span>Cash on Delivery</span>
                        </label>
                    </div>
                    
                    <div class="form-actions">
                        <a href="cart.php" class="btn btn-outline">Back to Cart</a>
                        <button type="submit" class="btn btn-primary">Place Order</button>
                    </div>
                </div>
                
                <div class="order-summary">
                    <h3>Order Summary</h3>
                    
                    <div class="order-items">
                        <?php foreach ($cartItems as $item): ?>
                        <div class="order-item">
                            <div class="item-image">
                                <img src="uploads/products/<?php echo $item['product']['image']; ?>" alt="<?php echo htmlspecialchars($item['product']['name']); ?>">
                            </div>
                            <div class="item-details">
                                <h4><?php echo htmlspecialchars($item['product']['name']); ?></h4>
                                <div class="item-quantity">Qty: <?php echo $item['quantity']; ?></div>
                            </div>
                            <div class="item-price">
                                $<?php echo number_format($item['product']['price'] * $item['quantity'], 2); ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="summary-totals">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span>$<?php echo number_format($cartTotal, 2); ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping:</span>
                            <span>$<?php echo number_format($shipping, 2); ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Tax:</span>
                            <span>$<?php echo number_format($tax, 2); ?></span>
                        </div>
                        <div class="summary-row total">
                            <span>Total:</span>
                            <span>$<?php echo number_format($finalTotal, 2); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<link rel="stylesheet" href="assets/css/checkout.css">

<?php
require_once 'footer.php';
?>