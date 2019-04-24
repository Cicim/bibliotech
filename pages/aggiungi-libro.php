<!-- Caporaletti 5BI -->
<!-- Completato dal Gruppo 1 -->
<!-- Modificato da Claudio Cicimurri, Lorenzo Clazzer, 5CI -->

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Bibliotech - Aggiungi un libro</title>

    <!-- Importa tutte le librerie comuni -->
    <?php include_once "../php/imports.php" ?>

    <!-- Importa gli stili della login -->
    <link rel="stylesheet" href="../css/aggiungi-libro.css">

    <!-- Carica il js e il css per la combobox -->
    <script src="../js/combobox.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/combobox.css">
</head>

<!-- Esci in caso di accesso negato -->
<?php
include_once "../php/access-denied.php";
livelloRichiesto(BIBLIOTECARIO); ?>

<body class="text-center wrapper">
    <!-- Includi l'header -->
    <?php include_once "../views/header.php" ?>

    <div>
        <!-- Titolo della pagina -->
        <div class="jumbotron" style="padding: 2rem 2rem">
            <h1 class="display-5 text-center">Aggiungi libro</h1>
        </div>

        <?php
        // Connettiti al database
        include_once '../php/connessione.php';
        $conn = connettitiAlDb();

        /**
         * @author Claudio Cicimurri, 5CI
         * Funzione per aggiungere un valore alla sua tabella
         * e per ottenere il suo id
         * @param string $tabella Tabella nella quale aggiungere la riga
         * @param string $colonna Colonna contenente il nome
         * @param string $nome Nome da inserire (primo attributo)
         * @param string $nomeTesto Nome della colonna nella quale si trova il testo
         * @return int $idRiga Id della riga appena inserita, -1 in caso di errore
         */
        function aggiungiRiga($tabella, $colonna, $nome)
        {
            // Componi la query
            $query = "INSERT INTO $tabella ($colonna) VALUES('$nome')";

            // Se stai aggiungendo una lingua, aggiungi l'abbreviazione
            if ($tabella == "Lingue") {
                $abbr = substr($nome, 0, 2);
                $abbr = strtoupper($abbr);
                $query = "INSERT INTO $tabella ($colonna, Abbreviazione) VALUES('$nome', '$abbr')";
            }

            // Connettiti al database
            $conn = connettitiAlDb();

            // Esegui la query
            $ris = mysqli_query($conn, $query);

            // Inizializza l'id a -1
            $id = -1;

            // In caso di errore, riporta -1
            if (!$ris) $id = -1;
            // Controlla se il risultato è giusto
            else {
                $query = "SELECT * FROM $tabella WHERE $colonna = '$nome'";

                // Esegui una nuova query
                $ris = mysqli_query($conn, $query);

                // Ottieni l'id del valore inserito
                if (mysqli_num_rows($ris) == 0) $id = -1;
                else $id = mysqli_fetch_row($ris)[0];
            }
            // Chiudi la connessione
            mysqli_close($conn);

            // Riporta l'id
            return $id;
        }

        /**
         * @author Lorenzo Clazzer, 5CI
         * Funzione per riportare errori durante l'aggiunta del libro
         * @return string Errore o ok se tutto va bene
         */
        function aggiungiLibro()
        {
            global $conn;

            // Recupero i dati dal form
            $ISBN = $_POST["ISBN"];
            $titolo = $_POST["titolo"];
            $descrizione = $_POST["descrizione"];
            $annoPubblicazione = $_POST["annoPubblicazione"];
            $dataAggiunta = date('Y-m-d');

            // Recupero id dal form
            $idGenere = $_POST["genere"];
            $idTipo = $_POST["tipologia"];
            $idEditore = $_POST["editore"];
            $idCollana = $_POST["collana"];
            $idLingua = $_POST["lingua"];

            // Se l'id è -1, aggiungili
            if ($idGenere == -1)
                if (($idGenere = aggiungiRiga("Generi", "Descrizione", $_POST["nGenere"])) == -1)
                    return "Impossibile aggiungere il genere";
            if ($idTipo == -1)
                if (($idTipo = aggiungiRiga("Tipologia", "Descrizione", $_POST["nTipologia"])) == -1)
                    return "Impossibile aggiungere la tipologia";
            if ($idEditore == -1)
                if (($idEditore = aggiungiRiga("Editori", "Nome", $_POST["nEditore"])) == -1)
                    return "Impossibile aggiungere l'editore";
            if ($idCollana == -1)
                if (($idCollana = aggiungiRiga("Collane", "Nome", $_POST["nCollana"])) == -1)
                    return "Impossibile aggiungere la collana";
            if ($idLingua == -1)
                if (($idLingua = aggiungiRiga("Lingue", "Descrizione", $_POST["nLingua"])) == -1)
                    return "Impossibile aggiungere la lingua";

            // Se la descrizione è vuota, impostala a NULL
            if ($descrizione == "") $descrizione = "NULL";
            else $descrizione = "'$descrizione'";

            // Se l'ISBN è vuoto
            if ($ISBN == "") {
                // Trova l'ultimo codice
                $ris = mysqli_query($conn, "SELECT ISBN FROM Libri WHERE ISBN LIKE 'N%' ORDER BY ISBN DESC LIMIT 1");
                // Estrailo
                $codice = mysqli_fetch_row($ris)[0];
                // Incrementalo e sostituiscilo all'ISBN
                $ISBN = ++$codice;
            }

            // Separo i dati recuperati dal popup per l'inserimento degli autori
            $AutRuo = explode(';', $_POST["idAutori"]);
            // Elimina i duplicati
            $AutRuo = array_unique($AutRuo);

            // Query per l'inserimento di un nuovo libro nella tabella Libri
            $query_inserimento = "INSERT INTO Libri (ISBN, Titolo, Descrizione, AnnoPubblicazione, DataAggiunta, idGenere, idTipo,
                                              idEditore, idCollana, idLingua) VALUES
                                ('$ISBN', '$titolo', $descrizione, $annoPubblicazione, '$dataAggiunta', $idGenere, $idTipo, $idEditore, $idCollana, $idLingua)";

            // Eseguo la prima query
            $ris_query_inserimento = mysqli_query($conn, $query_inserimento);

            if ($ris_query_inserimento == false)
                return "Errore durante l'esecuzione della query<br>" . mysqli_error($conn);

            // Per ogni autore
            foreach ($AutRuo as $riga) {
                $riga = explode(',', $riga);
                // Hai id e ruolo scrittura
                $idAutore = (int)$riga[0];
                $idRuolo = (int)$riga[1];

                // Query per il collegamento del nuovo libro ad un autore
                $queryInserimentoAutore = "INSERT INTO Autori_Libri (idAutore, ISBNLibro, idRuoloScrittura) VALUES
                                          ($idAutore, '$ISBN', $idRuolo)";

                // Eseguo la seconda query
                $ris = mysqli_query($conn, $queryInserimentoAutore);
                if ($ris == false) return "Errore durante l'inserimento di un autore<br>" . mysqli_error($conn);
            }

            return "ok";
        }

        $stato = "";
        // Se l'utente ha inviato il POST
        if (isset($_POST['titolo']))
            $stato = aggiungiLibro();

        // Se l'inserimento ha avuto successo, stampa un messaggio di successo
        if ($stato == "ok")
            echo '<div class="alert alert-success" role="alert">L\'inserimento è avvenuto con successo.</div>';

        // Altrimenti stampa un messaggio di errore
        else if ($stato != "")
            echo '<div class="alert alert-danger" role="alert">' . $stato . '</div>';
        ?>



        <div class="container">
            <form class="form-signin mt-5" style="max-width: 700px" autocomplete="off" method="post" action="">
                <!-- Prima riga -->
                <div class="row">
                    <!-- Titolo -->
                    <div class="col-md-12 mb-3">
                        <label for="titolo">Titolo</label>
                        <input type="text" class="form-control" name="titolo" placeholder="Es. Titolo del libro" value="" required="true">
                        <div class="invalid-feedback">Inserisci un titolo valido</div>
                    </div>
                </div>

                <!-- Seconda riga (2 caselle) -->
                <div class="row">
                    <!-- ISBN -->
                    <div class="col-md-4 mb-3">
                        <label for="ISBN">ISBN</label>
                        <input type="text" class="form-control" name="ISBN" placeholder="Es. 97855588015" value="">
                        <div class="invalid-feedback">Inserisci un ISBN valido.</div>
                    </div>
                    <!-- Anno pubblicazione -->
                    <div class="col-md-4 mb-3">
                        <label for="annoPubblicazione">Anno pubblicazione</label>
                        <input type="number" class="form-control" name="annoPubblicazione" placeholder="Es. YYYY" max="<?php echo date('Y') ?>" required="true">
                        <div class="invalid-feedback">Inserisci un anno di pubblicazione valido</div>
                    </div>
                    <!-- Lingua -->
                    <div class="col-md-4 mb-3">
                        <label for="autore">Lingua</label>
                        <div class="input-group" id="comboboxLingua">
                            <input type="text" class="form-control" name="nLingua" placeholder="Cerca lingua...">
                            <div class="input-group-prepend" data-toggle="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown"></button>
                                <div class="dropdown-menu dropdown-menu-right combobox-content">
                                    <a class="dropdown-item" href="#" value="-1">Inserisci nuova lingua</a>
                                    <!-- Script per importare tutte le opzioni -->
                                    <?php
                                    $query = "SELECT * FROM Lingue";

                                    // Esegui la query
                                    $qres = mysqli_query($conn, $query);

                                    // Stampa i link
                                    while ($row = mysqli_fetch_assoc($qres))
                                        // Stampa gli a href
                                        echo "<a class=dropdown-item href='#' value='" . $row["idLingua"] . "'>" . $row["Descrizione"] . "</a>";
                                    ?>
                                </div>
                            </div>
                            <input name="lingua" id="lingua" type="text" class="d-none">
                        </div>
                        <script>
                            $(function() {
                                combobox($('#comboboxLingua'), $('#lingua'));
                            });
                        </script>
                    </div>
                </div>


                <!-- Terza riga (1 caselle) -->
                <div class="row">
                    <!-- Descrizione del libro-->
                    <div class="col-md-12 mb-3">
                        <label for="descrizione">Descrizione del libro</label>
                        <textarea class="form-control" name="descrizione" placeholder="Es. Descrizione del libro"></textarea>
                    </div>
                </div>

                <!-- Quarta riga (2 caselle) -->
                <div class="row">
                    <!-- Genere -->
                    <div class="col-md-6 mb-3">
                        <label for="autore">Genere</label>
                        <div class="input-group" id="comboboxGenere">
                            <input type="text" class="form-control" name="nGenere" placeholder="Cerca genere...">
                            <div class="input-group-prepend" data-toggle="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown"></button>
                                <div class="dropdown-menu dropdown-menu-right combobox-content">
                                    <a class="dropdown-item" href="#" value="-1">Inserisci nuovo genere</a>
                                    <!-- Script per importare tutte le opzioni -->
                                    <?php
                                    $query = "SELECT * FROM Generi";

                                    // Esegui la query
                                    $qres = mysqli_query($conn, $query);

                                    // Stampa i link
                                    while ($row = mysqli_fetch_assoc($qres))
                                        // Stampa gli a href
                                        echo "<a class=dropdown-item href='#' value='" . $row["idGenere"] . "'>" . $row["Descrizione"] . "</a>";
                                    ?>
                                </div>
                            </div>
                            <input name="genere" id="genere" type="text" class="d-none">
                        </div>
                        <script>
                            $(function() {
                                combobox($('#comboboxGenere'), $('#genere'));
                            });
                        </script>
                    </div>

                    <!-- Tipologia -->
                    <div class="col-md-6 mb-3">
                        <label for="autore">Tipologia</label>
                        <div class="input-group" id="comboboxTipologia">
                            <input type="text" class="form-control" name="nTipologia" placeholder="Cerca tipologia...">
                            <div class="input-group-prepend" data-toggle="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown"></button>
                                <div class="dropdown-menu dropdown-menu-right combobox-content">
                                    <a class="dropdown-item" href="#" value="-1">Inserisci nuova tipologia</a>
                                    <!-- Script per importare tutte le opzioni -->
                                    <?php
                                    $query = "SELECT * FROM Tipologie";

                                    // Esegui la query
                                    $qres = mysqli_query($conn, $query);

                                    // Stampa i link
                                    while ($row = mysqli_fetch_assoc($qres))
                                        // Stampa gli a href
                                        echo "<a class=dropdown-item href='#' value='" . $row["idTipologia"] . "'>" . $row["Descrizione"] . "</a>";
                                    ?>
                                </div>
                            </div>
                            <input name="tipologia" id="tipologia" type="text" class="d-none">
                        </div>
                        <script>
                            $(function() {
                                combobox($('#comboboxTipologia'), $('#tipologia'));
                            });
                        </script>
                    </div>
                </div>

                <!-- Quinta riga (2 caselle) -->
                <div class="row">
                    <!-- Editore -->
                    <div class="col-md-6 mb-3">
                        <label for="autore">Editore</label>
                        <div class="input-group" id="comboboxEditore">
                            <input type="text" class="form-control" name="nEditore" placeholder="Cerca editore...">
                            <div class="input-group-prepend" data-toggle="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown"></button>
                                <div class="dropdown-menu dropdown-menu-right combobox-content">
                                    <a class="dropdown-item" href="#" value="-1">Inserisci nuovo editore</a>
                                    <!-- Script per importare tutte le opzioni -->
                                    <?php
                                    $query = "SELECT * FROM Editori";

                                    // Esegui la query
                                    $qres = mysqli_query($conn, $query);

                                    // Stampa i link
                                    while ($row = mysqli_fetch_assoc($qres))
                                        // Stampa gli a href
                                        echo "<a class=dropdown-item href='#' value='" . $row["idEditore"] . "'>" . $row["Nome"] . "</a>";
                                    ?>
                                </div>
                            </div>
                            <input name="editore" id="editore" type="text" class="d-none">
                        </div>
                        <script>
                            $(function() {
                                combobox($('#comboboxEditore'), $('#editore'));
                            });
                        </script>
                    </div>

                    <!-- Collana -->
                    <div class="col-md-6 mb-3">
                        <label for="autore">Collana</label>
                        <div class="input-group" id="comboboxCollana">
                            <input type="text" class="form-control" name="nCollana" placeholder="Cerca collana...">
                            <div class="input-group-prepend" data-toggle="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown"></button>
                                <div class="dropdown-menu dropdown-menu-right combobox-content">
                                    <a class="dropdown-item" href="#" value="-1">Inserisci nuova collana</a>
                                    <!-- Script per importare tutte le opzioni -->
                                    <?php
                                    $query = "SELECT * FROM Collane";

                                    // Esegui la query
                                    $qres = mysqli_query($conn, $query);

                                    // Stampa i link
                                    while ($row = mysqli_fetch_assoc($qres))
                                        // Stampa gli a href
                                        echo "<a class=dropdown-item href='#' value='" . $row["idCollana"] . "'>" . $row["Nome"] . "</a>";
                                    ?>
                                </div>
                            </div>
                            <input name="collana" id="collana" type="text" class="d-none">
                        </div>
                        <script>
                            $(function() {
                                combobox($('#comboboxCollana'), $('#collana'));
                            });
                        </script>
                    </div>
                </div>
                <br>

                <label for="idCopia">Seleziona l'id dell'autore</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Id autori" name="idAutori" id="idAutori">
                    <div class="input-group-append">
                        <!-- Al click del pulsante, apri un popup -->
                        <button class="btn btn-outline-info" type="button" onclick="window.open('../popup-selezione-autori/autori.php', 'Seleziona autori', 'width=600,height=400,status=yes,scrollbars=yes,resizable=yes')">Seleziona autori</button>
                    </div>
                </div>
                <div>
                    <!-- Pulsante per creare il prestito -->
                    <button type="submit" class="btn btn-info">Aggiungi libro</button>
                    <a class="btn btn-warning ml-2 block" href="sezione-amministrativa.php"><i class="fa fa-arrow-left"></i> Torna alla sezione amministrativa</a>
                </div>
                <br>
            </form>
        </div>

        <!-- Includi il footer -->
        <?php include_once "../views/footer.php" ?>
</body>