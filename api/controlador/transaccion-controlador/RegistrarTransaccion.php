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

$cuentaIban = isset($data['cuentaIban']) ? $data['cuentaIban'] : null;
$pan = isset($data['pan']) ? $data['pan'] : null;
$marcaTarjeta = isset($data['marcaTarjeta']) ? $data['marcaTarjeta'] : null;
$monto = isset($data['monto']) ? $data['monto'] : null;
$tipoTransferencia = isset($data['tipoTransferencia']) ? $data['tipoTransferencia'] : null;
$estado = isset($data['estado']) ? $data['estado'] : null;
$numeroReferencia = isset($data['numeroReferencia']) ? $data['numeroReferencia'] : null;

$transaccion = new Transaccion(null, $cuentaIban, $pan, $marcaTarjeta, $monto, null, null,
    $numeroReferencia, $tipoTransferencia, $estado, null, null);

$transaccionNegocios = new TransaccionNegocios();

$resultado = $transaccionNegocios->registrarTransaccion($transaccion);

header('Content-Type: application/json');
if ($resultado != "false") {
    header("HTTP/1.1 200 ok");
    echo json_encode($resultado);
} else {
    header("HTTP/1.1 500 Internal Server Error");
    echo $resultado;
}

exit();
?>