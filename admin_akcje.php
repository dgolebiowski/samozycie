<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Ostatnie Akcje | SamoŻycie |</title>
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
		<div class="header-big">Transakcje</div>
		<div class="header-small">Ostatnie Transakcje wykonane przez użytkowników.</div>
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

 <div class="tablediv">
            <table class="table">
  <thead>
    <tr class="viphistoria">
      <th>Do</th>
	  <th>Od</th>
      <th>Ilość Koprów</th>
	  <th>Data</th>
    </tr>
  </thead>
  <tbody>
 <?php
 
    $na_stronie = 30; // ilość wpisów na 1 stronie

    $page = mysql_query("SELECT COUNT(id) FROM `zgloszenia`") or die(mysql_error());
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
  $lista = mysql_query("SELECT * FROM `zgloszenia` ORDER BY `data` DESC LIMIT $od , $na_stronie") or die(mysql_error());
  $ile = mysql_num_rows($lista);
  
  while ( $row = mysql_fetch_row($lista) ) 
  {
		  echo '<tr>';
    echo '<td>' . $row[1] . '</td>';
	echo '<td>' . $row[4] .'</td>';
	echo '<td><b>' . $row[6] . ' <img src="icon.png" width="16" height="16" /></b></td>';
	echo '<td>' . $row[2] . '</td>';
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

            echo '<li class="previous"><a href="admin_akcje.php?strona=' . $poprzednia . '">&larr; Poprzednia strona</a></li>';
        }

        if ($nastepna <= $liczba_stron) {
            echo '<li class="next"><a href="admin_akcje.php?strona=' . $nastepna . '">Następna strona &rarr;</a></li>';

        }
        echo '</ul>';
    }

 } ?>
 
</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>