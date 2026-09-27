<?php

namespace App\Repositorios;

use App\Nucleo\Conexion;
use PDO;

class RepositorioTransferencias
{
    // Registrar una nueva transferencia en la bsd
    public static function registrar(int $cuentaOrigenId, int $cuentaDestinoId, float $valor): bool
    {
        $pdo = Conexion::obtener();
        $sql = "INSERT INTO transferencias (cuenta_origen_id, cuenta_destino_id, valor, fecha) VALUES (:cuenta_origen_id, :cuenta_destino_id, :valor, NOW())";
        
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            'cuenta_origen_id'  => $cuentaOrigenId,
            'cuenta_destino_id' => $cuentaDestinoId,
            'valor'             => $valor
        ]);
    }

    // Obtener el historial de transferencias enviadas por una cuenta
    public static function obtenerEnviadasPorCuenta(int $cuentaId): array
    {
        $pdo = Conexion::obtener();
        $sql = "SELECT id, cuenta_destino_id, valor, fecha FROM transferencias WHERE cuenta_origen_id = :cuenta_id ORDER BY fecha DESC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['cuenta_id' => $cuentaId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}