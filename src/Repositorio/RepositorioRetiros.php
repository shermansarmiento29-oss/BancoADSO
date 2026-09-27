<?php

namespace App\Repositorios;

use App\Nucleo\Conexion;
use PDO;

class RepositorioRetiros
{
    // Registra el nuevo retiro en la base de datos 
    public static function registrar(int $cuentaId, float $valor): bool
    {
        $pdo = Conexion::obtener();
        $sql = "INSERT INTO retiros (cuenta_id, valor, fecha) VALUES (:cuenta_id, :valor, NOW())";
        
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            'cuenta_id' => $cuentaId,
            'valor'     => $valor
        ]);
    }

    // obtenemos todos los retiros para el historial, de una cuenta especifica 
    public static function obtenerPorCuenta(int $cuentaId): array
    {
        $pdo = Conexion::obtener();
        $sql = "SELECT id, valor, fecha FROM retiros WHERE cuenta_id = :cuenta_id ORDER BY fecha DESC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['cuenta_id' => $cuentaId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}