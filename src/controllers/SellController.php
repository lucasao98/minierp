<?php

require_once "../config/connection.php";
require "../models/Stock.php";
require "../models/Order.php";
require "../models/Coupon.php";
require "../config/session.php";
require "../models/OrderProduct.php";

$response = [
    'message' => null,
    'status' => null
];



if($_GET['method'] == 'add') {
    if(!isset($_SESSION['cart'])){
        $response['message'] = 'Carrinho sem produtos';
        $response['status'] = 400;
        
        echo json_encode($response);
    }else{
        if(isset($_SESSION['coupon']) && isset($_SESSION['delivery_price'])) {
            $order = new Order();
            $order->setDeliveryPrice($_SESSION['delivery_price']);
            $order->setTotalOrderPrice(number_format(finalPrice(),2));
            $order->setDeliveryAddress("RUA IPANEMA 83 apto");
            $order->setCreatedAt(getDatetime());
            $id_order = $order->store();

            $order_products = $_SESSION['cart'];
                
            foreach ($order_products as $productKey => $product) {
                $stock = new Stock();
                $stock->getStockByProductId($product['product_id']);
                if($stock->checkProductInStock()) {
                    $stock->sendProduct($product['product_quantity']);
                    
                    $order_product = new OrderProduct();
                    $order_product->setProductQuantity($product['product_quantity']);
                    $order_product->setTotalPriceOrderProduct($product['product_quantity'] * $product['product_price']);
                    $order_product->setProductId($product['product_id']);
                    $order_product->setOrderId($id_order);
                    $order_product->setCreatedAt(getDatetime());

                    $order_product->store();
                }
            }

            $response['message'] = "Compra finalizada";
            $response['status'] = 200;
            http_response_code(200);
            
            echo json_encode($response);
        }
    }
}else if ($_GET['method'] == 'coupon'){
    $request = file_get_contents('php://input');
    $coupon_code = json_decode($request, true);

    if(empty($coupon_code)){
        $response['message'] = "Cupom Inválido";
        $response['status'] = 404;

        echo $json_encode($response);
    }else{
        $coupon = new Coupon();
        $coupon->getCouponByCode($coupon_code);

        if(empty($coupon->getCouponId())){
            $response['message'] = "Erro no Cupom";
            $response['status'] = 400;

            echo json_encode($response);
        }else{
            $response['message'] = "Cupom encontrado com sucesso";
            $response['status'] = 200;
            
            setCoupon($coupon);
            
            $response['coupon'] = [
                'code' => $coupon->getCouponCode(),
                'discount' => $coupon->getDiscount(),
                'minimum_price' => $coupon->getMinimumPrice()
            ];
            
            echo json_encode($response);
        }
    }
}