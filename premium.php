<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Premium | SamoŻycie |</title>
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
		<div class="header-big">SZH</div>
		<div class="header-small">Sztos Ziomale Halibut</div>
	</div>

	 <div class="header-big">Konto VIP</div>
	 <div class="header-small">Konto VIP to nowa możliwość w projekcie SamoŻycie oferowana przez firmę SZH, która pozwala Ci zainwestować swoje pieniądze i żyć na wyższym poziomie niż reszta użytkowników.
	<br>
				<?php
				$tabelaadmin = mysql_query("SELECT * FROM admin");
				$licytacjapremium = mysql_fetch_array($tabelaadmin);
				?>
				Następny drop kont: <span class="lg-c"><?php echo $licytacjapremium[5]; ?></span>
	</div>
<div class="przelew">
<div class="title"> Informacje o ELITARNYM KONCIE VIP </div>

	<span class="lg-c">1. Jakie będę miał z niego korzyści?</span> 
<div class="header-small">
				<li>Ikona <img src="vip.gif"> w rankingu.</li>
				<li>Ikona <img src="vip.gif"> przy przelewach.</li>
				<li>Możliwość doboru własnego koloru w przelewach oraz w rankingu.</li>
				<li>Możliwość ustawienia własnego awataru.</li>
				<li>Przypinka "VIP" na mundurek do noszenia w czasie posiadania ulepszonego konta.</li>
				<li>Duużoo więcej pieniędzy za obecność na lekcji.</li>
				<li>Tematy prezentacji tylko dla VIP, które będą darmowe, ale rozdawane w sposób "dropów" - kto pierwszy, ten lepszy.</li>
				<li>Grupa/bot VIP na Facebooku z codziennymi memami i zdjęciami pjesków na dobry początek dnia.</li>
				<li>Możliwość powieszenia ogłoszenia na tablice informacyjną w szkole lub dodania ogłoszenia na grupie na FB.</li>
				<li>Możliwość dodania ogłoszenia na ChatBota.</li>
				<li>Panel VIP na stronie (dodatkowe funkcje, których liczba może się powiększać z czasem).</li>
</div>
				<span class="lg-c">2. Ile będzie trwała subskrypcja mojego konta VIP?</span><br />
<div class="header-small">				Konto VIP zakupujesz na okres <span class="lg-b">2 tygodni</span>, przez które możesz w pełni korzystać ze wszystkich przywilejów, które mu towarzyszą.<br /></div>
				<br />
				<span class="lg-c">3. Jaki jest haczyk?</span><br />
<div class="header-small">				Haczyk jest taki, że konto VIP może posiadać <span class="lg-b">maksymalnie 5 użytkowników</span> projektu naraz. Pozwala to zachować atmosferę elitarności wśród posiadaczy!<br /></div>
				<br />
				<span class="lg-c">4. Jak zdobyć konto VIP?</span><br />
<div class="header-small">				Na start ustalamy cenę konta VIP na 150 <img src="icon.png" width="16" height="16" />. Kupi je 5 pierwszych osób które wejdą na stronę zakupu konta, po ogłoszeniu jego sprzedaży, a następnie zapłacą. Wtedy, jeśli będziesz jednym ze szczęśliwców, system zabierze Ci pieniądze z konta, a Ty otrzymasz konto VIP!</div>
	
</div>
<div class="title"> Lista użytkowników z kontem V I P </div>
<div class="tablediv">
<table class="table">
  <thead>
    <tr>
      <th><img src="vip.gif"></th>
	  <th>UŻYTKOWNIK</th>
	  <th>DATA ZAKUPU</th>
	  <th>WAŻNY PRZEZ</th>
    </tr>
  </thead>
  <tbody>
 <?php
	$zapytanievip = mysql_query("SELECT * FROM `premium`");
	$premium = mysql_fetch_array($zapytanievip);
	
	$vip = mysql_query("SELECT * FROM `premium` ORDER BY `login` ASC") or die(mysql_error());

		 while ( $row = mysql_fetch_row($vip) )
		 {			
					$vipinf = mysql_query("SELECT * FROM user WHERE login='". $row[1] ."'");
					$inf = mysql_fetch_array($vipinf);
					
					echo '<tr bgcolor="'. $inf[9] .'">';
					echo '<td><img src="'. $inf[10] .'" height=50px></td>';
					echo '<td><img src="vip.gif" alt="Konto VIP" /> <span class="tekst">'. $row[1] .'</span></td>';
					echo '<td><span class="vip">'. $row[2] .'</span></td>';
					echo '<td><span class="vip">'. $row[3] .'</span></td>';
					echo '</tr>';
					}	
					?>
					
  </tbody>
  
</table>	
</div>

</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>