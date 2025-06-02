<?php
require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$username = $input['username'] ?? '';
$password = $input['password'] ?? '';

$validUser = 'tecsa';
$validPass = 'tecsa';

if ($username === $validUser && $password === $validPass) {
    $key = 'KEYTECSA';
    $payload = [
        'iss' => 'http://localhost',
        'aud' => 'http://localhost',
        'iat' => time(),
        'exp' => time() + 3600,
        'user_id' => 1,
        'username' => $username
    ];
    $jwt = JWT::encode($payload, $key, 'HS256');
    echo json_encode(['token' => $jwt]);
} else {
    http_response_code(401);
    echo json_encode(['error' => 'Usuário ou senha inválidos']);
}
