<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/concessionaire/framework/';
include($path . "model/connect.php");

class DAOCars
{
	function insert_cars($datos)
	{

		$modelo = $datos['modelo'];
		$marca = $datos['marca'];
		$matricula = $datos['matricula'];
		$km = $datos['km'];
		$color = $datos['color'];
		$tipo = $datos['tipo'];
		$puertas = $datos['puertas'];
		$cv = $datos['cv'];
		$fecha = $datos['fecha'];

		$sql = " INSERT INTO cars (modelo, marca, matricula, km, color, tipo, puertas, cv, fecha_matr)"
			. " VALUES ('$modelo', '$marca', '$matricula', '$km', '$color', '$tipo', '$puertas', '$cv', '$fecha')";

		$conexion = connect::con();
		$res = mysqli_query($conexion, $sql);
		connect::close($conexion);
		return $res;
	}

	function select_all_cars()
	{
		$sql = "SELECT * FROM cars ORDER BY id ASC";

		$conexion = connect::con();
		$res = mysqli_query($conexion, $sql);
		connect::close($conexion);
		// $data = 'hola DAO select_all_user';
		// die('<script>console.log('.json_encode( $data ) .');</script>');
		return $res;
	}

	function select_cars($id)
	{
		$sql = "SELECT * FROM cars WHERE id='$id'";

		$conexion = connect::con();
		$res = mysqli_query($conexion, $sql)->fetch_object();
		connect::close($conexion);
		return $res;
	}

	function delete_matr($matr)
	{
		$sql = "DELETE FROM cars WHERE matricula='$matr'";

		$conexion = connect::con();
		$res = mysqli_query($conexion, $sql)->fetch_object();
		connect::close($conexion);
		return $res;
	}

	function update_cars($datos)
	{

		$modelo = $datos['modelo'];
		$marca = $datos['marca'];
		$matricula = $datos['matricula'];
		$km = $datos['km'];
		$color = $datos['color'];
		$tipo = $datos['tipo'];
		$puertas = $datos['puertas'];
		$cv = $datos['cv'];
		$fecha_matr = $datos['fecha'];

		$sql = " UPDATE cars SET modelo='$modelo', matricula='$matricula', km='$km', color='$color', tipo='$tipo', puertas='$puertas',"
			. " cv='$cv', fecha_matr='$fecha_matr' WHERE matricula='$matricula'";

		$conexion = connect::con();
		$res = mysqli_query($conexion, $sql);
		connect::close($conexion);
		return $res;
	}

	function delete_cars($id)
	{
		$sql = "DELETE FROM cars WHERE id='$id'";

		$conexion = connect::con();
		$res = mysqli_query($conexion, $sql);
		connect::close($conexion);
		return $res;
	}
	function add_dummies()
	{
		$sql = "INSERT INTO `cars` (`modelo`, `marca`, `matricula`, `km`, `estado`, `color`, `tipo`, `puertas`, `cv`, `fecha_matr`) VALUES
			('leon', 'Seat', '7876PCD', '100', 'Km0', '#a63e27', 'Gasolina', '5', '120', '10/08/2020'),
			(	'fiesta', 'Ford', '7654LKL', '2000', 'Km0', '#FF11AF', 'Electrico', '4', '200', '20/09/2021')";

		$conexion = connect::con();
		$res = mysqli_query($conexion, $sql);
		connect::close($conexion);
		return $res;
	}

	function delete_all()
	{
		$sql = "DELETE FROM cars";

		$conexion = connect::con();
		$res = mysqli_query($conexion, $sql);
		connect::close($conexion);
		return $res;
	}
}
