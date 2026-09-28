<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Banco ADSO - Panel Principal</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { color: #333; }
        .saldo-box { background: #e9ecef; padding: 20px; border-radius: 6px; text-align: center; margin: 20px 0; }
        .saldo-box h3 { margin: 0; color: #555; }
        .saldo-box p { font-size: 2em; color: #28a745; margin: 10px 0 0 0; }
        .acciones { display: flex; gap: 10px; justify-content: space-between; }
        .acciones a { flex: 1; text-align: center; padding: 10px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; }
        .acciones a.danger { background: #dc3545; }
        .acciones a:hover { opacity: 0.9; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Bienvenido, <?= htmlspecialchars($nombreCliente ?? 'Cliente') ?></h2>
        <p>Cuenta N°: <strong><?= htmlspecialchars($numeroCuenta ?? '') ?></strong></p>
        
        <div class="saldo-box">
            <h3>Saldo Disponible</h3>
            <p>$<?= number_format($saldoActual ?? 0, 2, ',', '.') ?></p>
        </div>

        <div class="acciones">
            <a href="index.php?accion=vista-retiro">Retirar Dinero</a>
            <a href="index.php?accion=vista-transferencia">Transferir</a>
            <a href="index.php?accion=logout" class="danger">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>