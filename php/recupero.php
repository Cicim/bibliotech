<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Bibliotech - Recupero password</title>

    <!-- Bootstrap core CSS -->
    <?php include "imports.php" ?>

    <!-- Custom styles for this template -->
    <link href="../css/login.css" rel="stylesheet">
</head>

<body class="text-center">

    <?php include "header.php" ?>

    <form class="form-signin">
        <!-- Icona di Bibliotech -->
        <h1> Bibliotech </h1>
        <h1 class="h3 mb-3 font-weight-normal">Schermata di accesso</h1> <br>

        <label for="inputEmail" class="sr-only">Indirizzo mail</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Indirizzo mail" required autofocus>

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Ricordami
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-info btn-block" type="submit">Accedi</button> <br>

        <a href="#" class="text-info"> Recupero password </a> <br>
        <a href="/bib2/php/registrazione.php" class="text-info"> Registrati </a>
        <p class="mt-5 mb-3 text-muted">&copy; Bibliotech, 2019 </p>
    </form>

    <?php
    if (isset($_POST['invia'])) {

        $errore = 0;

        if ($_POST['email'] == "") {
            $errore = 1;
        } else {
            $result = mysql_query("select id, password from utenti where email='" . $_POST['email'] . "' limit 0,1", $db);
            if (mysql_num_rows($result) > 0) {
                $row = mysql_fetch_array($result);
                $hash = $row['password'] . "" . $row['id'];
            } else
                $errore = 1;
        }

        if ($errore == 0) {

            $header = "From: sito.it <info@sito.it>\n";
            $header .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
            $header .= "Content-Transfer-Encoding: 7bit\n\n";

            $subject = "sito.it - Nuova password utente";

            $mess_invio = "<html><body>";

            $mess_invio .= "
		Clicca sul <a href=\"http://www.sito.it/nuova_password.php?hash=" . $hash . "\">link</a> per confermare la nuova password.<br />
		Se il link non è visibile, copia la riga qui sotto e incollala sul tuo browser: <br />
		http://www.sito.it/nuova_password.php?hash=" . $hash . "
		";

            $mess_invio .= '</body><html>';

            //invio email
            if (@mail($_POST['email'], $subject, $mess_invio, $header)) {
                echo "<div class=\"campo_contatti\" style=\"margin-left: 20px; height: 300px\">";
                echo "Email inviata con successo. Controlla la tua email<br /><br />";
                echo "</div>
			<div class=\"clear\"></div>";
                unset($_POST);
            }
        }
    }
    ?>

    <!--<form action="" method="post" id="login">
        <div class="campo_contatti">
            <div class="voce_campo">Inserisci la tua email per ricevere la nuova password</div>
            <input type="text" name="email" value="<?= @$_POST['email'] ?>" class="campo" />
        </div>

        <div class="clear"></div>

        <div class="campo_contatti">
            <input type="submit" value="invia" />
        </div>

        <div class="clear"></div>

    </form>-->

</body>

</html> 