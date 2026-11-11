<?php
// Exemplo de coordenadas (latitude e longitude de teste)
$latitude = "37.7759792";
$longitude = "-122.41823";
$access_token = "SEU_ACCESS_TOKEN_AQUI"; // O token obtido no passo anterior

$url = "https://test-api.uber.com/v1.2/products?latitude=" . $latitude . "&longitude=" . $longitude;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . $access_token,
    "Accept-Language: pt_BR",
    "Content-Type: application/json"
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code === 200) {
    $produtos = json_decode($response, true);
    
    echo "<h3>Produtos Disponíveis:</h3><pre>";
    print_r($produtos);
    echo "</pre>";
} else {
    echo "Erro na requisição da API. Código HTTP: " . $http_code . "<br>" . $response;
}
?>