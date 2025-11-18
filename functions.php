<?php
session_start();

// Function to get products
function getProducts($pdo, $limit = null, $category = null, $trending = false, $featured = false) {
    $sql = "SELECT p.*, c.name as category_name FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id WHERE 1=1";
    
    $params = [];
    
    if ($category) {
        $sql .= " AND p.category_id = ?";
        $params[] = $category;
    }
    
    if ($trending) {
        $sql .= " AND p.trending = 1";
    }
    
    if ($featured) {
        $sql .= " AND p.featured = 1";
    }
    
    $sql .= " ORDER BY p.created_at DESC";
    
    if ($limit) {
        $sql .= " LIMIT " . (int)$limit;
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get product by ID
function getProductById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p 
                          LEFT JOIN categories c ON p.category_id = c.id 
                          WHERE p.id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to get categories
function getCategories($pdo) {
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get sliders
function getSliders($pdo) {
    $stmt = $pdo->query("SELECT * FROM sliders WHERE active = 1 ORDER BY created_at");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Cart functions
function addToCart($productId, $quantity = 1) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }
}

function removeFromCart($productId) {
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
}

function updateCartQuantity($productId, $quantity) {
    if (isset($_SESSION['cart'][$productId])) {
        if ($quantity <= 0) {
            removeFromCart($productId);
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }
    }
}

function getCartItems($pdo) {
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        return [];
    }
    
    $productIds = array_keys($_SESSION['cart']);
    $placeholders = str_repeat('?,', count($productIds) - 1) . '?';
    
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($productIds);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $cartItems = [];
    foreach ($products as $product) {
        $cartItems[] = [
            'product' => $product,
            'quantity' => $_SESSION['cart'][$product['id']]
        ];
    }
    
    return $cartItems;
}

function getCartTotal($pdo) {
    $cartItems = getCartItems($pdo);
    $total = 0;
    
    foreach ($cartItems as $item) {
        $total += $item['product']['price'] * $item['quantity'];
    }
    
    return $total;
}

function getCartCount() {
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        return 0;
    }
    
    return array_sum($_SESSION['cart']);
}

// Search function
function searchProducts($pdo, $query) {
    $stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p 
                          LEFT JOIN categories c ON p.category_id = c.id 
                          WHERE p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?");
    $searchTerm = "%$query%";
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Generate stars for rating
function generateStars($rating) {
    $stars = '';
    $fullStars = floor($rating);
    $hasHalfStar = $rating - $fullStars >= 0.5;
    
    for ($i = 0; $i < $fullStars; $i++) {
        $stars .= '★';
    }
    
    if ($hasHalfStar) {
        $stars .= '½';
    }
    
    $emptyStars = 5 - ceil($rating);
    for ($i = 0; $i < $emptyStars; $i++) {
        $stars .= '☆';
    }
    
    return $stars;
}
?>