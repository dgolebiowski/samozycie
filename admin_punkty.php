<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Dodaj/Odejmij | SamoŻycie |</title>
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
		<div class="header-big">Dodaj/Odejmij</div>
		<div class="header-small">Dodaj/Odejmij komuś $ z konta.</div>
	</div>
<?php
	$zapytanie = mysql_query("SELECT * FROM user WHERE login='".$_SESSION['login']."'"); 
	$wynik = mysql_fetch_array($zapytanie);
	
	if($wynik['ranga'] < 1)
{?>
	Ta część strony nie jest dla Ciebie dostępna!
<?php }
else
{ ?>

 <?php
                include_once("inc/search.php");
                include_once("inc/admin_points.php");
            ?>



<?php } ?> 
 
</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>