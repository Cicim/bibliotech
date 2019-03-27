<!DOCTYPE html>
<html>

<head>
	<title>Identificazione dell'utente</title>
	
    <?php include "php/imports.php" ?>
</head>

<body>
    <?php include "php/header.php" ?>
    <h2>Accesso all'area riservata</h2>
    <form action="php/controllalogin.php" method="post">
        <p>
            Email: <input type="text" name="email" size="40" />
            Password: <input type="password" name="password" size="40" /><br />
        </p>
        <p>
            <input type="submit" name="invio" value="Login" />
            <input type="reset" name="cancella" size="Annulla" />
        </p>
    </form>
    <?php include "php/footer.php" ?>
</body>

</html>