<?php

require "../config/connection.php";
require "../models/Stock.php";

class Product {
    private $name;
    private $price;
    private $variation;

    public function getProducts() {
        try {
            $pdo = connect_db();
            $statment = $pdo->prepare("SELECT product_name, product_price, product_variation FROM products");

            $statment->execute();
            $products = $statment->fetchAll(PDO::FETCH_ASSOC);

            return $products;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public function getProduct($id_product) {
        try {
            $pdo = connect_db();
            $statment = $pdo->prepare("SELECT * FROM products WHERE id_product = :id");
            $statment->bindValue(":id", $id_product);
            $statment->execute();
            
            $product = $statment->fetch(PDO::FETCH_OBJ);

            return $product;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }

    }

    public function update($request){
        $product = self::getProduct(strval($request['id']));
        
        if(!empty($product)){
            try {
                $pdo = connect_db();
                $statment = $pdo->prepare("UPDATE products SET product_name = :product_name, product_price = :product_price, product_variation = :product_variation WHERE id_product = :id");

                $statment->bindParam(':product_name', $request['name']);
                $statment->bindParam(':product_price', $request['price']);
                $statment->bindParam(':product_variation', $request['variation']);
                $statment->bindParam(':id', strval($product->id_product));
                $statment->execute();

                return true;
            } catch (PDOException $e) {
                var_dump($e->getMessage());
            }
        }
        return false;
    }

    
    private function exists($product_name){
        try {
            $pdo = connect_db();
            $statment = $pdo->prepare("SELECT * FROM products WHERE product_name = :product_name");

            $statment->execute([':product_name' => $product_name]);
            
            if(!empty($statment->fetch(PDO::FETCH_OBJ))){
                return true;
            }
            return false;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public function store(){
        $productExists = self::exists($this->name);
        
        if(!$productExists){
            try {
                $pdo = connect_db();
                $statment = $pdo->prepare("INSERT INTO products (product_name, product_price, product_variation, created_at) VALUES (:name, :price, :variation, :created_at)");

                $statment->bindParam(':name', $this->name);
                $statment->bindParam(':price', $this->price);
                $statment->bindParam(':variation', $this->variation);
                $statment->bindParam(':created_at', getDatetime());
                $statment->execute();

                return $pdo->lastInsertId();
            } catch (PDOException $e) {
                var_dump($e->getMessage());
            }
        }
        return -1;
    }

    public function setName($name){
        $this->name = $name;
    }
    
    public function setPrice($price){
        $this->price = $price;
    }
    
    public function setVariation($variation){
        $this->variation = $variation;
    }

    public function getName(){
        return $this->name;
    }
    
    public function getPrice(){
        return $this->price;
    }

    public function getVariation(){
        return $this->variation;
    }
}

?>