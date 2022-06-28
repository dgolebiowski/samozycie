<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Panel Firmy | SamoÅ»ycie |</title>
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
		<div class="header-big">Panel Firmy</div>
		<div class="header-small">sieam mordzix, co tam</div>
	</div>

<div class="przywileje">
<?php 
$zapytanief = mysql_query("SELECT * FROM `firmy` WHERE nazwa='" . $wynik['firma'] ."'"); 
$wynikf = mysql_fetch_array($zapytanief);  

		?>
	<li><a href="firma_edytuj.php?id=<?php echo $wynikf['id']; ?>"><button class="btn btn-form"><i class="fa fa-edit"></i> Edytuj [Firma]</a> </button></li>
	<li><a href="firma_pracownicy.php"><button class="btn btn-form"> Pracownicy [Firma]</a> </button></li>
	<li><a href="firma_hajs.php"><button class="btn btn-form"> Zarobki/Wydatki [Firma]</a> </button></li>
	<li><a href="firma_ranking.php"><button class="btn btn-form"> Ranking [Firma]</a> </button></li>
	<li><a href="loteria_edytuj.php"><button class="btn btn-form"> [Loteria] Edytuj Loterie</a> </button></li>
	<li><a href="pic_edytuj.php"><button class="btn btn-form"> [P&C] Edytuj P & C</a> </button></li>
	<li><a href="firma_premium.php"><button class="btn btn-form"> [SZH] Konta Premium</a> </button></li>
	<li><a href="podatek_lista.php"><button class="btn btn-form"> [US] Sprawdz podatek</a> </button></li>
	<li><a href="biuro_dodaj.php"><button class="btn btn-form"> [Biuro Patentowe] Dodaj firme</a> </button></li>
	<li><a href="biuro_zarzadzaj.php"><button class="btn btn-form"> [Biuro Patentowe] Edytuj firme</a> </button></li>
</div>
	
	</div>
</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>