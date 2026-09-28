<?php

namespace App\Controladores;

use App\Repositorios\RepositorioCuentas;
use App\Repositorios\RepositorioRetiros;
use App\Repositorios\RepositorioTransferencias;
use App\Servicios\ServicioTransacciones;

class ControladorBanco
{
    private function verificarSesion(): int
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // si nohay seccion activa nos manda al login 
        if (!isset($_SESSION['cuenta_id'])) {
            header('Location: /index.php?ruta=login');
            exit;
        }

        // Leer el ID exclusivamente de la sesión (Aislamiento de cuentas)
        return (int) $_SESSION['cuenta_id'];
    }

    public function mostrarPanel(): void
    {
        $cuentaId = $this->verificarSesion();

        // Consultar saldo en vivo desde la base de datos 
        $cuenta = RepositorioCuentas::obtenerPorId($cuentaId);

        require_once __DIR__ . '/../../vistas/panel.php';
    }

    public function mostrarRetiro(): void
    {
        $this->verificarSesion();
        require_once __DIR__ . '/../../vistas/retiro.php';
    }

    public function procesarRetiro(): void
    {
        $cuentaId = $this->verificarSesion();
        $valor = (float) ($_POST['valor'] ?? 0);
        $clave = $_POST['clave'] ?? '';

        $resultado = ServicioTransacciones::retirar($cuentaId, $valor, $clave);
        $mensaje = $resultado['mensaje'];
        $exito = $resultado['exito'];

        require_once __DIR__ . '/../../vistas/retiro.php';
    }

    public function mostrarTransferencia(): void
    {
        $this->verificarSesion();
        require_once __DIR__ . '/../../vistas/transferencia.php';
    }

    public function procesarTransferencia(): void
    {
        $cuentaId = $this->verificarSesion();
        $cuentaDestino = $_POST['cuenta_destino'] ?? '';
        $valor = (float) ($_POST['valor'] ?? 0);
        $clave = $_POST['clave'] ?? '';

        $resultado = ServicioTransacciones::transferir($cuentaId, $cuentaDestino, $valor, $clave);
        $mensaje = $resultado['mensaje'];
        $exito = $resultado['exito'];

        require_once __DIR__ . '/../../vistas/transferencia.php';
    }

    public function mostrarHistorialRetiros(): void
    {
        $cuentaId = $this->verificarSesion();
        $retiros = RepositorioRetiros::obtenerPorCuentaId($cuentaId);

        require_once __DIR__ . '/../../vistas/historial_retiros.php';
    }

    public function mostrarHistorialTransferencias(): void
    {
        $cuentaId = $this->verificarSesion();
        $transferencias = RepositorioTransferencias::obtenerEnviadasPorCuentaId($cuentaId);

        require_once __DIR__ . '/../../vistas/historial_transferencias.php';
    }
}?>