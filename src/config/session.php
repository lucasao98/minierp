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
    if (!isset($product) && !isset($product->id_product) && !isset($product->product_name) && !isset($product->product_price) && !isset($product->product_variation)) {
        return json_encode([
            'success' => false,
            'message' => 'Parametros incompletos!'
        ]);
    }

    $_SESSION['cart'][] = [
        'product_id' => $product->id_product,
        'product_name' => $product->product_name,
        'product_price' => (float) $product->product_price,
        'product_variation' => $product->product_variation
    ];

    // Retorna resposta JSON de sucesso
    return json_encode([
        'success' => true,
        'message' => 'Produto adicionado ao carrinho!',
    ]);
}

function remove_cart($id_product) {
    if(isset($_SESSION['cart'])) {
        $productKeyFound = array_search($id_product->id_product, array_column($_SESSION['cart'] , 'product_id'));
        
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
        return 15.00;
    }else if($totalPurchaseValue > 200.00){
        return 0;
    }else{
        return 20;
    }

}

function totalPriceProducts() {
    if(isset($_SESSION['cart'])){
        $total_products_price = 0;
        $products_quant = count($_SESSION['cart']);
        $products_selected = $_SESSION['cart'];

        foreach ($products_selected as $productKey => $product) {
            $total_products_price += $product['product_price'];
        }
    }
    return $total_products_price;
}

function finalPrice() {
    return totalPriceProducts() + setDeliveryPrice();
}

function totalProductsSelected(){
    return $products_quant = count($_SESSION['cart']);
}