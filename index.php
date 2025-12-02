<?php
require_once 'classes/Product.php';
require_once 'classes/ProductRepository.php';
require_once 'includes/helpers.php';

// Initialize repository
$productRepo = new ProductRepository(__DIR__ . '/data/products.json');

// Get category from URL if exists
$categoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;

// Get products based on category filter
$products = $productRepo->getProductsByCategory($categoryId);
$categories = $productRepo->getAllCategories();

// Error handling
$error = '';
if (empty($products) && $categoryId) {
    $error = 'Tidak ada produk dalam kategori yang dipilih.';
} elseif (empty($products)) {
    $error = 'Tidak ada produk yang tersedia.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1200">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS & JS -->
    <link rel="stylesheet" href="./css/style.css?v=2.0">
    <script src="./js/script.js?v=2.0"></script>

    <!-- Remix Icon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.7.0/fonts/remixicon.css" rel="stylesheet">

    <title>Katalog Produk</title>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="container">
        <div class="navbar-box">
            <h1>Jastipdies</h1>
            <div class="logo">
                <ul class="menu nav-menu">
                    <li><a href="#">Beranda</a></li>
                    <li><a href="#layanan-section">Layanan</a></li>
                    <li><a href="#produk-section">Produk Kami</a></li>
                    <li><a href="https://www.instagram.com/jastipdies/" target="_blank">Social media</a></li>                  </ul>
            </div>
        </div>
    </div>
</div>

<!-- HERO -->
<div class="hero">
    <div class="container">
        <div class="hero-box">
            <div class="hero-text">
                <h1>Solusi Jasa Titip Terpercaya</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse ipsa voluptate nesciunt dolore expedita.</p>
                <a href="#produk-section" class="btn">Detail Produk Kami</a>
            </div>
            <div class="hero-img">
                <img src="https://jastipdies.web.app/assets/cropped-Cuplikan%20layar%202025-11-17%20200218.png" alt="foto-jastip" />
            </div>
        </div>
    </div>
</div>

<!-- LAYANAN -->
<div class="layanan" id="layanan-section">
    <div class="container">
        <div class="layanan-box">
            <div class="box">
                <i class="ri-shopping-bag-3-line ri-2x"></i>
                <h2>Beragam Produk</h2>
                <p>Kami menyediakan berbagai produk yang terjamin 100% original.</p>
            </div>
            <div class="box">
                <i class="ri-shield-check-line ri-2x"></i>
                <h2>Aman dan Terpercaya</h2>
                <p>Keamanan dan kepercayaan Anda adalah prioritas utama kami dalam setiap transaksi.</p>
            </div>
            <div class="box">
                <i class="ri-price-tag-line ri-2x"></i>
                <h2>Harga Terjangkau</h2>
                <p>Penawaran harga yang adil dan transparan untuk setiap produk.</p>
            </div>
        </div>
    </div>
</div>

<!-- PRODUK -->
<div class="foto" id="produk-section">
    <div class="container">
        <div class="foto_box">
            <h2>Produk Kami</h2>
            
            <!-- Category Filter -->
            <div class="category-section">
                <div class="category-container">
                    <h3 class="category-title">Kategori Produk</h3>
                    <div class="category-filter">
                        <a href="?" class="category-btn <?= !isset($_GET['category']) ? 'active' : '' ?>">
                            <span>Semua</span>
                        </a>
                        <?php foreach ($categories as $category): 
                            $productCount = count($productRepo->getProductsByCategory($category['id']));
                        ?>
                            <a href="?category=<?= $category['id'] ?>" 
                               class="category-btn <?= (isset($_GET['category']) && $_GET['category'] == $category['id']) ? 'active' : '' ?>">
                                <span><?= htmlspecialchars($category['name']) ?></span>
                                <?php if ($productCount > 0): ?>
                                    <span class="category-count"><?= $productCount ?></span>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- Add some spacing -->
            <div style="margin-bottom: 20px;"></div>
            
            <div class="produk-grid" id="produk-container">
                <?php if ($error): ?>
                    <div class="error-message">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php else: ?>
                    <?php 
                        foreach ($products as $product): 
                            $categoryName = $productRepo->getCategoryName($product->getCategoryId());
                            echo renderProductCard($product, $categoryName);
                        endforeach; 
                    ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Kontak Modal -->
<div id="kontak-modal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <span class="close-btn" id="close-modal-btn">&times;</span>
        <h2>Kontak Kami</h2>
        <p>Hubungi kami melalui:</p>
        <div class="kontak-links">
            <a href="https://www.instagram.com/jastipdies/" target="_blank" class="kontak-link instagram">
                <i class="ri-instagram-line"></i>
                <span>Instagram</span>
            </a>
            <a href="https://wa.me/6285767412586" target="_blank" class="kontak-link whatsapp">
                <i class="ri-whatsapp-line"></i>
                <span>WhatsApp</span>
            </a>
        </div>
    </div>
</div>

</body>
</html>
