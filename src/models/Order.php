<?php

require_once "../config/connection.php";


class Order {
    private $id_order;
    private $delivery_price;
    private $total_order_price;
    private $delivery_address;
    private $created_at;

    public function store(){
        try {
            $pdo = connect_db();
            $statment = $pdo->prepare("INSERT INTO orders (delivery_price, total_order_price, delivery_address, created_at) VALUES (:delivery_price, :total_order_price, :delivery_address, :created_at)");
            
            $statment->bindParam(':delivery_price', $this->getDeliveryPrice());
            $statment->bindParam(':total_order_price', $this->getTotalOrderPrice());
            $statment->bindParam(':delivery_address', $this->getDeliveryAddress());
            $statment->bindParam(':created_at', $this->getCreatedAt());
            
            $statment->execute();

            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public function getIdOrder() {
        return $this->id_order;
    }

    public function getDeliveryPrice() {
        return $this->delivery_price;
    }
    
    public function setDeliveryPrice($delivery_price) {
        $this->delivery_price = $delivery_price;
    }

    public function getTotalOrderPrice() {
        return $this->total_order_price;
    }

    public function setTotalOrderPrice($total_order_price){
        $this->total_order_price = $total_order_price;
    }

    public function getDeliveryAddress() {
        return $this->delivery_address;
    }

    public function setDeliveryAddress($delivery_address) {
        $this->delivery_address = $delivery_address;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setCreatedAt($created_at){
        $this->created_at = $created_at;
    }
}