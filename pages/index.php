<!-- File creato inizialmente da Claudio Cicimuurri -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Homepage - Bibliotech</title>

    <!-- Include le librerie comuni -->
    <?php include "../php/imports.php";
    // Includi il codice per la paginazione
    include "../php/paginazione.php";
    // Includi il codice per la connessione al database
    include '../php/connessione.php'; ?>

    <!-- Carica il css per il catalogo -->
    <link rel="stylesheet" type="text/css" href="../css/catalogo.css">
</head>

<body class="wrapper">
        <!-- Pagina dell'header importata -->
        <?php include "../views/header.php"; ?>

        <div>
            <!-- Rettangolo grigio per il titolo della sezione -->
            <div class="jumbotron" style="padding: 2rem 2rem">
                <h1 class="display-4 text-center">Libri in Vetrina</h1>
            </div>

            <!-- Homepage - Vetrina -->
            <div class="container books margin-auto">

                <?php
                    // Crea la query per ottenere tutti i libri
                    $query = 'SELECT Libri.ISBN, Libri.Titolo, Editori.idEditore AS idEditore, Editori.Nome AS "nomeEditore",
                    Generi.Descrizione AS "Genere",
                    Tipologie.Descrizione AS "Tipologia"
                    FROM Libri, Generi, Editori, Tipologie
                    WHERE Libri.idGenere = Generi.idGenere
                    AND Libri.idEditore = Editori.idEditore
                    AND Libri.idTipo = Tipologie.idTipologia
                    ORDER BY Libri.DataAggiunta ASC, Libri.Titolo ASC';

                    // Stampa tutti i libri risultati dalla query
                    paginazione($query);
                    ?>

            </div>
        </div>

        <!-- Pagina del footer importata -->
        <?php include "../views/footer.php"; ?>
</body> 