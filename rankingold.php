<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1');
session_start(); //start sesji
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Ranking | SamoŻycie |</title>
	<?php include 'inc/dane_head.php';?>
</head>

<body>
<?php
include 'connect.php';
include 'inc/menu.php';

if (empty($_SESSION['login'])) {
    header("Location: login.php");
}
?>

<div class="main-content">

	<div class="header">
		<div class="header-big">Ranking</div>
		<div class="header-small">Tutaj sprawdzisz listę najbogatszych osób.</div>
	</div>
<div class="tablediv">
<table class="table">
  <thead>
    <tr>
      <th>Użytkownik</th>
	  <th>Klasa</th>
	  <th><img src="icon.png" width="16" height="16" /></th>
	  <th>Firma</th>
    </tr>
  </thead>
  <tbody>
  <?php
$lp = 0;

$listar = mysql_query("SELECT * FROM `user` WHERE `ranga`<'2' ORDER BY `punkty` DESC") or die(mysql_error());
while ($row = mysql_fetch_row($listar)) {
    $lp++;
    if ($row[4] == 0) {
        echo '<tr>';
        echo '<td>' . $lp . '. <i class="fa fa-user-tie"></i><span class="tekst">  ' . $row[1] . '</span></td>';
        echo '<td>' . $row[2] . '</td>';
        echo '<td>' . $row[7] . ' <img src="icon.png" width="16" height="16" /></td>';
        echo '<td>' . $row[6] . '</td>';
        echo '</tr>';
    } else if ($row[4] == 1) {
        echo '<tr bgcolor="' . $row[9] . '">';
        echo '<td><span class="vip">' . $lp . '. <img src="vip.gif" alt="Użytkownik VIP"></i><span class="tekst">  ' . $row[1] . '</span></td>';
        echo '<td><span class="vip">' . $row[2] . '</span></td>';
        echo '<td><span class="vip">' . $row[7] . ' <img src="icon.png" width="16" height="16" /></span></td>';
        echo '<td><span class="vip">' . $row[6] . '</span></td>';
        echo '</tr>';
    }

}
?>
  </tbody>
</table>
</div>
</div>
<!-- KONIEC CONTAINER-->

  <?php include 'inc/footer.php';?>
</body>
</html>

<?php ob_end_flush();?>