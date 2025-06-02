<?php

require_once("../../../autoload.php");

$controller = new ManagerTaskController();

$function = '';

if (isset($_POST['function']) && strlen($_POST['function']) > 0) {
  $function = $_POST['function'];
} else {
  echo json_encode(array("response" => false, "data" => "Falha interna, consulte o suporte."));
  return;
}


switch ($function) {
  case "getAllPagCartas":
    $response = $controller->getAllTasks($_POST);
    echo json_encode($response, JSON_INVALID_UTF8_IGNORE);
    break;
}
