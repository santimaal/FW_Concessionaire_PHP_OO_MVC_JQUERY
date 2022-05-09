<?php
    include("model/connect.php");
    
	class DAOError{
		function insert_exception($error){
			
			$errortype=$error['error'];
        	

            $sql = " INSERT INTO exceptions (error, fecha)"
            ." VALUES ('$errortype', CURTIME())";

            $conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion);
			return $res;
		}

        function select_all_exception(){
            $sql = "SELECT error, fecha FROM exceptions ORDER BY id";

            $conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion);
			return $res;
        }
    }