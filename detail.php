<?php
require_once 'classes/Product.php';
require_once 'classes/ProductRepository.php';

// Initialize repository
$productRepo = new ProductRepository(__DIR__ . '/data/products.json');

// Check if product ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$productId = (int)$_GET['id'];
$product = $productRepo->findProductById($productId);

// If product not found, redirect to home
if (!$product) {
    header('Location: index.php');
    exit;
}

// Get category name
$categoryName = $productRepo->getCategoryName($product->getCategoryId());
$page_title = htmlspecialchars($product->getName() . ' - Jastipdies');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.7.0/fonts/remixicon.css" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="./css/detail.css">
    
</head>
<body>
    <!-- Header -->
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="back-link" aria-label="Kembali">
                <i class="ri-arrow-left-line"></i>
            </a>
            <a href="index.php" class="logo">Jastipdies</a>
        </div>
    </nav>

    <!-- Product Detail -->
    <main class="detail-container">
        <div class="container">
            <div class="product-layout">
                <!-- Kolom Kiri - Galeri Produk -->
                <div class="product-gallery">
                    <div class="main-image-container">
                        <?php 
                        $images = $product->getImages();
                        $mainImage = !empty($images) ? reset($images) : 'https://via.placeholder.com/600x600?text=Gambar+Tidak+Ditemukan';
                        ?>
                        <!-- Debug: <?= htmlspecialchars(print_r($images, true)) ?> -->
                        <img src="<?= htmlspecialchars($mainImage) ?>"
                             alt="<?= htmlspecialchars($product->getName()) ?>"
                             class="main-image"
                             onerror="this.onerror=null; this.src='https://via.placeholder.com/600x600?text=Gambar+Tidak+Ditemukan'"
                             loading="lazy">
                    </div>
                    <?php if (count($product->getImages()) > 1): ?>
                    <div class="thumbnail-list">
                        <?php foreach ($product->getImages() as $index => $imageUrl): ?>
                            <div class="thumbnail-item <?= $index === 0 ? 'active' : '' ?>" 
                                 data-image="<?= htmlspecialchars($imageUrl) ?>">
                                <img src="<?= htmlspecialchars($imageUrl) ?>" 
                                     alt="<?= htmlspecialchars($product->getName()) ?> - Gambar <?= $index + 1 ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Kolom Kanan - Info Produk -->
                <div class="product-info">
                    <div class="product-header">
                        <span class="product-category"><?= htmlspecialchars($categoryName) ?></span>
                        <h1 class="product-title"><?= htmlspecialchars($product->getName()) ?></h1>
                        <div class="product-price"><?= $product->getFormattedPrice() ?></div>
                    </div>

                    <div class="product-description-section">
                        <h3>Deskripsi Produk</h3>
                        <div class="product-description">
                            <?= nl2br(htmlspecialchars($product->getDescription())) ?>
                        </div>
                    </div>
                    
                    <div class="product-actions">
                        <a href="https://wa.me/6285767412586?text=<?= urlencode("Halo, saya ingin mempesan " . $product->getName() . " dengan harga " . $product->getFormattedPrice()) ?>" 
                           class="whatsapp-btn" 
                           target="_blank">
                            <i class="ri-whatsapp-line"></i> Pesan via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Add any necessary JavaScript here
        document.querySelector('.back-link').addEventListener('click', function(e) {
            e.preventDefault();
            window.history.back();
        });
    </script>
</body>
</html>