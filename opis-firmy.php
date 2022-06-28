<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();
include('connect.php');
?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">

<?php
$listafirm = mysql_query("SELECT * FROM `firmy` WHERE id=" . $_GET['id'] ."") or die(mysql_error());
$wynik = mysql_fetch_row($listafirm);
$firma = $wynik[1];
 ?>
 
<head>
	<title>Firma <?php echo $firma; ?> | SamoŻycie |</title>
	<?php include('inc/dane_head.php'); ?>
</head>

<body>
<?php
include('inc/menu.php');

if(empty($_SESSION['login']))
{
	header("Location: login.php");
}
?>

<div class="main-content">
	
	<div class="header">
		<div class="header-big">Firma <?php echo $firma; ?></div>
		<div class="header-small">Więcej informacji o wybranej przez ciebie firmie.</div>
	</div>
<div class="przelew">
 <?php
  $listafirmy = mysql_query("SELECT * FROM `firmy` WHERE id=" . $_GET['id'] ."") or die(mysql_error());
  while ( $row = mysql_fetch_row($listafirmy) ) 
  {
	echo '<img src="'. $row [5]	.'"><br>';
    echo '<span class="lg-b">Nazwa firmy:</span><span class="lg-c"> <i class="fa fa-building"></i> ' . $row[1] . '</span><br>';
	echo '<span class="lg-b">Prezes:</span><span class="lg-c"> <i class="fa fa-user-tie"></i> ' . $row[3] . '</span><br>';
    echo '<span class="lg-b">V-Prezes:</span><span class="lg-c"> ' . $row[4] . '</span><br>';
  }
	?>
</div>
	<div class="pracownicy">
	  
                                    <th>Pracownicy firmy:</th>
                              
                                <?php
                                try{
                                    $stmt = $pdo->prepare("SELECT * FROM user WHERE firma=:firma");
                                    $stmt->bindParam(":firma", $firma, PDO::PARAM_STR);
                                    $stmt->execute();
                                    $workers = $stmt->fetchAll();
                                    foreach($workers as $r){                                        
									echo '<li><i class="fa fa-user-circle"></i> ' . $r["login"] . '</li>';
                                      }
                                } catch(Exception $ex){

                                }
	?>
                            </tbody>

                        </table>
				</div>
						
	</div>
</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>