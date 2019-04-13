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
          <a href='area_personale.php' class='list-group-item list-group-item-action'>Informazioni Utente</a>
          <a href='#' class='list-group-item list-group-item-action'>Impostazioni Account</a>
          <a href='#' class='list-group-item list-group-item-action active'>Lista Desideri</a>
          <a href='cronologia_prestiti.php' class='list-group-item list-group-item-action'>Cronologia Prestiti</a>                
        </div> 
    </div>


<br>
<div class='col-md-9'>
        <div class='card'>
            <div class='card-body'>
                <div class='row'>
                    <div class='col-md-12'>
                    </div></div></div></div></div></div></div><br><br>"

?>
    

        
    <!-- Pagina del footer importata -->
    <?php include "../views/footer.php"; ?>

</body> 