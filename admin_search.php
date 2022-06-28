<?php
header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

include('connect.php');

if(empty($_SESSION['login']))
{
	header("Location: login.php");
}
try{
    if($_SERVER['REQUEST_METHOD']=="POST"){
        if(!empty($_POST['userSearch'])){
            $search = $_POST['userSearch'];
            $strings = split(" - ", $search);
            $stmt = $pdo->prepare("SELECT * FROM user WHERE login=:login");
            $stmt->bindParam(":login", $strings[0], PDO::PARAM_STR);
            $stmt->execute();
            $user_search = $stmt->fetch();
            if($user_search){
                header("Location: admin_zobacz.php?id=".$user_search['id']);
            }
            else {
                header("Location: profil.php");
            }
            //echo var_dump($user_search);
            //echo "admin_zobacz.php?id=".$user_search['id'];
             }
        
        
    }
    else{
        header("Location: profil.php");
    }
} catch(Exception $ex){
    header("Location: index.php");
    echo $ex->getMessage();
}
//header("Location: index.php");

?>