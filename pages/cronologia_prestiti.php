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
    <link rel="stylesheet" type="text/css" href="../css/cronologia_prestiti.css">
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
          <a href='lista_desideri.php' class='list-group-item list-group-item-action'>Lista Desideri</a>
          <a href='#' class='list-group-item list-group-item-action active'>Cronologia Prestiti</a>                
        </div> 
    </div>


<br>
<div class='col-md-9'>
        <div class='card'>
            <div class='card-body'>
                <div class='row'>
                    <div class='col-md-12'>";

$sql = "SELECT Titolo, DataConsegna, DataRiconsegna
FROM Libri, Copie, Prestiti, Utenti
WHERE Utenti.CodFiscale = '$codfisc'
AND Copie.idCopia = Prestiti.idCopia
AND Copie.ISBN = Libri.ISBN";


 $conn = connettitiAlDb();

 $res = mysqli_query($conn, $sql);
 ?>

<ul class="list-group-horizontal">
  <li class="list-group-item"><b>Nome Libro</b></li> 
  <li class="list-group-item"><b>Data Prestito</b></li>
  <li class="list-group-item"><b>Data Riconsegna</b></li>
</ul>


 <?php
 while($row = mysqli_fetch_array($res)) {
    echo "<ul class='list-group-horizontal'>";
    echo "<li class='list-group-item'>" . $row["Titolo"] . "</li> ";
    echo "<li class='list-group-item'>" . $row["DataConsegna"] . "</li> ";
    echo "<li class='list-group-item'>" . $row["DataRiconsegna"] . "</li> ";
    echo "</ul>";
 }
 echo "
 </div></div></div></div></div></div></div><br><br>";

?>



        <!-- Pagina del footer importata -->
        <?php include "../views/footer.php"; ?>
</body> 