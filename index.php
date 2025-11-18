<?php
require_once 'header.php';

// Get products for different sections
$trendingProducts = getProducts($pdo, 4, null, true);
$featuredProducts = getProducts($pdo, 4, null, false, true);
$categories = getCategories($pdo);
$sliders = getSliders($pdo);
?>

<!-- Hero Slider -->
<section class="hero-slider">
    <?php foreach ($sliders as $index => $slider): ?>
    <div class="slide <?php echo $index === 0 ? 'active' : ''; ?>" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('uploads/sliders/<?php echo $slider['image']; ?>');">
        <div class="slide-content">
            <h2><?php echo htmlspecialchars($slider['title']); ?></h2>
            <p><?php echo htmlspecialchars($slider['subtitle']); ?></p>
            <a href="<?php echo $slider['button_link']; ?>" class="btn btn-primary"><?php echo $slider['button_text']; ?></a>
        </div>
    </div>
    <?php endforeach; ?>
    <div class="slider-dots">
        <?php foreach ($sliders as $index => $slider): ?>
        <span class="dot <?php echo $index === 0 ? 'active' : ''; ?>"></span>
        <?php endforeach; ?>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section">
    <div class="container">
        <div class="section-header">
            <h2>Shop by Category</h2>
            <p>Browse our wide range of product categories</p>
        </div>
        <div class="categories">
            <?php foreach ($categories as $category): ?>
            <div class="category-card">
                <h3><?php echo htmlspecialchars($category['name']); ?></h3>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Trending Products -->
<section class="trending-products">
    <div class="container">
        <div class="section-header">
            <h2>Trending Products</h2>
            <p>Most popular items right now</p>
        </div>
        <div class="products-grid">
            <?php foreach ($trendingProducts as $product): ?>
            <div class="product-card">
                <div class="product-image">
                    <img src="uploads/products/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <?php if ($product['badge']): ?>
                    <span class="product-badge"><?php echo $product['badge']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="product-info">
                    <div class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></div>
                    <h3 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h3>
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
    </div>
</section>

<!-- Featured Products -->
<section class="best-sellers">
    <div class="container">
        <div class="section-header">
            <h2>Best Sellers</h2>
            <p>Customer favorites</p>
        </div>
        <div class="products-grid">
            <?php foreach ($featuredProducts as $product): ?>
            <div class="product-card">
                <div class="product-image">
                    <img src="uploads/products/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <?php if ($product['badge']): ?>
                    <span class="product-badge"><?php echo $product['badge']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="product-info">
                    <div class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></div>
                    <h3 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h3>
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
    </div>
</section>

<script src="assets/js/index.js"></script>

<?php
require_once 'footer.php';
?>