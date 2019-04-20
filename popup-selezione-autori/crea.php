<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Crea autore - Bibliotech</title>

    <!-- Include le librerie comuni -->
    <?php
    include_once "../php/imports.php";
    include_once "../php/connessione.php";
    $conn = connettitiAlDb();
    ?>

    <!-- Carica il css per il catalogo -->
    <link rel="stylesheet" type="text/css" href="../css/catalogo.css">
    <!-- Carica il js e il css per la combobox -->
    <script src="../js/combobox.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/combobox.css">

    <!-- Carica le librerie per il datetimepicker -->
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
</head>

<body>
    <!-- Contenuto principale della pagina -->
    <div>
        <!-- Rettangolo grigio per il titolo della sezione -->
        <div class="jumbotron" style="padding: 2rem 2rem">
            <h1 class="display-4 text-center">
                <a href="autori.php" title="Torna alla lista degli autori"><i class="fa fa-undo text-info"></i></a>
                Crea un autore&nbsp;&nbsp;
            </h1>
        </div>

        <?php
        // Importa le librerie
        include_once "../php/connessione.php";

        /**
         * @author Claudio Cicimurri, 5CI
         * Funzione per permettere l'uscita con errore
         * dalla creazione di un autore
         * @return string Errore o "ok" se l'autore è stato inserito con successo
         */
        function inserisciAutore()
        {
            // Ottieni tutti i dati in input
            $nome = $_POST['nome'];
            $cognome = $_POST['cognome'];
            $dataNascita = $_POST['dataNascita'];
            $dataMorte = $_POST['dataMorte'];
            $descrizione = $_POST['descrizione'];
            $nomeArte = $_POST['nomeArte'];
            $cittaNascita = $_POST['cittaNascita'];
            $nazionalita = $_POST['nazionalita'];
            $cittaMorte = $_POST['cittaMorte'];

            // Il cognome deve sempre essere definito
            // Così come il nome, che però può essere lasciato vuoto
            if ($cognome == "") return "Il cognome non può essere vuoto";
            // La data di nascita deve essere inserita
            if ($dataNascita == "") return "La data di nascita è richiesta";
            // La data di morte, la descrizione e il nome d'arte possono
            // essere omessi

            // La nazionalità è richiesta
            if ($nazionalita == "") return "La nazionalità è richiesta";
            // La città di nascita è richiesta
            if ($cittaNascita == "") return "La città di nascita è richiesta";

            // Imposta a NULL i valori omessi
            if ($dataMorte == "") $dataMorte = "NULL";
            else $dataMorte = "'$dataMorte'";
            if ($descrizione == "") $descrizione = "NULL";
            else $descrizione = "'$descrizione'";
            if ($nomeArte == "") $nomeArte = "NULL";
            else $nomeArte = "'$nomeArte'";


            // Connettiti al database
            $conn = connettitiAlDb();

            // Ottieni gli id delle città
            $idCNascita = ottieniIdCitta($cittaNascita);
            // Se non esiste, creala
            if ($idCNascita == false) {
                $query = "INSERT INTO Citta (Nome, Provincia) VALUES ('$cittaNascita', 'XX')";
                mysqli_query($conn, $query);
                // Riottieni l'id
                $idCNascita = ottieniIdCitta($cittaNascita);
            }
            $idCMorte = "NULL";
            if ($cittaMorte != "") {
                $idCMorte = ottieniIdCitta($cittaNascita);
                // Se non esiste, creala
                if ($idCMorte == false) {
                    $query = "INSERT INTO Citta (Nome, Provincia) VALUES ('$cittaMorte', 'XX')";
                    mysqli_query($conn, $query);
                    // Riottieni l'id
                    $idCMorte = ottieniIdCitta($cittaMorte);
                }
            }

            // Esegui la query per l'inserimento dell'autore
            $query = "INSERT INTO Autori (NomeAutore, CognomeAutore, DataNascita, DataMorte,
                         Descrizione, NomeArte, idNazionalita, idCittaNascita, idCittaMorte)
                         VALUES ('$nome', '$cognome', '$dataNascita', $dataMorte,
                         $descrizione, $nomeArte, $nazionalita, $idCNascita, $idCMorte)";
            $ris = mysqli_query($conn, $query);

            if ($ris) return "ok";
            else return "Errore durante l'esecuzione della query<br>" . mysqli_error($conn);
        }

        $stato = "";
        // All'invio dei dati
        if (isset($_POST["inserito"]))
            $stato = inserisciAutore();


        // Se tutto è andato a buon fine
        if ($stato == 'ok') {
            // Stampa un messaggio di successo
            echo '<div class="alert alert-success" role="alert">Autore inserito con successo</div>';
        }
        // Se c'è qualche problema
        else if ($stato != "") {
            // Stampa un alert
            echo '<div class="alert alert-danger" role="alert">';
            // Con un testo diverso a seconda del problema
            echo "$stato</div>";
        }
        ?>

        <!-- idAutore INT NOT NULL AUTO_INCREMENT,
             NomeAutore VARCHAR(45) NOT NULL,
             CognomeAutore VARCHAR(45) NOT NULL,
             DataNascita DATE NOT NULL,
             DataMorte DATE NULL,
             Descrizione VARCHAR(200) NULL,
             NomeArte VARCHAR(45) NULL,
             idNazionalita INT NOT NULL,
             idCittaNascita INT NOT NULL,
             idCittaMorte INT NULL, -->
        <form action="" method="POST">
            <div class="col-md-12 mb-3">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome" placeholder="Es. Mario" value="" required="true">
                <div class="invalid-feedback">Inserisci un nome valido</div>
            </div>

            <!-- Cognome -->
            <div class="col-md-12 mb-3">
                <label for="cognome">Cognome</label>
                <input type="text" class="form-control" name="cognome" placeholder="Es. Rossi" value="" required="true">
                <div class="invalid-feedback">Inserisci un cognome valido.</div>
            </div>

            <!-- Data di Nascita -->
            <div class="container col-12 mb-3">
                <label for="dataNascita">Data di Nascita </label>
                <div class="form-group">
                    <div class="input-group date" id="dataNascita" data-target-input="nearest" required="true">
                        <input type="text" class="form-control datetimepicker-input" name="dataNascita" data-target="#cittaNascita" />
                        <div class="input-group-append" data-target="#dataNascita" data-toggle="datetimepicker">
                            <div class="input-group-text">
                                <i class="fa fa-calendar" style="font-size:24px"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $(function() {
                    $('#dataNascita').datetimepicker({
                        format: 'YYYY-MM-DD',
                        locale: 'it',
                    });
                });
            </script>

            <!-- Data di Morte -->
            <div class="container col-12 mb-3">
                <label for="cittaMorte">Data di Morte </label>
                <div class="form-group">
                    <div class="input-group date" id="dataMorte" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" name="dataMorte" data-target="#cittaMorte" />
                        <div class="input-group-append" data-target="#dataMorte" data-toggle="datetimepicker">
                            <div class="input-group-text">
                                <i class="fa fa-calendar" style="font-size:24px"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $(function() {
                    $('#dataMorte').datetimepicker({
                        format: 'YYYY-MM-DD',
                        locale: 'it',
                    });
                });
            </script>

            <!-- Descrizione del libro-->
            <div class="col-md-12 mb-3">
                <label for="descrizione">Descrizione dell'autore</label>
                <textarea class="form-control" name="descrizione" placeholder="Es. Descrizione dell'autore"></textarea>
            </div>

            <!-- Nome d'arte -->
            <div class="col-md-12 mb-3">
                <label for="nomeArte">Nome d'arte</label>
                <input type="text" class="form-control" name="nomeArte" placeholder="Es. Mario" value="">
            </div>

            <!-- Nazionalità -->
            <div class="col-md-12 mb-3">
                <label for="nazionalita">Nazionalità</label>
                <div class="input-group" id="comboboxNazionalita">
                    <input type="text" class="form-control" placeholder="Cerca nazionalità...">
                    <div class="input-group-prepend" data-toggle="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown"></button>
                        <div class="dropdown-menu dropdown-menu-right combobox-content">
                            <!-- Script per importare tutte le opzioni -->
                            <?php
                            $query = "SELECT * FROM Nazionalita";

                            // Esegui la query
                            $qres = mysqli_query($conn, $query);

                            // Stampa i link
                            while ($row = mysqli_fetch_assoc($qres))
                                // Stampa gli a href
                                echo "<a class=dropdown-item href='#' value='" . $row["idNazionalita"] . "'>" . $row["Descrizione"] . "</a>";
                            ?>
                        </div>
                    </div>
                    <input name="nazionalita" id="nazionalita" type="text" class="d-none">
                </div>
                <script>
                    $(function() {
                        combobox($('#comboboxNazionalita'), $('#nazionalita'));
                    });
                </script>
            </div>


            <!-- Città di nascita -->
            <div class="col-md-12 mb-3">
                <label for="cittaNascita">Città di nascita</label>
                <input type="text" class="form-control" name="cittaNascita" placeholder="Es. Roma" value="" required="true">
            </div>

            <!-- Città di morte -->
            <div class="col-md-12 mb-3">
                <label for="cittaMorte">Città di morte</label>
                <input type="text" class="form-control" name="cittaMorte" placeholder="Es. Firenze" value="">
            </div>

            <!-- Pulsante per l'invio -->
            <div class="text-center">
                <button type="submit" class="btn btn-info" value="1" name="inserito">Aggiungi autore</button>
                <button class="btn btn-danger ml-2 block" onclick="window.close()"><i class="fa fa-close"></i> Chiudi</button>
            </div>
        </form>

    </div>
</body>

</html>