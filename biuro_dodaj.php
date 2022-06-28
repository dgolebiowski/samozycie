<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Firma - Biuro Patentowe | SamoŻycie |</title>
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

$biuro = mysql_query("SELECT * FROM `admin`");
$wynik2 = mysql_fetch_array($biuro);

if($wynik['login']!==$wynik2[3])
{
    header("Location: index.php");
}
?>

<div class="main-content">
	
	<div class="header">
		<div class="header-big">Biuro Patentowe - Dodaj firme</div>
		<div class="header-small">Dodaj firme</div>
	</div>
<div class="title"> Dodaj Firme</div>
<div class="przelew">
<?php 
	if($_POST['dodajfirme'] == 1)
	{
		$nazwa = htmlspecialchars($_POST['nazwa']);
		$opis = htmlspecialchars($_POST['opis']);
		$prezes = htmlspecialchars($_POST['prezes']);
		$vice = htmlspecialchars($_POST['vice']);
		$logo = htmlspecialchars($_POST['logo']);
		
		mysql_query("INSERT INTO firmy VALUES (NULL, '". $nazwa ."', '". $opis ."', '". $prezes ."', '". $vice ."', '". $logo ."', '')");		
		mysql_query("UPDATE user SET firma='". $nazwa ."' WHERE login='". $prezes ."' ");
		
		echo 'Dodano firme';
	}
	
	
	?>
	<form action="biuro_dodaj.php" method="post">
		<div class="form-group">
			<label for="exampleInputEmail1">Nazwa Firmy</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="nazwa">
		</div>
		
		<div class="form-group">
			<label for="exampleInputEmail1">Opis</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="opis">
		</div>
		
		<div class="form-group">
			<label for="exampleInputEmail1">Prezes(Nick)</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="prezes">
		</div>
		
		<div class="form-group">
			<label for="exampleInputEmail1">VicePrezes(Nick)</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="vice">
		</div>
		
		<div class="form-group">
			<label for="exampleInputEmail1">Logo</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="logo">
		</div>

		<input type="hidden" value="1" name="dodajfirme"><button type="submit" name="submit" class="btn btn-form">Dodaj</button>

</form>

</div>
</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>