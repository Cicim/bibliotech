<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Bibliotech - Visualizzazione prestiti e scadenze</title>

    <!-- Importa tutte le librerie comuni -->
    <?php include_once "../php/imports.php" ?>
</head>

<!-- Esci in caso di accesso negato -->
<?php 
    include_once "../php/access-denied.php";
    livelloRichiesto(BIBLIOTECARIO); ?>


<body class="text-center">
    <!-- Includi l'header -->
    <?php include_once "../views/header.php" ?>

    <!-- Rettangolo grigio per il titolo della sezione -->
    <div class="jumbotron" style="padding: 2rem 2rem">
        <h1 class="display-4 text-center">Prestiti</h1>
    </div>

    <!-- Bottone per tornare alla pagina principale della sezione amministrativa -->
    <div align = "center">
        <a class="btn btn-danger ml-2 block" id="btnSezioneAmministrativa" href="sezione-amministrativa.php"><i class="fa fa-arrow-left"></i> Torna a sezione amministrativa</a>
    </div>

    <br><br>

    <table border = "2" align = "center" class = "table">
        <?php

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

                    $query = "SELECT Libri.Titolo, Copie.idCopia, Prestiti.idPrestito, Prestiti.DataConsegna, Prestiti.DataRiconsegna, Utenti.Nome, Utenti.Cognome 
                    FROM Libri, Utenti, Prestiti, Copie
                    WHERE Libri.ISBN = Copie.ISBN
                    AND Utenti.CodFiscale = Prestiti.CodFiscaleUtente
                    AND Copie.idCopia = Prestiti.idCopia";
                    $risultato = mysqli_query($conn, $query);
                    if(!$risultato){
                        echo "Errore nella query";
                    }
                    else{

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
                    while ($riga = mysqli_fetch_assoc($risultato)) {
                        echo
                        '<tr><td>' .
                        $riga['Titolo'] . '</td><td>' . $riga['idCopia'] . '</td><td>' . $riga['idPrestito'] . '</td><td>' . $riga['DataConsegna'] . '</td><td>' . $riga['DataRiconsegna'] . '</td><td>' . $riga['Nome'] . '</td><td>' . $riga['Cognome'];
                    
                    echo "<form method = \"GET\" action = \"rinnovo-prestito.php\">";
                        #Pulsante per rinnovare il prestito
                        echo "<td align=\"center\">
                            <input type = \"hidden\" id = " . $riga['idPrestito'] . "name =" . $riga['idPrestito'] . "value=" . $riga['idPrestito'] . ">
                            <button type = \"submit\" class=\"btn btn-info ml-2\">
                                <i class=\"fa fa-edit\"></i>Rinnova
                            </button>
                        </td></td>";
                        $_GET['btnRinnova'] = $riga['idPrestito'];
                        echo $_GET['btnRinnova'];
                    echo "</form>";

                    echo "<form method = \"GET\" action = \"restituzione-libro.php\">";
                        #Pulsante per restituire il libro
                        echo "<td align=\"center\">
                            <button type = \"submit\" class=\"btn btn-info ml-2\" id=\"btnRestituzione\">
                                <i class=\"fa fa-check\"></i>Restituzione
                            </button>
                        </td></td>
                </td></td>";
                    echo "</form>";
                    }
                         
                    }
                }
            }
        ?>
    </table>

    <!-- Bottone per tornare alla pagina principale della sezione amministrativa -->
    <div align = "center">
        <a class="btn btn-danger ml-2 block" id="btnSezioneAmministrativa" href="sezione-amministrativa.php"><i class="fa fa-arrow-left"></i> Torna a sezione amministrativa</a>
    </div>

    <br>

    <br><br>

</body>