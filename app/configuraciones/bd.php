<?php
class BD {
    public static $instancia = null;

    public static function crearInstancia() {
        if (!isset(self::$instancia)) {
            try {
                $host = "dpg-cts0a9i3esus73dktjjg-a.oregon-postgres.render.com";
                $port = 5432;
                $dbname = "prueba_gufs";
                $user = "root";
                $password = "uP4xmDnrs3dzxXJE35t3qPhvKL4lj7OT";

                $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

                $opciones = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

                self::$instancia = new PDO($dsn, $user, $password, $opciones);
            } catch (PDOException $e) {
                echo "Error de conexión: " . $e->getMessage();
            }
        }
        return self::$instancia;
    }
}

BD::crearInstancia();
?>
