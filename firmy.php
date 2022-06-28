<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Firmy | SamoŻycie |</title>
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
		<div class="header-big">Firmy</div>
		<div class="header-small">Lista firm w naszym projekcie!</div>
	</div>
<div class="przelew">
<div class="tablediv">
<table class="table">
  <thead>
    <tr>
      <th>NAZWA FIRMY</th>
	  <th>#</th>
    </tr>
  </thead>
  <tbody>
 <?php
	$zapytaniefirmy = mysql_query("SELECT * FROM `firmy`");
	$firmy = mysql_fetch_array($zapytaniefirmy);
	
	$listafirmy = mysql_query("SELECT * FROM `firmy` ORDER BY `nazwa` ASC") or die(mysql_error());

		 while ( $row = mysql_fetch_row($listafirmy) )
		 {			
					echo '<tr>';
					echo '<td><i class="fa fa-building"></i><span class="lg-c"> '. $row[1] .'</span></td>';
					echo '<td><a href="opis-firmy.php?id=' . $row[0] .'">Zobacz szczegóły</a></td>';
					}	
					?>
					
  </tbody>
  
</table>
	
	</div>
</div>
</div>
</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>