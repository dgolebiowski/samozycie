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
		<div class="header-small">Zarzadzaj firmami</div>
	</div>
<div class="title"> Zarzadzaj Firmami</div>
<div class="przelew">
<div class="tablediv">
 <table class="table">
  <thead>
    <tr>
      <th>Nazwa firmy</th>
	  <th>#</th>
    </tr>
  </thead>
  <tbody>
  <?php
  if($_GET['id'])
  {
	  $zapy = "DELETE FROM firmy WHERE id='". $_GET['id'] ."'";
	  mysql_query($zapy);
	  echo 'Usunięto!';
  }
  $listaf = mysql_query("SELECT * FROM `firmy`") or die(mysql_error());
  while ( $row = mysql_fetch_row($listaf) ) 
  {
    echo '<tr>';
    echo '<td>' . $row[1] . '</td>';
	echo '<td><a href="biuro_edytujfirme.php?id='. $row[0]. '"><i class="fa fa-edit"></i></a> | <a href="biuro_zarzadzaj.php?id='. $row[0]. '"><i class="fa fa-ban"></i></a></td>';
    echo '</tr>';
  }
	?>
  </tbody>
  
</table>
</div>
</div>
</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>