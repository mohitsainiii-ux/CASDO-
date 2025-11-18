<?php
require_once 'db.php';
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CASDO - Premium Online Shopping</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap">
    <style>
        :root {
            --primary-blue: #0B5FFF;
            --primary-orange: #FF6A00;
            --text-dark: #1a1a1a;
            --text-light: #f5f5f5;
            --bg-light: #ffffff;
            --bg-dark: #121212;
            --card-light: #f8f9fa;
            --card-dark: #1e1e1e;
            --border-light: #e0e0e0;
            --border-dark: #333333;
            --shadow-light: rgba(0, 0, 0, 0.1);
            --shadow-dark: rgba(0, 0, 0, 0.3);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: var(--bg-light);
            transition: var(--transition);
            overflow-x: hidden;
        }

        body.dark-theme {
            color: var(--text-light);
            background-color: var(--bg-dark);
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        ul {
            list-style: none;
        }

        button {
            cursor: pointer;
            border: none;
            outline: none;
            font-family: inherit;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        header {
            background-color: var(--bg-light);
            box-shadow: 0 2px 10px var(--shadow-light);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: var(--transition);
        }

        body.dark-theme header {
            background-color: var(--bg-dark);
            box-shadow: 0 2px 10px var(--shadow-dark);
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo {
            font-family: 'Poppins', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-blue);
        }

        .logo span {
            color: var(--primary-orange);
        }

        .search-bar {
            flex: 1;
            max-width: 600px;
            margin: 0 20px;
            position: relative;
        }

        .search-bar input {
            width: 100%;
            padding: 12px 20px;
            border-radius: 30px;
            border: 1px solid var(--border-light);
            background-color: var(--card-light);
            font-size: 16px;
            transition: var(--transition);
        }

        body.dark-theme .search-bar input {
            background-color: var(--card-dark);
            border-color: var(--border-dark);
            color: var(--text-light);
        }

        .search-bar button {
            position: absolute;
            right: 5px;
            top: 5px;
            background-color: var(--primary-blue);
            color: white;
            border-radius: 30px;
            padding: 7px 15px;
            transition: var(--transition);
        }

        .search-bar button:hover {
            background-color: var(--primary-orange);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .theme-toggle {
            background: none;
            font-size: 20px;
            color: var(--text-dark);
            transition: var(--transition);
        }

        body.dark-theme .theme-toggle {
            color: var(--text-light);
        }

        .cart-icon {
            position: relative;
            font-size: 22px;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--primary-orange);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
        }

        .user-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: 500;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background-color: var(--primary-blue);
            color: white;
        }

        .btn-primary:hover {
            background-color: #0047cc;
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--primary-blue);
            color: var(--primary-blue);
        }

        .btn-outline:hover {
            background-color: var(--primary-blue);
            color: white;
        }

        /* Ripple effect for buttons */
        .ripple {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.7);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Navigation */
        nav {
            background-color: var(--primary-blue);
            padding: 0;
            transition: var(--transition);
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-links {
            display: flex;
            gap: 25px;
        }

        .nav-links a {
            color: white;
            padding: 15px 0;
            font-weight: 500;
            position: relative;
            transition: var(--transition);
        }

        .nav-links a:hover {
            color: rgba(255, 255, 255, 0.8);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 3px;
            background-color: var(--primary-orange);
            transition: var(--transition);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .hamburger {
            display: none;
            background: none;
            color: white;
            font-size: 24px;
        }

        /* Hero Slider */
        .hero-slider {
            position: relative;
            height: 500px;
            overflow: hidden;
            margin-bottom: 40px;
        }

        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease;
            display: flex;
            align-items: center;
            background-size: cover;
            background-position: center;
        }

        .slide.active {
            opacity: 1;
        }

        .slide-content {
            max-width: 500px;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            margin-left: 10%;
            animation: fadeInUp 1s ease;
        }

        body.dark-theme .slide-content {
            background-color: rgba(30, 30, 30, 0.9);
        }

        .slide-content h2 {
            font-size: 36px;
            margin-bottom: 15px;
            color: var(--primary-blue);
        }

        .slide-content p {
            margin-bottom: 20px;
            font-size: 18px;
        }

        .slider-dots {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: var(--transition);
        }

        .dot.active {
            background-color: white;
        }

        /* Section Styles */
        section {
            padding: 60px 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-header h2 {
            font-size: 32px;
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }

        .section-header h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background-color: var(--primary-orange);
        }

        /* Product Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
        }

        .product-card {
            background-color: var(--bg-light);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px var(--shadow-light);
            transition: var(--transition);
            position: relative;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }

        body.dark-theme .product-card {
            background-color: var(--card-dark);
            box-shadow: 0 5px 15px var(--shadow-dark);
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px var(--shadow-light);
        }

        body.dark-theme .product-card:hover {
            box-shadow: 0 15px 30px var(--shadow-dark);
        }

        .product-image {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .product-card:hover .product-image img {
            transform: scale(1.1);
        }

        .product-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: var(--primary-orange);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .product-info {
            padding: 20px;
        }

        .product-category {
            font-size: 12px;
            color: #888;
            margin-bottom: 5px;
        }

        .product-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
            height: 40px;
            overflow: hidden;
        }

        .product-rating {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .stars {
            color: #FFC107;
            margin-right: 5px;
        }

        .rating-count {
            font-size: 12px;
            color: #888;
        }

        .product-price {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .current-price {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-blue);
        }

        .original-price {
            font-size: 14px;
            color: #888;
            text-decoration: line-through;
        }

        .add-to-cart {
            width: 100%;
            padding: 10px;
            background-color: var(--primary-blue);
            color: white;
            border-radius: 4px;
            font-weight: 600;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .add-to-cart:hover {
            background-color: var(--primary-orange);
        }

        .add-to-cart.bounce {
            animation: bounce 0.5s ease;
        }

        @keyframes bounce {
            0%, 20%, 60%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            80% {
                transform: translateY(-5px);
            }
        }

        /* Categories Section */
        .categories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .category-card {
            background-color: var(--card-light);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px var(--shadow-light);
            transition: var(--transition);
            position: relative;
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        body.dark-theme .category-card {
            background-color: var(--card-dark);
            box-shadow: 0 5px 15px var(--shadow-dark);
        }

        .category-card:hover {
            transform: translateY(-5px);
        }

        .category-card h3 {
            font-size: 20px;
            color: var(--primary-blue);
            z-index: 1;
            position: relative;
        }

        /* Footer */
        footer {
            background-color: var(--primary-blue);
            color: white;
            padding: 60px 0 20px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-column h3 {
            font-size: 18px;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: var(--primary-orange);
        }

        .footer-column ul li {
            margin-bottom: 10px;
        }

        .footer-column ul li a {
            transition: var(--transition);
        }

        .footer-column ul li a:hover {
            color: rgba(255, 255, 255, 0.8);
            padding-left: 5px;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background-color: var(--primary-blue);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 5px 15px var(--shadow-light);
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            z-index: 100;
        }

        body.dark-theme .back-to-top {
            box-shadow: 0 5px 15px var(--shadow-dark);
        }

        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            background-color: var(--primary-orange);
            transform: translateY(-5px);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Skeleton Loading */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 4px;
        }

        body.dark-theme .skeleton {
            background: linear-gradient(90deg, #2a2a2a 25%, #3a3a3a 50%, #2a2a2a 75%);
            background-size: 200% 100%;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .nav-links {
                display: none;
            }

            .hamburger {
                display: block;
            }

            .slide-content {
                margin-left: 5%;
            }
        }

        @media (max-width: 768px) {
            .header-top {
                flex-direction: column;
                gap: 15px;
            }

            .search-bar {
                margin: 15px 0;
                max-width: 100%;
            }

            .hero-slider {
                height: 400px;
            }

            .slide-content {
                padding: 20px;
                max-width: 90%;
            }

            .slide-content h2 {
                font-size: 28px;
            }
        }

        @media (max-width: 576px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 15px;
            }

            .product-image {
                height: 150px;
            }

            .product-info {
                padding: 15px;
            }

            .section-header h2 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-top">
                <a href="index.php" class="logo">CAS<span>DO</span></a>
                
                <form action="search.php" method="GET" class="search-bar">
                    <input type="text" name="q" placeholder="Search for products, brands and more..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
                    <button type="submit">Search</button>
                </form>
                
                <div class="header-actions">
                    <button class="theme-toggle" id="themeToggle">🌙</button>
                    <a href="cart.php" class="cart-icon">
                        🛒
                        <span class="cart-count"><?php echo getCartCount(); ?></span>
                    </a>
                    <div class="user-actions">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="logout.php" class="btn btn-outline">Logout</a>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-outline">Login</a>
                            <a href="signup.php" class="btn btn-primary">Sign Up</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <nav>
            <div class="container nav-container">
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="products.php">Categories</a></li>
                    <li><a href="products.php?trending=1">Trending</a></li>
                    <li><a href="products.php?featured=1">Best Sellers</a></li>
                    <li><a href="products.php">Today's Deals</a></li>
                    <li><a href="products.php">New Releases</a></li>
                </ul>
                <button class="hamburger">☰</button>
            </div>
        </nav>
    </header>