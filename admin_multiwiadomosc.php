<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Wiadomosc | SamoŻycie |</title>
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
		<div class="header-big">Wiadomosc</div>
		<div class="header-small">Wyslij wiadomosc do uzytkownika.</div>
	</div>
<?php
	$zapytanie = mysql_query("SELECT * FROM user WHERE login='".$_SESSION['login']."'"); 
	$wynik = mysql_fetch_array($zapytanie);
	
?>
		  <script>
                var ilosc = 0;
            </script>
			
  <div class="title">Panel Admina - Wyslij wiadomosc</div>
                <div class="przelew">
                    <?php
                        if($wynik['ranga']<2)
                        {
                            echo "Ta część strony nie jest dla Ciebie dostępna!";
                        }
                        else
                        {

                        if (isset($_SESSION['success'])) {
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                        }
                        if ($_POST['dodaj'] == 1) {
                            foreach ($_POST["user"] as $r) {
                                $uzytkownik = htmlspecialchars($r);
					
					
							$tresc = "<b>" . nl2br($_POST['tresc']) . "</b>";
							$od = $_SESSION['login'];
							$data = date("Y-m-d H:i");
							$dodaj = "INSERT INTO wiadomosc VALUES (NULL, '$tresc', '$uzytkownik', '$od', '$data', '0')";
							mysql_query($dodaj) or die(mysql_error());
								
                            }


                            $_SESSION['success'] = '<span class="lg-c">Wysłano!</span>';
                            header("Location: /admin_multiwiadomosc.php");
                        }
						
                        ?>

                    <form action="admin_multiwiadomosc.php" method="post">
					<div class="form-group">
					<label for="exampleInputEmail1">Treść:</label>
					<textarea class="form-control" name="tresc"></textarea>
					</div>
                        <span class="lg-c">Klasa 1A</span>
                        <?php
                            $users = mysql_query("SELECT * FROM user WHERE klasa='1a' ORDER BY imie ASC");
                            while ($user = mysql_fetch_assoc($users)) {
                                echo '<div class="checkbox">
	<label><input type="checkbox" value="' . $user['login'] . '" name="user[]" onchange="checkboxclock(this)"> ' . $user['imie'] . ' - <b>'. $user['login'] .'</b></label>
			</div>';
                            }

                            ?>
                        <span class="lg-c">Klasa 1B</span><br />
                        <?php
                            $users = mysql_query("SELECT * FROM user WHERE klasa='1b' ORDER BY imie ASC");
                            while ($user = mysql_fetch_assoc($users)) {
                                echo '<div class="checkbox">
	<label><input type="checkbox" value="' . $user['login'] . '" name="user[]" onchange="checkboxclock(this)">' . $user['imie'] . ' - <b>'. $user['login'] .'</b></label>
			</div>';
                            }

                            ?>
                        <span class="lg-c">Klasa 1C</span><br />
                        <?php
                            $users = mysql_query("SELECT * FROM user WHERE klasa='1c' ORDER BY imie ASC");
                            while ($user = mysql_fetch_assoc($users)) {
                                echo '<div class="checkbox">
	<label><input type="checkbox" value="' . $user['login'] . '" name="user[]" onchange="checkboxclock(this)">' . $user['imie'] . ' - <b>'. $user['login'] .'</b></label>
			</div>';
                            }

                            ?>


                        <input type="hidden" value="1" name="dodaj">
                        <button type="submit" name="submit" class="btn btn-form button-multiwiadomosc">Potwierdz
                            wysylanie
                        </button>
                    </form>
					</div>
 
<?php } ?>
</div>

 <script>
            function checkboxclock(element) {
                if (element.checked) {
                    ilosc++;
                    $(".button-multiwiadomosc").text("Potwierdz wysylanie (" + ilosc + ")");
                } else {
                    ilosc--;
                    if (ilosc > 0) {
                        $(".button-multiwiadomosc").text("Potwierdz wysylanie (" + ilosc + ")");
                    } else {
                        $(".button-multiwiadomosc").text("Potwierdz wysylanie");
                    }
                }

            }
        </script>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>