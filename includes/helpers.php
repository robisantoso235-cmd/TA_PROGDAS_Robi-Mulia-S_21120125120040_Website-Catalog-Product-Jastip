<?php
function renderProductCard($product, $categoryName) {
    ob_start();
    ?>
    <a href="detail.php?id=<?= $product->getId() ?>" class="produk-link">
        <div class="produk-box">
            <div class="produk-image">
                <img src="<?= htmlspecialchars($product->getImageUrl()) ?>" 
                     alt="<?= htmlspecialchars($product->getName()) ?>">
            </div>
            <div class="produk-info">
                <h3><?= htmlspecialchars($product->getName()) ?></h3>
                <p class="price"><?= $product->getFormattedPrice() ?></p>
                <p class="category"><?= htmlspecialchars($categoryName) ?></p>
            </div>
        </div>
    </a>
    <?php
    return ob_get_clean();
}

function renderCategoryFilter($categories, $activeCategory = null) {
    ob_start();
    ?>
    <div class="category-filter">
        <a href="?" class="category-btn <?= is_null($activeCategory) ? 'active' : '' ?>">
            Semua
        </a>
        <?php foreach ($categories as $category): ?>
            <a href="?category=<?= $category['id'] ?>" 
               class="category-btn <?= $activeCategory == $category['id'] ? 'active' : '' ?>">
                <?= htmlspecialchars($category['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
