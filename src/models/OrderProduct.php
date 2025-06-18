<?php

require_once "../config/connection.php";

class OrderProduct{
    private $id_order_product;
    private $product_quantity;
    private $total_price_order_product;
    private $product_id;
    private $order_id;
    private $created_at;

    public function store(){
        try {
            $pdo = connect_db();
            $statment = $pdo->prepare("INSERT INTO order_products (product_quantity, total_price_order_product, product_id, order_id, created_at) VALUES (:product_quantity, :total_price_order_product, :product_id, :order_id, :created_at)");
            
            $statment->bindParam(':product_quantity', $this->getProductQuantity());
            $statment->bindParam(':total_price_order_product', $this->getTotalPriceOrderProduct());
            $statment->bindParam(':product_id', $this->getProductId());
            $statment->bindParam(':order_id', $this->getOrderId());
            $statment->bindParam(':created_at', $this->getCreatedAt());
            
            $statment->execute();
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public function getOrderProductId() {
        return $this->id_order_product;
    }

    public function getProductQuantity() {
        return $this->product_quantity;
    }

    public function setProductQuantity($product_quantity) {
        $this->product_quantity = $product_quantity;
    }

    public function getTotalPriceOrderProduct() {
        return $this->total_price_order_product;
    }

    public function setTotalPriceOrderProduct($total_price_order_product) {
        $this->total_price_order_product = $total_price_order_product;
    }

    public function getProductId() {
        return $this->product_id;
    }

    public function setProductId($product_id){
        $this->product_id = $product_id;
    }

    public function getOrderId() {
        return $this->order_id;
    }

    public function setOrderId($order_id) {
        $this->order_id = $order_id;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }
  }