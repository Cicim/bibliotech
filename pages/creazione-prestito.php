<!-- Pagina scritta dal gruppo 2 -->
<!-- Passata di mano al gruppo 1 (D'Averio, incontro del 16/04/2019) -->
<!-- Modifiche a cura di Claudio Cicimurri, 5CI -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Creazione di un prestito - Bibliotech</title>

    <!-- Inclusione librerie di Bootstrap -->
    <?php include_once "../php/imports.php"; ?>

    <!-- Importa tutte le librerie per il datepicker -->
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
</head>

<!-- Esci in caso di accesso negato -->
<?php
include_once "../php/access-denied.php";
livelloRichiesto(BIBLIOTECARIO); ?>

<body class="wrapper">
    <!-- Pagina dell'header importata -->
    <?php include_once "../views/header.php"; ?>

    <div>
        <!-- Titolo della pagina -->
        <div class="jumbotron" style="padding: 2rem 2rem">
            <h1 class="display-5 text-center">Creazione di un prestito</h1>
        </div>

        <?php
        include_once "../php/connessione.php";
        $fisc = '';
        /**
         * @author Claudio Cicimurri, 5CI
         * Funzione per uscire in qualsiasi momento con un errore
         * dalla selezione del codice fiscale
         * @return bool Se ha trovato l'utente
         */
        function selezioneCodiceFiscale()
        {
            // Connettiti al database
            $conn = connettitiAlDb();

            // Ottieni il codice fiscale
            global $fisc;
            $fisc = $_GET['codiceFiscale'];


            // Ottieni l'utente, se esiste
            $ris = mysqli_query($conn, "SELECT Nome, Cognome, Email FROM Utenti WHERE CodFiscale = '$fisc'");

            // Chiudi la connessione
            mysqli_close($conn);

            if (mysqli_num_rows($ris) == 1) {
                $ris = mysqli_fetch_row($ris);
                global $nome, $cognome, $email;
                // Ottieni i dati
                $nome = $ris[0];
                $cognome = $ris[1];
                $email = $ris[2];

                // Imposta lo stato a ok
                return true;
            } else
                return false;
        }

        $stato_fisc = "";
        // Controlla se l'utente è già stato selezionato
        if (isset($_GET['codiceFiscale']))
            $stato_fisc = selezioneCodiceFiscale();

        /**
         * @author Claudio Cicimurri, 5CI
         * Funzione per uscire in qualsiasi momento con un errore
         * dalla creazione di un prestito
         * @return string Codice di errore o ok
         */
        function creazionePrestito()
        {
            global $stato_fisc, $fisc;
            // Assicurati che un utente sia stato selezionato
            if (!$stato_fisc)
                return "Nessun utente selezionato";

            // Ottieni il codice fiscale dell'utente
            $codUtente = $fisc;
            // Ottieni il codice fiscale del bibliotecario
            $codBib = $_SESSION['user_id'];

            // Ottieni l'id della copia
            $idCopia = $_POST['idCopia'];
            // Ottieni la data di riconsegna
            $dataRiconsegna = $_POST['dataRiconsegna'];

            // Se l'idCopia non è definito
            if ($idCopia == '')
                return "Non è stata scelta nessuna copia";
            // Se la dataRiconsegna non è definita
            if ($dataRiconsegna == '')
                return "Data riconsegna non valida";

            // Ottieni la data odierna
            $dataConsegna = date('Y-m-d');

            // Connettiti al db
            $conn = connettitiAlDb();

            // Controlla che il libro non sia già prenotato
            if (mysqli_fetch_row(mysqli_query($conn, "SELECT Prestato FROM Copie WHERE idCopia = $idCopia"))[0])
                return "Copia già prestata";

            // Blocca il libro
            mysqli_query($conn, "UPDATE Copie SET Prestato = TRUE WHERE idCopia = $idCopia");

            // Esegui la query
            $query = "INSERT INTO Prestiti (DataConsegna, DataRiconsegna, idCopia, codFiscaleUtente, bibConsegna)
                        VALUES ('$dataConsegna', '$dataRiconsegna', $idCopia, '$codUtente', '$codBib')";
            // Aggiungi il prestito
            $ris = mysqli_query($conn, $query);

            if ($ris)
                return "ok";
            else
                return "Errore durante l'esecuzione della query<br>" . mysqli_error($conn);
        }

        $stato = "";
        // Script per effettuare il prestito
        if (isset($_POST['dataRiconsegna']))
            $stato = creazionePrestito();
        ?>


        <!-- Contenitore -->
        <div class="container">
            <?php
            global $stato;

            // Se il prestito è stato effettuato con successo
            if ($stato == "ok")
                echo '<div class="alert alert-success" role="alert">Libro prestato</div>';
            else if ($stato != '') {
                echo '<div class="alert alert-danger" role="alert">';
                echo $stato;
                echo '</div>';
            }
            ?>
            <!-- Prima riga: selezione utente -->
            <form action="" method="GET">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Codice fiscale" name="codiceFiscale" value="<?php echo $fisc ?>">
                    <div class="input-group-append">
                        <button class="btn btn-info" type="submit">Verifica utente</button>
                    </div>
                </div>
                <?php
                // Stampa il risultato dell'operazione
                if ($fisc == '')
                    echo "<div class='alert alert-info'>
                        Seleziona un codice fiscale</div>";
                else if ($stato_fisc)
                    echo "<div class='alert alert-primary'>
                        Scegli dati per il prestito a <b>$nome $cognome</b> &lt;<b>$email</b>&gt;</div>";
                else
                    echo "<div class='alert alert-danger'>
                        Utente con codice fiscale \"<b>$fisc</b>\" non trovato</div>";

                // Calcola la prossima data di riconsegna
                $riconsegna =  date('Y-m-d', strtotime('+30 days', time()))
                ?>
            </form>

            <!-- Seconda riga: seleziona copia -->
            <form action="" method="POST">
                <label for="idCopia">Seleziona l'id della copia:</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Id copia" name="idCopia" id="idCopia">
                    <div class="input-group-append">
                        <!-- Al click del pulsante, apri un popup -->
                        <a class="btn btn-outline-info" onclick="window.open('../views/catalogo.php?bibliotecario', 'Seleziona id copia', 'width=600,height=400,status=yes,scrollbars=yes,resizable=yes')">Seleziona id copia</a>
                    </div>
                </div>

                <label for="dataRiconsegna">Seleziona la data di riconsegna (di default fra 30 giorni):</label>
                <div class="form-group">
                    <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" id="dataRiconsegna" name="dataRiconsegna" data-target="#datetimepicker" value="<?php echo $riconsegna ?>" />
                        <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                            <div class="input-group-text">
                                <i class="fa fa-calendar" style="font-size:24px"></i>
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


                <!-- Pulsante per creare il prestito -->
                <button type="submit" class="btn btn-info">Crea prestito</button>
                <a class="btn btn-warning ml-2 block" href="sezione-amministrativa.php"><i class="fa fa-arrow-left"></i> Torna alla sezione amministrativa</a>
                <br>
                <br>
            </form>
        </div>
    </div>


    <!-- Pagina del footer importata -->
    <?php include_once "../views/footer.php"; ?>

</body>