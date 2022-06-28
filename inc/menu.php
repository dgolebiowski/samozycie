<div class="menu-gorne">
	<a href="index.php"><div class="logo-top"><span class="lg-b">SAMO</span><span class="lg-c">ŻYCIE</span></div></a>
	
	<div class="menu-bar">
	<span style="font-size:30px;cursor:pointer" onclick="openNavMenu()"><i class="fa fa-bars"></i></span>
	</div>
	<div class="user-bar">
	<span style="font-size:30px;cursor:pointer" onclick="openNavUser()"><i class="far fa-user-circle"></i></span>
	</div>
</div>

<?php
		$zapytanie = mysql_query("SELECT * FROM user WHERE login='".$_SESSION['login']."'"); 
		$wynik = mysql_fetch_array($zapytanie); 
?>

<div id="Menu" class="nawigacja">
	<li><a href="javascript:void(0)" class="closebtn" onclick="closeNavMenu()">&times;</a>
	
	<div class="logo-menu">
	<a href="index.php">
	<div class="logo-menu-img"><img src="img/logo.png"></div>
	<div class="logo-menu-txt"><span class="lg-b">SAMO</span><span class="lg-c">ŻYCIE</span></div>
	</a>
	</div>
	
	<li><a href="przelew.php"><i class="fa fa-exchange-alt"></i> Przelewaj</a></li>
	<li><a href="historia.php"><i class="fa fa-history"></i> Historia</a></li>
	<li><a href="podatek.php"><i class="fas fa-file-invoice-dollar"></i> Podatek</a></li>
	<li><a href="ranking.php"><i class="fa fa-piggy-bank"></i> Ranking</a></li>
	<li><a href="firmy.php"><i class="fa fa-building"></i> Firmy</a></li>
	<li><a href="loteria.php"><i class="fa fa-ticket-alt"></i> Loteria</a></li>
	<li><a href="pic.php"><i class="fa fa-star"></i> P&C </a></li>
	<li><a href="premium.php"><img src="vip.gif"> Premium</a></li>
	<?php 
	$dostepfirmy= mysql_query("SELECT * FROM `firmy` WHERE prezes='" . $_SESSION['login'] ."'");
$dostepfirmy2= mysql_query("SELECT * FROM `firmy` WHERE vice='" . $_SESSION['login'] ."'"); 
	
		if( (mysql_num_rows($dostepfirmy)) == 1 || (mysql_num_rows($dostepfirmy2)) == 1)
		{
			echo '<li><a href="firma_panel.php"><i class="fa fa-building"></i> Panel Firmy</a></li>';
		}
		if ($wynik['ranga']>=1)
		{
		echo '<li><a href="panel_vip.php"><i class="fa fa-star"></i> Panel VIPa</a></li>';
		}
		if ($wynik['ranga']>=2)
		{
		echo '<li><a href="panel_asystenta.php"><i class="fa fa-dashboard"></i> Panel Asystenta</a></li>';
		}
	?>
	
	<div class="dol">
		<li><a href="regulamin.php">Regulamin</a></li>
		<li><a href="asystenci.php">Asystenci</a></li>
		<li><a href="https://www.facebook.com/pg/czarnypijar">Gazetka</a></li>
	</div>
</div>


<div id="User" class="nawigacja2">
	<li><a href="javascript:void(0)" class="closebtn" onclick="closeNavUser()">&times;</a>
	
	<div class="logo-menu">
	<a href="index.php">
	<div class="logo-menu-img"><img src="img/logo.png"></div>
	<div class="logo-menu-txt"><span class="lg-b">SAMO</span><span class="lg-c">ŻYCIE</span></div>
	</a>
	</div>
	
	
	<li><span class="user-login"><?php echo $wynik['login']; ?></span></li>
	<?php 
		if ($wynik['ranga']==0)
		{
		echo '<li><span class="user-acc"> Zwykłe Konto</li>';
		}
		else if ($wynik['ranga']==1)
		{
		echo '<li><span class="user-acc"> <img src="vip.gif"> PREMIUM</li>';
		}
		else if ($wynik['ranga']>=2)
		{
		echo '<li><span class="user-acc"> ADMINISTRATOR</li>';
		}
	?>
	<br>
	<?php
	$zapytanie2 = mysql_query("SELECT * FROM wiadomosc WHERE do='".$_SESSION['login']."' AND przeczytane='0'"); 
		$ile = mysql_num_rows($zapytanie2);
		
	if($ile > 0)
	{
?>
	<div class="wiadomosc">
		<div class="wiadomosc-big"> Masz nową wiadomość! </div>
		<div class="wiadomosc-small"><a href="wiadomosci.php">Kliknij tutaj aby ją zobaczyć!</a></div>
	</div>
	<?php } ?>
	<br>
	<li><i class="fa fa-dollar-sign"></i> Twój stan konta: <span class="lg-c"><?php echo $wynik['punkty']; ?> <img src="icon.png" width="16" height="16" /></span></li>
	<li><i class="fa fa-users"></i> Twoja klasa: <span class="lg-c"><?php echo $wynik['klasa']; ?></span></li>
	<li><i class="fa fa-building"></i> Twoja firma: <span class="lg-c"><?php echo $wynik['firma']; ?></span></li>

	<div class="dol"><a href="wyloguj.php">Wyloguj się.</a><br>
	<li><a href="/"><span class="lg-b">POL</a></span></li>
	<li><a href="/eng/"><span class="lg-b">ANG</a></span></li>
	</div>
	

</div>

<!-- KONIEC MENU  -->