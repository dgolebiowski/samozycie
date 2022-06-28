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


if($wynik['firma']!=='P&C')
{
	header("Location: index.php");
}

?>

<div class="main-content">
	
	<div class="header">
		<div class="header-big"> P&C - Edycja </div>
		<div class="header-small">Tutaj możesz edytować swoją firmę.</div>
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

	$pobierz = "SELECT * FROM pic";
	$wyszlo = mysql_query($pobierz) or die(mysql_error());
	$item = mysql_fetch_array($wyszlo); 
		
		
		if($_POST['check'] == 1)
	{
		$pula = htmlspecialchars($_POST['pula']);
		$data = htmlspecialchars($_POST['data']);
		$cena = htmlspecialchars($_POST['cena']);
		$stan = htmlspecialchars($_POST['stan']);
		$pytanie = htmlspecialchars($_POST['pytanie']);
		$ostatni = htmlspecialchars($_POST['ostatni']);

			$zmianak = "UPDATE pic SET pula='" . $pula ."', data='" . $data . "', cena='" . $cena . "', ostatni='" . $ostatni ."', pytanie='". $pytanie ."', stan='". $stan ."'";
			mysql_query($zmianak) or die(mysql_error());
		
			$_SESSION["success_add"] = 'Zaktualizowano!';
			header("Location: /pic_edytuj.php");
            die();
		}
	?>
	<form action="pic_edytuj.php" method="post">
		
		<div class="form-group">
			<label for="PIC">1 - Włączona | 0 - Wyłączona</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="stan" value="<?php echo $item[4]; ?>">
		</div>
		
		<div class="form-group">
			<label for="PIC">Ile do wygrania</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="pula" value="<?php echo $item[0]; ?>">
		</div>
		
		<div class="form-group">
			<label for="PIC">Koszt udzialu</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="cena" value="<?php echo $item[2]; ?>">
		</div>
		
		<div class="form-group">
			<label for="PIC">Pytanie konkursowe</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="pytanie" value="<?php echo $item[5]; ?>">
		</div>
		
		<div class="form-group">
			<label for="PIC">Data Losowania</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="data" value="<?php echo $item[1]; ?>">
		</div>
		
		<div class="form-group">
			<label for="PIC">Ostatni Zwycięzca</label>
			<input type="text" class="form-control" id="exampleInputRozmiar" name="ostatni" value="<?php echo $item[3]; ?>">
		</div>
		
		<input type="hidden" value="1" name="check"><button type="submit" name="submit" class="btn btn-form">Zmień</button>

</form>
</div>

<div class="title">Lista Uczestników Konkursu</div>

<div class="tablediv">			
	<table class="table">
  <thead>
    <tr>
	  <th>NR</th>
      <th>UŻYTKOWNIK</th>
	  <th>ODPOWIEDZ</th>
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
					echo '<td><i class="fa fa-user-circle"></i><span class="lg-b"> '. $row[1] .'</span></td>';
					echo '<td><span class="lg-b">'. $row[3] .'</span></td>';
					echo '<td>'. $row[4] .'</td>';
					echo '</tr>';
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
			
			echo '<li class="previous"><a href="pic_edytuj.php?strona='.$poprzednia.'">&larr; Poprzednia strona</a></li>';
        }
        
        if ($nastepna <= $liczba_stron) 
		{
			echo '<li class="next"><a href="pic_edytuj.php?strona='.$nastepna.'">Następna strona &rarr;</a></li>';
			
        }
		echo '</ul>';
	}
  
?>

			<div class="title">Panel Konkursów - Czyść Tabelke</div>
  <div class="przelew">
  
  <div class="alert alert-danger"> Klikać tylko po zakończonym konkursie! </div>
	<?php
			if($_POST['czysc'] == 1)
	{
			header("Location: pic_czysc.php");
			
		}
	?>
		<form action="pic_edytuj.php" method="post">
	<input type="hidden" value="1" name="czysc"><button type="submit" name="submit" class="btn btn-form">Wyczyść Tabelke</button>
	</form>
</div>

</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>