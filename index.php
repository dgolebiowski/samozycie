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
	<div class="header">
	<div class="header-big" style="font-size: 3vh;">Stan konta:</div>
	<div class="header-small" style="color: green; font-size: 3vh; font-weight: 700;"><b><?php echo $wynik['punkty']; ?> IK</b></div>
	</div>
	
	<div class="header">
	<div class="header-big" style="font-size: 3vh;">Podatek:</div>
	<div class="header-small" style="color: green; font-size: 3vh; font-weight: 700;">
<?php 
if($wynik['podatek']==5)
{
	echo '<div class="header-small" style="color: #6f0808; font-size: 3vh; font-weight: 700;"><b>Nie ma cie w projekcie - nie placisz ;3</b></div>';
}
else if($wynik['podatek']==0)
{
	echo '<div class="header-small" style="color: #6f0808; font-size: 3vh; font-weight: 700;"><b>Niezaplacono!!! <br><a href="podatek.php" style="text-decoration: none; color: yellow;">*Kliknij aby zaplacic*</a></b></div>';
}
else if($wynik['podatek']==1)
{
	echo '<div class="header-small" style="color: yellow; font-size: 3vh; font-weight: 700;"><b>Trwa sprawdzanie..</b></div>';
}
else{
 echo '<div class="header-small" style="color: green; font-size: 3vh; font-weight: 700;">Zaplacono ((:</b></div>';
}	?>
<br>
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

	

		<div class="title"> Ostatnie transakcje</div>
<div class="ostatnie">

<?php
	$listaostatnie = mysql_query("SELECT * FROM `zgloszenia` WHERE login='". $_SESSION['login'] ."' OR od='". $_SESSION['login'] ."' ORDER BY `id` DESC LIMIT 5") or die(mysql_error());
    
	while ($row = mysql_fetch_row($listaostatnie)) {
  $vipwydatki = mysql_query("SELECT * FROM user WHERE login='" . $row[1] . "'");
  $vipw = mysql_fetch_array($vipwydatki);
  $vipdochody = mysql_query("SELECT * FROM user WHERE login='" . $row[4] . "'");
  $vipd = mysql_fetch_array($vipdochody);
  
		if($row[1]==$wynik['login'])
		{
			if ($row[4] == "System") //Przelew System
                        {
							echo '<div class="transakcja">';
							echo '<div class="t_left">';
							echo '	<div class="t_title"> '. $row[7] .' </div>';
							echo '	<div class="t_login"><i class="fas fa-users-cog" style="color: #6f0808;"></i> <span class="lg-c">'. $row[4] .'</span> </div>';
							echo '</div>';
							echo '<div class="t_right">';
							echo '	<div class="t_data"> '. $row[2] .'</div>';
							echo '	<div class="t_money" style="color: green;"> +'. $row[6] .'IK</div>';
							echo '</div>';
							echo '</div>';
						}
						else
                    if ($row[4] == "Admin") //Przelew Panel Admina
                        {
							echo '<div class="transakcja">';
							echo '<div class="t_left">';
							echo '	<div class="t_title"> '. $row[7] .' </div>';
							echo '	<div class="t_login"><i class="fas fa-users-cog" style="color: #6f0808;"></i> <span class="lg-c">'. $row[4] .'</span> </div>';
							echo '</div>';
							echo '<div class="t_right">';
							echo '	<div class="t_data"> '. $row[2] .'</div>';
							echo '	<div class="t_money" style="color: green;"> +'. $row[6] .'IK</div>';
							echo '</div>';
							echo '</div>';	
						}
						else
                    if ($vipd['ranga'] == 1) //Sprawdzanie VIP
                        {
							echo '<div class="transakcja" style="background-color="' . $vipd['kolor'] . ';">';
							echo '<div class="t_left">';
							echo '	<div class="t_title" style="color:' . $vipd['kolor'] . ';"> '. $row[7] .' </div>';
							echo '	<div class="t_login"><img src="vip.gif" alt="UZYTKOWNIK VIP"> <span class="vip" style="color:' . $vipd['kolor'] . ';">'. $row[4] .'</span> </div>';
							echo '</div>';
							echo '<div class="t_right">';
							echo '	<div class="t_data"> '. $row[2] .'</div>';
							echo '	<div class="t_money" style="color: green;"> +'. $row[6] .'IK</div>';
							echo '</div>';
							echo '</div>';	
						}
					 	else
                 if ($vipd['ranga'] >= 2) //Sprawdzanie ASYSTENT
                        {
							echo '<div class="transakcja">';
							echo '<div class="t_left">';
							echo '	<div class="t_title"> '. $row[7] .' </div>';
							echo '	<div class="t_login"><i class="fas fa-user-cog" style="color: #6f0808;"></i> <span class="lg-c">'. $row[4] .'</span> </div>';
							echo '</div>';
							echo '<div class="t_right">';
							echo '	<div class="t_data"> '. $row[2] .'</div>';
							echo '	<div class="t_money" style="color: green;"> +'. $row[6] .'IK</div>';
							echo '</div>';
							echo '</div>';	
						}
						else //ZWYKLY USER
                        {		
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
		}
		
		else if($row[4]==$wynik['login'])
		{
			if ($row[1] == "Admin") 
				{
			echo '<div class="transakcja">';
			echo '<div class="t_left">';
			echo '	<div class="t_title"> '. $row[7] .' </div>';
			echo '	<div class="t_login"><i class="fas fa-users-cog" style="color: #6f0808;"></i> <span class="lg-c"> '. $row[1] .' </div>';
			echo '</div>';
			echo '<div class="t_right">';
			echo '	<div class="t_data"> '. $row[2] .'</div>';
			echo '	<div class="t_money" style="color: #6f0808;"> -'. $row[6] .'IK</div>';
			echo '</div>';
			echo '</div>';
				}
			else if ($vipw['ranga'] == 1) 
				{
			echo '<div class="transakcja">';
			echo '<div class="t_left">';
			echo '	<div class="t_title" style="color: '. $vipw['kolor'] .';"> '. $row[7] .' </div>';
			echo '	<div class="t_login"><img src="vip.gif" alt="UZYTKOWNIK VIP"> <span class="vip" style="color: '. $vipw['kolor'] . ';"> '. $row[1] .' </div>';
			echo '</div>';
			echo '<div class="t_right">';
			echo '	<div class="t_data"> '. $row[2] .'</div>';
			echo '	<div class="t_money" style="color: #6f0808;"> -'. $row[6] .'IK</div>';
			echo '</div>';
			echo '</div>';
				}
			else if ($vipw['ranga'] >= 2) 
				{
			echo '<div class="transakcja">';
			echo '<div class="t_left">';
			echo '	<div class="t_title" > '. $row[7] .' </div>';
			echo '	<div class="t_login"><i class="fas fa-user-cog" style="color: #6f0808;"></i> <span class="lg-c"> '. $row[1] .' </div>';
			echo '</div>';
			echo '<div class="t_right">';
			echo '	<div class="t_data"> '. $row[2] .'</div>';
			echo '	<div class="t_money" style="color: #6f0808;"> -'. $row[6] .'IK</div>';
			echo '</div>';
			echo '</div>';
				}
				else
				{
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
	}		
?>

</div>
	
</div>
<?php
include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>