<?php

namespace App\Nucleo;

use PDO;
use PDOException;

class Conexion
{
    private static ?PDO $instancia = null;   // private: solo la propia clase la toca

    private function __construct() {}        // nadie puede hacer "new Conexion()" desde afuera

    public static function obtener(): PDO    // public: es la puerta de entrada
    {
        if (self::$instancia === null) {
            /* $host = 'localhost';
            $db   = 'db_banco_adso'; 
            $user = 'root';         
            $pass = '1234';             
            $charset = 'utf8mb4';

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";*/

            $config = require __DIR__ . '/../../basedatos.php';

            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                $config['host'],
                $config['db_banco_adso'],
                $config['utf8mb4']
            );

            
            $opciones = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instancia = new PDO(
                    $dsn, 
                    $config['usuario'], 
                    $config['clave'], 
                    $opciones
                );
            } catch (PDOException $e) {
                die("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }
        
        return self::$instancia;              // siempre devuelve la MISMA conexión
    }
}
?>