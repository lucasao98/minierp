<?php

require '../config/session.php';

$response = [
    'message' => null,
    'status' => null
];

if($_GET['method'] === 'add') {
    if(!isset($_SESSION['cart'])) {
        $response['message'] = 'Carrinho não foi inicializado';
        $response['status'] = 400;

    }
    
    $request = file_get_contents('php://input');

    $product = json_decode($request);

    $response_cart = add_cart($product);

    $response['message'] = 'Sucesso';
    $response['status'] = 200;

    echo json_encode($response);
}else if($_GET['method'] === 'remove'){
    if(!isset($_SESSION['cart'])) {
        $response['message'] = 'Carrinho não foi inicializado';
        $response['status'] = 400;
    }

    $request = file_get_contents('php://input');

    $product_id = json_decode($request);

    $response_cart = remove_cart($product_id);

    $response['message'] = 'Sucesso';
    $response['status'] = 200;

    echo json_encode($response);
}