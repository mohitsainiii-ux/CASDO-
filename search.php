<?php
require_once 'header.php';

$query = isset($_GET['q']) ? trim($_GET['q']) : '';

if (empty($query)) {
    header('Location: products.php');
    exit;
}

$products = searchProducts($pdo, $query);
?>

<section class="search-results">
    <div class="container">
        <div class="section-header">
            <h2>Search Results for "<?php echo htmlspecialchars($query); ?>"</h2>
            <p>Found <?php echo count($products); ?> products</p>
        </div>
        
        <?php if (empty($products)): ?>
        <div class="no-results">
            <h3>No products found</h3>
            <p>Try different keywords or browse our categories</p>
            <a href="products.php" class="btn btn-primary">Browse All Products</a>
        </div>
        <?php else: ?>
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
            <div class="product-card">
                <div class="product-image">
                    <img src="uploads/products/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <?php if ($product['badge']): ?>
                    <span class="product-badge"><?php echo $product['badge']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="product-info">
                    <div class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></div>
                    <h3 class="product-title">
                        <a href="product-details.php?id=<?php echo $product['id']; ?>">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </a>
                    </h3>
                    <div class="product-rating">
                        <div class="stars"><?php echo generateStars($product['rating']); ?></div>
                        <div class="rating-count">(<?php echo $product['review_count']; ?>)</div>
                    </div>
                    <div class="product-price">
                        <span class="current-price">$<?php echo number_format($product['price'], 2); ?></span>
                        <?php if ($product['old_price']): ?>
                        <span class="original-price">$<?php echo number_format($product['old_price'], 2); ?></span>
                        <?php endif; ?>
                    </div>
                    <button class="add-to-cart" data-product-id="<?php echo $product['id']; ?>">Add to Cart</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<link rel="stylesheet" href="assets/css/search.css">

<script src="assets/js/search.js"></script>

<?php
require_once 'footer.php';
?>