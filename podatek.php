<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Podatek | SamoŻycie |</title>
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


$adminbaza = mysql_query("SELECT * FROM admin"); 
$admin	= mysql_fetch_array($adminbaza);

$data = date("Y-m-d", strtotime("-1 week"));

$hajs1 = mysql_query("SELECT SUM(punkty) AS total_value1 FROM zgloszenia WHERE od='". $wynik['login'] ."' AND data>='". $data ."' AND login!='Urzad Skarbowy'");
$wydatki=mysql_result($hajs1,0,0);

$procent=$admin[10]*100;
$podatek=$wynik['punkty']*$admin[10];

?>

<div class="main-content">
	
	<div class="header">
		<div class="header-big">Podatki</div>
		<div class="header-small">Tutaj zapłacisz podatek. Pamiętaj aby to zrobić bo w innym wypadku zapłacisz karę.
  </div>
	</div>
	
<div class="przelew">

 <div class="header-big">Podsumowanie</div>
  <div class="header-small">
	<b>Obecny procent: <span class="lg-b"><?php echo $procent; ?>%</span></b><br />
	<b>Twój stan konta: <span class="lg-b"><?php echo $wynik['punkty']; ?> <img src="icon.png" width="16" height="16" /></span></b><br />
	<b>Wydatki w ostatnim tygodniu: <span class="lg-b"><?php if ($wydatki<1) { echo 'W systemie nie znaleziono wydatkow w ostatnim tygodniu ):'; } else echo ''.$wydatki.' <img src="icon.png" width="16" height="16" />'; ?></span></b> <br />
 </div>
  
			
  <div class="title">Twoje rozliczenie z podatku</div>
<?php 
if($wynik['podatek']==5)
{
	echo '<div class="alert alert-success"> Nie ma cie w projekcie come on - nie musisz placic i tak </div>';
}
else if($wynik['podatek']==2)
{
	echo '<div class="alert alert-success"> Sprawdzono! Odjęliśmy z twojego konta odpowiednią ilość IK. </div>';
}
else if($wynik['podatek']==1)
{
	echo '<div class="alert alert-light"> Trwa sprawdzanie... </div>';
}
else
{
	?>

 <?php 
		if($_POST['zaplac'] == 1)
	{
		$login = htmlspecialchars($_POST['user']);
		$podatek = htmlspecialchars($_POST['podatek']);
		$ulga = htmlspecialchars($_POST['ulga']);
		$zaplata = $podatek - $ulga;

		if($ulga>$podatek)
		{
			echo'<div class="alert alert-danger">Nawet nie próbuj oszukiwać cwaniaczku...</div>';
		}
		else 
		{
		mysql_query("INSERT INTO podatek VALUES (NULL, '". $login ."', NOW(), '". $podatek ."', '". $ulga ."', '". $zaplata ."', '0')");		
		mysql_query("UPDATE user SET podatek='1' WHERE login='". $login ."' ");
		
			header("Location: podatek.php");
		}
		
	}
?>
	
<form action="podatek.php" method="post">
		
		<div class="form-group">
			<label for="User">Nazwa Użytkownika</label>
			<input type="text" class="form-control" name="user" value="<?php echo $wynik['login']; ?>" readonly>
		</div>

		<div class="form-group">
			<label for="Podatek">Podatek</label>
			<input type="text" class="form-control" name="podatek" value="<?php echo $podatek ?>" readonly>
		</div>
		
		<div class="form-group">
			<label for="Ulga">Ulga</label>
			<input type="text" class="form-control" name="ulga">
		</div>
		
		<input type="hidden" value="1" name="zaplac"><button type="submit" name="submit" class="btn btn-form">Zapłać Podatek</button>

</form>
<div class="alert alert-danger"> Pamiętaj, że jeśli wpiszesz większa ulge niż prawdziwa lub spróbujesz oszukać system to nałożymy na ciebię karę (Zabierzemy ci 50% twoich pieniędzy).</div>

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