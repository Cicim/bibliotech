<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sezione amministrativa - Bibliotech</title>

    <!-- Include le librerie comuni -->
    <?php include "../php/imports.php"; ?>

    <!-- Carica il css per il catalogo -->
    <link rel="stylesheet" type="text/css" href="../css/catalogo.css">

    <style>
        table, th, td {
            border: 0px solid black;
        }

        .block{
            display: block;
            width: 100%;
            padding: 100px;
            text-align: center;
            font-size: 300%;
        }
    </style>
</head>

<body>
    <!-- Pagina dell'header importata -->
    <?php include "../views/header.php"; ?>
    
    <!-- Rettangolo grigio per il titolo della sezione -->
    <div class="jumbotron" style="padding: 2rem 2rem">
        <h1 class="display-4 text-center">Sezione amministrativa</h1>
    </div>

    <br><br>

    <!-- Lista utenti registrati -->
    <table border = "0" align = "center" class = "table">
    <span class="glyphicon glyphicon-cog"></span>
        <tr>
            <td align = "right">
                <a class="btn btn-success ml-2 block" id="btnGestioneUtenti" href="#"><i class="fa fa-user"></i> Gestione utenti</a>
            </td>
            <td align = "left">
                <a class="btn btn-success ml-2 block" id="btnGestioneLibri" href="#"><i class="fa fa-book"></i> Gestione libri</a>
            </td>
        </tr>
        <tr>
            <td align = "right">
                <a class="btn btn-success ml-2 block" id="btnVisualizzaListe" href="#"><i class="fa fa-list"></i> Visualizza lista</a>
            </td>
            <td align = "left">
                <a class="btn btn-success ml-2 block" id="btnCreazionePrestitio" href="#"><i class="fa fa-plus"></i> Creazione prestito</a>
            </td>
        </tr>
    </table>

    <br>

    <br><br>

    <!-- Pagina del footer importata -->
    <?php include "../views/footer.php"; ?>

</body> 