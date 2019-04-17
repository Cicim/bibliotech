<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Seleziona autore - Bibliotech</title>

    <!-- Include le librerie comuni -->
    <?php include_once "../php/imports.php" ?>

    <!-- Carica il css per il catalogo -->
    <link rel="stylesheet" type="text/css" href="../css/catalogo.css">
    <!-- Carica il js e il css per la combobox -->
    <script src="../js/combobox.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/combobox.css">
</head>

<body>
    <!-- Contenuto principale della pagina -->
    <div>
        <!-- Rettangolo grigio per il titolo della sezione -->
        <div class="jumbotron" style="padding: 2rem 2rem">
            <h1 class="display-4 text-center">
                Seleziona autori
            </h1>
        </div>

        <!-- Barra di ricerca -->
        <form method="get">
            <div class="text-center mb-3">
                L'autore che stai cercando non è nella lista? <a href="crea.php">Crea un autore</a>
            </div>
            <div class="container w-60" style="margin:auto">
                <div class="input-group mb-0">
                    <input type="text" name="ricerca" class="form-control" placeholder="Cerca un autore" autofocus>
                    <div class="input-group-append">
                        <!-- Pulsante di cancellazione ricerca -->
                        <!-- Desktop -->
                        <a href="autori.php" style="padding-top: 10px" class="btn btn-outline-danger fa fa-close full-search"><span class="ml-2" style="font-family:arial">Annulla ricerca</span></a>
                        <!-- Mobile -->
                        <a href="autori.php" style="padding-top: 10px" class="btn btn-outline-danger fa fa-close small-search"></a>
                        
                        <!-- Pulsante di ricerca -->
                        <!-- Desktop -->
                        <button type="submit" value="1" class="btn btn-outline-info fa fa-search full-search" name="cerca" type="button"><span class="ml-2" style="font-family:arial">Cerca</span></button>
                        <!-- Mobile -->
                        <button type="submit" value="1" class="btn btn-outline-info fa fa-search small-search" name="cerca" type="button"></button>
                    </div>
                </div>
            </div>
        </form>

        <div class="container">
            <ul class="list-group">
                <!-- Lista degli autori -->
                <?php
                include_once "../php/connessione.php";

                /**
                 * @author Claudio Cicimurri, 5CI
                 * Stampa la lista degli autori data la query
                 * @param string $query Query per ottenere gli autori
                 * @return string Eventuale errore
                 */
                function stampaListaAutori($query)
                {
                    // Effettua la connessione al database
                    $conn = connettitiAlDb();

                    // Ottieni la lista dei ruoli
                    $listaRuoli = [];
                    $ris = mysqli_query($conn, "SELECT idRuolo, Descrizione FROM Ruolo_Scrittura");

                    // Crea la lista
                    while ($riga = mysqli_fetch_array($ris)) {
                        $listaRuoli[(int)$riga['idRuolo']] = $riga['Descrizione'];
                    }

                    
                    // Esegui la query
                    $ris = mysqli_query($conn, $query);
                    if (!$ris) return "Errore durante l'esecuzione della query<br>" . mysqli_error($conn);

                    // Conta i risultati
                    if (mysqli_num_rows($ris) == 0)
                        return "Nessun risultato";


                    // Ottieni tutti gli elementi
                    while ($riga = mysqli_fetch_array($ris)) {
                        // Salva nome e cognome
                        $nome = $riga['CognomeAutore'] . ' ' . $riga['NomeAutore'];
                        // Salva il nome d'arte
                        $arte = $riga['NomeArte'];
                        // Salva la nazionalità
                        $naz = $riga['Descrizione'];

                        // Salva l'id
                        $idAutore = $riga['idAutore'];

                        echo "<li class='list-group-item'><b>$nome</b><br>";
                        // Se l'autore ha un nome d'arte, scrivilo
                        if ($arte) echo "<b>Nome d'arte</b>: $arte<br>";
                        // Stampa la nazionalità
                        if ($naz != 'N/D') echo "<b>Nazionalità</b>: $naz<br>";

                        // Lista dei ruoli
                        echo "Aggiungi come: ";

                        // Scorri attraverso la lista dei ruoli
                        foreach ($listaRuoli as $idRuolo => $ruolo) {
                            // Stampa il ruolo
                            echo "<a href='#' onclick='";
                            
                            // Stampa l'onclick
                            echo "seleziona($idAutore, $idRuolo)";

                            echo "'>";
                            echo $ruolo;
                            echo '</a> ';
                        }

                        echo "</li>";
                    }
                }


                // Se l'utente ha effettuato la ricerca
                if (isset($_GET['ricerca'])) {
                    $against = $_GET['ricerca'];
                    // Trova la semiquery per il punteggio
                    $score = "MATCH (NomeAutore) AGAINST ('$against' IN BOOLEAN MODE) * 0.4 +
                              MATCH (CognomeAutore) AGAINST ('$against' IN BOOLEAN MODE) * 0.6 +
                              MATCH (NomeArte) AGAINST ('$against' IN BOOLEAN MODE) * 0.8";

                    // Calcola la query per la ricerca
                    $query = "SELECT idAutore, NomeAutore, CognomeAutore, NomeArte, Nazionalita.Descrizione,
                        $score AS Score
                     FROM Autori, Nazionalita 
                     WHERE Autori.idNazionalita = Nazionalita.idNazionalita
                        AND $score > 0
                     ORDER BY score DESC
                     LIMIT 300";

                    stampaListaAutori($query);
                }
                // Altrimenti stampa la query vanilla
                else
                    echo stampaListaAutori("SELECT idAutore, NomeAutore, CognomeAutore, NomeArte, Nazionalita.Descrizione FROM
                 Autori, Nazionalita WHERE Autori.idNazionalita = Nazionalita.idNazionalita LIMIT 300");
                ?>
            </ul>
        </div>


        <!-- Script per la selezione -->
        <script>
            /**
             * @author Claudio Cicimurri, 5CI
             * Aggiunge l'autore alla lista
             * @param {number} idAutore Id dell'autore
             * @param {number} idRuolo Id del ruolo scrittura
             */
            function seleziona(idAutore, idRuolo) {
                // Ottieni la finestra genitore
                var win = window.opener;
                // Ottieni la casella di testo dove scrivere
                var casella = win.document.getElementById('idAutori');

                // Aggiungici il ;
                if (casella.value !== '') casella.value += ';';
                // Aggiungi idAutore,idRuolo
                casella.value += idAutore + ',' + idRuolo;
            }
        </script>
    </div>
</body>

</html>