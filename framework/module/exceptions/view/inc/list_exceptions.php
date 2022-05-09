<?php
$sql = "SELECT * FROM exceptions";

$conexion = connect::con();
$res = mysqli_query($conexion, $sql);

if ($conexion->connect_error) {

    echo "Lo sentimos, este sitio web está experimentando problemas.<br>";
    echo "Error: Fallo al conectarse a MySQL debido a: <br>";
    echo "Error Nro: " . $conexion->connect_errno . "<br>";
    echo "Error: " . $conexion->connect_error . "<br>";

    exit;
}


if (!$resultado = $conexion->query($sql)) {
    echo "Lo sentimos, no se pudo realizar la consulta.";
    exit;
}

echo "<table width='200' border='1' align=center><tr><th>Error</th><th>Fecha</th></tr>";
while ($array_registro = $resultado->fetch_assoc()) {
    echo "<br>";
    echo "<tr><td>".$array_registro['error']."</td><td>".$array_registro['fecha']."</td></tr>";
}
echo "</table>";

connect::close($conexion);
