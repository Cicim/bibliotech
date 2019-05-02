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

        $copiePrestate = 0;
        /**
         * @author Claudio Cicimurri, 5CI
         * Funzione per uscire in qualsiasi momento con un errore
         * dalla creazione di un prestito
         * @return string Codice di errore o ok
         */
        function creazionePrestito()
        {
            global $stato_fisc, $fisc, $copiePrestate;
            // Assicurati che un utente sia stato selezionato
            if (!$stato_fisc)
                return "Nessun utente selezionato<br>Impossibile proseguire";

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
                return "Non è stata scelta nessuna copia<br>Impossibile proseguire";
            // Se la dataRiconsegna non è definita
            if ($dataRiconsegna == '')
                return "Data riconsegna non valida<br>Impossibile proseguire";

            // Ottieni la data odierna
            $dataConsegna = date('Y-m-d');

            // Connettiti al db
            $conn = connettitiAlDb();

            // Separa le copie per ,
            $copie = explode(',', $idCopia);
            // Elimina i duplicati
            $copie = array_unique($copie);
            
            // Crea un log di errore
            $log = '<ol>';

            // Manda un errore se qualche valore non è un numero
            foreach ($copie as $idCopia) {
                // Controlla che tutti gli id copia siano validi
                if (preg_match("/^\d+$/", $idCopia) == false)
                    return "Id copia non valido: \"$idCopia\". Evita di inserirli manualmente<br>Impossibile proseguire";
            }

            
            // Per ogni copia
            foreach ($copie as $idCopia) {
                // Controlla se non è già stata prenotata
                if (mysqli_fetch_row(mysqli_query($conn, "SELECT Prestato FROM Copie WHERE idCopia = $idCopia"))[0])
                {
                    // Stampa l'errore a log
                    $log .= "<li>Trovata copia già prestata ($idCopia)</li>";
                    continue;
                }

                // Bloccala
                mysqli_query($conn, "UPDATE Copie SET Prestato = TRUE WHERE idCopia = $idCopia");

                // Esegui la query
                $query = "INSERT INTO Prestiti (DataConsegna, DataRiconsegna, idCopia, codFiscaleUtente, bibConsegna)
                            VALUES ('$dataConsegna', '$dataRiconsegna', $idCopia, '$codUtente', '$codBib')";
                // Aggiungi il prestito
                $ris = mysqli_query($conn, $query);

                // Se il prestito non riesce
                // P.S. Non dovrebbe avvenire mai quest'errore
                if (!$ris)
                {
                    // Stampa l'errore a log
                    $log .= "<li>Errore durante l'esecuzione della query ($idCopia)<br>"
                     . mysqli_error($conn) . '</li>';
                    continue;
                }

                // Incrementa il numero di copie correttamente prestate
                $copiePrestate++;
            }

            // Se non ci sono errori
            if ($log == '<ol>')
                return "ok";
            // Altrimenti
            else {
                // Chiudi il log
                $log .= '</ol>';
                // Aggiungi il numero di copie prestate
                if ($copiePrestate == 1) $log .= "Prestata una copia";
                else $log .= "Prestate $copiePrestate copie";
                // Riportalo come errore
                return $log;
            }
        }

        $stato = "";
        // Script per effettuare il prestito
        if (isset($_POST['dataRiconsegna']))
            $stato = creazionePrestito();
        ?>


        <!-- Contenitore -->
        <div class="container">
            <?php
            global $stato, $copiePrestate;

            // Se il prestito è stato effettuato con successo
            if ($stato == "ok")
                // Stampa il numero di copie prestate
                echo '<div class="alert alert-success" role="alert">' .
                    ($copiePrestate == 1 ? "Copia del libro prestata" : "Prestate $copiePrestate copie")
                . '</div>';
            else if ($stato != '') {
                echo '<div class="alert alert-danger" role="alert">';
                echo $stato;
                echo '</div>';
            }
            ?>

            <!-- Rinnovo della data -->
            <form action="" method="POST">

                <label for="DataRinnovata">Seleziona la nuova data di scadenza del prestito</label>
                <div class="form-group">
                    <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" id="DataRinnovata" name="DataRinnovata" data-target="#datetimepicker" value="<?php echo $riconsegna ?>" />
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
                <button type="submit" class="btn btn-info">Rinnova prestito</button>
                <a class="btn btn-warning ml-2 block" href="vis-prestiti-scadenze.php"><i class="fa fa-arrow-left"></i> Torna alla sezione prestiti</a>
                <br>
                <br>
            </form>
            <?php

            if(isset($_GET['btnRinnova'])){

              echo $_GET['btnRinnova'];
              
              $host = "localhost";
              $user = "root";
              $password = "";

              $conn = mysqli_connect($host, $user, $password);

              if(!$conn){
                  echo "Impossibile connettersi al database";
              }
              else{

                  $sel = mysqli_select_db($conn, "Biblioteca");

                  if(!$sel){
                      echo "Database non trovato";
                  }
                  else{

                    if(isset($_POST['DataRinnovata'])){

                      $query = "UPDATE Prestiti
                      SET DataRiconsegna = \"" . $_POST['DataRinnovata'] .
                      "\" WHERE idPrestito = \"" . $_POST['idPrestito'] . "\"";

                      echo $query;

                      $risultato = mysqli_query($conn, $query);
                      if(!$risultato){
                          echo "Errore nella query";
                      }
                      else{

                        
                      
                      }
                    }
                  }
                }
            }
            ?>
        </div>
    </div>


    <!-- Pagina del footer importata -->
    <?php include_once "../views/footer.php"; ?>

</body>