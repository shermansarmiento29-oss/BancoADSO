<?php

namespace App\Controladores;

use App\Servicios\ServicioAutenticacion;

class ControladorLogin
{
    public function mostrarLogin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['cuenta_id'])) {
            header('Location: /index.php?ruta=panel');
            exit;
        }

        require_once __DIR__ . '/../../vistas/login.php';
    }

    public function procesarLogin(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $numeroCuenta = $_POST['numero_cuenta'] ?? '';
            $clave = $_POST['clave'] ?? '';

            $exito = ServicioAutenticacion::login($numeroCuenta, $clave);

            if ($exito) {
                header('Location: /index.php?ruta=panel');
                exit;
            } else {
                $error = "Número de cuenta o contraseña incorrectos.";
                require_once __DIR__ . '/../../vistas/login.php';
            }
        }
    }

    public function cerrarSesion(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: /index.php?ruta=login');
        exit;
    }
}?>