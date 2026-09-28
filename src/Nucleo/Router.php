<?php

namespace App\Nucleo;

class Router
{
    private array $rutas = [];

    public function registrar(string $ruta, string $controlador, string $metodo): void
    {
        $this->rutas[$ruta] = [
            'controlador' => $controlador,
            'metodo' => $metodo
        ];
    }

    public function despachar(string $url): void
    {
        // Limpiar la URL para obtener solo la acción (ej. ?ruta=panel -> panel)
        $url = trim($url, '/');
        
        if (array_key_exists($url, $this->rutas)) {
            $info = $this->rutas[$url];
            $nombreControlador = $info['controlador'];
            $metodo = $info['metodo'];

            if (class_exists($nombreControlador)) {
                $instancia = new $nombreControlador();
                if (method_exists($instancia, $metodo)) {
                    $instancia->$metodo();
                    return;
                }
            }
        }

        // Si la ruta no existe, redirigir al login
        header('Location: /index.php?ruta=login');
        exit;
    }
}?>