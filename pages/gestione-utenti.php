<!-- Pagina scritta da Antonio D'Averio, del gruppo di lavoro 2 -->

<!DOCTYPE html>

<html>

<head>
    <!-- Definizione dei caratteri e del design responsivo -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Titolo della scheda del browser -->
    <title>Gestione utenti - Bibliotech</title>
    <!-- Inclusione librerie di Bootstrap -->
    <?php include_once "../php/imports.php"; ?>
</head>

<!-- Controllo dei permessi dell'utente -->
<?php
include_once "../php/access-denied.php";
livelloRichiesto(BIBLIOTECARIO);
?>


<body>
    <!-- Inclusione dell'header -->
    <?php include_once "../views/header.php"; ?>

    <!-- Titolo della pagina -->
    <div class="jumbotron" style="padding: 2rem 2rem">
        <h1 class="display-4 text-center">Gestione utenti</h1>
    </div>

    <!-- Bottone per tornare alla pagina principale della sezione amministrativa -->
    <div align="center">
        <a class="btn btn-danger ml-2 block" id="btnSezioneAmministrativa" href="sezione-amministrativa.php"><i class="fa fa-arrow-left"></i> Torna a sezione amministrativa</a>
    </div>

    <br><br>

    <!-- Lista utenti registrati -->
    <table align="center" class="table">
        <?php
        include_once "../php/connessione.php";
        $conn = connettitiAlDb();
        # La query seleziona tutti i campi dalla tabella 'Utenti'
        $query = "SELECT * FROM Utenti";
        $risultato = mysqli_query($conn, $query);
        # Controllo di eventuali errori
        if (!$risultato) {
            echo "Errore nella query";
        }
        # Tabella per visualizzare i dati degli utenti
        else {
            # Titoli delle colonne della tabella
            echo
                "<tr>
                <th>
                    Codice fiscale 
                </th>
                <th> 
                    Nome 
                </th>
                <th> 
                    Cognome 
                </th>
                <th>
                    Email
                </th>
                <th>
                    Telefono cellulare
                </th>
                <th> 
                    Telefono fisso
                </th>
                <th>
                    Validità account 
                </th>
                <th>
                    Bibliotecario?
                </th>
            </tr>";
            // <th>
            //     Modifica utente 
            // </th>
            # Riempimento della tabella con i risultati della query
            # Ad ogni ripetizione corrisponde un record della tabella
            while ($riga = mysqli_fetch_assoc($risultato)) {
                echo
                    '<tr><td>' .
                        $riga['CodFiscale'] .
                        '</td><td>' .
                        $riga['Nome'] .
                        '</td><td>' .
                        $riga['Cognome'] .
                        '</td><td>' .
                        $riga['Email'] .
                        '</td><td>' .
                        $riga['TelefonoCellulare'] .
                        '</td><td>' .
                        $riga['TelefonoFisso'] .
                        '</td><td>';
                if ($riga['Validato'] == 1) {
                    echo "Account confermato </td></td>";
                } else {
                    echo "Account non confermato </td></td>";
                }
                // Ottieni permessi 
                $bibliotecario = $riga["Permessi"] <= BIBLIOTECARIO;
                $bibTesto = $bibliotecario ? "Sì" : "No";
                $bibBtn = $bibliotecario ? "danger" : "info";
                $bibIcon = $bibliotecario ? "minus" : "plus";
                $id = $riga["CodFiscale"];
                # Pulsante per aggiungere un nuovo bibliotecario
                echo "<td align=\"center\">
                    $bibTesto
                    <a class=\"btn btn-$bibBtn ml-2\" href=\"../php/rendi-bibliotecario.php?id=$id\" target=\"_blank\"><i class=\"fa fa-$bibIcon\"></i></a>
                </td>";
                # (Aggiungere il link alla pagina NuovoBibliotecario.php)
                # Pulsante per modificare un utente -->
                // echo "<td align=\"center\"><a class=\"btn btn-info ml-2\" id=\"btnModificaUtente\" href=\"#\"><i class=\"fa fa-edit\"></i> Modifica utente</a></td>";
                # (Aggiungere il link alla pagina ModificaUtente.php)            
            }
        }
        ?>
    </table>
    <br>
    <!-- Bottone per tornare alla pagina principale della sezione amministrativa -->
    <div align="center">
        <a class="btn btn-danger ml-2 block" id="btnSezioneAmministrativa" href="sezione-amministrativa.php"><i class="fa fa-arrow-left"></i> Torna a sezione amministrativa</a>
    </div>
    <br><br><br>ì
    <!-- Inclusione del footer -->
    <?php include_once "../views/footer.php"; ?>

</body>






















































































































              






















