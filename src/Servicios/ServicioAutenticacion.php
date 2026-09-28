<?php

namespace App\Servicios;

use App\Repositorios\RepositorioCuentas;
use App\Repositorios\RepositorioUsuarios;

class ServicioAutenticacion
{
    public static function login(string $numeroCuenta, string $clave): bool
    {
        // Buscar la cuenta por número
        $cuenta = RepositorioCuentas::obtenerPorNumero($numeroCuenta);
        if (!$cuenta) {
            return false;
        }

        // buscamos el usuario asoaciado con esa cuenta 
        $usuario = RepositorioUsuarios::obtenerPorCuentaId($cuenta['id']);
        if (!$usuario) {
            return false;
        }

        // password_verify para verificar la contraseña hash 
        if (!password_verify($clave, $usuario['clave_hash'])) {
            return false;
        }

        // Iniciar sesión de forma segura guardando únicamente el ID de la cuenta 
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION['cuenta_id'] = $cuenta['id'];
        return true;
    }
}