<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>P&C | SamoŻycie |</title>
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


if($wynik['firma']!=='P&C')
{
	header("Location: index.php");
}

?>

<div class="main-content">
	
	<div class="header">
		<div class="header-big"> P&C - Czysc Tabelke </div>
		<div class="header-small">Tutaj możesz edytować swoją firmę.</div>
	</div>
<div class="przelew">

<div class="alert alert-danger"> Potwierdz czyszczenie! </div>
	<?php
			if($_POST['czysc2'] == 1)
	{
			mysql_query("TRUNCATE TABLE `pic_konkurs`");
				echo '<span class="lg-c">Wyczyszczono!';
		}
	?>
		<form action="pic_czysc.php" method="post">
	<input type="hidden" value="1" name="czysc2"><button type="submit" name="submit" class="btn btn-form">Potwierdz Czyszczenie</button>
	</form>
</div>

</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>