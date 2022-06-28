<?php
$pdo = null;
try{
    $pdo = new PDO('mysql:host=mariadb105.server009267.nazwa.pl;dbname=server009267_samozycie;charset=utf8', 'server009267_samozycie', 'Admin123');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
}


mysql_connect ("mariadb105.server009267.nazwa.pl","server009267_samozycie","Admin123"); //łącze z bazą [serwer bazy,użytkownik,hasło]
mysql_select_db ("server009267_samozycie"); //nazwa bazy
error_reporting(0);

//PONIŻEJ NIC NIE ZMIENIAĆ!
mysql_query ("SET NAMES utf8"); //kodowanie znaków

$reklamkatekst = "";
$datawysylka = "";
$user = null;
try{
    $stmt = $pdo->query("SELECT * FROM reklamka");
    $reklamkatekst = $stmt->fetch();
    $stmt = $pdo->query("SELECT * FROM wysylka");
    $datawysylka = $stmt->fetch();
    $stmt = $pdo->prepare("SELECT * FROM user WHERE login=:login");
    $stmt->bindParam(":login", $_SESSION['login'], PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch();
}
catch(Exception $ex){
    //echo $ex->getMessage();
}

$is_admin = false;
if($user['ranga']>1){
    $is_admin = true;
}

$is_vip = false;
if($user['ranga']==1){
    $is_vip = true;
}

//$reklamka = mysql_query("SELECT * FROM reklamka");
//$reklamkatekst = mysql_fetch_array($reklamka);

//$data = mysql_query("SELECT * FROM wysylka");
//$datawysylka = mysql_fetch_array($data);


$reklama = '<div class="panel panel-primary">
    <div class="panel-heading">Ważna wiadomość!</div>

    <div class="panel-body">
        <center><b>'. $reklamkatekst[0] .'</b></center>

    </div>

</div>';

    

?>