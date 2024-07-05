<?php
require_once __DIR__ . '/../acceso-datos/TransaccionAD.php';
require_once __DIR__ . '/../../entidades/Transaccion.php';
require_once __DIR__ . '/../../utilidades/TransaccionReglasDeNegocio.php';

class TransaccionNegocios
{

    private $transaccionAD;
    private $transaccionRN;

    function __construct() {
        $this->transaccionAD = new TransaccionAD();
        $this->transaccionRN = new TransaccionReglasDeNegocio();
    }

    function registrarTransaccion(Transaccion $transaccion) {
        $validarPAN = $this->transaccionRN->validarPAN($transaccion->pan);
        if(!$validarPAN['status']) {
            return $validarPAN['message'];
        }

        $validarMarcaTarjeta = $this->transaccionRN->validarMarcaTarjeta($transaccion->marcaTarjeta);
        if(!$validarMarcaTarjeta['status']) {
            return $validarMarcaTarjeta['message'];
        }

        $validarTipoTransferencia = $this->transaccionRN->validarTipoTransferencia($transaccion->tipoTransferencia);
        if(!$validarTipoTransferencia['status']) {
            return $validarTipoTransferencia['message'];
        }

        $validarEstado = $this->transaccionRN->validarEstado($transaccion->estado);
        if(!$validarEstado['status']) {
            return $validarEstado['message'];
        }

        return $this->transaccionAD->registrarTransaccion($transaccion);
    }

    public function actualizarTransaccion(Transaccion $transaccion) {
        return $this->transaccionAD->actualizarTransaccion($transaccion);
    }

    public function obtenerTransaccionPorId($id) {
        return $this->transaccionAD->obtenerTransaccionPorId($id);
    }

    public function obtenerTodasLasTransacciones() {
        return $this->transaccionAD->obtenerTodasLasTransacciones();
    }

    public function obtenerTransaccionesAprobadas() {
        return $this->transaccionAD->obtenerTransaccionesAprobadas();
    }

}

?>