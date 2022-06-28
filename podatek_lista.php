<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Panel Urzędu Skarbowego - Podatki Lista | SamoŻycie |</title>
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

if($wynik['login']!==$wynik2[11])
{
  header("Location: index.php");
}
?>

<div class="main-content">
	
	<div class="header">
		<div class="header-big">Panel Urzędu Skarbowego</div>
		<div class="header-small">Tutaj możesz sprawdzać podatki.</div>
	</div>
<div class="title"> Do sprawdzenia:</div>
<div class="tablediv">
 <table class="table">
  <thead>
    <tr>
      <th>Użytkownik</th>
	  <th>Data</th>
	  <th>#</th>
    </tr>
  </thead>
  <tbody>
  <?php
  $listaf = mysql_query("SELECT * FROM `podatek` WHERE status='0'") or die(mysql_error());
  while ( $row = mysql_fetch_row($listaf) ) 
  {
    echo '<tr>';
    echo '<td>' . $row[1] . '</td>';
	echo '<td>' . $row[2] . '</td>';
	echo '<td><a href="podatek_sprawdz.php?id='. $row[0]. '"><i class="fa fa-edit"></i> Sprawdź. </a></td>';
    echo '</tr>';
  }
	?>
  </tbody>
  
</table>
</div>

<div class="title"> Sprawdzono:</div>
<div class="tablediv">
 <table class="table">
  <thead>
    <tr>
      <th>Użytkownik</th>
	  <th>Data</th>
	  <th>#</th>
    </tr>
  </thead>
  <tbody>
  <?php
  $listaf = mysql_query("SELECT * FROM `podatek` WHERE status>='1' ") or die(mysql_error());
  while ( $row = mysql_fetch_row($listaf) ) 
  {
if($row[6]==1) {
    echo '<tr>';
    echo '<td>' . $row[1] . '</td>';
	echo '<td>' . $row[2] . '</td>';
	echo '<td> Akceptowane. </td>';
    echo '</tr>';
  }
else if($row[6]==2)
	{
    echo '<tr>';
    echo '<td>' . $row[1] . '</td>';
	echo '<td>' . $row[2] . '</td>';
	echo '<td> Odrzucone. </td>';
    echo '</tr>';
	}
}
	?>
  </tbody>
  
</table>
</div>

</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>