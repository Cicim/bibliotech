<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Bibliotech - Visualizzazione liste dei desideri</title>

     <!-- Importa tutte le librerie comuni -->
     <?php include_once "../php/imports.php" ?>
</head>

<!-- Esci in caso di accesso negato -->
<?php 
    include_once "../php/access-denied.php";
    livelloRichiesto(BIBLIOTECARIO); 
?>

<body class="wrapper">
    <!-- Pagina dell'header importata -->
    <?php include_once "../views/header.php"; ?>

    <div>
        <!-- Rettangolo grigio per il titolo della sezione -->
        <div class="jumbotron" style="padding: 2rem 2rem">
            <h1 class="display-4 text-center">Visualizzazione liste dei desideri</h1>
        </div>

        <div align="center">
            <!-- Bottone per tornare alla pagina principale della sezione amministrativa -->
            <a class="btn btn-danger ml-2 block" id="btnSezioneAmministrativa" href="sezione-amministrativa.php"><i class="fa fa-arrow-left"></i> Torna a sezione amministrativa</a>
        </div>
        <br>

        <div align=center>

            <!-- Selezione utente di cui visualizzare la lista dei desideri -->
            <form method = "POST" name="nomeUtente" id="nomeUtente" action = "vis-liste-desideri.php">

                    <select name="nomeUtente">
                        <?php
                            include_once "../php/connessione.php";
                            $conn = connettitiAlDb();

                            $query = "SELECT CodFiscale, Nome, Cognome FROM Utenti";

                            $qres = mysqli_query($conn, $query);

                            while ($row = mysqli_fetch_assoc($qres)){
                                echo "<option value='" . $row['CodFiscale'] . "'>" . $row['Nome'] . " " . $row['Cognome'] . "</option>";
                            }
                        ?>
                    </select>
                    <input type="submit" value="Seleziona">

            </form>

        </div>

        <br>

        <br>

        <!-- Lista dei desideri dell'utente specificato -->
        <table class="table" align=center>
            <?php
            if(isset($_POST['nomeUtente'])){
                // Connettiti al database
                include_once "../php/connessione.php";
                $conn = connettitiAlDb();

                $query = "SELECT *
                            FROM Libri, Lista_Interessi
                            WHERE Lista_Interessi.codFiscaleUtente = '" . $_POST['nomeUtente'] . "'" .
                            "AND Libri.ISBN = Lista_Interessi.ISBNLibro";

                $risultato = mysqli_query($conn, $query)
                    or die("Errore nella query" . mysqli_error($conn));

                echo
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
                while ($riga = mysqli_fetch_assoc($risultato)) {
                    echo '<tr><td>' . $riga['Titolo'] . '</td><td>' . $riga['ISBN'] . '</td><td>' . $riga['DataInserimento'] . '</td></tr>';
                }
            }
            else{
                echo "control";
            }

            ?>
        </table>

        <!-- Bottone per tornare alla pagina principale della sezione amministrativa -->
        <div align="center">
            <a class="btn btn-danger ml-2 block" href="sezione-amministrativa.php"><i class="fa fa-arrow-left"></i> Torna a sezione amministrativa</a>
        </div>
        <br>
    </div>

    <!-- Pagina del footer importata -->
    <?php include_once "../views/footer.php"; ?>

</body>
    