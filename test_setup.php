<?php
// Script de Diagnóstico para CD Riohacha Web App
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Diagnóstico del Sistema</h1>";

// 1. Verificar Versión de PHP
echo "<h2>1. Entorno PHP</h2>";
echo "Versión de PHP: " . phpversion() . "<br>";
echo "Ruta del script: " . __FILE__ . "<br>";
echo "Directorio actual: " . __DIR__ . "<br>";

// 2. Verificar Sesiones
echo "<h2>2. Sesiones</h2>";
if (session_start()) {
    echo "✅ Sesiones iniciadas correctamente.<br>";
    $_SESSION['test'] = 'Funciona';
    echo "ID de Sesión: " . session_id() . "<br>";
    echo "Ruta de guardado de sesiones: " . session_save_path() . "<br>";
    if (is_writable(session_save_path())) {
        echo "✅ El directorio de sesiones es escribible.<br>";
    } else {
        echo "⚠️ El directorio de sesiones NO es escribible (o no se puede determinar).<br>";
    }
} else {
    echo "❌ Error al iniciar sesiones.<br>";
}

// 3. Verificar Configuración y Base de Datos
echo "<h2>3. Base de Datos</h2>";
$configFile = 'config/db.php';
if (file_exists($configFile)) {
    echo "✅ Archivo config/db.php encontrado.<br>";
    require_once $configFile;
    
    echo "Intentando conectar a BD: <strong>" . DB_NAME . "</strong> en <strong>" . DB_HOST . "</strong> con usuario <strong>" . DB_USER . "</strong>...<br>";
    
    try {
        if (isset($pdo)) {
            echo "✅ Conexión establecida (variable \$pdo existe).<br>";
            
            // Verificar Tabla Usuarios
            $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
            if ($stmt->rowCount() > 0) {
                echo "✅ Tabla 'users' existe.<br>";
                
                // Verificar Usuario Admin
                $stmt = $pdo->query("SELECT * FROM users WHERE role = 'admin'");
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($admin) {
                    echo "✅ Usuario Admin encontrado: " . $admin['email'] . "<br>";
                    echo "Hash de contraseña: " . substr($admin['password_hash'], 0, 10) . "...<br>";
                } else {
                    echo "❌ No se encontró ningún usuario con rol 'admin'.<br>";
                }
            } else {
                echo "❌ Tabla 'users' NO existe. Ejecute el script SQL.<br>";
            }
        } else {
            echo "❌ Variable \$pdo no definida después de incluir config.<br>";
        }
    } catch (PDOException $e) {
        echo "❌ Error de Conexión: " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ Archivo config/db.php NO encontrado.<br>";
}

// 4. Verificar Rutas
echo "<h2>4. Rutas y Servidor</h2>";
echo "SERVER_NAME: " . $_SERVER['SERVER_NAME'] . "<br>";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "<br>";
$basePath = str_replace('/test_setup.php', '', $_SERVER['SCRIPT_NAME']);
echo "Base Path calculado: " . $basePath . "<br>";

echo "<h2>5. Pasos Siguientes</h2>";
echo "<ul>";
echo "<li>Si hay errores de base de datos, revise config/db.php.</li>";
echo "<li>Si la tabla users no existe, importe sql/schema.sql en phpMyAdmin.</li>";
echo "<li>Si el login falla, asegúrese de usar <strong>admin@cdriohacha.com</strong> y contraseña <strong>password</strong>.</li>";
echo "</ul>";
?>
