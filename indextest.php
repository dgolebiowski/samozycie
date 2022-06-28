<?php
header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
  <head>
    <title>| SamoZycie |</title>
	<?php include('inc/dane_head.php'); ?>
  </head>
 
<body> 
<?php
include('connect.php');
include('inc/menu.php');

$stan = mysql_query("SELECT * FROM admin"); 
$wyniks	= mysql_fetch_array($stan);

if(empty($_SESSION['login']))
{
	header("Location: login.php");
}
else
	
if($wyniks['stanstrony'] == 0)
{
	header("Location: przerwa.html");
}

?>

<div class="main-content">

	<div class="header">
		<div class="header-big"> Hejkaaa <?php echo $wynik['login']; ?> </div>
		<div class="header-small">Co tam? Jak tam? Jak zdrowie, samopoczucie...?</div>
	</div>
	
<?php
	$zapytanie2 = mysql_query("SELECT * FROM wiadomosc WHERE do='".$_SESSION['login']."' AND przeczytane='0'"); 
		$ile = mysql_num_rows($zapytanie2);
		
	if($ile > 0)
	{
?>
	<div class="wiadomosc">
		<div class="wiadomosc-big"> Masz nowa wiadomosc! </div>
		<div class="wiadomosc-small"><a href="wiadomosci.php">Kliknij tutaj aby ja zobaczyc!</a></div>
	</div>
	
<?php } ?>

	<div class="wykres">
		<div class="title"> Tutaj Wykres</div>
		
<?php 
	
$hajsik = mysql_query("SELECT SUM(punkty) AS total_value5 FROM user WHERE klasa='". $wynik['klasa'] ."'");
$hajsklasowy=mysql_result($hajsik,0,0);


	echo 'xd '. $hajsklasowy .' xd';
?>
	</div>
	
	
<div class="szybkie_p">
		<div class="title"> Hej jestes prezesem firmy :o</div>
		
		<div class="okienko_p"><a href="firma_edytuj.php">
			<div class="image_p"><i class="fa fa-edit"></i></div>
			<div class="user_p"> Edycja </div>
		</a></div>
		
		<div class="okienko_p"><a href="firma_pracownicy.php">
			<div class="image_p"><i class="fa fa-users-cog"></i></div>
			<div class="user_p"> Pracownicy </div>
		</a></div>
		
		<div class="okienko_p"><a href="firma_hajs.php">
			<div class="image_p"><i class="fa fa-dollar-sign"></i></div>
			<div class="user_p"> Hajs </div>
		</a></div>
	
		
		<div class="okienko_p"><a href="firma_przelew.php">
			<div class="image_p"><i class="fa fa-exchange-alt"></i></div>
			<div class="user_p"> Przelew </div>
		</a></div>
		
		
	</div>

		<div class="title"> Ostatnie transakcje</div>
<div class="ostatnie">
<?php
	$lista = mysql_query("SELECT * FROM `zgloszenia` WHERE login='" . $_SESSION['login'] . "' OR od='". $_SESSION['login'] ."' ORDER BY `id` DESC LIMIT 5") or die(mysql_error());
    
	while ($row = mysql_fetch_row($lista)) {

		if($row[1] == $_SESSION['login'])
		{
			$tytul = $row[7];
			echo '<div class="transakcja">';
			echo '<div class="t_left">';
			echo '	<div class="t_title"> '. $row[7] .' </div>';
			echo '	<div class="t_login"><i class="fa fa-user-circle"></i> '. $row[4] .' </div>';
			echo '</div>';
			echo '<div class="t_right">';
			echo '	<div class="t_data"> '. $row[2] .'</div>';
			echo '	<div class="t_money" style="color: green;"> +'. $row[6] .'IK</div>';
			echo '</div>';
			echo '</div>';
		}
		
		else if($row[4] == $_SESSION['login'])
		{
			$tytul = $row[7];
			echo '<div class="transakcja">';
			echo '<div class="t_left">';
			echo '	<div class="t_title"> '. $row[7] .' </div>';
			echo '	<div class="t_login"><i class="fa fa-user-circle"></i> '. $row[1] .' </div>';
			echo '</div>';
			echo '<div class="t_right">';
			echo '	<div class="t_data"> '. $row[2] .'</div>';
			echo '	<div class="t_money" style="color: #6f0808;"> -'. $row[6] .'IK</div>';
			echo '</div>';
			echo '</div>';
		}
	}		
?>

</div>
	
</div>
<?php
include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>