<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>P&C | SamoŻycie |</title>
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
		<div class="header-big"> P&C </div>
		<div class="header-small">Superaśne konkursiki - Jedna z firm projektu!</div>
	</div>

<div class="title"> Informacje </div>
<?php
	$zapytaniepic = mysql_query("SELECT * FROM pic"); 
    $pic = mysql_fetch_array($zapytaniepic); 
	
	
		echo 'Pula nagród: <span class="lg-c">'.$pic['pula'] . ' <img src="icon.png" width="16" height="16" /></span><br>';
		echo 'Koszt udziału: <span class="lg-c">' . $pic['cena'] . ' <img src="icon.png" width="16" height="16" /></span><br>';
		echo 'Data rozstrzygnięcia konkursu: <span class="lg-c">' . $pic['data'] . '</span><br>';
		echo 'Ostatni zwycięzca: <span class="lg-c"><i class="fa fa-star"></i>' . $pic['ostatni'] . '</span><br>';
	 ?>
	 
	 
<?php
	$zapytanies = mysql_query("SELECT * FROM pic"); 
	$wynik = mysql_fetch_array($zapytanies);
	
	if($wynik['stan'] == 0)
{?>
<div class="title"> Aktualnie nie ma żadnego konkursu ): </div>

<?php }
else
{ ?>
  <div class="title">Wez udział w konkursie!</div>
 <div class="przelew">
	 <?php
                    if(isset($_SESSION['success_add'])){
                        echo $_SESSION['success_add'];
                        unset($_SESSION['success_add']);
                    }
                    if(isset($_SESSION['message'])){
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }
					?>
    <?php
		if($_POST['konkurs'] == 1)
		{
			if($_POST['pytanie'])
			{
				$zapytaniepic = mysql_query("SELECT * FROM pic"); 
				$pic = mysql_fetch_array($zapytaniepic); 
				
				$pytanie = htmlspecialchars($_POST['pytanie']);
				$kupon = htmlspecialchars($_POST['kupon']);
				$punktylos = $kupon * $pic['cena'];
				
				$uzytkownik = htmlspecialchars($_SESSION['login']);
				$sprawdz = mysql_query("SELECT * FROM pic_konkurs WHERE login='". $uzytkownik ."'"); 
				
				$user = mysql_query("SELECT * FROM `user` WHERE login='" . $_SESSION['login'] ."'") or die(mysql_error());
				$daj = mysql_fetch_row($user);

				if($kupon < 1)
					{
						$_SESSION["message"] = '<div class="alert alert-danger">No soreczki mordeczko - nie uda Ci się! ):</div>';
						 header("Location: /pic.php");
                         die();
					}
					
					else
						
				if($daj[7] < $punktylos)
					{
						$_SESSION["message"] = '<div class="alert alert-danger">No soreczki mordeczko - nie uda Ci się! ):</div>';
						header("Location: /pic.php");
                         die();
					}

				else
					
				if(mysql_num_rows($sprawdz)==10)
					{
						$_SESSION["message"] = '<div class="alert alert-danger">Już wziąłeś udział w konkursie ):</div>';
						header("Location: /pic.php");
                         die();
					}
				else
					
				if($wynik['firma']=='P&C')
					{
						$_SESSION["message"] = '<div class="alert alert-danger">Błąd użytkownika - Jesteś organizatorem - nie możesz kupić losu!</div>';
						header("Location: /pic.php");
                         die();
					}
			
				else
					{
						$uzytkownik = htmlspecialchars($_SESSION['login']);
						
						$zapytanie2 = mysql_query("SELECT * FROM user WHERE login='". $_SESSION['login'] ."'"); 
						$user1 = mysql_fetch_array($zapytanie2); 
						
						$punktykon = $kupon * $pic['cena'];
						$punktynew = $user1['punkty'] - $punktykon;
						
						mysql_query("INSERT INTO pic_konkurs VALUES(NULL, '" . $uzytkownik . "', '". $kupon ."','". $pytanie ."', NOW())");
						mysql_query("INSERT INTO zgloszenia VALUES(NULL, 'Peter1234', NOW(), '', '". $uzytkownik ."', '-', '" . $punktykon ."', 'P&C', '1', '1', '')");

						
						$aktualizujusera = "UPDATE user SET  punkty='". $punktynew . "' WHERE login='". $uzytkownik ."'";
						mysql_query($aktualizujusera) or die(mysql_error());
						
						$zapytanie3 = mysql_query("SELECT * FROM user WHERE login='Peter1234'"); 
						$user2 = mysql_fetch_array($zapytanie3); 
						
						$punktyfirma = $user2['punkty'] + $punktykon;
						$aktualizujusera2 = "UPDATE user SET  punkty='". $punktyfirma . "' WHERE login='Peter1234'";
						mysql_query($aktualizujusera2) or die(mysql_error());
				
					$_SESSION['success_add'] = '<div class="alert alert-success">Dziękujemy za zgłoszenie! Powodzenia!</div>';
			        header("Location: /pic.php");
					}
			}
			else
			{
				echo '<div class="alert alert-danger">Nie uzupełniono wszystkich pól!</div>';
			}
			
		}
		
			$pobierz = "SELECT * FROM pic";
			$wyszlo = mysql_query($pobierz) or die(mysql_error());
			$item = mysql_fetch_array($wyszlo); 
		
			?>
			
			
	<form method="post">
		<div class="form-group">
			<label for="pytanie">Pytanie konkursowe:<span class="tekst"> <?php echo $item[5]; ?></span></label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="pytanie">
		</div>
		<div class="form-group">
			Wzięcie udziału w konkursie kosztuje <?php echo $item[2]; ?><img src="icon.png" width="16" height="16" />
<input type="hidden" name="kupon" value="1">
		</div>
		<input type="hidden" name="konkurs" value="1"><button type="submit" name="submit" class="btn btn-form">Biorę udział w konkursie!</button>

	</form>
</div>


			<div class="title">Lista Uczestników Konkursu</div>
<div class="tablediv">
	<table class="table">
  <thead>
    <tr>
	  <th>NR</th>
      <th>UŻYTKOWNIK</th>
	  <th>DATA</th>
    </tr>
  </thead>
  <tbody>
 <?php
   $na_stronie = 20; // ilość wpisów na 1 stronie
  
	$page = mysql_query("SELECT COUNT(id) FROM `pic_konkurs`") or die(mysql_error());
	$a = mysql_fetch_row($page);
	$liczba_wpisow = $a[0];
	$liczba_stron = ceil($liczba_wpisow / $na_stronie);
	
	if (isset($_GET['strona'])) 
	{
        if ($_GET['strona'] < 1 || $_GET['strona'] > $liczba_stron) $strona = 1;
        else $strona = $_GET['strona'];
    }
	else $strona = 1;

	
	$zapytanieloteria = mysql_query("SELECT * FROM `pic_konkurs`");
	$kupony = mysql_fetch_array($zapytanieloteria);
	$lp=0;
	
	$od = $na_stronie * ($strona - 1);
	$listakuponow = mysql_query("SELECT * FROM `pic_konkurs` ORDER BY `id` ASC LIMIT $od, $na_stronie") or die(mysql_error());
	$ile =  mysql_num_rows($lista2);
	
	
		 while ( $row = mysql_fetch_row($listakuponow) )
		 {	 $lp++;		
	 
					echo '<tr>';
					echo '<td>'. $row[0] .'.</td>';
					echo '<td><i class="fa fa-user-circle"></i><span class="tekst"> '. $row[1] .'</span></td>';
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
			
			echo '<li class="previous"><a href="pic.php?strona='.$poprzednia.'">&larr; Poprzednia strona</a></li>';
        }
        
        if ($nastepna <= $liczba_stron) 
		{
			echo '<li class="next"><a href="pic.php?strona='.$nastepna.'">Następna strona &rarr;</a></li>';
			
        }
		echo '</ul>';
	}
  
 } ?>
</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>