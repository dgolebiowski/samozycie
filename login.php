<?php
header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1'); 
session_start(); //start sesji 
ob_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Logowanie | SamoŻycie |</title>
	<?php include('inc/dane_head.php'); ?>
	<link rel="stylesheet" type="text/css" href="logowanie/css/main_samozycie.css">
</head>

<body>
<?php
include('connect.php');
?>
	<div class="logowanie">
		
		<div class="login-content">
		
		<div class="logo-menu">
		<div class="logo-menu-img"><img src="img/logo.png"></div>
		<div class="logo-menu-txt"><span class="lg-b">SAMO</span><span class="lg-c">ŻYCIE</span></div>
		</div>
	
<?php

		if (isset($_POST['login']) and isset($_POST['password']))
		{
			if(!$_POST['login'] || !$_POST['password'])
			{
					echo '<span class="header-small"> Nie podano loginu lub hasła!<br/><a href="login.php">&laquo; Powrót</a> </span>';
			}
		else
		{
			$konto=mysql_real_escape_string(trim($_POST['login']));
			$password=mysql_real_escape_string(trim($_POST['password']));
		
		if ($konto!="" and $password!="")
		{
			$password = sha1($password);
			$zapytanie="SELECT * FROM user WHERE login='$konto' and haslo ='$password' and code = '0'";
			$temp=mysql_query($zapytanie) or die("Wystąpił błąd!");
			$ile=mysql_num_rows($temp);
			$temp=mysql_fetch_array($temp);
			$id=$temp['id'];
   
			if ($ile==1)
			{
				$_SESSION['user_id']=$id;
				$_SESSION['login']=$konto;
				$_SESSION['ranga']=$temp['ranga'];
				
				
					header("Location: index.php");
			}
			else
			{
				echo ('<span class="header-small">Podano nieprawidłowe dane! Jeżeli nie możesz się zalogować to albo pomyliłeś dane przy wpisywaniu, albo twoje konto jest nieaktywne <br/><a href="login.php">&laquo; Wróć</a></span>'); }
			}
		}
		}
		else{
		?>
				<form class="login100-form validate-form" action="login.php" method="post">
					
					<div class="wrap-input100 validate-input" data-validate="Wpisz Login!">
					<input class="input100" type="text" name="login" placeholder="Login">
					</div>
					
					<div class="wrap-input100 validate-input" data-validate="Wpisz Hasło!">
					<input class="input100" type="password" name="password" placeholder="Hasło">
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<input type="hidden" name="loguj"><button type="submit" name="submit" class="login100-form-btn">Zaloguj!</button>
						</div>
					</div>

					<div class="header-small">
							Nie masz konta?
						<a href="register.php">
							Zarejestruj się!
						</a>
					</div>
				</form>
						<?php }?>
			</div>
	</div>
<?php include('inc/footer.php'); ?>
</body>
</html>

<?php ob_end_flush(); ?>