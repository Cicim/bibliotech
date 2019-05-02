<!-- Pagina scritta da Antonio D'Averio, del gruppo di lavoro 2 -->

<!DOCTYPE html>

<html>

<head>
    <!-- Definizione dei caratteri e del design responsivo -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Titolo della scheda del browser -->
    <title>Sezione amministrativa - Bibliotech</title>
    <!-- Inclusione librerie di Bootstrap -->
    <?php include_once "../php/imports.php"; ?>
    <!-- Stile CSS per la tabella principale della pagina -->
    <style>
        /* I bordi della tabella sono nascosti, lasciando solo una griglia trasparente in cui i pulsanti sono inseriti */
        .block {
            display: block;
            margin: 2px;
            text-align: center;
            font-size: 24pt;
        }
    </style>
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
            <h1 class="display-5 text-center">Sezione amministrativa</h1>
        </div>
        <!-- Lista dei link -->
        <!-- Prima riga -->
        <div class="container mb-5">
            <div class="row">
                <!-- Link alla pagina di gestione degli utenti -->
                <div class="col-md-4">
                    <a class="btn btn-info ml-2 block" href="gestione-utenti.php">
                        <i class="fa fa-user"></i> Gestione utenti
                    </a>
                </div>
                <!-- Link alla pagina di gestione dei libri -->
                <div class="col-md-4">
                    <a class="btn btn-info ml-2 block" href="gestione-libri.php">
                        <i class="fa fa-book"></i> Gestione libri
                    </a>
                </div>
                <!-- Link alla pagina di gestione dei prestiti -->
                <div class="col-md-4">
                    <a class="btn btn-info ml-2 block" href="vis-prestiti-scadenze.php">
                        <i class="fa fa-leanpub"></i> Prestiti
                    </a>
                </div>
            </div>
            <!-- Seconda riga -->
            <div class="row mt-md-4">
                <!-- Link alla pagina per aggiungere un libro -->
                <div class="col-md-4">
                    <a class="btn btn-info ml-2 block" href="aggiungi-libro.php">
                        <i class="fa fa-plus"></i> Aggiungi libro
                    </a>
                </div>
                <!-- Link alla pagina per creare un prestito -->
                <div class="col-md-4">
                    <a class="btn btn-info ml-2 block" href="creazione-prestito.php">
                        <i class="fa fa-plus"></i> Crea prestito
                    </a>
                </div>
                <!-- Link alla pagina per visualizzare la lista dei desideri di un determinato utente -->
                <div class="col-md-4">
                    <a class="btn btn-info ml-2 block" href="vis-liste-desideri.php">
                        <i class="fa fa-bookmark"></i> Liste dei desideri
                    </a>
                </div>
            </div>
            <!-- Terza riga -->
            <div class="row mt-md-4">
                <!-- Casella vuota per permettere al pulsante successivo di essere centrato nella tabella -->
                <div class="col-md-4"></div>
                <!-- Link per tornare alla pagina principale del sito -->
                <div class="col-md-4">
                    <a class="btn btn-danger ml-2 block" href="index.php">
                        <i class="fa fa-times-circle"></i> Esci
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Inclusione del footer -->
    <?php include_once "../views/footer.php"; ?>

</body>