<!-- Pagina scritta da Stefano Aggio e Antonio D'Averio, del gruppo di lavoro 2 -->

<!DOCTYPE html>

<html>

<head>
    <!-- Definizione dei caratteri e del design responsivo -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Titolo della scheda del browser -->
    <title>Bibliotech - Visualizzazione prestiti e scadenze</title>
    <!-- Inclusione librerie Bootstrap -->
    <?php include_once "../php/imports.php" ?>
</head>

<!-- Controllo dei permessi dell'utente -->
<?php
include_once "../php/access-denied.php";
livelloRichiesto(BIBLIOTECARIO);
?>


<body class="wrapper">
    <!-- Inclusione dell'header -->
    <?php include_once "../views/header.php"
    ?>

    <?php
    // Se il GET è impostato, allora imposta una variabile
    if (isset($_GET["non"])) $non = true;
    else $non = false;
    ?>

    <div>
        <!-- Titolo della pagina -->
        <div class="jumbotron" style="padding: 2rem 2rem">
            <h1 class="display-4 text-center">Prestiti</h1>
        </div>
        <!-- Bottone per tornare alla pagina principale della sezione amministrativa -->
        <div class="text-center">
            <a class="btn btn-danger ml-2 block" href="sezione-amministrativa.php"><i class="fa fa-arrow-left"></i> Torna a sezione amministrativa</a>
            <?php
            // Mostra il pulsante corretto
            if ($non)
                echo "<a class=\"btn btn-info ml-2 block\" href=\"?\"><i class=\"fa fa-close\"></i> Non mostrare i prestiti già riconsegnati</a>";
            else
                echo "<a class=\"btn btn-info ml-2 block\" href=\"?non\"><i class=\"fa fa-check\"></i> Mostra anche prestiti già riconsegnati</a>";
            ?>
        </div>
        <br><br>
        <!-- Lista prestiti e scadenze -->
        <table align="center" class="table">
            <?php
            include_once "../php/connessione.php";
            $conn = connettitiAlDb();
            # Definizione della query
            # La query seleziona titolo, numero di copia, numero di prestito, data di presa in consegna, data di riconsegna prevista e generalità dell'utente dalle tabelle 'Libri', 'Utenti', 'Prestiti' e 'Copie'
            $query = "SELECT Libri.Titolo, Copie.idCopia, Prestiti.idPrestito, Prestiti.DataConsegna, Prestiti.DataRiconsegna, Utenti.Nome, Utenti.Cognome 
                    FROM Libri, Utenti, Prestiti, Copie
                    WHERE Libri.ISBN = Copie.ISBN
                    AND Utenti.CodFiscale = Prestiti.CodFiscaleUtente
                    AND Copie.idCopia = Prestiti.idCopia";

            // Se non si devono mostrare i prestiti già riconsegnati
            if(!$non)
                $query .= "\nAND Prestiti.bibRiconsegna IS NULL";

            # Esecuzione della query
            $risultato = mysqli_query($conn, $query);
            # Controllo di eventuali errori
            if (!$risultato) {
                echo "Errore nella query";
            } else {
                # Titoli delle colonne della tabella
                echo
                    "<tr><th>" .
                        "Titolo" .
                        "</th><th>" .
                        "Numero copia" .
                        "</th><th>" .
                        "Numero prestito" .
                        "</th><th>" .
                        "Data di consegna" .
                        "</th><th>" .
                        "Data di riconsegna" .
                        "</th><th>" .
                        "Nome utente" .
                        "</th><th>" .
                        "Cognome utente" .
                        "</th><th>" .
                        "Rinnovo prestito" .
                        "</th><th>" .
                        "Restituzione libro" .
                        "</th></tr>";
                # Riempimento della tabella con i risultati della query
                # Ad ogni ripetizione corrisponde un record della tabella   
                while ($riga = mysqli_fetch_assoc($risultato)) {
                    echo
                        '<tr><td>' .
                            $riga['Titolo'] . '</td><td>' . $riga['idCopia'] . '</td><td>' . $riga['idPrestito'] . '</td><td>' . $riga['DataConsegna'] . '</td><td>' . $riga['DataRiconsegna'] . '</td><td>' . $riga['Nome'] . '</td><td>' . $riga['Cognome'];
                    # Form per l'invio dei dati alla pagina di rinnovo prestito
                    # Pulsante per rinnovare il prestito
                    echo "<td align=\"center\">";
                    echo "<form method = \"GET\" action = \"rinnovo-prestito.php\">";
                    echo "      <input type=\"hidden\" name=\"idPrestito\" value=" . $riga['idPrestito'] . ">
                                <button type=\"submit\" class=\"btn btn-info ml-2\">
                                    <i class=\"fa fa-edit\"></i>Rinnova
                                </button>
                            </td>";
                    $_GET['btnRinnova'] = $riga['idPrestito'];
                    echo $_GET['btnRinnova'];
                    echo "</form>";

                    # Form per l'invio dei dati alla pagina di restituzione del libro
                    # Pulsante per restituire il libro
                    echo "<td align=\"center\">";
                    echo "<form method = \"GET\" action = \"restituzione-libro.php\">";
                    echo "      <input type = \"hidden\" name=\"idPrestito\" value=" . $riga['idPrestito'] . ">
                                <button type = \"submit\" class=\"btn btn-info ml-2\" id=\"btnRestituzione\">
                                    <i class=\"fa fa-check\"></i>Restituzione
                                </button>
                        </form>
                        </td>";
                }
            }
            ?>
        </table>
        <!-- Bottone per tornare alla pagina principale della sezione amministrativa -->
        <div align="center">
            <a class="btn btn-danger ml-2 block" id="btnSezioneAmministrativa" href="sezione-amministrativa.php"><i class="fa fa-arrow-left"></i> Torna a sezione amministrativa</a>
        </div>
    </div>
    <!-- Inclusione del footer -->
    <?php include_once "../views/footer.php"; ?>

</body>