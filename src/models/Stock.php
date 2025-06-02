<?php

// No topo do Stock.php
require_once __DIR__ . '/../config/connection.php';

class Stock {
    private $id_stock;
    private $total_product;
    private $last_update;
    private $product_id;

    public function store(){
        try {
            $pdo = connect_db();
            $statment = $pdo->prepare("INSERT INTO stock (total_product, last_update, product_id) VALUES (:total_product, :last_update, :product_id)");

            $statment->bindParam(':total_product', $this->total_product);
            $statment->bindParam(':last_update', $this->last_update);
            $statment->bindParam(':product_id', $this->product_id);
            $statment->execute();
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public function getStocks(){
        try {
                $pdo = connect_db();
                $statment = $pdo->prepare("SELECT * FROM stock");

                $statment->execute();
                $stocks = $statment->fetchAll(PDO::FETCH_CLASS, 'Stock');
                
                return $stocks;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public function update($request){
        $stock = self::getStock(strval($request['id']));

        if(!empty($stock)){
            try {
                $pdo = connect_db();
                $statment = $pdo->prepare("UPDATE stock SET total_product = :total_product, last_update = :last_update WHERE id_stock = :id");

                $statment->bindParam(':total_product', strval($request['total_product']));
                $statment->bindParam(':last_update', $request['last_update']);
                $statment->bindParam(':id', strval($stock->id_stock));
                $statment->execute();

                return true;
            } catch (PDOException $e) {
                var_dump($e->getMessage());
            }
        }
        return false;
    }

    public function getStock($id){
        try {
            $pdo = connect_db();
            $statment = $pdo->prepare("SELECT * FROM stock WHERE id_stock = :id");
            $statment->bindParam(":id", $id);
            $statment->execute();
            $stock = $statment->fetch(PDO::FETCH_OBJ);

            return $stock;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }
    
    public function getStockByProductId($product_id){
        try {
            $pdo = connect_db();
            $statment = $pdo->prepare("SELECT * FROM stock WHERE product_id = :id");
            $statment->bindParam(":id", $product_id);
            $statment->execute();
            $stock = $statment->fetch(PDO::FETCH_OBJ);

            self::setTotalProduct($stock->total_product);
            self::setLastUpdate($stock->last_update);
            self::setIdStock($stock->id_stock);
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    private function setIdStock($id_stock){
        $this->id_stock = $id_stock;

    }

    public function setTotalProduct($total_product){
        $this->total_product = $total_product;
    }
    
    public function setLastUpdate($last_update){
        $this->last_update = $last_update;
    }
    
    public function setProductId($product_id){
        $this->product_id = $product_id;
    }

    public function getStockId(){
        return $this->id_stock;
    }
    
    public function getTotalProduct(){
        return $this->total_product;
    }
    
    public function getLastUpdate(){
        return $this->last_update;
    }
    
    public function getProductId(){
        return $this->product_id;
    }

    public function product(){
        try {
            $pdo = connect_db();
            $statment = $pdo->prepare("SELECT * FROM stock INNER JOIN products ON stock.product_id = products.id_product WHERE id_stock = :id_stock");

            $statment->bindParam(':id_stock', $this->id_stock);
            $statment->execute();

            $product = $statment->fetch(PDO::FETCH_OBJ);
            
            return $product;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

}

?>