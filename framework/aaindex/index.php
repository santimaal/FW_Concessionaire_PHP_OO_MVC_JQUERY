<?php
if ((isset($_GET['page'])) && ($_GET['page'] === "controller_home")) {
	include("view/inc/top_page_home.html");
} else if ((isset($_GET['page'])) && ($_GET['page'] === "controller_cars")) {
	include("view/inc/top_page_cars.html");
} else if ((isset($_GET['page'])) && ($_GET['page'] === "controller_shop")) {
	include("view/inc/top_page_shop.html");
} else if ((isset($_GET['page'])) && ($_GET['page'] === "controller_login")) {
	include("view/inc/top_page_login.html");
} else if ((isset($_GET['page'])) && ($_GET['page'] === "controller_register")) {
	include("view/inc/top_page_register.html");
} else {
	include("view/inc/top_page.html");
}
session_start();
?>
<link rel="icon" type="image/png" href="view/img/pic01.png" />
<div id="wrapper">
	<div id="header">
		<?php
		include("view/inc/header.html");
		?>
	</div>
	<div id="menu">
		<?php
		include("view/inc/menu.html");
		?>
	</div>
	<div id="">
		<?php
		include("view/inc/pages.php");
		?>
		<br style="clear:both;" />
	</div>
	<div id="aboutus">
		<?php
		include("module/aboutus/aboutus.php");
		?>
	</div>
	<div id="footer">
		<?php
		include("view/inc/footer.html");
		?>
	</div>
</div>
<?php
include("view/inc/bottom_page.html");
?>