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
    <link rel="stylesheet" type="text/css" href="../css/area_personale.css">

</head>

<body>


    <!-- Pagina dell'header importata -->
    <?php include "../views/header.php"; ?>
<?php

echo "<br>
<br>
<div class='container'>
<div class='row'>
    <div class='col-md-3 '>
         <div class='list-group '>
          <a href='#' class='list-group-item list-group-item-action active'>Informazioni Utente</a>
          <a href='#' class='list-group-item list-group-item-action'>Impostazioni Account</a>
          <a href='lista_desideri.php' class='list-group-item list-group-item-action'>Lista Desideri</a>
          <a href='cronologia_prestiti.php' class='list-group-item list-group-item-action'>Cronologia Prestiti</a>
          
          
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
                            <label class='col-4 col-form-label'>Nome Utente</label> 
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
                            <input class='form-control here' placeholder=''  type='text' disabled>
                            </div>
                          </div>
                          <div class='form-group row'>
                            <label for='text' class='col-4 col-form-label'>Account Registrato il</label> 
                            <div class='col-8'>
                              <input placeholder='' class='form-control here' type='text' disabled> 
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

<br>"

?>
    

        
    <!-- Pagina del footer importata -->
    <?php include "../views/footer.php"; ?>

</body> 