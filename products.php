<?php
require_once 'header.php';

$category = isset($_GET['category']) ? intval($_GET['category']) : null;
$trending = isset($_GET['trending']) ? true : false;
$featured = isset($_GET['featured']) ? true : false;
$search = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($search) {
    $products = searchProducts($pdo, $search);
    $pageTitle = "Search Results for: " . htmlspecialchars($search);
} else {
    $products = getProducts($pdo, null, $category, $trending, $featured);
    
    if ($trending) {
        $pageTitle = "Trending Products";
    } elseif ($featured) {
        $pageTitle = "Best Sellers";
    } elseif ($category) {
        $categoryData = getCategories($pdo);
        $currentCategory = array_filter($categoryData, function($cat) use ($category) {
            return $cat['id'] == $category;
        });
        $currentCategory = reset($currentCategory);
        $pageTitle = $currentCategory ? $currentCategory['name'] : "Products";
    } else {
        $pageTitle = "All Products";
    }
}

$categories = getCategories($pdo);
?>

<section class="products-page">
    <div class="container">
        <div class="section-header">
            <h2><?php echo $pageTitle; ?></h2>
            <?php if ($search): ?>
            <p>Found <?php echo count($products); ?> products matching your search</p>
            <?php endif; ?>
        </div>
        
        <div class="products-layout">
            <!-- Sidebar with categories -->
            <aside class="categories-sidebar">
                <h3>Categories</h3>
                <ul>
                    <li><a href="products.php" class="<?php echo !$category ? 'active' : ''; ?>">All Products</a></li>
                    <?php foreach ($categories as $cat): ?>
                    <li>
                        <a href="products.php?category=<?php echo $cat['id']; ?>" 
                           class="<?php echo $category == $cat['id'] ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                
                <h3>Filters</h3>
                <ul>
                    <li><a href="products.php?trending=1" class="<?php echo $trending ? 'active' : ''; ?>">Trending</a></li>
                    <li><a href="products.php?featured=1" class="<?php echo $featured ? 'active' : ''; ?>">Best Sellers</a></li>
                </ul>
            </aside>
            
            <!-- Products grid -->
            <div class="products-grid">
                <?php if (empty($products)): ?>
                <div class="no-products">
                    <h3>No products found</h3>
                    <p>Try adjusting your search or filter criteria</p>
                </div>
                <?php else: ?>
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
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="assets/css/products.css">

<script src="assets/js/products.js"></script>

<?php
require_once 'footer.php';
?>