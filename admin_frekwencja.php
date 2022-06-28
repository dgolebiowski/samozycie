<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Frekwencja | SamoŻycie |</title>
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
		<div class="header-big">Frekwencja</div>
		<div class="header-small">Dodaj $ za frekwencje (:</div>
	</div>
<?php
	$zapytanie = mysql_query("SELECT * FROM user WHERE login='".$_SESSION['login']."'"); 
	$wynik = mysql_fetch_array($zapytanie);
	
	if($wynik['ranga'] < 1)
{?>
	Ta część strony nie jest dla Ciebie dostępna!
<?php }
else
{
	$zapytaniedata = mysql_query("SELECT * FROM admin");
    $wynikd = mysql_fetch_array($zapytaniedata);
 ?>
	<script>
   var ilosc = 0;
	</script>
	
	   <div class="alert alert-info"> Ostatnie dodanie $: <b>
                            <?php echo $wynikd[0]; ?></b> przez
                        <b>
                            <?php echo $wynikd[2]; ?></b></div>
							
							<?php
                        if (isset($_SESSION['success'])) {
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                        }
                        if ($_POST['dodaj'] == 1) {
                            foreach ($_POST["user"] as $r) {
                                $uzytkownik = htmlspecialchars($r);
                                $zapytanie3 = mysql_query("SELECT * FROM user WHERE login='" . $uzytkownik . "'");
                                $user2 = mysql_fetch_array($zapytanie3);
								
								if ($user2['ranga']==1)
								{
									 mysql_query("INSERT INTO zgloszenia VALUES(NULL, '" . $uzytkownik . "', NOW(), '', 'System', '-', '35', 'Frekwencja <img src=vip.gif>', '1', '1', '')");
                                
                                $punkty = $user2['punkty'] + 35;
								$aktualizujusera = "UPDATE user SET  punkty='" . $punkty . "' WHERE login='" . $uzytkownik . "'";
                                mysql_query($aktualizujusera) or die(mysql_error());
								}
								
								else
								{
									 mysql_query("INSERT INTO zgloszenia VALUES(NULL, '" . $uzytkownik . "', NOW(), '', 'System', '-', '25', 'Frekwencja', '1', '1', '')");
                                
								$punkty = $user2['punkty'] + 25;
                                $aktualizujusera = "UPDATE user SET  punkty='" . $punkty . "' WHERE login='" . $uzytkownik . "'";
                                mysql_query($aktualizujusera) or die(mysql_error());
								}
                            }


                            $datadodawania = "UPDATE admin SET frekwencja=NOW()";
                            mysql_query($datadodawania) or die(mysql_error());

                            $admindodawania = "UPDATE admin SET admin_frekwencja='" . $_SESSION['login'] . "'";
                            mysql_query($admindodawania) or die(mysql_error());

                            $_SESSION['success'] = '<span class="tekst">Dodano!</span>';
                            header("Location: /admin_frekwencja.php");
                        }
                        ?>

                    <form action="admin_frekwencja.php" method="post">
                        <span class="lg-c">Klasa 1A</span>
                        <?php
                            $users = mysql_query("SELECT * FROM user WHERE klasa='1a' ORDER BY imie ASC");
                            while ($user = mysql_fetch_assoc($users)) {
                                echo '<div class="checkbox">
	<label><input type="checkbox" value="' . $user['login'] . '" name="user[]" onchange="checkboxclock(this)"> ' . $user['imie'] . '</label>
			</div>';
                            }

                            ?>
                        <span class="lg-c">Klasa 1B</span><br />
                        <?php
                            $users = mysql_query("SELECT * FROM user WHERE klasa='1b' ORDER BY imie ASC");
                            while ($user = mysql_fetch_assoc($users)) {
                                echo '<div class="checkbox">
	<label><input type="checkbox" value="' . $user['login'] . '" name="user[]" onchange="checkboxclock(this)">' . $user['imie'] . '</label>
			</div>';
                            }

                            ?>
                        <span class="lg-c">Klasa 1C</span><br />
                        <?php
                            $users = mysql_query("SELECT * FROM user WHERE klasa='1c' ORDER BY imie ASC");
                            while ($user = mysql_fetch_assoc($users)) {
                                echo '<div class="checkbox">
	<label><input type="checkbox" value="' . $user['login'] . '" name="user[]" onchange="checkboxclock(this)">' . $user['imie'] . '</label>
			</div>';
                            }

                            ?>


                        <input type="hidden" value="1" name="dodaj">
                        <button type="submit" name="submit" class="btn btn-primary button-frekwencja">Potwierdz
                            dodawanie
                        </button>
                    </form>
           

            <?php } ?>
        </div>
        <script>
            function checkboxclock(element) {
                if (element.checked) {
                    ilosc++;
                    $(".button-frekwencja").text("Potwierdz dodawanie (" + ilosc + ")");
                } else {
                    ilosc--;
                    if (ilosc > 0) {
                        $(".button-frekwencja").text("Potwierdz dodawanie (" + ilosc + ")");
                    } else {
                        $(".button-frekwencja").text("Potwierdz dodawanie");
                    }
                }

            }
        </script>
			
			
</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>