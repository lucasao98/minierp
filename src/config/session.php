<?php 

session_start();
// session_unset();
initCart();

function inCart($product_id) {
    foreach ($_SESSION['cart'] as $productKey => $product) {
        if(strval($product['product_id']) === strval($product_id)){
            return true;
        }
    }
}

function getProductInCart($product_id) {
    foreach ($_SESSION['cart'] as $productKey => $product) {
        if(strval($product['product_id']) === strval($product_id)){
            return $product;
        }
    }
}

function initCart(){
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = [];
    }
}

function getProductsSelected() {
    return $_SESSION['cart'];
}

function add_cart($product) {
    // Verifica se todos os parâmetros necessários estão presentes
    if (!isset($product) && !isset($product->id_product) && !isset($product->product_name) && !isset($product->product_price) && !isset($product->product_variation) && !isset($product->product_quantity)) {
        return json_encode([
            'success' => false,
            'message' => 'Parametros incompletos!'
        ]);
    }

    $_SESSION['cart'][] = [
        'product_id' => $product->id_product,
        'product_name' => $product->product_name,
        'product_price' => (float) $product->product_price,
        'product_variation' => $product->product_variation,
        'product_quantity' => $product->product_quantity
    ];

    // Retorna resposta JSON de sucesso
    return json_encode([
        'success' => true,
        'message' => 'Produto adicionado ao carrinho!',
    ]);
}

function remove_cart($id_product) {
    if(isset($_SESSION['cart'])) {
        // $productKeyFound = array_search($id_product->id_product, array_column($_SESSION['cart'] , 'product_id'));
        $productKeyFound = searchProductInCart($_SESSION['cart'], $id_product);
        
        if(gettype($productKeyFound) == 'boolean'){
            // Retorna resposta JSON de sucesso
            return json_encode([
                'success' => false,
                'message' => 'Produto não encontrado no carrinho!',
            ]);
        }
        
        unset($_SESSION['cart'][$productKeyFound]);
        
        // Retorna resposta JSON de sucesso
        return json_encode([
            'success' => true,
            'message' => 'Produto removido do carrinho!',
        ]);
    }
}

function setDeliveryPrice() {
    $totalPurchaseValue = totalPriceProducts();

    if($totalPurchaseValue >= 52.00 && $totalPurchaseValue <= 166.59) {
        $_SESSION['delivery_price'] = 15.00;
        return 15.00;
    }else if($totalPurchaseValue > 200.00){
        $_SESSION['delivery_price'] = 0;
        return 0;
    }else{
        $_SESSION['delivery_price'] = 20.00;
        return 20;
    }    
}

function searchProductInCart($cart_list, $id_product) {
    foreach ($cart_list as $productKey => $product) {
        if($product['product_id'] === $id_product) {
            return $productKey;
        }
    }
}

function totalPriceProducts() {
    if(isset($_SESSION['cart'])){
        $total_products_price = 0;
        $products_quant = count($_SESSION['cart']);
        $products_selected = $_SESSION['cart'];

        foreach ($products_selected as $productKey => $product) {
            $total_products_price += ($product['product_price'] * $product['product_quantity'] );
        }
    }
    return $total_products_price;
}

function finalPrice() {
    $total_order = totalPriceProducts() + setDeliveryPrice();

    if(isset($_SESSION['coupon'])) {
        return $total_order -= ($total_order * $_SESSION['coupon']['coupon_discount']);
    }
    return $total_order;
}

function totalProductsSelected(){
    return count($_SESSION['cart']);
}

function initDeliveryPrice() {
    if(!isset($_SESSION['delivery_price'])){
        $_SESSION['delivery_price'] = 0;
    }
}

function setCoupon($coupon) {
    if(isset($_SESSION['coupon'])) {
        $_SESSION['coupon'] = $coupon;
    }
    
    $_SESSION['coupon'] = [
        'coupon_id' => $coupon->getCouponId(),
        'coupon_code' => $coupon->getCouponCode(),
        'coupon_discount' => $coupon->getDiscount(),
        'coupon_minimum_price' => $coupon->getMinimumPrice()
    ];
}