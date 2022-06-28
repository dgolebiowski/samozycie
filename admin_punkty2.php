<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Przeslij | SamoŻycie |</title>
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
		<div class="header-big">Przesylanie $</div>
		<div class="header-small">Przeslij hajs z konta1 na konto2.</div>
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

			
			                <div class="title">Panel Admina - Przesyłanie Punktów</div>
                <div class="przelew">

                    <?php
                        if(isset($_SESSION['success'])){
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                        }
                    ?>
                    <?php
                        

                        //echo var_dump($_SERVER);
                        if($_SERVER['REQUEST_METHOD']=="POST"){
                            //echo var_dump($_POST);
                            if(!empty($_POST['loginAdd'])&&!empty($_POST['loginSub'])&&!empty($_POST['nazwa'])&&!empty($_POST['punkty'])){
                                try{
                                    $points = $_POST['punkty'];
                                    $loginAdd = $_POST['loginAdd'];
                                    $loginSub = $_POST['loginSub'];
                                    $note = $_POST['nazwa'];
                                    $admin = $_SESSION['login'];
                                    $stmt_add = $pdo->prepare("INSERT INTO zgloszenia VALUES(NULL, :loginAdd, NOW(), '-', 'Admin', :admin, :points, :note, '1', '1', '')");
                                    $stmt_add->bindParam(":loginAdd", $loginAdd, PDO::PARAM_STR);
                                    $stmt_add->bindParam(":admin", $admin, PDO::PARAM_STR);
                                    $stmt_add->bindParam(":points", $points, PDO::PARAM_STR);
                                    $stmt_add->bindParam(":note", $note, PDO::PARAM_STR);
                                    $stmt_add->execute();
                                    $stmt_sub = $pdo->prepare("INSERT INTO zgloszenia VALUES(NULL, 'Admin', NOW(), '-', :loginSub, :admin, :points, :note, '1', '2', '')");
                                    $stmt_sub->bindParam(":loginSub", $loginSub, PDO::PARAM_STR);
                                    $stmt_sub->bindParam(":admin", $admin, PDO::PARAM_STR);
                                    $stmt_sub->bindParam(":points", $points, PDO::PARAM_STR);
                                    $stmt_sub->bindParam(":note", $note, PDO::PARAM_STR);
                                    $stmt_sub->execute();
                                    $stmt_user_add = $pdo->prepare("UPDATE user SET punkty = punkty + :points where login = :userAdd ");
                                    $stmt_user_add->bindParam(":points", $points, PDO::PARAM_INT);
                                    $stmt_user_add->bindParam(":userAdd", $loginAdd, PDO::PARAM_STR);
                                    $stmt_user_add->execute();
                                    $stmt_user_sub = $pdo->prepare("UPDATE user SET punkty = punkty - :points where login = :userSub ");
                                    $stmt_user_sub->bindParam(":points", $points, PDO::PARAM_INT);
                                    $stmt_user_sub->bindParam(":userSub", $loginSub, PDO::PARAM_STR);
                                    $stmt_user_sub->execute();
                                    $_SESSION['success'] = '<div class="alert alert-success">Przelew wykonano!</div>';
			                        header("Location: /admin_punkty2.php");
                                }
                                catch(Exception $ex){
                                    echo var_dump($ex);
                                }
                                
                            }
                            else echo "Brak danych";
                        }
                        

                        /*if($_POST['dodaj'] == 1)
                        {
                            if($_POST['login'] || $_POST['nazwa'] || $_POST['punkty'])
                            {
                                    $admin = htmlspecialchars($_SESSION['login']);
                                    $login = htmlspecialchars($_POST['login']);
                                    $nazwa = htmlspecialchars($_POST['nazwa']);
                                    $punkty = htmlspecialchars($_POST['punkty']);

                                    {
                                        mysql_query("INSERT INTO zgloszenia VALUES(NULL, '" . $login . "', NOW(), '-', 'Admin', '". $admin ."', '" . $punkty ."', '". $nazwa ."', '1', '1', '')");			
                                        
                                        $zapytanie2 = mysql_query("SELECT * FROM user WHERE login='". $login ."'"); 
                                        $user = mysql_fetch_array($zapytanie2); 
                        
                                        $punkty = $user['punkty'] + $punkty;

                                        $aktualizujusera = "UPDATE user SET  punkty='". $punkty . "' WHERE login='" . $login ."'";
                                        mysql_query($aktualizujusera) or die(mysql_error());
                                    }
                                    
                                    
                                    $_SESSION['success'] = '<div class="alert alert-success">Dodano Punkty!</div>';
                                    header("Location: /admin_punkty.php");
                            }
                            else
                            {
                                echo '<div class="alert alert-danger">Nie uzupełniono wszystkich pól!</div>';
                            }
                        }
                    */
                    ?>
                    <form method="post" action="admin_punkty2.php">
                        <div class="form-group">
                            <label for="loginAdd">Tutaj wpisz login użytkownika, któremu chcesz dodać punkty:</label>
                            <input type="text" class="form-control" id="loginAdd" name="loginAdd" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label for="loginAdd">Tutaj wpisz login użytkownika, któremu chcesz odjąć punkty:</label>
                            <input type="text" class="form-control" id="loginSub" name="loginSub" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label for="note">Notatka Administracyjna:</label>
                            <input type="text" class="form-control" id="note" name="nazwa" required>
                        </div>

                        <div class="form-group">
                            <label for="points">Tutaj wpisz ile chcesz dodać punktów:</label>
                            <input type="text" class="form-control" id="points" name="punkty" required>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Wykonaj przelew">

                    </form>
                </div>
 
<?php } ?>
</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>