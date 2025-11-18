<?php
$pageTitle = "Edit Product";
require_once 'header.php';

if (!isset($_GET['id'])) {
    header('Location: manage-products.php');
    exit;
}

$productId = intval($_GET['id']);
$product = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$product->execute([$productId]);
$product = $product->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: manage-products.php');
    exit;
}

// Get categories for dropdown
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $category_id = intval($_POST['category_id']);
    $price = floatval($_POST['price']);
    $old_price = !empty($_POST['old_price']) ? floatval($_POST['old_price']) : null;
    $stock = intval($_POST['stock']);
    $rating = floatval($_POST['rating']);
    $review_count = intval($_POST['review_count']);
    $badge = trim($_POST['badge']);
    $featured = isset($_POST['featured']) ? 1 : 0;
    $trending = isset($_POST['trending']) ? 1 : 0;
    
    // Handle image upload
    $image = $product['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $file_type = $_FILES['image']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            // Delete old image
            if ($image && file_exists('../uploads/products/' . $image)) {
                unlink('../uploads/products/' . $image);
            }
            
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image = uniqid() . '.' . $extension;
            $upload_path = '../uploads/products/' . $image;
            
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                $error = "Failed to upload image.";
            }
        } else {
            $error = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
        }
    }
    
    if (!isset($error)) {
        $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, category_id = ?, price = ?, old_price = ?, image = ?, stock = ?, rating = ?, review_count = ?, badge = ?, featured = ?, trending = ? WHERE id = ?");
        
        if ($stmt->execute([$name, $description, $category_id, $price, $old_price, $image, $stock, $rating, $review_count, $badge, $featured, $trending, $productId])) {
            header('Location: manage-products.php');
            exit;
        } else {
            $error = "Failed to update product.";
        }
    }
}
?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Edit Product</h4>
        
        <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?php echo htmlspecialchars($product['name']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>" 
                                    <?php echo $category['id'] == $product['category_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" 
                                       value="<?php echo $product['price']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="old_price" class="form-label">Old Price (Optional)</label>
                                <input type="number" class="form-control" id="old_price" name="old_price" step="0.01"
                                       value="<?php echo $product['old_price']; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="image" class="form-label">Product Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <?php if ($product['image']): ?>
                        <div class="mt-2">
                            <img src="../uploads/products/<?php echo $product['image']; ?>" 
                                 alt="Current Image" style="max-width: 200px; height: auto;">
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock Quantity</label>
                                <input type="number" class="form-control" id="stock" name="stock" 
                                       value="<?php echo $product['stock']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="badge" class="form-label">Badge (Optional)</label>
                                <input type="text" class="form-control" id="badge" name="badge" 
                                       value="<?php echo $product['badge']; ?>" placeholder="Sale, New, Popular, etc.">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating</label>
                                <input type="number" class="form-control" id="rating" name="rating" step="0.1" min="0" max="5"
                                       value="<?php echo $product['rating']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="review_count" class="form-label">Review Count</label>
                                <input type="number" class="form-control" id="review_count" name="review_count"
                                       value="<?php echo $product['review_count']; ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1"
                                   <?php echo $product['featured'] ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="featured">Featured Product</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="trending" name="trending" value="1"
                                   <?php echo $product['trending'] ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="trending">Trending Product</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="manage-products.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php
require_once 'footer.php';
?>