<?php
class ProductRepository {
    private $products = [];
    private $categories = [];

    public function __construct($jsonFile) {
        $this->loadData($jsonFile);
    }

    private function loadData($jsonFile) {
        $jsonData = file_get_contents($jsonFile);
        $data = json_decode($jsonData, true);
        
        // Load categories
        $this->categories = $data['categories'];
        
        // Load products
        foreach ($data['products'] as $productData) {
            $this->products[] = new Product($productData);
        }
    }

    public function getAllProducts() {
        return $this->products;
    }

    public function getProductsByCategory($categoryId) {
        if (empty($categoryId)) {
            return $this->products;
        }
        
        return array_filter($this->products, function($product) use ($categoryId) {
            return $product->getCategoryId() == $categoryId;
        });
    }

    public function findProductById($id) {
        $products = $this->getAllProducts();
        foreach ($products as $product) {
            if ($product->getId() === $id) {
                return $product;
            }
        }
        return null;
    }

    public function getAllCategories() {
        return $this->categories;
    }

    public function getCategoryName($categoryId) {
        foreach ($this->categories as $category) {
            if ($category['id'] == $categoryId) {
                return $category['name'];
            }
        }
        return 'Uncategorized';
    }
}
