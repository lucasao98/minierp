<?php

const URL_API_CEP = "viacep.com.br/ws/";

$response = [
    'message' => null,
    'status' => null
];

if(isset($_GET['postal_code'])){
    $postal_code = $_GET['postal_code'];

    getByApi($postal_code);
}

function getByApi($cep) {
    // Inicializar o cURL
    $ch = curl_init();

    // Configurar opções
    curl_setopt($ch, CURLOPT_URL, URL_API_CEP . $cep ."/json/"); // URL da requisição
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Retornar resposta como string

    // Executar e obter resposta
    $response = curl_exec($ch);

    
    // Verificar erros
    if(curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        http_response_code(400);
        header('Content-Type: application/json');
        $response['message'] = $error_msg;
        $response['status'] = 400;
        echo json_encode($response);
        return;
    }

    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // Fechar sessão
    curl_close($ch);
    
    $dados = json_decode($response, true);
    
    http_response_code(200);
    
    
    header('Content-Type: application/json');
    
    echo json_encode([
        'message' => 'Cep encontrado',
        'status' => 200,
        'data' => $dados
    ]);
}