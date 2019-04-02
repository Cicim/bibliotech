<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Bibliotech - Registrazione</title>

    <!-- Importa tutte le librerie comuni -->
    <?php include "../php/imports.php" ?>

    <!-- Importa lo stile per il login -->
    <link href="../css/login.css" rel="stylesheet">

    <!-- Carica le librerie per il datetimepicker -->
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
</head>

<!-- Tutta la pagina è centrata -->

<body class="text-center">
    <!-- Includi l'header -->
    <?php include "../views/header.php" ?>

    <!--Script php per l'invio dei dati al database-->
    <?php
    /**
     * Funzione per effettuare la registrazione.
     * Per poter uscire in qualsiasi momento
     * utilizzando la keyword return. 
     * @return string Lo stato attuale della registrazione
     */
    function registrazione()
    {
        // Includi il codice per la connessione al database
        include "../php/connessione.php";
        $conn = connettitiAlDb();

        // Recupera i dati dal form
        $nome = $_POST["nome"];
        $cognome = $_POST["cognome"];
        $sesso = $_POST["sesso"];
        $viaPzz = $_POST["viaPzz"];
        $citta = $_POST["citta"];
        $numeroCivico = $_POST["numeroCivico"];
        $codFiscale = $_POST["codFiscale"];
        $dataNascita = date('Y-m-d', strtotime(str_replace('/', '-', $_POST["dataNascita"])));
        $telCellulare = $_POST["telCellulare"];
        $telFisso = $_POST["telFisso"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confermaPassword = $_POST["confermaPassword"];

        // Esegui i necessari controlli
        // 1) Confronta il codice fiscale con quello calcolato
        echo comparaDatiConCodiceFiscale($nome, $cognome, $dataNascita, $sesso);


        // Se il telefono fisso non è stato inserito, settalo a NULL
        if ($telFisso == "") $fisso = "NULL";
        // Altrimenti mettilo tra virgolette
        else $fisso = "'$telFisso'";

        // Genera l'hash della password
        $pwd = md5($password);

        //Query di inserimento campi nel database
        $qry = "INSERT INTO Utenti (CodFiscale, Nome, Cognome, Email, ViaPzz, NumeroCivico,
            TelefonoCellulare, TelefonoFisso, Validato, CodiceValidazione, DataValidazione,
            Sesso, Password, Citta, DataNascita, Permessi) VALUES
            ('$codFiscale', '$nome', '$cognome', '$email',
             '$viaPzz', $numeroCivico, '$telCellulare', $fisso, 1, NULL, '2019-03-12',
             '$sesso', '$pwd', 279, '$dataNascita', 3)";

        // Mostra l'errore
        // if (!$query_res = mysqli_query($conn, $qry)) {
        //     echo ("ERROR: " . mysqli_error($conn));
        // }

        //Chiudo la connessione
        mysqli_close($conn);
    }

    // Se il form è stato compilato
    if (isset($_POST["nome"]))
        // Esegui la funzione per la registrazione
        $stato = registrazione();


    ?>


    <!-- Il form per la registrazione -->
    <form class="form-signin mt-5" style="max-width: 700px" novalidation="" method="post" action="">
        <h1>Bibliotech</h1>
        <h1 class="h3 mb-3 font-weight-normal">Registrati</h1>

        <!-- Prima riga (3 caselle) -->
        <div class="row">
            <!-- Nome -->
            <div class="col-md-5 mb-3">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome" placeholder="Es. Mario" value="" required="true">
                <div class="invalid-feedback">Inserisci un nome valido</div>
            </div>
            <!-- Cognome -->
            <div class="col-md-5 mb-3">
                <label for="cognome">Cognome</label>
                <input type="text" class="form-control" name="cognome" placeholder="Es. Rossi" value="" required="true">
                <div class="invalid-feedback">Inserisci un cognome valido.</div>
            </div>
            <!-- Selezione Sesso -->
            <div class="col-md-2 mb-3">
                <label for="sesso">Sesso</label>
                <select type="text" class="form-control" name="sesso" value="" required="true">
                    <option>M</option>
                    <option>F</option>
                    <option>Altro</option>
                </select>
            </div>
        </div>

        <!-- Seconda riga (3 caselle) -->
        <div class="row">
            <!-- Via / Piazza-->
            <div class="col-md-6 mb-3">
                <label for="viaPzz">Via / Piazza</label>
                <input class="form-control w-100" name="viaPzz" placeholder="Es. Via Garibaldi / Piazza Verdi" required="true">
                <div class="invalid-feedback">Inserisci una via valida</div>
            </div>

            <!-- Città -->
            <div class="col-md-4 mb-3">
                <label for="citta">Città</label>
                <input class="form-control w-100" name="citta" placeholder="Es. Torino" required="true">
                <div class="invalid-feedback">Inserisci una città valida.</div>
            </div>

            <!-- Numero Civico -->
            <div class="col-md-2 mb-3">
                <label for="numeroCivico"># Civico</label>
                <input type="text" class="form-control" name="numeroCivico" placeholder="Es. 20">
            </div>
        </div>

        <!-- Terza riga (2 caselle, datetimepicker) -->
        <div class="row">
            <!-- Codice Fiscale -->
            <div class="col-md-6 mb-3">
                <label for="codFiscale">Codice Fiscale</label>
                <input type="text" class="form-control" name="codFiscale" placeholder="Es. RSSMRO25R12R657K" required="true">
                <div class="invalid-feedback">Inserisci un codice fiscale valido</div>
            </div>
            <!-- Data di Nascita -->
            <div class="container col-md-6 mb-3">
                <label for="datetimepicker">Data di Nascita </label>
                <div class="form-group">
                    <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" name="dataNascita" data-target="#datetimepicker" />
                        <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                            <div class="input-group-text">
                                <i class="fa fa-calendar" style="font-size:24px"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Codice per il datetimepicker -->
        <script type="text/javascript">
            $(function() {
                $('#datetimepicker').datetimepicker({
                    format: 'YYYY-MM-DD',
                    locale: 'it',
                });
            });
        </script>

        <!-- Quarta riga (2 caselle) -->
        <div class="row">
            <!-- Telefono Cellulare -->
            <div class="col-md-6 mb-3">
                <label for="telCellulare">Telefono Cellulare</label>
                <input type="text" class="form-control" name="telCellulare" placeholder="Cellulare" required="true">
                <div class="invalid-feedback">Inserisci il numero di telefono.</div>
            </div>
            <!-- Telefono Fisso -->
            <div class="col-md-6 mb-3">
                <label for="telFisso">Telefono Fisso</label>
                <input type="text" class="form-control" name="telFisso" placeholder="Fisso (opzionale)">
            </div>
        </div>

        <!-- Quinta riga (1 casella) -->
        <!-- Indirizzo Email -->
        <div class="mb-3">
            <label for="email">Indirizzo Email</label>
            <input type="email" class="form-control" name="email" placeholder="Es. mario.rossi@gmail.com" required="true">
            <div class="invalid-feedback">Inserisci un'email valida.</div>
        </div>

        <!-- Sesta riga (2 caselle) -->
        <div class="row">
            <!-- Password -->
            <div class="col-md-6 mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" required="true" onchange='passwordUguali()' pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                <span> Minimo 8 caratteri con una maiuscola, una minuscola ed un numero. </span>
                <div class="invalid-feedback">Inserisci una password valida.</div>
            </div>

            <!-- Conferma Password -->
            <div class="col-md-6 mb-3">
                <label for="confermaPassword">Conferma Password</label>
                <input type="password" class="form-control" name="confermaPassword" required="true" onchange='passwordUguali()' pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                <div class="invalid-feedback">Inserisci una password valida.</div>
            </div>
        </div>

        <!-- Javascript per il controllo delle password -->
        <script type="text/javascript">
            // Controllo per combaciamento password
            function passwordUguali() {
                if (document.getElementById('password').value ==
                    document.getElementById('confermaPassword').value) {
                    document.getElementById('confermaPassword').style.color = 'green';
                } else {
                    document.getElementById('confermaPassword').style.color = 'red';
                }
            }
        </script>

        <!-- Pulsante per inviare -->
        <button class="btn btn-primary btn-lg btn-info w-100 mt-5" type="submit">Registrati</button>
        <!-- Link per tornare al login -->
        <p class="mt-3 mb-3 text-muted">
            Sei già registrato? Torna al <a href="login.php">login</a>
        </p>

        <!-- Footer -->
        <p class="mt-5 mb-3 text-muted">&copy; Bibliotech, 2019 </p>
    </form>

</body>

</html> 