<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Loteria Edytowanie | SamoŻycie |</title>
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


if($wynik['firma']!=='Loteria')
{
	header("Location: index.php");
}

?>

<div class="main-content">
	
	<div class="header">
		<div class="header-big"> Loteria- Edycja </div>
		<div class="header-small">Tutaj możesz edytować swoją firmę.</div>
	</div>
<div class="przelew">

<?php 

	$pobierz = "SELECT * FROM loteria";
	$wyszlo = mysql_query($pobierz) or die(mysql_error());
	$item = mysql_fetch_array($wyszlo); 
		
		
		if($_POST['check'] == 1)
	{
		$pula = htmlspecialchars($_POST['pula']);
		$data = htmlspecialchars($_POST['data']);
		$cena = htmlspecialchars($_POST['cena']);
		$stan = htmlspecialchars($_POST['stan']);
		$ostatni = htmlspecialchars($_POST['ostatni']);

			$zmiana = "UPDATE loteria SET pula='" . $pula ."', data='" . $data . "', cena='" . $cena . "', ostatni='" . $ostatni ."', stan='". $stan ."'";
			mysql_query($zmiana) or die(mysql_error());
		
			echo 'Zaktualizowano!';
		}
	?>
	<form action="loteria_edytuj.php" method="post">
		
		<div class="form-group">
			<label for="exampleInputHaslo">1 - Włączona | 0 - Wyłączona</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="stan" value="<?php echo $item[4]; ?>">
		</div>
		
		<div class="form-group">
			<label for="exampleInputHaslo">Pula Losowania</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="pula" value="<?php echo $item[0]; ?>">
		</div>
		
		<div class="form-group">
			<label for="exampleInputHaslo">Cena Kuponu</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="cena" value="<?php echo $item[2]; ?>">
		</div>
		
		<div class="form-group">
			<label for="exampleInputHaslo">Data Losowania</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="data" value="<?php echo $item[1]; ?>">
		</div>
		
		<div class="form-group">
			<label for="exampleInputHaslo">Ostatni Zwycięzca</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="ostatni" value="<?php echo $item[3]; ?>">
		</div>
		
		<input type="hidden" value="1" name="check"><button type="submit" name="submit" class="btn btn-form">Zmień</button>

</form>
</div>

		<div class="title">Panel Loterii - Czyść Tabelke</div>
  <div class="przelew">
  
  <div class="alert alert-danger"> Klikać tylko po zakończonym losowaniu! </div>
	<?php
			if($_POST['czysc'] == 1)
	{
			header("Location: loteria_czysc.php");
			
		}
	?>
		<form action="loteria_edytuj.php" method="post">
	<input type="hidden" value="1" name="czysc"><button type="submit" name="submit" class="btn btn-form">Wyczyść Tabelke</button>
	</form>
  </div>

</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>