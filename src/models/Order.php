<?php

require_once "../config/connection.php";


class Order {
    private $id_order;
    private $product_quantity;
    private $total_order_price;
    private $product_id;
    private $created_at;

    public function store(){
        try {
            $pdo = connect_db();
            $statment = $pdo->prepare("INSERT INTO orders (product_quantity, total_order_price, product_id, created_at) VALUES (:product_quantity, :total_order_price, :product_id, :created_at)");
            
            $statment->bindParam(':product_quantity', $this->getProductQuantity());
            $statment->bindParam(':total_order_price', $this->getTotalOrderPrice());
            $statment->bindParam(':product_id', $this->getProductId());
            $statment->bindParam(':created_at', $this->getCreatedAt());
            
            $statment->execute();
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public function getIdOrder() {
        return $this->id_order;
    }

    public function getProductQuantity() {
        return $this->product_quantity;
    }
    
    public function setProductQuantity($product_quantity) {
        $this->product_quantity = $product_quantity;
    }

    public function getTotalOrderPrice() {
        return $this->total_order_price;
    }

    public function setTotalOrderPrice($total_order_price){
        $this->total_order_price = $total_order_price;
    }

    public function getProductId() {
        return $this->product_id;
    }

    public function setProductId($product_id) {
        $this->product_id = $product_id;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setCreatedAt($created_at){
        $this->created_at = $created_at;
    }
}