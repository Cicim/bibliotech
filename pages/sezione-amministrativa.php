<!-- Pagina scritta dal gruppo di lavoro 2 -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sezione amministrativa - Bibliotech</title>

    <!-- Inclusione librerie di Bootstrap -->
    <?php include "../php/imports.php"; ?>

    <!-- CSS per la tabella principale della pagina -->
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
    <!-- Inclusione dell'header -->
    <?php include "../views/header.php"; ?>
    
    <!-- Titolo della pagina -->
    <div class="jumbotron" style="padding: 2rem 2rem">
        <h1 class="display-4 text-center">Sezione amministrativa</h1>
    </div>

    <br><br>
    
    
    <table border = "0" align = "center" class = "table">
        <tr>
            <!-- Bottone per la pagina di gestione utenti -->
            <td align = "right" width="30%">
                <a class="btn btn-success ml-2 block" id="btnGestioneUtenti" href="gestione-utenti.php"><i class="fa fa-user"></i> Gestione utenti</a>
            </td>
            <!-- Bottone per la pagina di gestione libri -->
            <td align = "left" width="30%">
                <a class="btn btn-success ml-2 block" id="btnGestioneLibri" href="#"><i class="fa fa-book"></i> Gestione libri</a>
            </td>
            <!-- Bottone per la pagina con l'elenco dei prestiti in corso e delle date di scadenza, con relative opzioni di rinnovo e restituzione -->
            <td width="30%">
                <a class="btn btn-success ml-2 block" id="btnVisPrestitiScadenze" href="vis-prestiti-scadenze.php"><i class="fa fa-leanpub"></i> Prestiti</a>
            </td>
        </tr>
        <tr>
            <!-- Bottone per visualizzare l'elenco delle liste dei desideri non vuote degli utenti -->
            <td align = "right" width="30%">
                <a class="btn btn-success ml-2 block" id="btnVisualizzaListe" href="#"><i class="fa fa-list-ul"></i> Visualizza liste</a>
            </td>
            <!-- Bottone per la pagina di creazione di un nuovo prestito -->
            <td align = "left" width="30%">
                <a class="btn btn-success ml-2 block" id="btnCreazionePrestitio" href="creazione-prestito.php"><i class="fa fa-plus"></i> Crea prestito</a>
            </td>
            <!-- Bottone per uscire dalla sezione amministrativa e tornare alla pagina principale -->
            <td width="30%">
                <a class="btn btn-danger ml-2 block" id="btnIndietro" href="index.php"><i class="fa fa-times-circle"></i> Esci</a>
            </td>
        </tr>
    </table>

    <br>

    <br><br>

    <!-- Pagina del footer importata -->
    <?php include "../views/footer.php"; ?>

</body> 