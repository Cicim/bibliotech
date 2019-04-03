<!-- Caporaletti 5BI -->

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Bibliotech - Aggiungi un libro</title>

    <!-- Importa tutte le librerie comuni -->
    <?php include "../php/imports.php" ?>

</head>
<body class="text-center">
    <!-- Includi l'header -->
    <?php include "../views/header.php" ?>

    <div class="row">
            <!-- ISBN -->
            <div class="col-md-4 mb-3">
                <label for="nome">ISBN</label>
                <input type="text" class="form-control" name="ISBN" placeholder="Es. 81-7525-766-0 " value="" required="true">
                <div class="invalid-feedback">Inserisci ISBN valido</div>
            </div>
            <!-- Titolo -->
            <div class="col-md-5 mb-3">
                <label for="cognome">Titolo</label>
                <input type="text" class="form-control" name="titolo" placeholder="Es. Senilità" value="" required="true">
                <div class="invalid-feedback">Inserisci un titolo valido.</div>
            </div>
    </div>
            
            <!-- Seconda riga (3 caselle) -->
    <div class="row">
            <!-- Autore -->
            <div class="col-md-6 mb-3">
                <label for="viaPzz">Autore</label>
                <input class="form-control w-100" name="Autore" placeholder="Es. Italo Svevo" required="true">
                <div class="invalid-feedback">Inserisci una via valida</div>
            </div>

            <!-- Numero Civico -->
            <div class="col-md-2 mb-3">
                <label for="numeroCivico"># Civico</label>
                <input type="text" class="form-control" name="numeroCivico" placeholder="Es. 20">
            </div>

            <!-- Città -->
            <div class="col-md-4 mb-3">
                <label for="citta">Città</label>
                <input class="form-control w-100" name="citta" placeholder="Es. Torino" required="true">
                <div class="invalid-feedback">Inserisci una città valida.</div>
            </div>
        </div>
    </div>
</body>   
        