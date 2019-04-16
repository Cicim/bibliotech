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

    <?php
    // Includo la funzione per la connessione al DB
    require_once "../php/connessione.php";
    $conn = connettitiAlDb();
    
    $query = "select idPrestito, ISBN, Titolo, CodFiscale from Utenti, Prestiti, Libri where utenti.CodFiscale = prestiti.codFiscaleUtente and prestiti.idCopia = copie.idCopia and copie.ISBN = libri.ISBN";
    $risultato = mysqli_query($conn, $query);
     if(!$risultato)
     echo("errore ciao");
    ?>

    <table class="table mb-5" border="1" style="max-width:60%;margin:auto;">
        <thead>
            <tr>
            <th scope="col">Codice Prestito</th>
            <th scope="col">Codice Fiscale</th>
            <th scope="col">Codice ISBN</th>
            <th scope="col">Titolo libro</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td>  </td>
            <td>  </td>
            <td>  </td>
            <td>  </td>
            </tr>
        </tbody>
    </table>


      
    </table>
</body>


<td><button type="button" class="btn btn-primary">Rinnovo</button></td>