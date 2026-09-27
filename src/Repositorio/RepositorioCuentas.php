<?php

namespace App\Repositorios;

use App\Nucleo\Conexion;
use App\Modelos\Cuentas;
use PDO;

class RepositorioCuentas
{
    
    public static function buscarPorId(int $id): ?array
    {
        $pdo = Conexion::obtener();
        $sql = "SELECT id, numero_cuenta, saldo, cliente_id FROM cuentas WHERE id = :id LIMIT 1";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        return $fila ? $fila : null;
    }

    // útil para transferencias o validaciones (creo que me servira para las dos cosas )
    public static function buscarPorNumero(string $numeroCuenta): ?array
    {
        $pdo = Conexion::obtener();
        $sql = "SELECT id, numero_cuenta, saldo, cliente_id FROM cuentas WHERE numero_cuenta = :numero_cuenta LIMIT 1";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['numero_cuenta' => $numeroCuenta]);
        
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        return $fila ? $fila : null;
    }


    public static function obtenerSaldo(int $id): ?float
    {
        $pdo = Conexion::obtener();
        $sql = "SELECT saldo FROM cuentas WHERE id = :id LIMIT 1";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        return $fila ? (float)$fila['saldo'] : null;
    }

    
    public static function actualizarSaldo(int $id, float $nuevoSaldo): bool
    {
        $pdo = Conexion::obtener();
        $sql = "UPDATE cuentas SET saldo = :saldo WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            'saldo' => $nuevoSaldo,
            'id' => $id
        ]);
    }
}