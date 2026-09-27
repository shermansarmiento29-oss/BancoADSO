<?php

namespace App\Repositorios;

use App\Nucleo\Conexion;
use App\Modelos\Clientes;
use PDO;

class RepositorioClientes
{
    // 
    public static function buscarPorId(int $id): ?Clientes
    {
        $pdo = Conexion::obtener();
        $sql = "SELECT id, nombre FROM clientes WHERE id = :id LIMIT 1";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$fila) {
            return null; 
        }

        // reurna una instancia del modelo Clientes usando sus datos
        return Clientes::desdeFila($fila);
    }
}