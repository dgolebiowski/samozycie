<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Panel Urzędu Skarbowego - Sprawdz | SamoŻycie |</title>
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

$biuro = mysql_query("SELECT * FROM `admin`");
$wynik2 = mysql_fetch_array($biuro);

if($wynik['login']!==$wynik2[11])
{
  header("Location: index.php");
}
?>

<div class="main-content">
	
	<div class="header">
		<div class="header-big">Panel Urzędu Skarbowego</div>
		<div class="header-small">Sprawdzanie podatków.</div>
	</div>


<?php

if($_GET['id'])
	{
		
		$pobierz = "SELECT * FROM podatek WHERE id='" . $_GET['id'] . "'";
		$wyszlo = mysql_query($pobierz) or die(mysql_error());
		$item = mysql_fetch_array($wyszlo); 
		
		
$adminbaza = mysql_query("SELECT * FROM admin"); 
$admin	= mysql_fetch_array($adminbaza);

$login = $item['login'];
$podatekt = $item['podatek'];
$ulga = $item['ulga'];
$zaplata = $item['zaplata'];

$podatekbaza = mysql_query("SELECT * FROM user WHERE login='". $login ."'"); 
$podatek2 = mysql_fetch_array($podatekbaza);

$stankonta = $podatek2['punkty'];

$procent=$admin[10]*100;
$podatek=$wynik['punkty']*$admin[10];

$data = date("Y-m-d", strtotime("-1 week"));

$hajs1 = mysql_query("SELECT SUM(punkty) AS total_value1 FROM zgloszenia WHERE od='". $item['login'] ."' AND data>='". $data ."' AND login!='Urzad Skarbowy'");
$wydatki=mysql_result($hajs1,0,0);


		if($_POST['akceptuj'] == 1)
	{
			$akceptujpodatek = "UPDATE podatek SET status='1' WHERE login='". $login ."'";
			mysql_query($akceptujpodatek) or die(mysql_error());
			$akceptujuser = "UPDATE user SET podatek='2' WHERE login='". $login ."'";
			mysql_query($akceptujuser) or die(mysql_error());
			
			$punktynew = $stankonta - $zaplata;
			$userkasa = "UPDATE user SET punkty='". $punktynew ."' WHERE login='". $login ."'";
			mysql_query($userkasa) or die(mysql_error());
			
			mysql_query("INSERT INTO zgloszenia VALUES(NULL, 'Urzad Skarbowy', NOW(), '', '". $login ."', '-', '" . $zaplata ."', 'Urząd Skarbowy - Podatek', '1', '1', '')");
			
			header("Location: podatek_lista.php");
		}
		
		if($_POST['odrzuc'] == 1)
	{
			$odrzucpodatek = "UPDATE podatek SET status='2' WHERE login='". $login ."'";
			mysql_query($odrzucpodatek) or die(mysql_error());
			$odrzucuser = "UPDATE user SET podatek='2' WHERE login='". $login ."'";
			mysql_query($odrzucuser) or die(mysql_error());
			
			$polowa = 0.2 * $stankonta;
			$punktynew2 = $stankonta - $polowa;
			$userkasa2 = "UPDATE user SET punkty='". $punktynew2 ."' WHERE login='". $login ."'";
			
			mysql_query("INSERT INTO zgloszenia VALUES(NULL, 'Urzad Skarbowy', NOW(), '', '". $login ."', '-', '" . $polowa ."', 'Oszustwo Podatkowe', '1', '1', '')");
			
			header("Location: podatek_lista.php");
		}
	?>
	
	<div class="title">Podsumowanie</div>
  <div class="header-small">
    <b>Obecny procent: <span class="lg-b"><?php echo $procent; ?>%</span></b><br />
	<b>Login podatnika: <span class="lg-b"><?php echo $login; ?></span></b><br />
	<b>Stan konta: <span class="lg-b"><?php echo $stankonta; ?> <img src="icon.png" width="16" height="16" /></span></b><br />
	<b>Podatek: <span class="lg-b"><?php echo $podatekt; ?> <img src="icon.png" width="16" height="16" /></span></b><br />
	<b>Wpisana ulga: <span class="lg-b"><?php echo $ulga; ?> <img src="icon.png" width="16" height="16" /></span></b><br />
	<b>Ulga wyliczona przez system: <span class="lg-b"><?php echo $wydatki; ?> <img src="icon.png" width="16" height="16" /></span></b><br />
	<b>Do zapłaty: <span class="lg-b"><?php echo $zaplata; ?> <img src="icon.png" width="16" height="16" /></span></b><br />

 </div>
 <div id="wydatki" class="wydatki" style="display: block;">
<div class="title">
            Wydatki użytkownika
        </div>
		
<div class="ostatnie">
        <?php
        $akcje = mysql_query("SELECT * FROM user WHERE login='" . $login . "'");
        $lista = mysql_fetch_array($zapytanie);
        ?>
                <?php
                $lista2 = mysql_query("SELECT * FROM `zgloszenia` WHERE od='" . $login . "'") or die(mysql_error());
                $ile = mysql_num_rows($lista2);

                if ($ile < 1) {
                    echo '<span class="lg-b">Brak akcji wydatkowych!</span>';
                } else {
                    $lista = mysql_query("SELECT * FROM `zgloszenia` WHERE od='" . $login . "' ORDER BY `id` DESC LIMIT 10") or die(mysql_error());
                    while ($row = mysql_fetch_row($lista)) {
                        $vipwydatki = mysql_query("SELECT * FROM user WHERE login='" . $row[1] . "'");
                        $vipw = mysql_fetch_array($vipwydatki);
						
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
			echo '	<div class="t_title" style="color:' . $vipw['kolor'] . ';"> '. $row[7] .' </div>';
			echo '	<div class="t_login"><img src="vip.gif" alt="UZYTKOWNIK VIP"> <span class="vip" style="color:' . $vipw['kolor'] . ';"> '. $row[1] .' </div>';
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
			echo '	<div class="t_title"> '. $row[7] .' </div>';
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
                </tbody>
            </table>
        </div>
</div>
 <div id="dochody" class="dochody" style="display: block;">
<div class="title">
            dochody użytkownika
        </div>
		
<div class="ostatnie">
        <?php
                $lista2 = mysql_query("SELECT * FROM `zgloszenia` WHERE login='" . $login . "'") or die(mysql_error());
                $ile = mysql_num_rows($lista2);


                if ($ile < 1) {
                    echo '<span class="lg-b">Brak akcji dochodowych!</span>';
                } else {
                    $lista = mysql_query("SELECT * FROM `zgloszenia` WHERE login='" . $login . "' ORDER BY `id` DESC LIMIT 5") or die(mysql_error());
                    while ($row = mysql_fetch_row($lista)) {
                        $vipdochody = mysql_query("SELECT * FROM user WHERE login='" . $row[4] . "'");
                        $vipd = mysql_fetch_array($vipdochody);
						
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
							echo '<div class="transakcja">';
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
                }

                ?>
                </tbody>
            </table>
        </div>
</div>

 <br>
<form action="podatek_sprawdz.php?id=<?php echo $item[0]; ?>" method="post">
		<input type="hidden" value="1" name="akceptuj"><button type="submit" name="submit" class="btn btn-form">Akceptuj</button>
</form>
<form action="podatek_sprawdz.php?id=<?php echo $item[0]; ?>" method="post">
		<input type="hidden" value="1" name="odrzuc"><button type="submit" name="submit" class="btn btn-form">Odrzuć</button>
</form>
<?php
	}
	?>
</div>
</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>