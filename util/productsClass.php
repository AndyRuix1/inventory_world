<?php 
class Products extends DB{
    private $inventoryId;

    public function __construct($inventoryId){
        $this->inventoryId = $inventoryId;
        parent::__construct();
    }

    public function getProduct($productId){
        $query = $this->connect()->prepare('SELECT * FROM products WHERE id=:product_id AND inventory_id=:inventory_id');
        $query->execute(['product_id' => $productId, 'inventory_id' => $this->inventoryId]);
        return $query->fetch(PDO::FETCH_ASSOC) ?? array();
    }

    public function getProducts(){
        $query = $this->connect()->prepare('SELECT * FROM products WHERE inventory_id=:inventory_id');
        $query->execute(['inventory_id' => $this->inventoryId]);
        return $query->fetchAll(PDO::FETCH_ASSOC) ?? array();
    }

    public function deleteProduct($productId){
        $query = $this->connect()->prepare('DELETE FROM products WHERE id=:product_id AND inventory_id=:inventory_id');
        $query->execute(['product_id' => $productId, 'inventory_id' => $this->inventoryId]);
        return ($query->rowCount() > 0);
    }

    public function createProduct($productName, $productDescription, $productPrice = 0, $product_count = 0){
        $query = $this->connect()->prepare('INSERT INTO products (id, inventory_id, product_name, product_description, product_price, product_count) VALUES (NULL, :inventory_id, :product_name, :product_description, :product_price, :product_count);');
        $result = $query->execute(['inventory_id' => $this->inventoryId, 'product_name' => $productName, 'product_description' => $productDescription, 'product_price' => $productPrice, 'product_count' => $product_count]);
        return ($result && $query->rowCount() > 0);
    }

    public function updateProduct($productId, $productName, $productDescription, $productPrice = 0, $productCount = 0){

        $query = $this->connect()->prepare('UPDATE products SET product_name=:product_name, product_description=:product_description, product_price=:product_price, product_count=:product_count WHERE id=:product_id AND inventory_id=:inventory_id');
        $query->execute(['product_name' => $productName, 'product_description' => $productDescription, 'product_price' => $productPrice, 'product_count' => $productCount, 'product_id' => $productId, 'inventory_id' => $this->inventoryId]);
        return ($query->rowCount() > 0);
    }

    public function productExist($productId){
        $query = $this->connect()->prepare('SELECT * FROM products WHERE inventory_id=:inventory_id AND id=:product_id');
        $query->execute(['inventory_id' => $this->inventoryId, 'product_id' => $productId]);
        return ($query->rowCount() > 0);
    }



}
?>