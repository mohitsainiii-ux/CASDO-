<?php
require_once 'header.php';

if (!isset($_GET['id'])) {
    header('Location: products.php');
    exit;
}

$productId = intval($_GET['id']);
$product = getProductById($pdo, $productId);

if (!$product) {
    header('Location: products.php');
    exit;
}

// Get related products
$relatedProducts = getProducts($pdo, 4, $product['category_id']);
?>

<section class="product-details">
    <div class="container">
        <div class="product-details-layout">
            <!-- Product Images -->
            <div class="product-images">
                <div class="main-image">
                    <img src="uploads/products/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="product-info">
                <div class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></div>
                <h1 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h1>
                
                <div class="product-rating">
                    <div class="stars"><?php echo generateStars($product['rating']); ?></div>
                    <div class="rating-count">(<?php echo $product['review_count']; ?> reviews)</div>
                </div>
                
                <div class="product-price">
                    <span class="current-price">$<?php echo number_format($product['price'], 2); ?></span>
                    <?php if ($product['old_price']): ?>
                    <span class="original-price">$<?php echo number_format($product['old_price'], 2); ?></span>
                    <span class="discount"><?php echo round(($product['old_price'] - $product['price']) / $product['old_price'] * 100); ?>% OFF</span>
                    <?php endif; ?>
                </div>
                
                <div class="product-description">
                    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                </div>
                
                <div class="product-stock">
                    <?php if ($product['stock'] > 0): ?>
                    <span class="in-stock">In Stock (<?php echo $product['stock']; ?> available)</span>
                    <?php else: ?>
                    <span class="out-of-stock">Out of Stock</span>
                    <?php endif; ?>
                </div>
                
                <div class="product-actions">
                    <div class="quantity-selector">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>">
                    </div>
                    
                    <button class="btn btn-primary add-to-cart-btn" 
                            data-product-id="<?php echo $product['id']; ?>"
                            <?php echo $product['stock'] <= 0 ? 'disabled' : ''; ?>>
                        Add to Cart
                    </button>
                    
                    <button class="btn btn-outline">Add to Wishlist</button>
                </div>
            </div>
        </div>
        
        <!-- Related Products -->
        <?php if (!empty($relatedProducts)): ?>
        <section class="related-products">
            <div class="section-header">
                <h2>Related Products</h2>
                <p>You might also like</p>
            </div>
            <div class="products-grid">
                <?php foreach ($relatedProducts as $relatedProduct): ?>
                <div class="product-card">
                    <div class="product-image">
                        <img src="uploads/products/<?php echo $relatedProduct['image']; ?>" alt="<?php echo htmlspecialchars($relatedProduct['name']); ?>">
                        <?php if ($relatedProduct['badge']): ?>
                        <span class="product-badge"><?php echo $relatedProduct['badge']; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="product-info">
                        <div class="product-category"><?php echo htmlspecialchars($relatedProduct['category_name']); ?></div>
                        <h3 class="product-title">
                            <a href="product-details.php?id=<?php echo $relatedProduct['id']; ?>">
                                <?php echo htmlspecialchars($relatedProduct['name']); ?>
                            </a>
                        </h3>
                        <div class="product-rating">
                            <div class="stars"><?php echo generateStars($relatedProduct['rating']); ?></div>
                            <div class="rating-count">(<?php echo $relatedProduct['review_count']; ?>)</div>
                        </div>
                        <div class="product-price">
                            <span class="current-price">$<?php echo number_format($relatedProduct['price'], 2); ?></span>
                            <?php if ($relatedProduct['old_price']): ?>
                            <span class="original-price">$<?php echo number_format($relatedProduct['old_price'], 2); ?></span>
                            <?php endif; ?>
                        </div>
                        <button class="add-to-cart" data-product-id="<?php echo $relatedProduct['id']; ?>">Add to Cart</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </div>
</section>

<link rel="stylesheet" href="assets/css/product-details.css">

<script src="assets/js/product-detail.js"></script>

<?php
require_once 'footer.php';
?>