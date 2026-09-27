<?php
namespace App\Modelos;

final class Transferencia
{
    public function __construct(
        public readonly int $id,
        public readonly int $cuenta_origen_id,
        public readonly int $cuenta_destino_id,
        public readonly float $valor,
        public readonly string $fecha
    ) {
    }

    public static function desdeFila(array $fila): self
    {
        return new self(
            id: (int) $fila['id'],
            cuenta_origen_id: (int) $fila['cuenta_origen_id'],
            cuenta_destino_id: (int) $fila['cuenta_destino_id'],
            valor: (float) $fila['valor'],
            fecha: $fila['fecha']
        );
    }
}
?>