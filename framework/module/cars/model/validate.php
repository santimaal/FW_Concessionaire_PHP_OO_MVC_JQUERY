<?php
    function validate_modelo($texto){
        $reg="/^[a-zA-Z]*$/";
        return preg_match($reg,$texto);
    }
//   function validate_modelo($texto){
//    $sql = "SELECT * FROM cars WHERE id='$texto'";
			
//    $conexion = connect::con();
//    $res = mysqli_query($conexion, $sql)->fetch_object();
//    connect::close($conexion);
//    return $res;
//    }

    function validate_marca($texto){
        $reg="/^[a-zA-Z]*$/";
        return preg_match($reg,$texto);
    }

    function validate_matricula($texto){
        $reg="/^[0-9]{4}[BCDFGHJKLMNPRSTVWXYZ]{3}$/";
        return preg_match($reg, $texto);
    }

    function validate_color($texto){
       // $reg="/^[#0-9a-zA-Z]*$/";
       // return preg_match($reg,$texto);
       return true;
    }

    function validate_tipo($texto){
        if(!isset($texto) || empty($texto)){
            return false;
        }else{
            return true;
        }
    }

    function validate_cv($texto){
        $reg="/[0-9]{3}$/";
        return preg_match($reg,$texto);
    }

//    funcion validate_matricula($matr) {
//        $sql = "SELECT * FROM cars WHERE id='$matr'";
//			
//        $conexion = connect::con();
//        $res = mysqli_query($conexion, $sql)->fetch_object();
//        connect::close($conexion);
//        return $res;
//    }
    
//    function validate_tipo($texto){
//        $reg = "/^[("gasolina"|"electrico")]$/";
//        return preg_match($reg,$texto);
//    }
    
    function validate_km($texto){
        $reg="/[0-9]{1,6}$/";
        return preg_match($reg,$texto);
    }
    
    function validate_puertas($marca){
        $reg="/[0-9]{1}$/";
        return preg_match($reg,$marca);
    }
    

    
    function validate_php(){
        // $data = 'hola validate php';

        $check=true;
        
        $v_matricula=$_POST['matricula'];
        $v_modelo=$_POST['modelo'];
        $v_marca=$_POST['marca'];
        $v_color=$_POST['color'];
        $v_tipo=$_POST['tipo'];
        $v_cv=$_POST['cv'];
        $v_km=$_POST['km'];
        $v_puertas=$_POST['puertas'];

        
        $r_matricula=validate_matricula($v_matricula);
        $r_km=validate_km($v_km);
        $r_modelo=validate_modelo($v_modelo);
        $r_marca=validate_marca($v_marca);
        $r_tipo=validate_tipo($v_tipo);
        $r_cv=validate_cv($v_cv);
        $r_km=validate_km($v_km);
        $r_puertas=validate_puertas($v_puertas);
        
        if($r_matricula !== 1){
            $error_matricula = " * La matricula introducido no es valido";
            $check=false;
        }else{
            $error_matricula = "";
            
        }
        if($r_km !== 1){
            $error_km = " * La contraseña introducida no es valida";
            $check=false;
        }else{
            $error_km = "";
            
        }
        if($r_modelo !== 1){
            $error_modelo = " * El modelo introducido no es valido";
            $check=false;
        }else{
            $error_modelo = "";
            
        }
        if($r_marca !== 1){
            $error_marca = " * El marca introducido no es valido";
            $check=false;
        }else{
            $error_marca = "";
        }
        if(!$r_tipo){
            $error_tipo = " * No has seleccionado ningun tipo";
            $check=false;
        }else{
            $error_tipo = "";
        }
        if(!$r_cv){
            $error_cv = " * El cv introducido no es valido";
            $check=false;
        }else{
            $error_cv = "";
        }
        if(!$r_km){
            $error_km = " * El km introducido no es valido";
            $check=false;
        }else{
            $error_cv = "";
        }
        if($r_puertas !== 1){
            $error_puertas = " * La puertas introducida no es valida";
            $check=false;
        }else{
            $error_puertas = "";
        }
        
        return $check;
    }




 