<?php
class CuentaBancaria {
    public $cuentaIban;
    public $usuarioCedula;
    public $tipoCuenta;
    public $montoCuenta;
    public $fechaCreacion;
    public $fechaModificacion;

     function __construct($cuentaIban = null, $usuarioCedula = null, $tipoCuenta = null, $montoCuenta = null) {
        $this->cuentaIban = $cuentaIban;
        $this->usuarioCedula = $usuarioCedula;
        $this->tipoCuenta = $tipoCuenta;
        $this->montoCuenta = $montoCuenta;
        $this->fechaCreacion = date('Y-m-d');;
        $this->fechaModificacion = date('Y-m-d');;
    }
}
