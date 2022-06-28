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
		<div class="header-big">Biuro Patentowe - Zarzadzanie</div>
		<div class="header-small">Edytowanie firm</div>
	</div>
<div class="title"> Edytuj Firme</div>
<div class="przelew">

<?php
if($_GET['id'])
	{
		
		$pobierz = "SELECT * FROM firmy WHERE id='" . $_GET['id'] . "'";
		$wyszlo = mysql_query($pobierz) or die(mysql_error());
		$item = mysql_fetch_array($wyszlo); 
		
		if($_POST['check'] == 1)
	{
		$nazwa = htmlspecialchars($_POST['nazwa']);
		$opis = htmlspecialchars($_POST['opis']);
		$prezes = htmlspecialchars($_POST['prezes']);
		$vice = htmlspecialchars($_POST['vice']);
		$logo = htmlspecialchars($_POST['logo']);
		$id = $_POST['id'];

			$dodaj = "UPDATE firmy SET nazwa='" . $nazwa ."', opis='" . $opis . "', prezes='" . $prezes . "', vice='" . $vice ."', logo='". $logo ."' WHERE id='". $id ."'";
			mysql_query($dodaj) or die(mysql_error());
		
			echo '<span class="tekst">Zaktualizowano!</span>';
		}
	?>
	<form action="biuro_edytujfirme.php?id=<?php echo $item[0]; ?>" method="post">
		
		<div class="form-group">
			<label for="exampleInputEmail1">ID Firmy</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="id" value="<?php echo $item['0']; ?>" readonly>
		</div>
		
		<div class="form-group">
			<label for="exampleInputEmail1">Nazwa firmy</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="nazwa" value="<?php echo $item['1']; ?>">
		</div>

		<div class="form-group">
			<label for="exampleInputHaslo">Opis</label>
			<textarea class="form-control" name="opis" ><?php $item[2] = str_replace('<br />', '', $item[2]);
			echo $item[2]; ?></textarea>
		</div>
		
		<div class="form-group">
			<label for="exampleInputHaslo">Prezes(Nick)</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="prezes" value="<?php echo $item[3]; ?>">
		</div>
		
		<div class="form-group">
			<label for="exampleInputHaslo">Vice(Nick)</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="vice" value="<?php echo $item[4]; ?>">
		</div>
		
		<div class="form-group">
			<label for="exampleInputHaslo">Logo</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="logo" value="<?php echo $item[5]; ?>">
		</div>
		
		<input type="hidden" value="1" name="check"><button type="submit" name="submit" class="btn btn-form">Zmień</button>

</form>

<?php
	}
	?>
</div>
</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>