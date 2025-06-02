<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require_once('./vendor/autoload.php');
require_once './database/Connection.class.php';
require_once './controller/TaskController.class.php';
require_once './auth/Authentication.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$controller = new TaskController();

if ($method === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($uri[0] === 'tasks') {
    $auth = new Authentication();
    if (!$auth->checkJWT()) {
        http_response_code(401);
        echo json_encode(['error' => 'Não autorizado']);
        exit;
    }

    $id = $uri[1] ?? null;
    $data = json_decode(file_get_contents("php://input"), true);

    switch ($method) {
        case 'GET':
            echo json_encode($id ? $controller->get($id) : $controller->getAll());
            break;
        case 'POST':
            echo json_encode($controller->create($data));
            break;
        case 'PUT':
            if (!$id) die(json_encode(['success' => false, 'error' => 'ID não informado']));
            echo json_encode($controller->update($id, $data));
            break;
        case 'DELETE':
            if (!$id) die(json_encode(['success' => false, 'error' => 'ID não informado']));
            echo json_encode($controller->delete($id));
            break;
        default:
            http_response_code(405);
            echo json_encode(['error' => 'Método não permitido']);
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Rota não encontrada']);
}
