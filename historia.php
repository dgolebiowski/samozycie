<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1');
session_start(); //start sesji 
ob_start();

?>

    <html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
    <head>
        <title>Historia Przelewów | SamoŻycie |</title>
        <?php include('inc/dane_head.php'); ?>
    </head>

    <body>
    <?php
    include('connect.php');
    include('inc/menu.php');

    if (empty($_SESSION['login'])) {
        header("Location: login.php");
    }
    ?>

    <div class="main-content">

        <div class="header">
            <div class="header-big">Historia Transakcji</div>
            <div class="header-small">Tutaj sprawdzisz swoje ostatnie przelewy.</div>
        </div>
		
		<div class="przyciski_historia">
		<li><a href="javascript:void(0)" id="button-dochody" class="btn btn-form" onclick="showDochody()">Dochody</a>
		<li><a href="javascript:void(1)" id="button-wydatki" class="btn btn-form" onclick="showWydatki()">Wydatki</a>
		</div>
		
        <?php
        $ranga = mysql_query("SELECT * FROM user WHERE login='" . $_SESSION['login'] . "'");
        $wynik = mysql_fetch_array($ranga);
        ?>
		
<div id="ostatnie-transakcje">
<div class="title"> Ostatnie transakcje</div>
<div class="ostatnie">
<?php
	$listaostatnie = mysql_query("SELECT * FROM `zgloszenia` WHERE login='" . $_SESSION['login'] . "' OR od='". $_SESSION['login'] ."' ORDER BY `id` DESC LIMIT 50") or die(mysql_error());
    
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
			echo '	<div class="t_title"> '. $row[7] .'  </div>';
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

<div id="dochody" class="dochody">

        <div class="title">
            Twoje dochody
        </div>
		<div class="ostatnie">
                <?php
                $lista2 = mysql_query("SELECT * FROM `zgloszenia` WHERE login='" . $_SESSION['login'] . "'") or die(mysql_error());
                $ile = mysql_num_rows($lista2);


                if ($ile < 1) {
                    echo '<span class="lg-b">Brak akcji dochodowych!</span>';
                } else {
                    $lista = mysql_query("SELECT * FROM `zgloszenia` WHERE login='" . $_SESSION['login'] . "' ORDER BY `id` DESC LIMIT 35") or die(mysql_error());
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
			</div>
        </div>

<div id="wydatki" class="wydatki">
        <div class="title">
            Twoje wydatki
        </div>
		
<div class="ostatnie">
        <?php
        $akcje = mysql_query("SELECT * FROM user WHERE login='" . $_SESSION['login'] . "'");
        $lista = mysql_fetch_array($zapytanie);
        ?>
                <?php
                $lista2 = mysql_query("SELECT * FROM `zgloszenia` WHERE od='" . $_SESSION['login'] . "'") or die(mysql_error());
                $ile = mysql_num_rows($lista2);

                if ($ile < 1) {
                    echo '<span class="lg-b">Brak akcji wydatkowych!</span>';
                } else {
                    $lista = mysql_query("SELECT * FROM `zgloszenia` WHERE od='" . $_SESSION['login'] . "' ORDER BY `id` DESC LIMIT 15") or die(mysql_error());
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



</div>
    <!-- KONIEC CONTAINER-->
	
<script>
function showDochody() {
   document.getElementById("dochody").style.display = "block";
   document.getElementById("wydatki").style.display = "none";
   document.getElementById("ostatnie-transakcje").style.display = "none";

}

function showWydatki() {
  document.getElementById("wydatki").style.display = "block";
	document.getElementById("dochody").style.display = "none";
	document.getElementById("ostatnie-transakcje").style.display = "none";
}

</script>

    <?php include('inc/footer.php'); ?>
    </body>
    </html>

<?php ob_end_flush(); ?>