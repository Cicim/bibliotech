<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>Homepage - Bibliotech</title>

    <!-- Include le librerie comuni -->
    <?php include "../php/imports.php";
    // Includi il codice per la paginazione
    include "../php/paginazione.php";
    // Includi il codice per la connessione al database
    include '../php/connessione.php'; ?>

    <!-- Carica il css per il catalogo -->
    <link rel="stylesheet" type="text/css" href="../css/lista_desideri.css">

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
          <a href='#' class='list-group-item list-group-item-action active'>Lista Desideri</a>
          <a href='cronologia_prestiti.php' class='list-group-item list-group-item-action'>Cronologia Prestiti</a>                
        </div> 
    </div>


<br>
<div class='col-md-9'>
        <div class='card'>
            <div class='card-body'>
                <div class='row'>
                    <div class='col-md-12'>";


$sql = "SELECT Titolo, DataInserimento, ISBN
FROM Libri, Utenti, Lista_Interessi
WHERE Utenti.CodFiscale = '$codfisc'
AND Libri.ISBN = Lista_Interessi.ISBNLibro";


 $conn = connettitiAlDb();

 $res = mysqli_query($conn, $sql);

?>

<ul class="list-group-horizontal">
  <li class="list-group-item"><b>Nome Libro</b></li> 
  <li class="list-group-item"><b>Data Inserimento</b></li>
  <li class="list-group-item"><b>Rimozione Libro</b></li>
</ul>


 <?php
 while($row = mysqli_fetch_array($res)) {
    echo "<ul class='list-group-horizontal'>";
    echo "<li class='list-group-item'>" . $row["Titolo"] . "</li> ";
    echo "<li class='list-group-item'>" . $row["DataInserimento"] . "</li> ";
    $isbn = $row["ISBN"];
    echo "<li class='list-group-item'>
    <form action='lista_desideri.php' method='post'>
    <button type='submit' class='btn btn-danger btn-md center-block' name='rimuovi' value='$isbn'>Rimuovi</button>
    </form>
    </li>";
    
    echo "</ul>";
 }
 echo "
 </div></div></div></div></div></div></div><br><br>";

 if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['rimuovi'])){

   $valore_isbn = $_POST['rimuovi'];

   $sql = "DELETE FROM lista_interessi 
   WHERE ISBNLibro = '$valore_isbn'";

    $conn = connettitiAlDb();
    
    $res = mysqli_query($conn, $sql);
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=lista_desideri.php\">";
}

?>


        
    <!-- Pagina del footer importata -->
    <?php include "../views/footer.php"; ?>

</body> 