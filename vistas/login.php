<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Banco ADSO - Iniciar Sesión</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 300px; }
        h2 { text-align: center; color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #666; }
        input { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 10px; background: #007bff; border: none; color: white; border-radius: 4px; font-weight: bold; cursor: pointer; }
        button:hover { background: #0056b3; }
        .error { color: red; font-size: 0.9em; text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Banco ADSO</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form action="index.php?accion=procesar-login" method="POST">
            <div class="form-group">
                <label for="numero_cuenta">Número de Cuenta:</label>
                <input type="text" id="numero_cuenta" name="numero_cuenta" required>
            </div>
            <div class="form-group">
                <label for="clave">Contraseña:</label>
                <input type="password" id="clave" name="clave" required>
            </div>
            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>