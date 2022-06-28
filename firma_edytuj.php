<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Firma - Edytuj | SamoŻycie |</title>
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

$dostepfirmy= mysql_query("SELECT * FROM `firmy` WHERE prezes='" . $_SESSION['login'] ."'");
$dostepfirmy2= mysql_query("SELECT * FROM `firmy` WHERE vice='" . $_SESSION['login'] ."'"); 

if( (mysql_num_rows($dostepfirmy)) == 1 OR (mysql_num_rows($dostepfirmy2)) == 1)
{
?>

<div class="main-content">
	
	<div class="header">
		<div class="header-big">Panel Firmy - Edytowanie</div>
		<div class="header-small">Tutaj możesz edytować swoją firmę.</div>
	</div>
<div class="przelew">
	<?php
                    if(isset($_SESSION['success_add'])){
                        echo $_SESSION['success_add'];
                        unset($_SESSION['success_add']);
                    }
                    if(isset($_SESSION['message'])){
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }
					?>
<?php 
	
		$pobierz = "SELECT * FROM firmy WHERE id='" . $_GET['id'] . "'";
		$wyszlo = mysql_query($pobierz) or die(mysql_error());
		$item = mysql_fetch_array($wyszlo); 
		$item2 = mysql_fetch_array($dostepfirmy); 
		
	if($wynik['firma'] != $item['1'])
{
	$_SESSION["message"] = 'Nie jesteś prezesem tej firmy!</div>';
	 header("Location: /firma_edytuj.php?id=". $item[0] ."");
     die();
}

	else
	if($_GET['id'])
	{
		
		$pobierz = "SELECT * FROM firmy WHERE id='" . $_GET['id'] . "'";
		$wyszlo = mysql_query($pobierz) or die(mysql_error());
		$item = mysql_fetch_array($wyszlo); 
		
		if($_POST['zmien'] == 1)
	{
		$nazwa = htmlspecialchars($_POST['nazwa']);
		$opis = htmlspecialchars($_POST['opis']);
		$prezes = htmlspecialchars($_POST['prezes']);
		$vice = htmlspecialchars($_POST['vice']);
		$logo = htmlspecialchars($_POST['logo']);
		$id = $_POST['id'];

		$dodaj = "UPDATE firmy SET opis='" . $opis . "', vice='" . $vice ."', logo='". $logo ."' WHERE id='". $_GET['id'] ."'";
			mysql_query($dodaj) or die(mysql_error());
		
			$_SESSION["success_add"] = 'Zaktualizowano!';
			header("Location: /firma_edytuj.php?id=". $item[0] .".php");
			die();
		}
	?>
	<form action="firma_edytuj.php?id=<?php echo $item[0]; ?>" method="post">
		
		<div class="form-group">
			<label for="exampleInputEmail1">Nazwa firmy</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="nazwa" value="<?php echo $item['1']; ?>" readonly>
		</div>

		<div class="form-group">
			<label for="exampleInputHaslo">Informacje o firmie</label>
			<textarea class="form-control" name="opis" ><?php $item[2] = str_replace('<br />', '', $item[2]);
			echo $item[2]; ?></textarea>
		</div>
		
		<div class="form-group">
			<label for="exampleInputHaslo">Prezes</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="prezes" value="<?php echo $item[3]; ?>" readonly>
		</div>
		
		<div class="form-group">
			<label for="exampleInputHaslo">Vice</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="vice" value="<?php echo $item[4]; ?>">
		</div>
		
		<div class="form-group">
			<label for="exampleInputHaslo">Logo (Link do grafiki)</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="logo" value="<?php echo $item[5]; ?>">
		</div>
		
		<input type="hidden" value="1" name="zmien"><button type="submit" name="submit" class="btn btn-form">Zmień</button>

</form>
</div>
	<?php }

}
else
{
	  header("Location: index.php");
}
	?>
</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>