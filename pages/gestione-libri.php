<!-- Pagina scritta dal gruppo di lavoro 2 -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gestione utenti - Bibliotech</title>

    <!-- Inclusione librerie di Bootstrap -->
    <?php include_once "../php/imports.php"; ?>

</head>

<!-- Esci in caso di accesso negato -->
<?php 
    include_once "../php/access-denied.php";
    livelloRichiesto(BIBLIOTECARIO); ?>


<body class="wrapper">
    <!-- Pagina dell'header importata -->
    <?php include_once "../views/header.php"; ?>

    <div>
        <!-- Rettangolo grigio per il titolo della sezione -->
        <div class="jumbotron" style="padding: 2rem 2rem">
            <h1 class="display-4 text-center">Gestione libri</h1>
        </div>

        <div align="center">
            <!-- Bottone per tornare alla pagina principale della sezione amministrativa -->
            <a class="btn btn-danger ml-2 block" id="btnSezioneAmministrativa" href="sezione-amministrativa.php"><i class="fa fa-arrow-left"></i> Torna a sezione amministrativa</a>

            <!-- Bottone per la pagina di aggiunta di un nuovo libro -->
            <a class="btn btn-info ml-2 block" id="btnAggiungiLibro" href="aggiungi-libro.php"><i class="fa fa-plus"></i> Aggiungi libro</a>
        </div>
        <br>

        <!-- Lista libri in catalogo -->
        <table border="2" align="center" class="table">
            <?php
            // Connettiti al database
            include_once "../php/connessione.php";
            $conn = connettitiAlDb();

            $query = "SELECT Libri.ISBN, Libri.Titolo, Libri.AnnoPubblicazione, Generi.Descrizione AS Genere, Tipologie.Descrizione AS Tipologia, Editori.Nome, Lingue.Abbreviazione
                        FROM Libri, Generi, Tipologie, Editori, Lingue
                        WHERE Generi.idGenere=Libri.idGenere
                        AND Tipologie.idTipologia=Libri.idTipo
                        AND Editori.idEditore=Libri.idEditore
                        AND Lingue.idLingua=Libri.idLingua";
            $risultato = mysqli_query($conn, $query)
                or die("Errore nella query" . mysqli_error($conn));

            echo
                "<tr><th>" .
                    "ISBN" .
                    "</th><th>" .
                    "Titolo" .
                    "</th><th>" .
                    "Anno" .
                    "</th><th>" .
                    "Genere" .
                    "</th><th>" .
                    "Tipologia" .
                    "</th><th>" .
                    "Editore" .
                    "</th><th>" .
                    "Lingua" .
                    "</th><th>" .
                    "Modifica libro" .
                    "</th></tr>";
            while ($riga = mysqli_fetch_assoc($risultato)) {
                echo
                    '<tr><td>' .
                        $riga['ISBN'] . '</td><td>' . $riga['Titolo'] . '</td><td>' . $riga['AnnoPubblicazione'] . '</td><td>' . $riga['Genere'] . '</td><td>' . $riga['Tipologia'] . '</td><td>' . $riga['Nome'] . '</td><td>' . $riga['Abbreviazione'];

                #Pulsante per modificare un libro -->
                # (Aggiungere il link alla pagina ModificaLibro.php)
                echo "<td align=\"center\"><a class=\"btn btn-info ml-2\" id=\"btnModificaLibro\" href=\"#\"><i class=\"fa fa-edit\"></i> Modifica</a></td></tr>";
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