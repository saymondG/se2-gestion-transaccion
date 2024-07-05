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
$pan = isset($data['pan']) ? $data['pan'] : null;
$marcaTarjeta = isset($data['marcaTarjeta']) ? $data['marcaTarjeta'] : null;
$monto = isset($data['monto']) ? $data['monto'] : null;
$numeroSecuencia = isset($data['numeroSecuencia']) ? $data['numeroSecuencia'] : null;
$identificadorAutorizacion = isset($data['identificadorAutorizacion']) ? $data['identificadorAutorizacion'] : null;
$numeroReferenciaSeguimiento = isset($data['numeroReferenciaSeguimiento']) ? $data['numeroReferenciaSeguimiento'] : null;
$tipoTransferencia = isset($data['tipoTransferencia']) ? $data['tipoTransferencia'] : null;
$estado = isset($data['estado']) ? $data['estado'] : null;
$fechaCreacion = isset($data['fechaCreacion']) ? $data['fechaCreacion'] : null;
$fechaModificacion = isset($data['fechaModificacion']) ? $data['fechaModificacion'] : null;

$transaccion = new Transaccion($id, $pan, $marcaTarjeta, $monto, $numeroSecuencia, $identificadorAutorizacion,
    $numeroReferenciaSeguimiento, $tipoTransferencia, $estado, $fechaCreacion, $fechaModificacion);

$transaccionNegocios = new TransaccionNegocios();

$resultado = $transaccionNegocios->actualizarTransaccion($transaccion);

if ($resultado != "false") {
    echo json_encode($resultado);
    header("HTTP/1.1 200 ok");
} else {
    echo $resultado;
    header("HTTP/1.1 500 Internal Server Error");
}

exit();
?>