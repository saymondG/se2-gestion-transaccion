<?php
require_once __DIR__ . '/../../utilidades/ConexionBaseDatos.php';
require_once __DIR__ . '/../../entidades/CuentaBancaria.php';

class CuentaBancariaAD {
    private $db;

    function __construct(){
        $this->db = new ConexionBaseDatos();
    }

    function registrarCuentaBancaria(CuentaBancaria $cuentaBancaria) {
        $query =
            "INSERT INTO cuenta_bancaria (cuenta_iban)
                values(
                    '{$cuentaBancaria->cuentaIban}'
                )";
        $queryAutoIncrement = "Select cuenta_iban from cuenta_bancaria WHERE cuenta_iban = '$cuentaBancaria->cuentaIban'";
        $resultado = $this->db->metodoPost($query, $queryAutoIncrement);
        return $resultado;
    }
}
?>