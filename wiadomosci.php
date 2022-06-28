<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Wiadomosci | SamoŻycie |</title>
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
		<div class="header-big"> Wiadomości </div>
		<div class="header-small">Tutaj znajdziesz powiadomienia/wiadomości od innych użytkowników i systemu.</div>
	</div>
	
<div class="przelew">
    
<?php
	if($_POST['check'] == 1)
	{
		$id = $_POST['id'];
		mysql_query("UPDATE wiadomosc SET przeczytane='1' WHERE id='$id'");
		
	}
	$akcje = mysql_query("SELECT * FROM user WHERE login='".$_SESSION['login']."'"); 
    $lista = mysql_fetch_array($zapytanie); 
  
  $lista2 = mysql_query("SELECT * FROM `wiadomosc` WHERE do='".$_SESSION['login']."' AND przeczytane='0' ORDER BY `data` DESC") or die(mysql_error());
  $ile = mysql_num_rows($lista2);
  
  if($ile > 0)
  {
  while ( $row = mysql_fetch_row($lista2) ) 
  {
		$usersprawdz = mysql_query("SELECT * FROM user WHERE login='". $row[3] ."'");
		$vip = mysql_fetch_array($usersprawdz);
		
		if($vip['ranga']>=2)
		{
		echo '<span class="lg-c">Wysłano:</span> ' . $row[4] . '<form method="POST">';
		echo '<span class="lg-b">Wiadomość od Administratora:</span>
		<br>'. $row[1] .'';
		}
		else if($vip['ranga']==1)
		{
		echo '<span class="lg-c">Wysłano:</span> ' . $row[4] . '<form method="POST">';
		echo '<span class="header-small">Wiadomość od <img src=vip.gif><span class="lg-c"> '. $row[3] .'</span>:</span>
		<br>'. $row[1] .'';
		}
		else
		{
		echo '<span class="lg-c">Wysłano:</span> ' . $row[4] . '<form method="POST">';
		echo '<span class="header-small">Powiadomienie:</span> '. $row[1] .'';
		}
		
		echo '<br><br><div class="header-small">Jeżeli przeczytałeś powyższą wiadomość kliknij:</div>		
		  <input type="hidden" value="' . $row[0] . '" name="id"><input type="hidden" value="1" name="check"><button type="submit" name="submit" class="btn btn-form btn-xs">Przeczytane</button></form><br>';
		echo '<hr>';
  }
  }
  else
  {
	  echo 'Nie masz żadnych wiadomości';
  }
  
	?>
  

</div>

</div>

</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>