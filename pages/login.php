<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Bibliotech - Login</title>

    <!-- Importa tutte le librerie comuni -->
    <?php include "../php/imports.php" ?>

    <!-- Importa lo stile per il login -->
    <link href="../css/login.css" rel="stylesheet">
</head>

<!-- Tutta la pagina è centrata -->

<body class="text-center">
    <!-- Importa l'header -->
    <?php include "../views/header.php" ?>

    <form class="form-signin" method="post" action="">
        <!-- Icona di Bibliotech -->
        <h1>Bibliotech</h1>
        <h1 class="h3 mb-3 font-weight-normal">Schermata di accesso</h1> <br>

        <!-- Casella per l'e-mail -->
        <label for="email" class="sr-only">Indirizzo mail</label>
        <input type="email" name="email" class="form-control" placeholder="Indirizzo mail" required autofocus>

        <!-- Casella per la password -->
        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Password" required>

        <!-- Checkbox per essere ricordato -->
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Ricordami
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-info btn-block" type="submit">Accedi</button> <br>

        <!-- Collegamento alla pagina per recuperare la password -->
        <a href="recupero.php" class="text-info">Recupero password </a> <br>
        <!-- Collegamento alla pagina per la registrazione -->
        <a href="registrazione.php" class="text-info"> Registrati </a>

        <!-- Footer -->
        <p class="mt-5 mb-3 text-muted">&copy; Bibliotech, 2019 </p>
    </form>

    <!--Script PHP-->
    <?php
    //includo la funzione per la connessione al DB
    include "../php/connessione.php";

    if(isset($_POST["email"]))
    {
        //recupero le informazioni inserite nei form
        $email = $_POST["email"];
        $pw = $_POST["password"];

        //connetto al DB
        $conn = connettitiAlDb();

        //query per vedere se le informazioni sono corrette
        $qry = "SELECT Email, Password FROM Utenti WHERE Email = '$email'";
        $qry_res = mysqli_query($conn, $qry) or die("Impossibile eseguire query<br>" . mysqli_error($conn));

        //se la mail è presente nel database
        if(!$qry_res)
            echo "Email non presente<br>";
        else 
        {
            $r = mysqli_fetch_row($qry_res);
            //estraggo i risultati
            $md5 = $r[1];

            //controlla se la password è giusta
            if(md5($pw) == $md5)
            {
                echo "Password corretta<br>";
            }
            else
            {
                echo "Password errata<br>";
                
            }
            $password = md5($pw);
            echo "md5: ".$md5."---pw: ".$pw."---PSW: ".$password."<br>";
        }







    }



    ?>
</body>

</html> 