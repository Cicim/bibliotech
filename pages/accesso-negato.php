<!-- Pagina scritta dal gruppo di lavoro 2 -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gestione utenti - Bibliotech</title>

    <!-- Inclusione librerie di Bootstrap -->
    <?php include_once "../php/imports.php"; ?>

</head>

<body>
    <!-- Inclusione dell'header -->
    <?php include_once "../views/header.php"; ?>

    <!-- Titolo della pagina -->
    <div class="jumbotron" style="padding: 2rem 2rem">
        <h1 class="display-4 text-center">Accesso negato</h1>
    </div>

    <table align = "center">
        <tr>
            <td>
                <p><font size = "5"> Non si dispongono di permessi sufficienti per compiere l'operazione. Contattare un admin. </font></p>
            </td>
        </tr>
    </table>

    <div align="center">
        <!-- Bottone per tornare alla pagina principale della sezione amministrativa -->
        <a class="btn btn-danger ml-2 block" id="btnAnnulla" href="sezione-amministrativa.php"><i class="fa fa-arrow-left"></i> Torna indietro</a>
    </div>

    <br>

    <!-- Inclusione del footer -->
    <?php include_once "../views/footer.php"; ?>

</body> 