<?php
require_once 'header.php';

if (!isset($_GET['order_id'])) {
    header('Location: index.php');
    exit;
}

$orderId = intval($_GET['order_id']);
?>

<section class="order-success">
    <div class="container">
        <div class="success-message text-center">
            <div class="success-icon">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <h2>Order Placed Successfully!</h2>
            <p class="lead">Thank you for your purchase. Your order has been confirmed.</p>
            <div class="order-details">
                <p><strong>Order ID:</strong> #<?php echo $orderId; ?></p>
                <p>We've sent a confirmation email to your registered email address.</p>
            </div>
            <div class="success-actions">
                <a href="products.php" class="btn btn-primary">Continue Shopping</a>
                <a href="index.php" class="btn btn-outline">Back to Home</a>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="assets/css/order-success.css">

<?php
require_once 'footer.php';
?>