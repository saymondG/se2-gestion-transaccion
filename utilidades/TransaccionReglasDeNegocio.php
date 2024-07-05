<?php
class TransaccionReglasDeNegocio
{
    function __construct() {
    }

    function validarPAN($data) {

        if(is_null($data)) {
            return ['status' => false, 'message' => 'El PAN es nula'];
        }
        if(empty($data)) {
            return ['status' => false, 'message' => 'El PAN esta vacio'];
        }

        if (!(strlen($data) == 16)) {
            return ['status' => false, 'message' => 'El Número de Tarjeta debe de tener 16 digitos'];
        }

        $digits = str_split($data);
        $digits = array_reverse($digits);

        $sum = 0;
        for ($i = 0; $i < count($digits); $i++) {
            $digit = (int)$digits[$i];

            if (!($i % 2 == 0)) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            $sum += $digit;
        }

        if (($sum % 10) == 0) {
            return ['status' => true];
        } else {
            return ['status' => false, 'message' => 'El Número de Tarjeta no es válido'];
        }
    }

    function validarMarcaTarjeta($data) {
        if(is_null($data)) {
            return ['status' => false, 'message' => 'La marca de la tarjeta es nula'];
        }
        if(empty($data)) {
            return ['status' => false, 'message' => 'La marca de la tarjeta esta vacia'];
        }

        if(!($data == 'VISA') && !($data == 'Mastercard') && !($data == 'American Express')) {
            return ['status' => false, 'message' => 'La marca de tarjeta debe ser VISA, Mastercard o American Express.'];
        }
        return ['status' => true];
    }

    function validarTipoTransferencia($data) {
        if(is_null($data)) {
            return ['status' => false, 'message' => 'El tipo de transferencia es nulo'];
        }
        if(empty($data)) {
            return ['status' => false, 'message' => 'El tipo de transferencia esta vacio'];
        }

        if(!($data == 'Debito') && !($data == 'Credito')) {
            return ['status' => false, 'message' => 'El tipo de transferencia debe ser Débito o Crédito.'];
        }
        return ['status' => true];
    }

    function validarEstado($data) {
        if(is_null($data)) {
            return ['status' => false, 'message' => 'El estado es nulo'];
        }
        if(empty($data)) {
            return ['status' => false, 'message' => 'El estado esta vacio'];
        }

        if(!($data == 'Aprobado') && !($data == 'Liquidado') && !($data == 'Declinado')) {
            return ['status' => false, 'message' => 'El estado puede ser Aprobado, Declinado o Liquidado.'];
        }
        return ['status' => true];
    }
}

?>