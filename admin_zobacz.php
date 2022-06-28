<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Ostatnie Akcje | SamoŻycie |</title>
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
		<div class="header-big">Transakcje</div>
		<div class="header-small">Ostatnie Transakcje wykonane przez użytkowników.</div>
	</div>
<?php
	$zapytanie = mysql_query("SELECT * FROM user WHERE login='".$_SESSION['login']."'"); 
	$wynik = mysql_fetch_array($zapytanie);
	
	if($wynik['ranga'] < 1)
{?>
	Ta część strony nie jest dla Ciebie dostępna!
<?php }
else
{ ?>
<div class="tablediv">
     <table class="table">
  <thead>
    <tr>
      <th>Pseudonim</th>
	  <th>Imie Nazwisko</th>
	  <th>Kopry</th>
	  <th>Firma</th>
    </tr>
  </thead>
  <tbody>
  <?php
if($_GET['id'])
{
	$id = $_GET['id'];
	$zapytanie1 = mysql_query("SELECT * FROM `user` WHERE id=" . $id . "") or die(mysql_error());
	$wynik = mysql_fetch_row($zapytanie1);
	
	$zapytanie2 = mysql_query("SELECT * FROM `zgloszenia` WHERE login='" . $wynik[1] . "' ORDER BY id DESC LIMIT 35") or die(mysql_error()); 
	?>
	<tr>
	<td><?php echo $wynik[1]; ?></td>
	<td><?php echo $wynik[8]; ?></td>
	<td><?php echo $wynik[7]; ?> <img src="icon.png" width="16" height="16" /></td>
	<td><?php echo $wynik[6]; ?></td>
	</tr>
  </tbody>
  
</table>
</div>

<div class="title"> Dochody </div>
<?php
	$akcje = mysql_query("SELECT * FROM user WHERE login='".$_SESSION['login']."'"); 
    $lista = mysql_fetch_array($zapytanie); 
	?>
<div class="tablediv">
	<table class="table">
  <thead>
    <tr>
	  <th>Od</th>
      <th>Transakcja</th>
      <th>Ilość Koprów</th>
	  <th>Data</th>
	  <th>Operacja</th>
    </tr>
  </thead>
  <tbody>
  <?php
  $lista2 = mysql_query("SELECT * FROM `zgloszenia` WHERE login='". $wynik[1]."'") or die(mysql_error());
  $ile =  mysql_num_rows($lista2);
  
  if($ile < 1)
  {
	echo '<tr>';
    echo '<td>Brak akcji wydatkowych!</td>';
    echo '</tr>';
  }
  else
  {
  $lista = mysql_query("SELECT * FROM `zgloszenia` WHERE login='". $wynik[1]."' ORDER BY `id` DESC LIMIT 25") or die(mysql_error());
  while ( $row = mysql_fetch_row($lista) ) 
  {
		   echo '<tr class="success">';
    echo '<td><i class="fa fa-user-tie"></i> ' . $row[4] . '</td>';
	echo '<td>' . $row[7] .'</td>';
	echo '<td><b>' . $row[6] . ' <img src="icon.png" width="16" height="16" /></b></td>';
	echo '<td>' . $row[2] . '</td>';
	echo '<td> Dodano $ </td>';
    echo '</tr>';
	  }
  }?>
  
 </tbody>
  
</table>
</div>

<div class="title"> Wydatki </div>
  <?php
	$akcje = mysql_query("SELECT * FROM user WHERE login='".$_SESSION['login']."'"); 
    $lista = mysql_fetch_array($zapytanie); 
	?>
<div class="tablediv">
	<table class="table">
  <thead>
    <tr>
	  <th>Do</th>
      <th>Transakcja</th>
      <th>Ilość Koprów</th>
	  <th>Data</th>
	  <th>Operacja</th>
    </tr>
  </thead>
  <tbody>
  <?php
  $lista2x = mysql_query("SELECT * FROM `zgloszenia` WHERE od='". $wynik[1] ."'") or die(mysql_error());
  $ile =  mysql_num_rows($lista2x);
  
  if($ile < 1)
  {
	echo '<tr>';
    echo '<td>Brak akcji wydatkowych!</td>';
    echo '</tr>';
  }
  else
  {
  $listax = mysql_query("SELECT * FROM `zgloszenia` WHERE od='". $wynik[1] ."' ORDER BY `id` DESC LIMIT 25") or die(mysql_error());
  while ( $row = mysql_fetch_row($listax) ) 
  {
	echo '<tr class="danger">';
    echo '<td><i class="fa fa-user-tie"></i> ' . $row[1] . '</td>';
	echo '<td>' . $row[7] .'</td>';
	echo '<td><b>' . $row[6] . ' <img src="icon.png" width="16" height="16" /></b></td>';
	echo '<td>' . $row[2] . '</td>';
	echo '<td> Odjęto $ </td>';
    echo '</tr>';
	  }
  }
  

	
 
}
?>
</tbody>
</table>
 </div>
<?php } ?>
</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>