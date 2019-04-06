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
          <a href='#' class='list-group-item list-group-item-action'>Informazioni Utente</a>
          <a href='#' class='list-group-item list-group-item-action'>Impostazioni Account</a>
          <a href='#' class='list-group-item list-group-item-action'>Lista Desideri</a>
          <a href='cronologia_prestiti.php' class='list-group-item list-group-item-action active'>Cronologia Prestiti</a>                
        </div> 
    </div>
</div>

<br>
<div class='row'>
<div class='col-md-12'>";

$sql = 'SELECT *
FROM Prestiti';


 $conn = connettitiAlDb();
 // Ottieni i dati in utf-8
 $res = mysqli_query($conn, $sql);
 echo "<div class='col-md-9'>";
 while($row = mysqli_fetch_array($res)) {

    echo " $row[DataConsegna]";
 }
 echo "</div>"

?>

        <!-- Pagina del footer importata -->
        <?php include "../views/footer.php"; ?>
</body> 