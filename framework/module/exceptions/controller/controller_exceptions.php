<?php

    include ("module/exceptions/model/DAOError.php");
    
    switch($_GET['op']){

        case '404';
        include ("module/exceptions/view/inc/error404.php");
            break;

        case '503';
            $daoerror = new DAOError();                       
    	    $rdo = $daoerror->insert_exception($_GET);
            include ("module/exceptions/view/inc/error503.php");
            break;
        
        case 'list';
            include ("module/exceptions/view/inc/list_exceptions.php");
            break;
            
    }

