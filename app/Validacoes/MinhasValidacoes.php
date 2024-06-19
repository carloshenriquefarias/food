<?php

namespace App\Validacoes;

class MinhasValidacoes {

    const CPF_INVALIDOS = [
        '00000000000', '11111111111', '22222222222', '33333333333',
        '44444444444', '55555555555', '66666666666', '77777777777',
        '88888888888', '99999999999'
    ];

    public function validaCpf(string $cpf, string &$error = null): bool {
        $cpf = str_pad(preg_replace('/[^0-9]/', '', $cpf), 11, '0', STR_PAD_LEFT);

        if (strlen($cpf) != 11 || in_array($cpf, self::CPF_INVALIDOS)) {
            $error = 'Por favor digite um CPF válido';
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                $error = 'Por favor digite um CPF válido';
                return false;
            }
        }

        return true;
    }
}
