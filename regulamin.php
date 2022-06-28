<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Regulamin | SamoŻycie |</title>
	<?php include('inc/dane_head.php'); ?>
</head>

<body>
<?php
include('connect.php');
include('inc/menu.php');

if(empty($_SESSION['login']))
{
	header("Location: login.php");
}
?>

<div class="main-content">
	
	<div class="header">
		<div class="header-big">Regulamin</div>
		<div class="header-small">Spis zasad projektu.</div>
	</div>


	<span class="lg-c">1. Postanowienia Ogólne</span><br>
				<span class="lg-b">1.1. Strona przeznaczona jest do projektu podstaw przedsiębiorczości w 1LO.<br>
					1.2. Kopry to wirtualna waluta systemowa.<br>
					<br></span>
					<span class="lg-c">2. Konta</span><br><span class="lg-b">
					2.1. Konto może utworzyć każdy uczestnik projektu.<br>
					2.2. Kazdy użytkownik będący w projekcie akceptuje regulamin.<br>
					2.3. Administrator zastrzega sobie możliwość do usunięcia, zablokowania konta bez podania przyczyny.<br>
					2.4. Użytkownik może posiadać tylko jedno konto w serwisie.<br>
					<br></span>
					<span class="lg-c">3. Przelewy</span><br><span class="lg-b">
					3.1. Każdy użytkownik może wykonać przelew do innego użytkownika.<br>
					3.2. Wykonanej transkacji nie da się cofnąć.<br>
					<br></span>
					<span class="lg-c">4. Postanowienia końcowe</span><br><span class="lg-b">
					4.1. Administrator zastrzega możliwość zmiany regulaminu bez podania przyczyny.<br>
					4.2. Podczas zmiany regulaminu każdy uczestnik projektu zostanie poinformowany.<br>
</span>
	
	</div>
</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>