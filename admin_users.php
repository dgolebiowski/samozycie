<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Użytkownicy | SamoŻycie |</title>
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
		<div class="header-big">Użytkownicy</div>
		<div class="header-small">Tutaj znajdziesz listę wszystkich użytkowników projektu.</div>
	</div>
<?php
	$zapytanie = mysql_query("SELECT * FROM user WHERE login='".$_SESSION['login']."'"); 
	$wynik = mysql_fetch_array($zapytanie);
	
	if($wynik['ranga'] < 1)
{?>
	Ta część strony nie jest dla Ciebie dostępna!
<?php }
else
{ ?>
<div class="przelew">
<?php
                include_once("inc/search.php");
            ?>
	</div>	
<div class="tablediv">
     <table class="table">
                        <thead>
                            <tr>
                                <th>Pseudonim</th>
                                <th>Imie Nazwisko</th>
                                <th>Kopry</th>
                                <th>Firma</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
if ($_GET['id']) {
    $zapy = "DELETE FROM user WHERE id='" . $_GET['id'] . "'";
    mysql_query($zapy);
    echo 'Usunięto!';
}

    $na_stronie = 30; // ilość wpisów na 1 stronie

    $page = mysql_query("SELECT COUNT(id) FROM `user`") or die(mysql_error());
    $a = mysql_fetch_row($page);
    $liczba_wpisow = $a[0];
    $liczba_stron = ceil($liczba_wpisow / $na_stronie);

    if (isset($_GET['strona'])) {
        if ($_GET['strona'] < 1 || $_GET['strona'] > $liczba_stron) {
            $strona = 1;
        } else {
            $strona = $_GET['strona'];
        }

    } else {
        $strona = 1;
    }

    $od = $na_stronie * ($strona - 1);
    $lista2 = mysql_query("SELECT * FROM `user` ORDER BY imie ASC LIMIT $od , $na_stronie") or die(mysql_error());
    $ile = mysql_num_rows($lista2);

    while ($row = mysql_fetch_row($lista2)) {
        echo '<tr>';
        echo '<td><span class="tekst">' . $row[1] . '</span></td>';
        echo '<td>' . $row[8] . '</td>';
        echo '<td>' . $row[7] . ' <img src="icon.png" width="16" height="16" /></td>';
        echo '<td>' . $row[6] . '</td>';
        echo '<td><a href="admin_users.php?id=' . $row[0] . '" onclick="return confirm(\'Czy na pewno chcesz tego dokonać? Tej czynności nie da się cofnąć.\')"><i class="fa fa-ban"></i></a></td>';
        echo '</tr>';
    }
    ?>
                        </tbody>

                    </table>
			</div>
                    <?php
if ($liczba_wpisow > $na_stronie) {
        $poprzednia = $strona - 1;
        $nastepna = $strona + 1;
        echo '<ul class="pager">';
        if ($poprzednia > 0) {

            echo '<li class="previous"><a href="admin_users.php?strona=' . $poprzednia . '">&larr; Poprzednia strona</a></li>';
        }

        if ($nastepna <= $liczba_stron) {
            echo '<li class="next"><a href="admin_users.php?strona=' . $nastepna . '">Następna strona &rarr;</a></li>';

        }
        echo '</ul>';
    }

 }?>

</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>