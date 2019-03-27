<!-- File creato inizialmente da Claudio Ferocino -->
<?php
	$host = "localhost";
	$username = "";
	$password = "";
	$db_nome = "db1";
	$tab_nome = "utenti";
	
	// connessione al server
	mysql_connect($host, $username, $password) or die('Impossibile connettersi al server: ' . mysql_error());
	// accesso al database
	mysql_select_db($db_nome) or die('Accesso al database non riuscito: ' . mysql_error());
	
	// acquisizione dati dal form HTML
	$email = $_POST["email"];
	$password = $_POST["password"];
	
	// protezione per SQL injection
	$email = stripslashes($email);
	$password = stripslashes($password );
	$email = mysql_real_escape_string($email);
	$password = mysql_real_escape_string($password );
	$passmd5 = md5($pasword);
	
	// lettura della tabella utenti
	$sql = "SELECT * FROM $tab_nome WHERE Email = '$email' AND Password = '$passmd5'";
	$result = mysql_query($sql);
	$conta = mysql_num_rows($result);
	if($conta == 1)
	{
		session_start();
		$_SESSION['email'] = $email;
		$_SESSION['password'] = $passmd5;
		header("Location: loginok.php");
	}
	else
	{
		echo "Identificazione non riuscita: nome utente o password errati <br />";
		echo "Torna a pagina di <a href = \"login.php\">login</a>";
	}
?>