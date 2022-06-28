<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Zakup VIP'a | SamoŻycie |</title>
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
		<div class="header-big">SZH - Kup VIPa</div>
		<div class="header-small">Tutaj możesz kupić konto PREMIUM od SZH!</div>
	</div>


<?php
	$zapytaniev = mysql_query("SELECT * FROM admin"); 
	$wynikv = mysql_fetch_array($zapytaniev);

	if($wynikv[8]==0)
{?>

  <div class="title"> Mozliwosc zakupu wyłączona ): </div>
  
<?php }
else
{ ?>

  <div class="title">Zakup Konto VIP</div>
  <div class="przelew">
    <?php
					$zapytaniezakup = mysql_query("SELECT * FROM admin"); 
				$zakup = mysql_fetch_array($zapytaniezakup); 
 

		if($_POST['zakupvip'] == 1)
		{
			if($_POST['vip'])
			{
				$zapytaniezakup = mysql_query("SELECT * FROM admin"); 
				$zakup = mysql_fetch_array($zapytaniezakup); 

				$ile = htmlspecialchars($_POST['vip']);
				$cenavip = $ile * $zakup[6];
				
				$uzytkownik = htmlspecialchars($_SESSION['login']);
				$sprawdz = mysql_query("SELECT * FROM premium WHERE login='". $uzytkownik ."'");
				$sprawdz2 = mysql_query("SELECT * FROM premium"); 
				
				$userv = mysql_query("SELECT * FROM `user` WHERE login='". $_SESSION['login'] ."'") or die(mysql_error());
				$user5 = mysql_fetch_array($userv); 
				

				if($ile < 1)
					{
						echo '<div class="alert alert-danger">No soreczki mordeczko - nie uda Ci się! ):</div>';
					}
					
					else
						
				if($user5[7] < $cenavip)
					{
						echo '<div class="alert alert-danger">No soreczki mordeczko - nie uda Ci się bo nie masz tyle kasy! ):</div>';
					}

				else
					
				if($user5[4]==1)
					{
						echo '<div class="alert alert-danger">Posiadasz już vipa!</div>';
					}
				else
					
				if(mysql_num_rows($sprawdz2)==6)
					{
						echo '<div class="alert alert-danger">Jest już za dużo vipów ):</div>';
					}
				else
					
					{
						$zapytanie2 = mysql_query("SELECT * FROM user WHERE login='". $_SESSION['login'] ."'"); 
						$user1 = mysql_fetch_array($zapytanie2); 
						$zapytanie5 = mysql_query("SELECT * FROM user WHERE login='Piotrek.Kietlinski'"); 
						$user6 = mysql_fetch_array($zapytanie5); 

						$cenavip = $ile * $zakup[6];
						$punktyfirma = $user6['punkty'] + $cenavip;
						$punktynew = $user1['punkty'] - $cenavip;
						
						mysql_query("INSERT INTO zgloszenia VALUES(NULL, 'Piotrek.Kietlinski', NOW(), '', '". $uzytkownik ."', '-', '" . $cenavip ."', 'Zakup Konta VIP', '1', '1', '')");
						mysql_query("INSERT INTO `premium` VALUES(NULL, '" . $_SESSION['login'] . "', NOW(), '2 TYGODNIE')") or die(mysql_error());
						mysql_query("INSERT INTO wiadomosc VALUES (NULL, 'Gratulacje! Od teraz posiadasz konto <span class=tekst>Premium</span>! Pamiętaj, że wygasa ono za 2 tygodnie!', '". $uzytkownik ."', 'SZH', NOW(), '0')");
						
						
						$aktualizujusera = "UPDATE user SET  punkty='". $punktynew . "' WHERE login='". $uzytkownik ."'";
						mysql_query($aktualizujusera) or die(mysql_error());
						$aktualizujuseravip = "UPDATE user SET ranga=1 WHERE login='". $uzytkownik ."'";
						mysql_query($aktualizujuseravip) or die(mysql_error());
						$aktualizujusera2 = "UPDATE user SET  punkty='". $punktyfirma . "' WHERE login='Piotrek.Kietlinski'";
						mysql_query($aktualizujusera2) or die(mysql_error());

				
						echo '<div class="alert alert-success"> Gratulujemy! Od teraz jesteś VIPem!</div>';
					}
			}
			else
			{
				echo '<div class="alert alert-danger">Nie uzupełniono wszystkich pól!</div>';
			}
			
		}
			?>
			
			<div class="alert alert-danger">Pamiętaj, że tylko 5 osób może posiadać VIPa!</div>
			
	<form method="post">
		<div class="form-group">
			<label for="exampleInputVip">Wybierz dostępne opcje:</label>
			<select class="form-control" name="vip">
			<option value="1">VIP 2 TYGODNIE | <?php echo $zakup[6]; ?>IK |</option>
			</select>	
		</div>
		<input type="hidden" name="zakupvip" value="1"><button type="submit" name="submit" class="btn btn-form">Kup VIPa!</button>

	</form>
	
  </div>


<?php } ?>

</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>