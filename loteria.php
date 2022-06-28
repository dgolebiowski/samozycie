<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Loteria | SamoŻycie |</title>
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
		<div class="header-big">Loteria</div>
		<div class="header-small">Superaśna Loteria - Jedna z firm projektu!</div>
	</div>
	
	<div class="title"> Informacje </div>
  <?php
	$zapytanielot = mysql_query("SELECT * FROM loteria"); 
    $loteria = mysql_fetch_array($zapytanielot); 
	
	
		echo 'Pula nagród: <span class="lg-c">'.$loteria['pula'] . ' <img src="icon.png" width="16" height="16" /></span><br>';
		echo 'Cena kuponu: <span class="lg-c">' . $loteria['cena'] . ' <img src="icon.png" width="16" height="16" /></span><br>';
		echo 'Data losowania:: <span class="lg-c">' . $loteria['data'] . '</span><br>';
		echo 'Ostatni zwycięzca: <span class="lg-c"><i class="fa fa-star"></i>' . $loteria['ostatni'] . '</span><br>';
	 ?>
<?php
	$zapytanies = mysql_query("SELECT * FROM loteria"); 
	$wynik = mysql_fetch_array($zapytanies);
	
	if($wynik['stan'] == 0)
{?>
	<div class="title"> Loteria jest obecnie wyłączona ): </div>
<?php }
else
{ ?>
	<div class="title"> Kup Losy </div>
<div class="przelew">
	<?php
		if($_POST['losuj'] == 1)
		{
			if($_POST['kupon'])
			{
				$zapytanielot = mysql_query("SELECT * FROM loteria"); 
				$loteria = mysql_fetch_array($zapytanielot); 

				$prezes = Fernando_Riviera;
				$kupon = htmlspecialchars($_POST['kupon']);
				$punktylos = $kupon * $loteria['cena'];
				
				$uzytkownik = htmlspecialchars($_SESSION['login']);
				$sprawdz = mysql_query("SELECT * FROM loteria_kupon WHERE login='". $uzytkownik ."'"); 
				
				$user = mysql_query("SELECT * FROM `user` WHERE login='" . $_SESSION['login'] ."'") or die(mysql_error());
				$daj = mysql_fetch_row($user);

				if($kupon < 1)
					{
						echo '<div class="alert alert-danger">No soreczki mordeczko - nie uda Ci się! ):</div>';
					}
					
					else
						
				if($daj[7] < $punktylos)
					{
						echo '<div class="alert alert-danger">No soreczki mordeczko - nie uda Ci się! ):</div>';
					}

				else
					
				if($uzytkownik == 'Fernando_Riviera')
					{
						echo '<div class="alert alert-danger">Błąd użytkownika - Jesteś organizatorem - nie możesz kupić losu!</div>';
					}
					
				else
					{
						$uzytkownik = htmlspecialchars($_SESSION['login']);
						
						$zapytanie2 = mysql_query("SELECT * FROM user WHERE login='". $_SESSION['login'] ."'"); 
						$user1 = mysql_fetch_array($zapytanie2); 

						$punktylos = $kupon * $loteria['cena'];
						$punktynew = $user1['punkty'] - $punktylos;
						
						mysql_query("INSERT INTO loteria_kupon VALUES(NULL, '" . $uzytkownik . "', '". $kupon ."','". $punktylos ."', NOW())");
						mysql_query("INSERT INTO zgloszenia VALUES(NULL, '". $prezes ."', NOW(), '', '". $uzytkownik ."', '-', '" . $punktylos ."', 'Loteria', '1', '1', '')");

						
						$aktualizujusera = "UPDATE user SET  punkty='". $punktynew . "' WHERE login='". $uzytkownik ."'";
						mysql_query($aktualizujusera) or die(mysql_error());
						
						$zapytanie3 = mysql_query("SELECT * FROM user WHERE login='". $prezes ."'"); 
						$user2 = mysql_fetch_array($zapytanie3); 
						
						$punktyfirma = $user2['punkty'] + $punktylos;
						$aktualizujusera2 = "UPDATE user SET  punkty='". $punktyfirma . "' WHERE login='". $prezes ."'";
						mysql_query($aktualizujusera2) or die(mysql_error());
				
					header("Location: loteria.php");
					}
			}
			else
			{
				echo '<div class="alert alert-danger">Nie uzupełniono wszystkich pól!</div>';
			}
			
		}
			?>
			
	<form method="post">
		<div class="form-group">
			<label for="exampleInputLosy">Wybierz ile losów chcesz kupic:</label>
			<select class="form-control" name="kupon">
			<option value="1">1 LOS</option>
			<option value="BRAK">CHWILOWO BRAK INNYCH OPCJI!</option>
			</select>	
		</div>
		<input type="hidden" name="losuj" value="1"><button type="submit" name="submit" class="btn btn-form">Kup Los!</button>

	</form>

	<div class="title"> Lista Uczestników Loterii </div>
	
<div class="tablediv">
	<table class="table">
  <thead>
    <tr>
	  <th>NR</th>
      <th>UŻYTKOWNIK</th>
	  <th>ILOŚĆ LOSÓW</th>
	  <th>DATA ZAKUPU</th>
    </tr>
  </thead>
  <tbody>
 <?php
   $na_stronie = 20; // ilość wpisów na 1 stronie
  
	$page = mysql_query("SELECT COUNT(id) FROM `loteria_kupon`") or die(mysql_error());
	$a = mysql_fetch_row($page);
	$liczba_wpisow = $a[0];
	$liczba_stron = ceil($liczba_wpisow / $na_stronie);
	
	if (isset($_GET['strona'])) 
	{
        if ($_GET['strona'] < 1 || $_GET['strona'] > $liczba_stron) $strona = 1;
        else $strona = $_GET['strona'];
    }
	else $strona = 1;

	
	$zapytanieloteria = mysql_query("SELECT * FROM `loteria_kupon`");
	$kupony = mysql_fetch_array($zapytanieloteria);
	$lp=0;
	
	$od = $na_stronie * ($strona - 1);
	$listakuponow = mysql_query("SELECT * FROM `loteria_kupon` ORDER BY `id` ASC LIMIT $od, $na_stronie") or die(mysql_error());
	$ile =  mysql_num_rows($lista2);
	
	
		 while ( $row = mysql_fetch_row($listakuponow) )
		 {	 $lp++;		
	 
					echo '<tr>';
					echo '<td>'. $row[0] .'.</td>';
					echo '<td><i class="fa fa-user-circle"></i><span class="tekst"> '. $row[1] .'</span></td>';
					echo '<td><i class="fa fa-ticket-alt"></i> '. $row[2] .'</td>';
					echo '<td>'. $row[4] .'</td>';
					}	
					?>
					
  </tbody>
  
</table>
</div>
<?php
if ($liczba_wpisow > $na_stronie) 
	{
        $poprzednia = $strona - 1;
        $nastepna = $strona + 1;
		echo '<ul class="pager">';
        if ($poprzednia > 0)
		{
			
			echo '<li class="previous"><a href="loteria.php?strona='.$poprzednia.'">&larr; Poprzednia strona</a></li>';
        }
        
        if ($nastepna <= $liczba_stron) 
		{
			echo '<li class="next"><a href="loteria.php?strona='.$nastepna.'">Następna strona &rarr;</a></li>';
			
        }
		echo '</ul>';
	}
  
?>

				</div>
				</div>
		
</div>
<?php } ?>

</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>