<html>

<head>
    <meta charset="utf-8" />
    <?php include "../views/header.php" ?>
</head>

<body>
    <?php include "../php/imports.php" ?>
    <?php include "../php/connessione.php" ?>
    <!-- Jumbotron -->
    <!--<div class="jumbotron" style="padding: 2rem 2rem">
        <h1 class="display-4 text-center">Vetrina</h1>
    </div>-->
    <?php
        // Connessione al Database
    $conn = connettitiAlDb();
    // Ottieni i dati in utf-8
    mysqli_query($conn, "set names 'utf8'");

    // Ottieni il valore della pagina
    //$isbn = $_GET["ISBN"];                                                        
    $isbn = "9788889672501";

    // Ottieni i dati sul libro
    $q1 = "SELECT ISBN, Titolo, Descrizione, AnnoPubblicazione From Libri WHERE Libri.ISBN = '$isbn'";
    $q2 = "SELECT Generi.Descrizione, Tipologie.Descrizione, Editori.Nome, Lingue.Descrizione, Collane.Nome
                FROM Generi, Tipologie, Editori, Lingue, Collane, Libri
                WHERE Libri.idGenere = Generi.idGenere
                AND Libri.idTipo = Tipologie.idTipologia
                AND Libri.idEditore = Editori.idEditore
                AND Libri.idLingua = Lingue.idLingua
                AND Libri.idCollana = Collane.idCollana
                AND Libri.ISBN = '$isbn'";
    $q3 = "SELECT CONCAT(Autori.NomeAutore, ' ', Autori.CognomeAutore) AS Autore, Autori.idAutore
            FROM Autori, Autori_Libri, Libri
            WHERE Autori.idAutore = Autori_Libri.idAutore
            AND Autori_Libri.ISBNLibro = Libri.ISBN
            AND Libri.ISBN = '$isbn'";

    // Estrai i dati dalla query
    $q1_res = mysqli_query($conn, $q1) or die("Impossibile eseguire query1<br>" . mysqli_error($conn));
    $q2_res = mysqli_query($conn, $q2) or die("Impossibile eseguire query1<br>" . mysqli_error($conn));
    $q3_res = mysqli_query($conn, $q3) or die("Impossibile eseguire query1<br>" . mysqli_error($conn));

    // Ottieni i dati sul libro
    $row = mysqli_fetch_row($q1_res);
    $row2 = mysqli_fetch_row($q2_res);

    // Ottieni tutti gli autori
    $autori = array();
    while ($row3 = mysqli_fetch_row($q3_res)) {
        // Salva gli autori nell'array
        $autori[] = $row3[0];
        $id_a[] = $row3[1];
    }

    // Salva i dati in variabili
    $titolo = $row[1];
    $desc = $row[2]; // Non perviene per alcun libro (inutile)
    $anno = $row[3];
    $genere = $row2[0];
    $tipo = $row2[1];
    $editore = $row2[2];
    $lingua = $row2[3];
    $collana = $row2[4];

    ?>

    <!--                    TITOLO                  -->
    <!--                  di $autore                -->
    <div class="jumbotron" style="padding: 2rem 2rem">
        <h1 class="display-4 text-center"><?php echo $titolo ?></h1>
        <h5 class="display-5 text-center">
            <?php 
            // Impagina gli autori di modo che compaiano
            // in una lista referenziabile
            // Se la lista degli autori è vuota
            if (sizeof($autori) > 0) {
                echo "di ";
                for ($i = 0; $i < sizeof($autori); $i++) {
                    echo "<a style='text-style: italic' href='autore.php?idAutore=";
                    echo $id_a[$i];
                    echo "'>" . $autori[$i] . "</a>";

                    if ($i < sizeof($autori) - 1) echo ", ";
                }
            } else echo "Autore non pervenuto";
            ?>
        </h5>
    </div>

    <!-- DISPONIBILITÀ: ~~  -->
    <table class="table table-striped" style="max-width:60%;margin:auto;">
        <tbody>
            <tr>
                <th scope="row">Genere</th>
                <td><?php echo $genere ?></td>
            </tr>
            <tr>
                <th scope="row">Editore</th>
                <td><?php echo $editore ?></td>
            </tr>
            <tr>
                <th scope="row">Collana</th>
                <td><?php echo $collana ?></td>
            </tr>
            <tr>
                <th scope="row">Pubblicazione</th>
                <td><?php echo $anno ?></td>
            </tr>
            <tr>
                <th scope="row">Lingua</th>
                <td><?php echo $lingua ?></td>
            </tr>
            <tr>
                <th scope="row">ISBN</th>
                <td><?php echo $isbn ?></td>
            </tr>
        </tbody>
    </table>

    <?php include "../views/footer.php" ?>
</b ody>

</html>