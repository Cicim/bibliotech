<!-- Pagina scritta da Marco Caporaletti e Antonio D'Averio, del gruppo di lavoro 2 -->

<!DOCTYPE html>

<html>

<head>
    <!-- Definizione dei caratteri e del design responsivo -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Titolo della scheda del browser -->
    <title>Bibliotech - Visualizzazione liste dei desideri</title>
    <!-- Inclusione librerie Bootstrap -->
    <?php include_once "../php/imports.php" ?>
</head>

<!-- Controllo dei permessi dell'utente -->
<?php 
    include_once "../php/access-denied.php";
    livelloRichiesto(BIBLIOTECARIO); 
?>

<body>
    <!-- Inclusione dell'header -->
    <?php include_once "../views/header.php"; ?>

    <div>
        <!-- Titolo della pagina -->
        <div class="jumbotron" style="padding: 2rem 2rem">
            <h1 class="display-4 text-center">Visualizzazione liste dei desideri</h1>
        </div>
        <!-- Bottone per tornare alla pagina principale della sezione amministrativa -->
        <div align="center">
            <a class="btn btn-danger ml-2 block" id="btnSezioneAmministrativa" href="sezione-amministrativa.php"><i class="fa fa-arrow-left"></i> Torna a sezione amministrativa</a>
        </div>
        <br>
        <!-- Selezione utente di cui visualizzare la lista dei desideri -->
        <div align=center>
            <!-- POST che si invia a questa pagina stessa per permettere l'aggiornamento dinamico della tabella -->
            <form method = "POST" name="nomeUtente" id="nomeUtente" action = "vis-liste-desideri.php">
                <!-- Menù a tendina -->
                <select name="nomeUtente">
                    <?php
                        # Connessione al database
                        include_once "../php/connessione.php";
                        $conn = connettitiAlDb();
                        # Definizione della query per riempire le opzioni del menù a tendina dinamicamente prendendo i dati direttamente dal database
                        # La query seleziona codice fiscale, nome e cognome dalla tabella 'Utenti'
                        $query = "SELECT CodFiscale, Nome, Cognome FROM Utenti";
                        # Esecuzione della query
                        $qres = mysqli_query($conn, $query);
                        # Controllo di eventuali errori
                        if(!$qres){
                            echo "Errore nella query";
                        }
                        # Riempimento del menù a tendina
                        # Ad ogni ripetizione corrisponde un'opzione del menù
                        while ($row = mysqli_fetch_assoc($qres)){
                            echo 
                            "<option value='" . $row['CodFiscale'] . "'>" . 
                            $row['Nome'] . " " . $row['Cognome'] . 
                            "</option>";
                        }
                    ?>
                </select>
                <!-- Pulsante per inviare i dati del form e cambiare così la tabella visualizzata in base all'utente selezionato dal menù -->
                <input type="submit" value="Seleziona">
            </form>
        </div>
        <br><br>
        <!-- Lista dei desideri dell'utente specificato -->
        <table class="table" align=center>
            <?php
            if(isset($_POST['nomeUtente'])){
                # Connessione al database
                include_once "../php/connessione.php";
                $conn = connettitiAlDb();
                # Definizione della query
                # La query seleziona tutti i campi dalle tabelle 'Libri' e 'Lista_Interessi', per poi usare il codice fiscale scelto dal menù a tendina come identificatore della lista dei desideri esatta
                $query = "SELECT *
                            FROM Libri, Lista_Interessi
                            WHERE Lista_Interessi.codFiscaleUtente = '" . $_POST['nomeUtente'] . "'" .
                            "AND Libri.ISBN = Lista_Interessi.ISBNLibro";
                # Esecuzione della query con controllo di eventuali errori
                $risultato = mysqli_query($conn, $query)
                    or die("Errore nella query" . mysqli_error($conn));
                # Tabella per visualizzare la lista dei desideri dell'utente scelto
                echo
                # Titoli delle colonne della tabella
                "<tr>
                    <th>
                        Titolo
                    </th>
                    <th>
                        ISBN
                    </th>
                    <th>
                        Inserito il
                    </th>
                </tr>";
                # Riempimento della tabella con i risultati della query
                # Ad ogni ripetizione corrisponde un record della tabella
                while ($riga = mysqli_fetch_assoc($risultato)) {
                    echo 
                    '<tr><td>' . 
                    $riga['Titolo'] . 
                    '</td><td>' . 
                    $riga['ISBN'] . 
                    '</td><td>' . 
                    $riga['DataInserimento'] . 
                    '</td></tr>';
                }
            }
            ?>
        </table>
        <br>
        <!-- Bottone per tornare alla pagina principale della sezione amministrativa -->
        <div align="center">
            <a class="btn btn-danger ml-2 block" href="sezione-amministrativa.php"><i class="fa fa-arrow-left"></i> Torna a sezione amministrativa</a>
        </div>
        <br>
    </div>
    <!-- Inclusione del footer -->
    <?php include_once "../views/footer.php"; ?>

</body>
    