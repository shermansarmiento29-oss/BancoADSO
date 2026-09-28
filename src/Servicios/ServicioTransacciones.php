<?php

namespace App\Servicios;

use App\Nucleo\Conexion;
use App\Repositorios\RepositorioCuentas;
use App\Repositorios\RepositorioUsuarios;
use App\Repositorios\RepositorioRetiros;
use App\Repositorios\RepositorioTransferencias;
use Exception;

class ServicioTransacciones
{
    // Lógica para realizar un retiro (RF4)
    public static function retirar(int $cuentaId, float $valor, string $clave): array
    {
        
        $usuario = RepositorioUsuarios::obtenerPorCuentaId($cuentaId);
        if (!$usuario || !password_verify($clave, $usuario['clave_hash'])) {
            return ['exito' => false, 'mensaje' => 'Contraseña reconfirmada incorrecta.'];
        }

        
        if ($valor <= 0) {
            return ['exito' => false, 'mensaje' => 'El valor a retirar debe ser mayor a cero.'];
        }

        // Validar saldo suficiente [el saldo de la base de datos]
        $cuenta = RepositorioCuentas::obtenerPorId($cuentaId);
        if ($cuenta['saldo'] < $valor) {
            return ['exito' => false, 'mensaje' => 'Saldo insuficiente para realizar el retiro.'];
        }

        // operación de retiro
        $nuevoSaldo = $cuenta['saldo'] - $valor;
        $pdo = Conexion::obtener();

        try {
            $pdo->beginTransaction();

            RepositorioCuentas::actualizarSaldo($cuentaId, $nuevoSaldo);
            RepositorioRetiros::registrar($cuentaId, $valor);

            $pdo->commit();
            return ['exito' => true, 'mensaje' => 'Retiro realizado con éxito.'];
        } catch (Exception $e) {
            $pdo->rollBack();
            return ['exito' => false, 'mensaje' => 'Error interno en la base de datos durante el retiro.'];
        }
    }

    //para realizar una transferencia atómica
    public static function transferir(int $cuentaOrigenId, string $numeroCuentaDestino, float $valor, string $clave): array
    {
        //  Reconfirmar contraseña de la cuenta origen
        $usuario = RepositorioUsuarios::obtenerPorCuentaId($cuentaOrigenId);
        if (!$usuario || !password_verify($clave, $usuario['clave_hash'])) {
            return ['exito' => false, 'mensaje' => 'Contraseña reconfirmada incorrecta.'];
        }

        // Validar que la cuenta destino exista
        $cuentaDestino = RepositorioCuentas::obtenerPorNumero($numeroCuentaDestino);
        if (!$cuentaDestino) {
            return ['exito' => false, 'mensaje' => 'La cuenta destino ingresada no existe.'];
        }

        //  Validar valor numérico y mayor a 0
        if ($valor <= 0) {
            return ['exito' => false, 'mensaje' => 'El valor a transferir debe ser mayor a cero.'];
        }

        //  Validar saldo suficiente en origen
        $cuentaOrigen = RepositorioCuentas::obtenerPorId($cuentaOrigenId);
        if ($cuentaOrigen['saldo'] < $valor) {
            return ['exito' => false, 'mensaje' => 'Saldo insuficiente para cubrir la transferencia.'];
        }

        // Validar que la cuenta destino sea diferente a la origen
        if ($cuentaOrigenId === $cuentaDestino['id']) {
            return ['exito' => false, 'mensaje' => 'No puedes realizar una transferencia a tu propia cuenta.'];
        }

        // 
        $pdo = Conexion::obtener();

        try {
            $pdo->beginTransaction();

            $nuevoSaldoOrigen = $cuentaOrigen['saldo'] - $valor;
            $nuevoSaldoDestino = $cuentaDestino['saldo'] + $valor;

            // Descontar origen, abonar destino y registrar transferencia
            RepositorioCuentas::actualizarSaldo($cuentaOrigenId, $nuevoSaldoOrigen);
            RepositorioCuentas::actualizarSaldo($cuentaDestino['id'], $nuevoSaldoDestino);
            RepositorioTransferencias::registrar($cuentaOrigenId, $cuentaDestino['id'], $valor);

            $pdo->commit();
            return ['exito' => true, 'mensaje' => 'Transferencia realizada con éxito.'];
        } catch (Exception $e) {
            $pdo->rollBack(); // Validacion por si algo falla en el camino de la transferencia 
            return ['exito' => false, 'mensaje' => 'Error en la transacción. La operación ha sido revertida.'];
        }
    }
}