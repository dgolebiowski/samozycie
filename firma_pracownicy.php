<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Firma - Pracownicy | SamoŻycie |</title>
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
		<div class="header-big">Panel Firmy - Pracownicy</div>
		<div class="header-small">Tutaj możesz dodaj/wyrzucic osoby ze swojej firmy.</div>
	</div>
	

  <div class="title">Dodaj użytkownika do firmy</div>
<div class="przelew">
	 <?php
$zapytaniefirmy= mysql_query("SELECT * FROM `firmy` WHERE nazwa='" . $wynik['firma'] ."'"); 
$firma = mysql_fetch_array($zapytaniefirmy);

		if($_POST['firmadodaj'] == 1)
		{
			if($_POST['uzytkownikdodaj'])
			{
				$uzytkownikd = htmlspecialchars($_POST['uzytkownikdodaj']);
				
				$sprawdz = mysql_query("SELECT * FROM user WHERE login='$uzytkownikd'"); 

				if(mysql_num_rows($sprawdz)==0)
					{
						echo '<div class="alert alert-danger">Użytkownik nie istnieje!</div>';
					}
					
				else
					{
						mysql_query("INSERT INTO wiadomosc VALUES (NULL, 'Gratulacje! Od teraz pracujesz w firmie <b>". $firma['nazwa'] ."</b>! Powodzenia w nowej pracy!', '". $uzytkownikd ."', 'System', NOW(), '0')");
						
						$aktualizujfirme1 = "UPDATE user SET firma='". $firma['nazwa'] . "' WHERE login='" . $uzytkownikd ."'";
						mysql_query($aktualizujfirme1) or die(mysql_error());
					
					echo '<span class="lg-c">Dodano do firmy!</span>';
					}
			}

		}
	
	?>
  <form method="post">
		<div class="form-group">
			<label for="exampleInputLogin">Login użytkownika:</label>
			<select class="form-control" name="uzytkownikdodaj">
			<option value="-"> Wybierz użytkownika! </option>
			<?php
			$login = $_SESSION['login'];
			
			$lista2 = mysql_query("SELECT * FROM `user` WHERE ranga=0 AND login!='$login' AND firma='' ORDER BY `login` ASC") or die(mysql_error());
			$ile2 = mysql_num_rows($lista2);
			
			while ( $row2 = mysql_fetch_row($lista2) ) 
			{
				echo '<option value="' . $row2[1] . '">' . $row2[1] . '</option>';
			}
  ?>
			</select>
		</div>
		
		<input type="hidden" name="firmadodaj" value="1"><button type="submit" name="submit" class="btn btn-form">Dodaj do firmy!</button>
	
	</form>
</div>

 <div class="title">Wyrzuc użytkownika z firmy</div>
<div class="przelew">
<?php

$zapytaniefirmy= mysql_query("SELECT * FROM `firmy` WHERE nazwa='" . $wynik['firma'] ."'"); 
$firma = mysql_fetch_array($zapytaniefirmy);

		if($_POST['firmawyrzuc'] == 1)
		{
			if($_POST['uzytkownikwyrzuc'])
			{
				$uzytkownikw = htmlspecialchars($_POST['uzytkownikwyrzuc']);
				
				$sprawdz = mysql_query("SELECT * FROM user WHERE login='$uzytkownikw'"); 

				if(mysql_num_rows($sprawdz)==0)
					{
						echo '<div class="alert alert-danger">Użytkownik nie istnieje!</div>';
					}
					
				else
					{
						mysql_query("INSERT INTO wiadomosc VALUES (NULL, 'Przykro nam ): Niestety firma <b>". $firma['nazwa'] ."</b> zwolniła cię! Od teraz jesteś osobą bezrobotną ):', '". $uzytkownikw ."', 'System', NOW(), '0')");
						
						$aktualizujfirme2 = "UPDATE user SET firma='' WHERE login='" . $uzytkownikw ."'";
						mysql_query($aktualizujfirme2) or die(mysql_error());
					
					echo '<span class="lg-c">Wyrzucono z firmy!</span>';
					}
			}

		}
	
	?>
  <form method="post">
		<div class="form-group">
			<label for="exampleInputLogin">Login użytkownika:</label>
			<select class="form-control" name="uzytkownikwyrzuc">
			<option value="-"> Wybierz użytkownika! </option>
			<?php
			
			$lista1 = mysql_query("SELECT * FROM `user` WHERE firma='". $firma['nazwa'] ."' AND login!='$login' AND login!='". $firma['prezes'] ."' ORDER BY `login` ASC") or die(mysql_error());
			$ile1 = mysql_num_rows($lista1);
			
				
			while ( $row1 = mysql_fetch_row($lista1) ) 
			{
				echo '<option value="' . $row1[1] . '">' . $row1[1] . '</option>';
			}
  ?>
			</select>
		</div>
		
		<input type="hidden" name="firmawyrzuc" value="1"><button type="submit" name="submit" class="btn btn-form">Wyrzuc z firmy!</button>

	</form>
  </div>

<?php }
?>
</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>