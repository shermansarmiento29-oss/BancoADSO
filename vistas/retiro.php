<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Banco ADSO - Retirar Dinero</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 300px; }
        h2 { text-align: center; color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #666; }
        input { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 10px; background: #28a745; border: none; color: white; border-radius: 4px; font-weight: bold; cursor: pointer; }
        button:hover { background: #218838; }
        .back { display: block; text-align: center; margin-top: 15px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Realizar Retiro</h2>
        <form action="index.php?accion=procesar-retiro" method="POST">
            <div class="form-group">
                <label for="valor">Monto a retirar:</label>
                <input type="number" step="0.01" id="valor" name="valor" required>
            </div>
            <button type="submit">Confirmar Retiro</button>
        </form>
        <a href="index.php?accion=dashboard" class="back">Volver al panel</a>
    </div>
</body>
</html>