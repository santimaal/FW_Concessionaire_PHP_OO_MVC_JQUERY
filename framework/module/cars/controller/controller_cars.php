<?php
        $path = $_SERVER['DOCUMENT_ROOT'] . '/concessionaire/framework/';
        include($path . "module/cars/model/DAOCars.php");
    //session_start();
    
    switch($_GET['op']){
        case 'list';
            // $data = 'hola crtl user';
            // die('<script>console.log('.json_encode( $data ) .');</script>');

            try{
                $daocars = new DAOCars();
            	$rdo = $daocars->select_all_cars();
            }catch (Exception $e){
                $callback = 'index.php?page=exceptions&op=503&error=error_list';
			    die('<script>window.location.href="'.$callback .'";</script>');
            }
            
            if(!$rdo){
    			$callback = 'index.php?page=exceptions&op=503&error=error_list';
			    die('<script>window.location.href="'.$callback .'";</script>');
    		}else{
                include("module/cars/view/list_cars.php");
    		}
            break;
            
        case 'create';
             //$data = 'hola crtl user create';
             //die('<script>console.log('.json_encode( $data ) .');</script>');

            include("module/cars/model/validate.php");
            
            $check = true;
            
            if ($_POST){
                
                //$data = 'hola create post user';
                //die('<script>console.log('.json_encode( $data ) .');</script>');

                $check=validate_php();
            
                if ($check){
                    
                    $_SESSION['id']=$_POST;
                    
                    try{
                        $daocars = new DAOCars();                       
    		            $rdo = $daocars->insert_cars($_POST);

                    }catch (Exception $e){
                        $callback = 'index.php?page=exceptions&op=503&error=error_create';
        			    die('<script>window.location.href="'.$callback .'";</script>');
                    }
                    
		            if($rdo){
            			echo '<script language="javascript">alert("Registrado en la base de datos correctamente")</script>';
            			$callback = 'index.php?page=controller_cars&op=list';
        			    die('<script>window.location.href="'.$callback .'";</script>');
            		}else{
            			$callback = 'index.php?page=exceptions&op=503&error=error_create';
    			        die('<script>window.location.href="'.$callback .'";</script>');
            		}
                }
            }
            include("module/cars/view/create_cars.php");
            break;
            
        case 'update';
            include("module/cars/model/validate.php");
            
            $check = true;
            
            if ($_POST){
                $check=validate_php();
                
                if ($check){
                    $_SESSION['id']=$_POST;
                    try{
                        $daocars = new DAOCars();
    		            $rdo = $daocars->update_cars($_POST);

                    }catch (Exception $e){
                        $callback = 'index.php?page=exceptions&op=503&error=error_update';
        			    die('<script>window.location.href="'.$callback .'";</script>');
                    }
                    
		            if($rdo){
            			echo '<script language="javascript">alert("Actualizado en la base de datos correctamente")</script>';
            			$callback = 'index.php?page=controller_cars&op=list';
        			    die('<script>window.location.href="'.$callback .'";</script>');
            		}else{
            			$callback = 'index.php?page=exceptions&op=503&error=error_update';
    			        die('<script>window.location.href="'.$callback .'";</script>');
            		}
                }
            }
            
            try{
                $daocars = new DAOCars();
            	$rdo = $daocars->select_cars($_GET['id']);
            	$cars=get_object_vars($rdo);

            }catch (Exception $e){
                $callback = 'index.php?page=exceptions&op=503&error=error_update';
			    die('<script>window.location.href="'.$callback .'";</script>');
            }
            
            if(!$rdo){
    			$callback = 'index.php?page=exceptions&op=503&error=error_update';
    			die('<script>window.location.href="'.$callback .'";</script>');
    		}else{
        	    include("module/cars/view/update_cars.php");
    		}
            break;
            
        case 'read';
            // $data = 'hola crtl user read';
            // die('<script>console.log('.json_encode( $data ) .');</script>');
            try{
                $daocars = new DAOCars();
            	$rdo = $daocars->select_cars($_GET['id']);
            	$cars=get_object_vars($rdo);
            }catch (Exception $e){
                $callback = 'index.php?page=exceptions&op=503&error=error_read';
			    die('<script>window.location.href="'.$callback .'";</script>');
            }
            if(!$rdo){
    			$callback = 'index.php?page=exceptions&op=503&error=error_read';
    			die('<script>window.location.href="'.$callback .'";</script>');
    		}else{
                include("module/cars/view/read_cars.php");
    		}
            break;
            
        case 'delete';
            if (isset($_POST['delete'])){
                try{
                    $daocars = new DAOCars();
                	$rdo = $daocars->delete_cars($_GET['id']);
                }catch (Exception $e){
                    $callback = 'index.php?page=exceptions&op=503&error=error_delete';
    			    die('<script>window.location.href="'.$callback .'";</script>');
                }
            	
            	if($rdo){
        			echo '<script language="javascript">alert("Borrado en la base de datos correctamente")</script>';
        			$callback = 'index.php?page=controller_cars&op=list';
    			    die('<script>window.location.href="'.$callback .'";</script>');
        		}else{
        			$callback = 'index.php?page=exceptions&op=503&error=error_delete';
			        die('<script>window.location.href="'.$callback .'";</script>');
        		}
            }
            
            include("module/cars/view/delete_cars.php");
            break;
        case "dummies";
            $daocars = new DAOCars();
            $rdo = $daocars-> add_dummies();
            $callback = 'index.php?page=controller_cars&op=list';
            die('<script>window.location.href="'.$callback .'";</script>');
            break;
        
        case "deleteall";
            $daocars = new DAOCars();
            $rdo = $daocars-> delete_all();
            $callback = 'index.php?page=controller_cars&op=list';
            die('<script>window.location.href="'.$callback .'";</script>');
            break;

            case 'read_modal':
                // echo $_GET["id"]; 
                // exit;
    
                try{
                    $daocars = new DAOCars();
                    $rdo = $daocars->select_cars($_GET['id']);
                }catch (Exception $e){
                    echo json_encode($path. "module/exceptions/view/inc/error503.php");
                    exit;
                }
                if(!$rdo){
                    echo json_encode($path. "module/exceptions/view/inc/error503.php");
                    exit;
                }else{
                    $cars=get_object_vars($rdo);                
                    echo json_encode($cars);
                    exit;
                }
                break;
        default;
            include($path. "module/exceptions/view/inc/error404.php");
            break;
    }