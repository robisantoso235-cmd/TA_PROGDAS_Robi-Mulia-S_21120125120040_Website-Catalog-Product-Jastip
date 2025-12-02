<?php
class Product {
    private $id;
    private $name;
    private $description;
    private $price;
    private $image;
    private $images;
    private $categoryId;
    private $stock;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->price = $data['price'];
        $this->image = $data['image'] ?? '';
        $this->images = $data['images'] ?? [];
        $this->categoryId = $data['category_id'];
    }

    // Getter methods
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function getPrice() { return $this->price; }
    public function getImage() { 
        // Jika images ada dan tidak kosong, kembalikan gambar pertama
        if (!empty($this->images)) {
            return is_array($this->images) ? $this->images[0] : $this->images;
        }
        return $this->image; 
    }
    
    public function getImages() {
        $images = [];
        
        // Jika ada image utama, tambahkan ke array
        if (!empty($this->image)) {
            $images[] = $this->image;
        }
        
        // Jika ada images, tambahkan ke array
        if (!empty($this->images)) {
            if (is_array($this->images)) {
                $images = array_merge($images, $this->images);
            } else {
                $images[] = $this->images;
            }
        }
        
        // Hapus duplikat dan nilai kosong
        $images = array_filter(array_unique($images));
        
        // Jika tidak ada gambar, kembalikan array dengan placeholder
        if (empty($images)) {
            return ['https://via.placeholder.com/600x600?text=No+Image'];
        }
        
        return array_values($images);
    }
    public function getCategoryId() { return $this->categoryId; }
    public function getStock() { return $this->stock; }

    // Helper methods
    public function getFormattedPrice() {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getImageUrl() {
        // First try to get from $this->image
        if (!empty($this->image)) {
            return $this->image;
        }
        
        // If $this->image is empty, try to get from $this->images
        if (!empty($this->images)) {
            if (is_array($this->images)) {
                return !empty($this->images[0]) ? $this->images[0] : 'https://via.placeholder.com/300x300?text=No+Image';
            }
            return $this->images; // In case it's a string
        }
        
        // Default fallback
        return 'https://via.placeholder.com/300x300?text=No+Image';
    }
}
