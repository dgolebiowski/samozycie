<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Firma - Premium | SamoŻycie |</title>
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

$firmapremium5 = mysql_query("SELECT * FROM `admin`");
$firmapremium = mysql_fetch_array($firmapremium5);
$premium = mysql_query("SELECT * FROM user WHERE login='". $_SESSION['login'] ."'");
$wynik3 = mysql_fetch_array($premium);

if($wynik['firma']!==$firmapremium[4])
{
    header("Location: index.php");
}
?>

<div class="main-content">
	
	<div class="header">
		<div class="header-big">Panel Firmy - Premium</div>
		<div class="header-small">Panel firmy SZH</div>
	</div>
	
<div class="przelew">

<div class="title">Dodaj VIP'a</div>
  
  <?php

		if($_POST['vipdodaj'] == 1)
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
						mysql_query("INSERT INTO wiadomosc VALUES (NULL, 'Gratulacje! Od teraz posiadasz konto <span class=tekst>Premium</span>! Pamiętaj, że wygasa ono za 2 tygodnie!', '". $uzytkownikd ."', 'System', NOW(), '0')");
						mysql_query("INSERT INTO premium VALUES (". $uzytkownikd .", 'NOW()', '2 Tygodnie od zakupu', '#fbff82', '')");
						
						$aktualizujvip = "UPDATE user SET ranga='1' WHERE login='" . $uzytkownikd ."'";
						mysql_query($aktualizujvip) or die(mysql_error());
					
					echo '<span class="tekst">Dodano VIPa!</span>';
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
			
			$lista2 = mysql_query("SELECT * FROM `user` WHERE ranga=0 AND login!='$login' ORDER BY `login` ASC") or die(mysql_error());
			$ile2 = mysql_num_rows($lista2);
			
			while ( $row2 = mysql_fetch_row($lista2) ) 
			{
				echo '<option value="' . $row2[1] . '">' . $row2[1] . ' - '. $row2[8] .'</option>';
			}
  ?>
			</select>
		</div>
		
		<input type="hidden" name="vipdodaj" value="1"><button type="submit" name="submit" class="btn btn-form">Dodaj VIPa</button>
	
	</form>
 

 
  <div class="title">Zabierz VIP'a</div>

  <?php

		if($_POST['vipzabierz'] == 1)
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
						mysql_query("INSERT INTO wiadomosc VALUES (NULL, 'Przykro nam ): Niestety ale ważność twojego <span class=tekst>konta premium</span> wygasła i musimy ci je zabrać ): Od teraz jesteś znowu zwykłym użytkownikiem ):', '". $uzytkownikw ."', 'System', NOW(), '0')");
						mysql_query("DELETE from premium WHERE login='".$uzytkownikw ."'");
						
						$aktualizujvip2 = "UPDATE user SET ranga='0' WHERE login='" . $uzytkownikw ."'";
						mysql_query($aktualizujvip2) or die(mysql_error());
					
					echo '<span class="tekst">Zabrano VIPa!</span>';
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
			
			$lista1 = mysql_query("SELECT * FROM `user` WHERE ranga='1' AND login!='$login' ORDER BY `login` ASC") or die(mysql_error());
			$ile1 = mysql_num_rows($lista1);
			
				
			while ( $row1 = mysql_fetch_row($lista1) ) 
			{
				echo '<option value="' . $row1[1] . '">' . $row1[1] . ' - '. $row1[8] .'</option>';
			}
  ?>
			</select>
		</div>
		
		<input type="hidden" name="vipzabierz" value="1"><button type="submit" name="submit" class="btn btn-form">Zabierz VIPa</button>

	</form>

</div>

</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>