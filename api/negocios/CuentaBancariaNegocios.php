<?php
require_once __DIR__ . '/../acceso-datos/CuentaBancariaAD.php';
require_once __DIR__ . '/../../entidades/CuentaBancaria.php';
class CuentaBancariaNegocios
{

    private $cuentaBancariaAD;

    function __construct() {
        $this->cuentaBancariaAD = new CuentaBancariaAD();
    }

    function registrarCuentaBancaria(CuentaBancaria $cuentaBancaria) {
        return $this->cuentaBancariaAD->registrarCuentaBancaria($cuentaBancaria);
    }

}

?>