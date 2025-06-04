<?php

require "../config/connection.php";
require "../models/Stock.php";
require "../models/Order.php";

$response = [
    'message' => null,
    'status' => null
];



if($_GET['method'] == 'add') {
    if(empty($_POST['cart'])){
        $response['message'] = 'Carrinho sem produtos';
        $response['status'] = 400;
        
        header('Location: http://localhost:8001/cart.php');
        return;
    }else{
         $order_products = json_decode($_POST['cart'], true);
    
        foreach ($order_products as $productKey => $product) {
            $stock = new Stock();
            $order = new Order();
            $stock->getStockByProductId($product['product_id']);
            if($stock->checkProductInStock()) {
                $stock->sendProduct();

                $order->setProductQuantity(1);
                $order->setTotalOrderPrice($product['product_price']);
                $order->setProductId($product['product_id']);
                $order->setCreatedAt(date("Y-m-d H:i:s"));
                $order->store();
            }
        }

        $response['message'] = "Compra finalizada";
        $response['status'] = 200;
        
        session_unset();
        header('Location: http://localhost:8001/');
        return;
    }
}