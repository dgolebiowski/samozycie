<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Asystenci | SamoŻycie |</title>
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
		<div class="header-big">Asystenci</div>
		<div class="header-small">Lista administratorów projektu.</div>
	</div>

<?php
  $listaasystentow = mysql_query("SELECT * FROM `user` WHERE ranga>1 ORDER BY `imie` ASC") or die(mysql_error());
  
  while ( $rowa = mysql_fetch_row($listaasystentow) ) 
  {
    echo '<span class="lg-b"> ' . $rowa[8] . '</span> <span class="lg-c">'. $rowa[2] .'</span> <br>';
	}
 ?>

	
	</div>
</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>