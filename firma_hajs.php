<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Firma - Hajs | SamoŻycie |</title>
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
	
	
	$zapytaniefirmy= mysql_query("SELECT * FROM `firmy` WHERE nazwa='" . $wynik['firma'] ."'"); 
$firma = mysql_fetch_array($zapytaniefirmy);

$hajs1 = mysql_query("SELECT SUM(punkty) AS total_value1 FROM zgloszenia WHERE notatka='". $firma['nazwa'] ."'");
	$dochody=mysql_result($hajs1,0,0);
$hajs2 = mysql_query("SELECT SUM(punkty) AS total_value2 FROM zgloszenia WHERE od='". $firma['nazwa'] ."'");
	$wydatki=mysql_result($hajs2,0,0);
?>

<div class="main-content">
	
	<div class="header">
		<div class="header-big">Panel Firmy - Hajs</div>
		<div class="header-small">Aby dochody się tutaj pokazały przelew musi być zatytułowany nazwą firmy!<br> Czyt. tam gdzie tytuł przelewu musi być tylko i wyłącznie nazwa firmy.<br> Aby transkacje pokazały się w wydatkach należy wykonać przelew firmowy!
  </div>
	</div>
	
<div class="przelew">

 <div class="header-big">Podsumowanie</div>
  <div class="header-small">
	<b>Dochody: <span class="lg-b"><?php if ($dochody<1) { echo 'W systemie nie znaleziono dochodów firmy ):'; } else echo ''.$dochody.' <img src="icon.png" width="16" height="16" />'; ?></span></b> <br />
	<b>Wydatki: <span class="lg-b"><?php if ($wydatki<1) { echo 'W systemie nie znaleziono wydatków firmy ):'; } else  echo ''.$wydatki.' <img src="icon.png" width="16" height="16" />'; ?></span></b>
  </div>
  
				
  <div class="title">Lista ostatnich 20 akcji zarobkowych twojej firmy</div>

<div class="tablediv">
	<table class="table">
  <thead>
    <tr>
      <th>Od</th>
	  <th>Tytuł Przelewu</th>
	  <th>Ilość Koprów</th>
	  <th>Data</th>
    </tr>
  </thead>
  <tbody>
  <?php
  $lista2 = mysql_query("SELECT * FROM `zgloszenia` WHERE notatka='".$firma['nazwa']."'") or die(mysql_error());
  $ile =  mysql_num_rows($lista2);
  
  
  if($ile < 1)
  {
	echo '<tr>';
    echo '<td>Brak akcji dochodowych!</td>';
    echo '</tr>';
  }
  else
  {
  $lista = mysql_query("SELECT * FROM `zgloszenia` WHERE notatka='".$firma['nazwa']."' ORDER BY `id` DESC LIMIT 20") or die(mysql_error());
  while ( $row = mysql_fetch_row($lista) ) 
  {
	
		  echo '<tr class="success">';
    echo '<td><i class="fa fa-user-tie"></i> ' . $row[4] . '</td>';
	echo '<td>' . $row[7] .'</td>';
	echo '<td><b>' . $row[6] . ' <img src="icon.png" width="16" height="16" /></b></td>';
	echo '<td>' . $row[2] . '</td>';
    echo '</tr>';
	 
	  }
  }
  
	?>
  </tbody>
  
</table>
</div>
	
  <div class="title">Lista ostatnich 15 wydatków </div>
<div class="tablediv">
	<table class="table">
  <thead>
    <tr>
      <th>Do</th>
	  <th>Tytuł Przelewu</th>
	  <th>Ilość Koprów</th>
	  <th>Data</th>
    </tr>
  </thead>
  <tbody>
  <?php
  $lista2 = mysql_query("SELECT * FROM `zgloszenia` WHERE od='".$firma['nazwa']."'") or die(mysql_error());
  $ile =  mysql_num_rows($lista2);
  
  
  if($ile < 1)
  {
	echo '<tr>';
    echo '<td>Brak wydatków!</td>';
    echo '</tr>';
  }
  else
  {
  $lista = mysql_query("SELECT * FROM `zgloszenia` WHERE od='".$firma['nazwa']."' ORDER BY `id` DESC LIMIT 50") or die(mysql_error());
  while ( $row = mysql_fetch_row($lista) ) 
  {
	
		  echo '<tr class="danger">';
    echo '<td><i class="fa fa-user-tie"></i> ' . $row[1] . '</td>';
	echo '<td>' . $row[7] .'</td>';
	echo '<td><b>' . $row[6] . ' <img src="icon.png" width="16" height="16" /></b></td>';
	echo '<td>' . $row[2] . '</td>';
    echo '</tr>';
	 
	  }
  }
  
	?>
  </tbody>
  
</table>
</div>
</div>


	<?php 
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