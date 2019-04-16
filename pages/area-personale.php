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
    <link rel="stylesheet" type="text/css" href="../css/area-personale.css">

</head>

<!-- Esci in caso di accesso negato -->
<?php 
    include "../php/access-denied.php";
    livelloRichiesto(UTENTE_REGISTRATO); ?>

<body class="wrapper">
    <!-- Pagina dell'header importata -->
    <?php include "../views/header.php"; ?>

    <!-- Script per ottenere i dati sulla validazione -->
    <?php
    $sql = "SELECT DataValidazione, Email, DataNascita
            FROM Utenti
            WHERE Utenti.CodFiscale = '$codfisc'";


    $conn = connettitiAlDb();

    $res = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_array($res)) {
        // Ottieni tutti i campi dell'utente
        $email = $row['Email'];
        $datavalidazione = $row['DataValidazione'];
        $datanascita = $row['DataNascita'];
    } ?>

    <div class='container mt-4'>
        <div class='row'>
            <div class='col-md-3 '>
                <div class='list-group '>
                    <a href='#' class='list-group-item list-group-item-action active'>Informazioni Utente</a>
                    <a href='lista-desideri.php' class='list-group-item list-group-item-action'>Lista Desideri</a>
                    <a href='cronologia-prestiti.php' class='list-group-item list-group-item-action'>Cronologia Prestiti</a>


                </div>
            </div>
            <div class='col-md-9'>
                <div class='card'>
                    <div class='card-body'>
                        <div class='row'>
                            <div class='col-md-12'>
                                <h4>Il Tuo Profilo</h4>
                                <hr>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-12'>
                                <form>
                                    <div class='form-group row'>
                                        <label class='col-4 col-form-label'>Nome</label>
                                        <div class='col-8'>
                                            <input class='form-control here' placeholder='<?php echo $nome ?>' type='text' disabled>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label class='col-4 col-form-label'>Cognome</label>
                                        <div class='col-8'>
                                            <input class='form-control here' placeholder='<?php echo $cognome ?>' type='text' disabled>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label class='col-4 col-form-label'>Email</label>
                                        <div class='col-8'>
                                            <input class='form-control here' placeholder='<?php echo $email ?>' type='text' disabled>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label for='text' class='col-4 col-form-label'>Data di nascita</label>
                                        <div class='col-8'>
                                            <input placeholder='<?php echo $datanascita ?>' class='form-control here' type='text' disabled>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label for='text' class='col-4 col-form-label'>Account registrato il</label>
                                        <div class='col-8'>
                                            <input placeholder='<?php echo $datavalidazione ?>' class='form-control here' type='text' disabled>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Pagina del footer importata -->
    <?php include "../views/footer.php"; ?>

</body>