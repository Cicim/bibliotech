<!-- Pagina scritta dal gruppo di lavoro 2 -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sezione amministrativa - Bibliotech</title>

    <!-- Inclusione librerie di Bootstrap -->
    <?php include_once "../php/imports.php"; ?>

    <!-- CSS per la tabella principale della pagina -->
    <style>
        .block {
            display: block;
            margin: 2px;
            text-align: center;
            font-size: 24pt;
        }
    </style>
</head>

<!-- Esci in caso di accesso negato -->
<?php 
    include_once "../php/access-denied.php";
    livelloRichiesto(BIBLIOTECARIO); ?>

<body class="wrapper">
    <!-- Inclusione dell'header -->
    <?php include_once "../views/header.php"; ?>

    <div>
        <!-- Titolo della pagina -->
        <div class="jumbotron" style="padding: 2rem 2rem">
            <h1 class="display-5 text-center">Sezione amministrativa</h1>
        </div>
        <!-- Lista dei link -->
        <div class="container mb-5">
            <div class="row">
                <div class="col-md-4">
                    <a class="btn btn-info ml-2 block" href="gestione-utenti.php">
                        <i class="fa fa-user"></i> Gestione utenti
                    </a>
                </div>
                <div class="col-md-4">
                    <a class="btn btn-info ml-2 block" href="gestione-libri.php">
                        <i class="fa fa-book"></i> Gestione libri
                    </a>
                </div>
                <div class="col-md-4">
                    <a class="btn btn-info ml-2 block" href="vis-prestiti-scadenze.php">
                        <i class="fa fa-leanpub"></i> Prestiti
                    </a>
                </div>
            </div>
            <div class="row mt-md-4">
                <div class="col-md-4">
                    <a class="btn btn-info ml-2 block" href="aggiungi-libro.php">
                        <i class="fa fa-plus"></i> Aggiungi libro
                    </a>
                </div>
                <div class="col-md-4">
                    <a class="btn btn-info ml-2 block" href="creazione-prestito.php">
                        <i class="fa fa-plus"></i> Crea prestito
                    </a>
                </div>
                <div class="col-md-4">
                    <a class="btn btn-info ml-2 block" href="vis-liste-desideri.php">
                        <i class="fa fa-bookmark"></i> Liste dei desideri
                    </a>
                </div>
            </div>
            <div class="row mt-md-4">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <a class="btn btn-danger ml-2 block" href="index.php">
                        <i class="fa fa-times-circle"></i> Esci
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagina del footer importata -->
    <?php include_once "../views/footer.php"; ?>

</body>