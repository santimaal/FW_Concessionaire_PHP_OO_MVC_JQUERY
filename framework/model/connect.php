
<?php
class connect
{
    public static function con()
    {
        $databaseHost = 'localhost';
        $databaseName = 'concessionaire';
        $databaseUsername = 'root';
        $databasePassword = 'not found';
        $conexion = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);
        return $conexion;
    }
    public static function close($conexion)
    {
        mysqli_close($conexion);
    }
}

?>