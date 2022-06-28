<?php
header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Panel vipa | SamoŻycie |</title>
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

if($wynik['ranga'] < 1){
		header("Location: index.php");
}
?>


<div class="main-content">
	
	<div class="header">
		<div class="header-big">Panel VIPa</div>
		<div class="header-small">sieam mordzix, co tam</div>
	</div>

	<div class="przelew">
	
<div class="title"> Panel VIp'a - Edytuj Kolor</div>
<?php 
	
		if($_POST['zmien'] == 1)
	{
		$zapytanie = mysql_query("SELECT * FROM user WHERE login='".$_SESSION['login']."'"); 
		$wynik = mysql_fetch_array($zapytanie);
		
		$kolor = htmlspecialchars($_POST['kolor']);

			$zmiana = "UPDATE user SET kolor='". $kolor ."' WHERE login='". $_SESSION['login'] ."'";
			mysql_query($zmiana) or die(mysql_error());
		
			echo 'Zaktualizowano!';
			header("Location: panel_vip.php");
		}
	?>
	<form action="panel_vip.php" method="post">
		 <div class="alert alert-danger"> Kolor należy podać w "NazwaKoloru/HEX/RGB"</div>
		<div class="form-group">
			<label for="kolor">Kolor Przelewów i Rankingu (Standardowo: #FBFF82)</label>
			<input type="text" class="form-control" id="kolor" name="kolor" value="<?php echo $wynik[9]; ?>">
		</div>
		
		<input type="hidden" value="1" name="zmien"><button type="submit" name="submit" class="btn btn-form">Zmień</button>

</form>

<div class="title">Panel VIP'a - Zmień Avatar</div>
	<?php
			if($_POST['zavatar'] == 1)
	{
			$avatar = htmlspecialchars($_POST['avatar']);

			$zmianaav = "UPDATE user SET avatar='". $avatar ."' WHERE login='". $_SESSION['login'] ."'";
			mysql_query($zmianaav) or die(mysql_error());
			
			echo 'Zaktualizowano!';
			header("Location: panel_vip.php");
		}
	?>
		<form action="panel_vip.php" method="post">
		<div class="form-group">
			<label for="Avatar">Link do Avatara</label>
			<input type="text" class="form-control" id="avatar" name="avatar" value="<?php echo $wynik[10]; ?>">
		</div>
		<input type="hidden" value="1" name="zavatar"><button type="submit" name="submit" class="btn btn-form">Zmień AVATAR</button>
	</form>


<div class="title"> Panel VIP'a - Wyslij wiadomość</div>
<?php
if($_POST['check'] == 1)
	{
		$do = $_POST['do'];

		$tresc = "<b>" . nl2br($_POST['tresc']) . "</b>";
		$od = $_SESSION['login'];
		$data = date("Y-m-d H:i");
		$dodaj = "INSERT INTO wiadomosc VALUES (NULL, '$tresc', '$do', '$od', '$data', '0')";
		mysql_query($dodaj) or die(mysql_error());
		
		echo 'Wysłano!';
		
	}?>
	<form action="panel_vip.php" method="post">
		<div class="form-group">
			<label for="exampleInputEmail1">Treść:</label>
			<textarea class="form-control" name="tresc"></textarea>
		</div>

		<div class="form-group">
			<label for="exampleInputHaslo">Login odbiorcy</label>
			<select class="form-control" name="do">
			<?php
			$lista8 = mysql_query("SELECT * FROM `user` ORDER BY `login` ASC") or die(mysql_error());
			$ile8 =  mysql_num_rows($lista8);
  
			while ( $row7 = mysql_fetch_row($lista8) ) 
			{
				echo '<option value="' . $row7[1] . '">' . $row7[1] . '</option>';
			}
  ?>
			</select>
		</div>
	
		<input type="hidden" value="1" name="check"><button type="submit" name="submit" class="btn btn-form">Wyślij</button>
</form>
</div>

			<div class="title">Panel VIP'a - Wysyłane Wiadomości</div>
  <div class="tablediv">

  <table class="table">
  <thead>
    <tr>
	  <th>DO</th>
	  <th>TREŚĆ</th>
	  <th>ODCZYTANE</th>
    </tr>
  </thead>
  <tbody>
  <?php
			 $na_stronie = 10; // ilość wpisów na 1 stronie

	$page = mysql_query("SELECT COUNT(id) FROM `wiadomosc` WHERE od='". $_SESSION['login'] ."'") or die(mysql_error());
    $a = mysql_fetch_row($page);
    $liczba_wpisow = $a[0];
    $liczba_stron = ceil($liczba_wpisow / $na_stronie);

    if (isset($_GET['strona'])) {
        if ($_GET['strona'] < 1 || $_GET['strona'] > $liczba_stron) {
            $strona = 1;
        } else {
            $strona = $_GET['strona'];
        }

    } else {
        $strona = 1;
    }

    $od = $na_stronie * ($strona - 1);
			
			$listaw = mysql_query("SELECT * FROM `wiadomosc` WHERE od='". $_SESSION['login'] ."' ORDER BY `data` DESC LIMIT $od , $na_stronie") or die(mysql_error());
			$ilew = mysql_num_rows($listaw);
			
			while ( $row2 = mysql_fetch_row($listaw) ) 
			{
				echo '<tr>';
				echo '<td><span class="lg-c">'. $row2[2] .'</span></td>';
				echo '<td>'. $row2[1] .'</td>';
				if($row2[5]==1)
				{
					echo '<td> <span class="lg-c"> TAK </span> </td>';
				}
				else
				{
					echo '<td> <span class="lg-c"> NIE </span> </td>';
				}
				
				echo '</tr>';
			}
  ?>
  
  </tbody>
</table>
</div>
<?php
if ($liczba_wpisow > $na_stronie) {
        $poprzednia = $strona - 1;
        $nastepna = $strona + 1;
        echo '<ul class="pager">';
        if ($poprzednia > 0) {

            echo '<li class="previous"><a href="panel_vip.php?strona=' . $poprzednia . '">&larr; Poprzednia strona</a></li>';
        }

        if ($nastepna <= $liczba_stron) {
            echo '<li class="next"><a href="panel_vip.php?strona=' . $nastepna . '">Następna strona &rarr;</a></li>';

        }
        echo '</ul>';
    }

    ?>
	
</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>