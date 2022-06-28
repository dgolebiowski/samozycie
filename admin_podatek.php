<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Podatek - Kontrola | SamoŻycie |</title>
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
		<div class="header-big">Podatki</div>
		<div class="header-small">Kto nie zaplacil i ile hajsu mamy z tego ;3</div>
	</div>
<?php
	$zapytanie = mysql_query("SELECT * FROM user WHERE login='".$_SESSION['login']."'"); 
	$wynik = mysql_fetch_array($zapytanie);

	if($wynik['ranga'] < 1)
{?>
	Ta część strony nie jest dla Ciebie dostępna!
<?php }
else
{
$data = date("Y-m-d", strtotime("-1 week"));

$hajs1 = mysql_query("SELECT SUM(zaplata) AS total_value1 FROM podatek WHERE data>='". $data ."'");
$wydatkityg = mysql_result($hajs1,0,0);

$hajs2 = mysql_query("SELECT SUM(zaplata) AS total_value1 FROM podatek");
$wydatki = mysql_result($hajs2,0,0);	

?>

<div class="header-big">Podsumowanie</div>
  <div class="header-small">
	<b>Kopry zebrane w tym tygodniu: <span class="lg-b"><?php if ($wydatkityg<1) { echo 'W systemie nie ma zadnych podatkow):'; } else echo ''.$wydatkityg.' <img src="icon.png" width="16" height="16" />'; ?></span></b><br />
	<b>Kopry zebrane ogolem: <span class="lg-b"><?php if ($wydatki<1) { echo 'W systemie nie ma zadnych podatkow):'; } else echo ''.$wydatki.' <img src="icon.png" width="16" height="16" />'; ?></span></b> <br />
 </div>

<div class="title">Nie zapłaciły osoby:</div>
<?php $listapodatek = mysql_query("SELECT * FROM `user` WHERE podatek='0'") or die(mysql_error());
  while ( $row = mysql_fetch_row($listapodatek) ) 
  {
	  echo '<li><span class="lg-b">'. $row[1] .'</span> - <span class="lg-c">'. $row[8] .'</span></li>';
  }
?>

<?php }
?>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>