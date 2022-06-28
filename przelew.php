<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Przelewy | SamoŻycie |</title>
	<?php include('inc/dane_head.php'); ?>
</head>

<body>
<?php
include('connect.php');
include('inc/menu.php');
include('inc/elasticsearch.php');

if(empty($_SESSION['login']))
{
	header("Location: login.php");
}
?>

<div class="main-content">
	
	<div class="header">
		<div class="header-big">Przelew</div>
		<div class="header-small">Tutaj możesz wykonać przelew do innej osoby.</div>
	</div>
<?php
	$ranga = mysql_query("SELECT * FROM user WHERE login='".$_SESSION['login']."'"); 
    $user = mysql_fetch_array($ranga); 
?>
	<div class="przelew">
	<?php
                    if(isset($_SESSION['success_add'])){
                        echo $_SESSION['success_add'];
                        unset($_SESSION['success_add']);
                    }
                    if(isset($_SESSION['message'])){
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }
                    ?>

                        <?php
                        if($_SERVER['REQUEST_METHOD']=="POST"){
                            //echo var_dump($_POST);
                            if($_POST["punkty"] < 1)
                            {
                                $_SESSION["message"] = '<div class="alert alert-danger">No soreczki mordeczko - nie uda Ci się! ):</div>';
                                header("Location: przelew.php");
                                die();
                            }
					
                            else if($user["punkty"] < $_POST['punkty'])
                            {
                                $_SESSION["message"] = '<div class="alert alert-danger">No soreczki mordeczko - nie uda Ci się! ):</div>';
                                header("Location: przelew.php");
                                die();
                            }
                            else if(!in_array($_POST['loginAdd'], $users))
                            {
                                $_SESSION["message"] = '<div class="alert alert-danger">Użytkownik nie istnieje!</div>';
                                header("Location: przelew.php");
                                die();
                            }
                            else if($_POST['loginAdd'] == $user['login'])
                            {
                                $_SESSION["message"] = '<div class="alert alert-danger">Błąd użytkownika - Nie możesz przelewać pieniędzy samemu sobie!</div>';
                                header("Location: przelew.php");
                                die();
                            }
                            
                            if(!empty($_POST['loginAdd'])&&!empty($_POST['notatka'])&&!empty($_POST['punkty'])){
                                try{
                                    $points = $_POST['punkty'];
                                    $loginAdd = $_POST['loginAdd'];
                                    $note = $_POST['notatka'];
                                    $loginSub = $user['login'];
                                    $message = "Otrzymałeś ".$points."$ od <b>".$loginSub."</b>";
                                    $stmt_add = $pdo->prepare("INSERT INTO zgloszenia VALUES(NULL, :loginAdd, NOW(), '', :user, '-', :points, :note, '1', '1', '')");
                                    $stmt_add->bindParam(":loginAdd", $loginAdd, PDO::PARAM_STR);
                                    $stmt_add->bindParam(":user", $loginSub, PDO::PARAM_STR);
                                    $stmt_add->bindParam(":points", $points, PDO::PARAM_STR);
                                    $stmt_add->bindParam(":note", $note, PDO::PARAM_STR);
                                    $stmt_add->execute();
                                    $stmt_addmsg = $pdo->prepare("INSERT INTO wiadomosc VALUES (NULL, :messages, :loginAdd, :loginSub, NOW(), '0')");
                                    $stmt_addmsg->bindParam(":loginAdd", $loginAdd, PDO::PARAM_STR);
                                    $stmt_addmsg->bindParam(":loginSub", $loginSub, PDO::PARAM_STR);
                                    $stmt_addmsg->bindParam(":messages", $message, PDO::PARAM_STR);
                                    $stmt_addmsg->execute();
                                    $stmt_user_add = $pdo->prepare("UPDATE user SET punkty = punkty + :points where login = :userAdd ");
                                    $stmt_user_add->bindParam(":points", $points, PDO::PARAM_INT);
                                    $stmt_user_add->bindParam(":userAdd", $loginAdd, PDO::PARAM_STR);
                                    $stmt_user_add->execute();
                                    $stmt_user_sub = $pdo->prepare("UPDATE user SET punkty = punkty - :points where login = :userSub ");
                                    $stmt_user_sub->bindParam(":points", $points, PDO::PARAM_INT);
                                    $stmt_user_sub->bindParam(":userSub", $loginSub, PDO::PARAM_STR);
                                    $stmt_user_sub->execute();
                                    $_SESSION['success_add'] = '<div class="alert alert-success">Pomyślnie wykonano przelew!</div>';
                                    header("Location: przelew.php");
                                }
                                catch(Exception $ex){
                                    echo var_dump($ex);
                                }
                                
                            }
                            else{
                                $_SESSION["message"] = '<div class="alert alert-danger">Proszę wypełnić wszystkie wymaganie pola!</div>';
                                header("Location: przelew.php");
                            }
                        }
                    
                    ?>
                        <form method="post">
                            <div class="form-group">
                                <label for="loginAdd">Login użytkownika:</label>
                                <input type="text" class="form-control" id="loginAdd" name="loginAdd" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <label for="points">Tutaj wpisz ile Koprów chcesz przelać:</label>
                                <input type="text" class="form-control" id="points" name="punkty" required>
                            </div>
                            <div class="form-group">
                                <label for="note">Tytuł przelewu:</label>
                                <input type="text" class="form-control" name="notatka" id="note" required>

                            </div>

                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-form" value="Wykonaj Przelew">
                            </div>
                        </form>
  </div>
	
</div>
<!-- KONIEC CONTAINER-->

  <?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>