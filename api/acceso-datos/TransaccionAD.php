<?php
require_once __DIR__ . '/../../utilidades/ConexionBaseDatos.php';
require_once __DIR__ . '/../../entidades/Transaccion.php';

class TransaccionAD {
    private $db;

    function __construct(){
        $this->db = new ConexionBaseDatos();
    }

    function registrarTransaccion(Transaccion $transaccion) {
        $guid = $this->createGUID();
        $identificadorLimitado = $this->obtenerContador()['resultado'][0]['total'] + 1;
        $query =
            "INSERT INTO transaccion (id, cuenta_iban, pan, marca_tarjeta, monto, numero_secuencia, identificador_autorizacion, numero_referencia_seguimiento, tipo_transferencia, estado,fecha_creacion, fecha_modificacion)
                values(
                    '{$guid}',
                    '{$transaccion->cuentaIban}',
                    '{$transaccion->pan}',
                    '{$transaccion->marcaTarjeta}',
                    '{$transaccion->monto}',
                    '{$identificadorLimitado}',
                    '$identificadorLimitado',
                    '{$transaccion->numeroReferenciaSeguimiento}',
                    '{$transaccion->tipoTransferencia}',
                    '{$transaccion->estado}',
                    '".date('d-m-Y')."',
                    '".date('d-m-Y')."'
                )";
        $queryAutoIncrement = "Select id, numero_secuencia, identificador_autorizacion, numero_referencia_seguimiento from transaccion WHERE id='$guid'";
        $resultado = $this->db->metodoPost($query, $queryAutoIncrement);
        return $resultado;
    }

    public function actualizarTransaccion(Transaccion $transaccion) {
        $query = "UPDATE transaccion SET ";
        $updateFields = [];

        $updateFields[] = $transaccion->pan !== null ? "pan = '{$transaccion->pan}'" : null;
        $updateFields[] = $transaccion->marcaTarjeta !== null ? "marca_tarjeta = '{$transaccion->marcaTarjeta}'" : null;
        $updateFields[] = $transaccion->monto !== null ? "monto = '{$transaccion->monto}'" : null;
        $updateFields[] = $transaccion->numeroSecuencia !== null ? "numero_secuencia = '{$transaccion->numeroSecuencia}'" : null;
        $updateFields[] = $transaccion->identificadorAutorizacion !== null ? "identificador_autorizacion = '{$transaccion->identificadorAutorizacion}'" : null;
        $updateFields[] = $transaccion->numeroReferenciaSeguimiento !== null ? "numero_referencia_seguimiento = '{$transaccion->numeroReferenciaSeguimiento}'" : null;
        $updateFields[] = $transaccion->tipoTransferencia !== null ? "tipo_transferencia = '{$transaccion->tipoTransferencia}'" : null;
        $updateFields[] = $transaccion->estado !== null ? "estado = '{$transaccion->estado}'" : null;
        $updateFields[] = $transaccion->fechaModificacion = "fecha_modificacion = '".date('d-m-Y')."'" ;

        $updateFields = array_filter($updateFields);

        $query .= implode(", ", $updateFields);

        $query .= " WHERE id = '{$transaccion->id}'";
        $resultado= $this->db->metodoPut($query);
        return $resultado;
    }

    public function obtenerTransaccionPorId($id) {
        $query=
            "SELECT 
                id, pan, marca_tarjeta, monto, numero_secuencia, identificador_autorizacion, numero_referencia_seguimiento, tipo_transferencia, estado,fecha_creacion, fecha_modificacion 
            FROM transaccion WHERE id = '$id';";
        $resultado= $this->db->metodoGet($query);
        return $resultado;
    }

    public function obtenerTodasLasTransacciones() {
        $query=
            "SELECT 
                id, pan, marca_tarjeta, monto, numero_secuencia, identificador_autorizacion, numero_referencia_seguimiento, tipo_transferencia, estado,fecha_creacion, fecha_modificacion  
            FROM transaccion ";
        $resultado= $this->db->metodoGet($query);
        return $resultado;
    }

    public function obtenerTransaccionesAprobadas() {
        $query=
            "SELECT 
                id, pan, marca_tarjeta, monto, numero_secuencia, identificador_autorizacion, numero_referencia_seguimiento, tipo_transferencia, estado,fecha_creacion, fecha_modificacion  
            FROM transaccion WHERE estado = 'Aprobado' ";
        $resultado= $this->db->metodoGet($query);
        return $resultado;
    }

    public function liquidarTransaccion($id) {
        $query = "UPDATE transaccion SET estado = 'Liquidado' WHERE id = '$id' ";
        $resultado= $this->db->metodoPut($query);
        return $resultado;
    }

    function getGUID(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12);// "}"
            return $uuid;
        }
    }

    function createGUID() {

        // Create a token
        $token      = $_SERVER['HTTP_HOST'];
        $token     .= $_SERVER['REQUEST_URI'];
        $token     .= uniqid(rand(), true);

        // GUID is 128-bit hex
        $hash        = strtoupper(md5($token));

        // Create formatted GUID
        $guid        = '';

        // GUID format is XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX for readability
        $guid .= substr($hash,  0,  8) .
            '-' .
            substr($hash,  8,  4) .
            '-' .
            substr($hash, 12,  4) .
            '-' .
            substr($hash, 16,  4) .
            '-' .
            substr($hash, 20, 12);

        return $guid;
    }

    public function obtenerContador() {
        $query = "SELECT COUNT(*) AS total FROM transaccion";
        $resultado = $this->db->metodoGet($query);
        return $resultado;
    }
}
?>