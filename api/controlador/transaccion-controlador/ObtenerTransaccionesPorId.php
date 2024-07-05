<?php
require_once __DIR__ . '/../../negocios/TransaccionNegocios.php';
require_once __DIR__ . '/../../../entidades/Transaccion.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS'); // Métodos permitidos
header('Access-Control-Allow-Headers: Content-Type, Authorization');


$putData = file_get_contents("php://input");
$data = json_decode($putData, true);

if (!$data) {
    echo json_encode(["error" => "JSON invalido"]);
    header("HTTP/1.1 400 Bad ");
    exit();
}

$id = isset($data['id']) ? $data['id'] : null;

$transaccionNegocios = new TransaccionNegocios();

$resultado = $transaccionNegocios->obtenerTransaccionPorId($id);

if ($resultado != "false") {
    echo json_encode($resultado);
    header("HTTP/1.1 200 ok");
} else {
    echo $resultado;
    header("HTTP/1.1 500 Internal Server Error");
}

exit();
?>