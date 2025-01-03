
<?php
class BD {
    public static $instancia = null;

    public static function crearInstancia() {
        if (!isset(self::$instancia)) {
            try {
                // Obtener la URL de la base de datos de Heroku
                $databaseUrl = getenv("DATABASE_URL");

                // Parsear la URL de la base de datos
                $parsedUrl = parse_url($databaseUrl);

                // Crear la instancia PDO para PostgreSQL usando los datos de la URL
                $opciones = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
                self::$instancia = new PDO(
                    "pgsql:host={$parsedUrl['host']};port={$parsedUrl['port']};dbname=" . ltrim($parsedUrl['path'], '/'),
                    $parsedUrl['user'],
                    $parsedUrl['pass'],
                    $opciones
                );

                //echo "Conectado..";  // Verificación de conexión
            } catch (PDOException $e) {
                echo "Error de conexión: " . $e->getMessage();
            }
        }
        return self::$instancia;
    }
}
?>

