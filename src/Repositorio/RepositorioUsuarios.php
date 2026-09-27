<?php

namespace App\Repositorios;

use App\Nucleo\Conexion;
use App\Modelos\Usuario;
use PDO;

class RepositorioUsuarios
{
    // Busca el usuario y su clave_hash haciendo un JOIN con cuentas usando el número de cuenta 
    public static function buscarPorNumeroCuenta(string $numeroCuenta): ?array
    {
        $pdo = Conexion::obtener();
        $sql = "SELECT u.id, u.cuenta_id, u.clave_hash, c.numero_cuenta 
                FROM usuarios u 
                JOIN cuentas c ON u.cuenta_id = c.id 
                WHERE c.numero_cuenta = :numero_cuenta 
                LIMIT 1";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['numero_cuenta' => $numeroCuenta]);
        
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$fila) {
            return null; 
        }

        return $fila;
    }
}