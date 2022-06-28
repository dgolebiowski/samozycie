<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Panel Firmy | SamoŻycie |</title>
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
		<div class="header-big">Panel Firmy - Edytowanie</div>
		<div class="header-small">Tutaj mozesz edytowac swoja firme.</div>
	</div>
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
	
		$pobierz = "SELECT * FROM ekoperliga WHERE id='" . $_GET['id'] . "'";
		$wyszlo = mysql_query($pobierz) or die(mysql_error());
		$item = mysql_fetch_array($wyszlo); 
		$item2 = mysql_fetch_array($dostepfirmy); 
		
	if($wynik['ekoperleague'] != $item['1'])
{
	$_SESSION["message"] = 'Nie jestes liderem tej firmy!</div>';
	 header("Location: /druzyna_panel.php?id=". $item[0] ."");
     die();
}

	else
	if($_GET['id'])
	{
		
		$pobierz = "SELECT * FROM ekoperliga WHERE id='" . $_GET['id'] . "'";
		$wyszlo = mysql_query($pobierz) or die(mysql_error());
		$item = mysql_fetch_array($wyszlo); 
		
		if($_POST['zmien'] == 1)
	{
		$nazwa = htmlspecialchars($_POST['nazwa']);
		$opis = htmlspecialchars($_POST['opis']);
		$lider = htmlspecialchars($_POST['lider']);
		$logo = htmlspecialchars($_POST['logo']);
		$id = $_POST['id'];

		$dodaj = "UPDATE firmy SET opis='" . $opis . "', logo='". $logo ."' WHERE id='". $_GET['id'] ."'";
			mysql_query($dodaj) or die(mysql_error());
		
			$_SESSION["success_add"] = 'Zaktualizowano!';
			header("Location: /druzyna_panel.php?id=". $item[0] .".php");
			die();
		}
	?>
	<form action="druzyna_panel.php?id=<?php echo $item[0]; ?>" method="post">
		
		<div class="form-group">
			<label for="exampleInputEmail1">Nazwa druzyny</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="nazwa" value="<?php echo $item['1']; ?>" readonly>
		</div>

		<div class="form-group">
			<label for="exampleInputHaslo">Informacje o druzynie</label>
			<textarea class="form-control" name="opis" ><?php $item[2] = str_replace('<br />', '', $item[2]);
			echo $item[2]; ?></textarea>
		</div>
		
		<div class="form-group">
			<label for="exampleInputHaslo">Lider</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="lider" value="<?php echo $item[3]; ?>" readonly>
		</div>

		<div class="form-group">
			<label for="exampleInputHaslo">Logo (Link do grafiki)</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="logo" value="<?php echo $item[5]; ?>">
		</div>
		
		<input type="hidden" value="1" name="zmien"><button type="submit" name="submit" class="btn btn-form">Zmien</button>

</form>
	<?php } ?>
	
<div class="header">
		<div class="header-big">Panel Druzyny - Team</div>
		<div class="header-small">Tutaj mozesz dodaj/wyrzucic osoby ze swojej druzyny.</div>
	</div>
	

  <div class="title">Dodaj uzytkownika do druzyny</div>
<div class="przelew">
	 <?php
$zapytaniedruzyna= mysql_query("SELECT * FROM `ekoperliga` WHERE nazwa='" . $wynik['ekoperleague'] ."'"); 
$druzyna = mysql_fetch_array($zapytaniedruzyna);

		if($_POST['druzynadodaj'] == 1)
		{
			if($_POST['uzytkownikdodaj'])
			{
				$uzytkownikd = htmlspecialchars($_POST['uzytkownikdodaj']);
				
				$sprawdz = mysql_query("SELECT * FROM user WHERE login='$uzytkownikd'"); 

				if(mysql_num_rows($sprawdz)==0)
					{
						echo '<div class="alert alert-danger">Uzytkownik nie istnieje!</div>';
					}
					
				else
					{
						mysql_query("INSERT INTO wiadomosc VALUES (NULL, 'Gratulacje! Od teraz pracujesz nalezys do druzyny <b>". $druzyna['nazwa'] ."</b>! Powodzenia!', '". $uzytkownikd ."', 'System', NOW(), '0')");
						
						$aktualizujfirme1 = "UPDATE user SET ekoperleague='". $druzyna['nazwa'] . "' WHERE login='" . $uzytkownikd ."'";
						mysql_query($aktualizujfirme1) or die(mysql_error());
					
					echo '<span class="lg-c">Dodano do druzyny!</span>';
					}
			}

		}
	
	?>
  <form method="post">
		<div class="form-group">
			<label for="exampleInputLogin">Login uzytkownika:</label>
			<select class="form-control" name="uzytkownikdodaj">
			<option value="-"> Wybierz uzytkownika! </option>
			<?php
			$login = $_SESSION['login'];
			
			$lista2 = mysql_query("SELECT * FROM `user` WHERE ranga=0 AND login!='$login' AND ekoperleague='Brak Druzyny' ORDER BY `login` ASC") or die(mysql_error());
			$ile2 = mysql_num_rows($lista2);
			
			while ( $row2 = mysql_fetch_row($lista2) ) 
			{
				echo '<option value="' . $row2[1] . '">' . $row2[1] . '</option>';
			}
  ?>
			</select>
		</div>
		
		<input type="hidden" name="druzynadodaj" value="1"><button type="submit" name="submit" class="btn btn-form">Dodaj do druzyny!</button>
	
	</form>
</div>

 <div class="title">Wyrzuc uzytkownika z druzyny</div>
<div class="przelew">
<?php

$zapytaniedruzyna= mysql_query("SELECT * FROM `ekoperliga` WHERE nazwa='" . $wynik['ekoperleague'] ."'"); 
$druzyna = mysql_fetch_array($zapytaniedruzyna);

		if($_POST['druzynawyrzuc'] == 1)
		{
			if($_POST['uzytkownikwyrzuc'])
			{
				$uzytkownikw = htmlspecialchars($_POST['uzytkownikwyrzuc']);
				
				$sprawdz = mysql_query("SELECT * FROM user WHERE login='$uzytkownikw'"); 

				if(mysql_num_rows($sprawdz)==0)
					{
						echo '<div class="alert alert-danger">Uzytkownik nie istnieje!</div>';
					}
					
				else
					{
						mysql_query("INSERT INTO wiadomosc VALUES (NULL, 'Przykro nam ): Niestety lider druzyny <b>". $druzyna['nazwa'] ."</b> wyrzucil Cie! ):', '". $uzytkownikw ."', 'System', NOW(), '0')");
						
						$aktualizujfirme2 = "UPDATE user SET ekoperleague='Brak Druzyny' WHERE login='" . $uzytkownikw ."'";
						mysql_query($aktualizujfirme2) or die(mysql_error());
					
					echo '<span class="lg-c">Wyrzucono z druzyny!</span>';
					}
			}

		}
	
	?>
  <form method="post">
		<div class="form-group">
			<label for="exampleInputLogin">Login uzytkownika:</label>
			<select class="form-control" name="uzytkownikwyrzuc">
			<option value="-"> Wybierz uzytkownika! </option>
			<?php
			
			$lista1 = mysql_query("SELECT * FROM `user` WHERE ekoperleague='". $druzyna['nazwa'] ."' AND login!='$login' AND login!='". $druzyna['lider'] ."' ORDER BY `login` ASC") or die(mysql_error());
			$ile1 = mysql_num_rows($lista1);
			
				
			while ( $row1 = mysql_fetch_row($lista1) ) 
			{
				echo '<option value="' . $row1[1] . '">' . $row1[1] . '</option>';
			}
  ?>
			</select>
		</div>
		
		<input type="hidden" name="druzynawyrzuc" value="1"><button type="submit" name="submit" class="btn btn-form">Wyrzuc z firmy!</button>

	</form>
  </div>	
	
</div>
<?php>
}
else
{
	  header("Location: index.php");
}
	?>
</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>