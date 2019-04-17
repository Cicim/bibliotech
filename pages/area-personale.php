<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Homepage - Bibliotech</title>

    <!-- Include le librerie comuni -->
    <?php include_once "../php/imports.php";
    // Includi il codice per la paginazione
    include_once "../php/paginazione.php";
    // Includi il codice per la connessione al database
    include '../php/connessione.php'; ?>

    <!-- Carica il css per il catalogo -->
    <link rel="stylesheet" type="text/css" href="../css/area-personale.css">

</head>

<!-- Esci in caso di accesso negato -->
<?php 
    include_once "../php/access-denied.php";
    livelloRichiesto(UTENTE_REGISTRATO); ?>

<body class="wrapper">
    <!-- Pagina dell'header importata -->
    <?php include_once "../views/header.php"; ?>

    <!-- Script per ottenere i dati sulla validazione -->
    <?php

    $sql = "SELECT *
            FROM Utenti
            WHERE Utenti.CodFiscale = '$codfisc'";


    $conn = connettitiAlDb();

    $res = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_array($res)) {
        // Ottieni tutti i campi dell'utente
        $email = $row['Email'];
        $datavalidazione = $row['DataValidazione'];
        $datanascita = $row['DataNascita'];
        $via = $row['ViaPzz'];
        $civico = $row['NumeroCivico'];
        $cellulare = $row['TelefonoCellulare'];
        $fisso = $row ['TelefonoFisso'];
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
<?php 

//In base al bottone cliccato passo ad uno stato diverso.
//Cliccando il bottone modifica, sblocco i parametri da cambiare
//Cliccando il bottone conferma, cambio i dati e li blocco
if(isset($_POST['modifica'])){
    $_SESSION["controllo"] = 1;
    $controllo = $_SESSION["controllo"];
}
elseif(isset($_POST['conferma'])){
    //salvo i nuovi valori
    $modificanome = $_POST['nome'];
    $modificacognome = $_POST['cognome'];
    $modificavia = $_POST['via'];
    $modificacivico = $_POST['civico'];
    $modificacellulare = $_POST['cellulare'];
    $modificafisso = $_POST['fisso'];
    //controllo che nessuna delle variabili sia vuota
    if($modificanome == "" || $modificacognome == "" || $modificavia == "" || $modificacivico == "" || $modificacellulare == ""){
    echo"<div class='alert alert-danger alert-dismissible'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    Hai lasciato vuote delle variabili!
                </div>";
        $_SESSION["controllo"] = 1;
        $controllo = $_SESSION["controllo"];
    }   
    else{

    $conn = connettitiAlDb();
    $sql = "UPDATE Utenti
    SET Nome = '$modificanome',
        Cognome = '$modificacognome',
        ViaPzz = '$modificavia',
        NumeroCivico = '$modificacivico',
        TelefonoCellulare = '$modificacellulare',
        TelefonoFisso = '$modificafisso'
    WHERE CodFiscale = '$codfisc'";


    //dal momento che nome e cognome sono variabili di sessione, devo modificarle in questo modo
    $_SESSION['nome'] = $modificanome;
    $_SESSION['cognome'] = $modificacognome;
    
    // Esegui la query
    $res = mysqli_query($conn, $sql);
    
    $_SESSION["controllo"] = 0;
    $controllo = $_SESSION["controllo"];
    echo "<meta http-equiv='refresh' content='0;URL=area-personale.php'>";
    }
}

    if($controllo == 0){
        echo"
            <div class='col-md-9'>
                <div class='card'>
                    <div class='card-body'>
                        <div class='row'>
                            <div class='col-md-12'>
                                <h4>Il Tuo Profilo </h4> 
                                <hr>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-12'>
                                <form>
                                    <div class='form-group row'>
                                        <label class='col-4 col-form-label'>Nome</label>
                                        <div class='col-8'>
                                            <input class='form-control here' placeholder='$nome' type='text' disabled>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label class='col-4 col-form-label'>Cognome</label>
                                        <div class='col-8'>
                                            <input class='form-control here' placeholder='$cognome' type='text' disabled>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label class='col-4 col-form-label'>Email</label>
                                        <div class='col-8'>
                                            <input class='form-control here' placeholder='$email' type='text' disabled>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label for='text' class='col-4 col-form-label'>Data di nascita</label>
                                        <div class='col-8'>
                                            <input placeholder='$datanascita' class='form-control here' type='text' disabled>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label for='text' class='col-4 col-form-label'>Account registrato il</label>
                                        <div class='col-8'>
                                            <input placeholder='$datavalidazione' class='form-control here' type='text' disabled>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label for='text' class='col-4 col-form-label'>Via</label>
                                        <div class='col-8'>
                                            <input placeholder='$via' class='form-control here' type='text' disabled>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label for='text' class='col-4 col-form-label'>Civico</label>
                                        <div class='col-8'>
                                            <input placeholder='$civico' class='form-control here' type='text' disabled>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label for='text' class='col-4 col-form-label'>Telefono Cellulare</label>
                                        <div class='col-8'>
                                            <input placeholder='$cellulare' class='form-control here' type='text' disabled>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label for='text' class='col-4 col-form-label'>Telefono Fisso</label>
                                        <div class='col-8'>
                                            <input placeholder='$fisso' class='form-control here' type='text' disabled>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <form method='post'>
                                <button class='button btn btn-info' type='submit' name='modifica'> Clicca qui per modificare i tuoi dati </button>
                                </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>";
    }
    else{
        echo"
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
                            <form method='post'>
                                <div class='form-group row'>
                                    <label class='col-4 col-form-label'>Nome</label>
                                    <div class='col-8'>
                                        <input class='form-control here' value='$nome' type='text' name='nome'>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <label class='col-4 col-form-label'>Cognome</label>
                                    <div class='col-8'>
                                        <input class='form-control here' value='$cognome' type='text' name='cognome'>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <label class='col-4 col-form-label'>Email</label>
                                    <div class='col-8'>
                                        <input class='form-control here' placeholder='$email' type='text' disabled>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <label for='text' class='col-4 col-form-label'>Data di nascita</label>
                                    <div class='col-8'>
                                        <input placeholder='$datanascita' class='form-control here' type='text' disabled>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <label for='text' class='col-4 col-form-label'>Account registrato il</label>
                                    <div class='col-8'>
                                        <input placeholder='$datavalidazione' class='form-control here' type='text' disabled>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <label for='text' class='col-4 col-form-label'>Via</label>
                                    <div class='col-8'>
                                        <input value='$via' class='form-control here' type='text' name='via'>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <label for='text' class='col-4 col-form-label'>Civico</label>
                                    <div class='col-8'>
                                        <input value='$civico' class='form-control here' type='text' name='civico'>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <label for='text' class='col-4 col-form-label'>Telefono Cellulare</label>
                                    <div class='col-8'>
                                        <input value='$cellulare' class='form-control here' type='text' name='cellulare'>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <label for='text' class='col-4 col-form-label'>Telefono Fisso</label>
                                    <div class='col-8'>
                                        <input value='$fisso' class='form-control here' type='text' name='fisso'>
                                    </div>
                                </div>
                            
                        </div>
                        
                        <button class='button btn btn-info' type='submit' name='conferma'> Clicca qui per confermare i cambiamenti </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>"; 
    }
    ?>


    <!-- Pagina del footer importata -->
    <?php include_once "../views/footer.php"; ?>

</body>