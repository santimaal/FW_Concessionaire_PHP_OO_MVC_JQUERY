<?php
			switch($_GET['page']){
		case "controller_home";
			// include("module/inicio/view/inicio.php");
			include("module/home/controller/controller_home.php");
			break;
		case "shop";
			include("module/shop/controller/controller_shop.php");
			break;
		case "controller_cars";
			include("module/cars/controller/".$_GET['page'].".php");
			break;
		case "services";
			include("module/services/".$_GET['page'].".php");
			break;
		case "aboutus";
			include("module/aboutus/".$_GET['page'].".php");
			break;
		case "contactus";
			include("module/contact/".$_GET['page'].".php");
			break;
		case "exceptions";
			include("module/exceptions/controller/controller_exceptions.php");
			break;
		case "controller_shop";
			include("module/shop/controller/controller_shop.php");
			break;
		case "controller_search";
			include("module/search/controller/controller_search.php");
			break;
		case "controller_login";
			include("module/login/controller/controller_login.php");
			break;
		case "controller_register";
			include("module/login/controller/controller_login.php");
			break;

		default;
			header("Location: http://localhost/concessionaire/framework/index.php?page=controller_home&op=list", TRUE, 301);
			// include("module/home/view/homepage.html");
			break;
	}
?>