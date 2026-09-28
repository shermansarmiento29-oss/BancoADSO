<?php

// Cargar el autoloader de Composer para PSR-4 (App\)
require_once __DIR__ . '/../vendor/autoload.php';

use App\Nucleo\Router;
use App\Controladores\ControladorLogin;
use App\Controladores\ControladorBanco;

// Iniciar sesión globalmente
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener la ruta solicitada por la URL (por defecto 'login')
$ruta = $_GET['ruta'] ?? 'login';

// Instanciar y configurar el Router
$router = new Router();

// Rutas de Autenticación
$router->registrar('login', ControladorLogin::class, 'mostrarLogin');
$router->registrar('login/procesar', ControladorLogin::class, 'procesarLogin');
$router->registrar('logout', ControladorLogin::class, 'cerrarSesion');

// Rutas del Banco (Protegidas por sesión)
$router->registrar('panel', ControladorBanco::class, 'mostrarPanel');
$router->registrar('retiro', ControladorBanco::class, 'mostrarRetiro');
$router->registrar('retiro/procesar', ControladorBanco::class, 'procesarRetiro');
$router->registrar('transferencia', ControladorBanco::class, 'mostrarTransferencia');
$router->registrar('transferencia/procesar', ControladorBanco::class, 'procesarTransferencia');
$router->registrar('historial/retiros', ControladorBanco::class, 'mostrarHistorialRetiros');
$router->registrar('historial/transferencias', ControladorBanco::class, 'mostrarHistorialTransferencias');

// Despachar la ruta actual
$router->despachar($ruta);?>