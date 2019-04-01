<!-- Codice per la stampa di un libro e per la paginazione -->
<?php
function paginazione($query)
{
    // Connettiti al db
    $conn = connettitiAlDb();
    // Ottieni i dati in utf-8
    mysqli_query($conn, "set names 'utf8'");
    // Esegui la query
    $res = mysqli_query($conn, $query);
    // Pagina corrente
    $pagina = 0;

    // Ottieni il numero massimo di libri
    $totLibri = mysqli_num_rows($res);
    // Numero massimo di libri per schermata
    $maxLibri = 15;
    // Numero di schermate
    $totPagine = ceil($totLibri / $maxLibri);

    // Ottieni la pagina corrente
    if (isset($_GET["page"])) {
        // Se è possibile recuperarla dall'URL
        $pagina = $_GET["page"];
    } else {
        // Se non è esistente
        $pagina = 0;
    }
    // Controlla che la pagina ottenuta sia un numero intero

    if (is_numeric($pagina)) {
        // Controlla che la pagina esista
        if ($pagina < 0) $pagina = 0;
        else if ($pagina > $totPagine - 1) $pagina = $totPagine - 1;
    } else $pagina = 0;

    // Nuova query per ottenere i dati della pagina corrente
    $qryPagina = $query . " LIMIT " . $maxLibri . " OFFSET " . ($maxLibri * $pagina);

    // Esegui la query
    $res2 = mysqli_query($conn, $qryPagina);

    /* 
        Questa è la vera e propria impaginazione.
        Contiene tutta la parte grafica ed è uguale per tutte
        le pagine che utilizzano questa funzione
    */

    //
    // Stampa i pulsanti per spostarsi tra le pagine
    //

    // Centra tutto
    echo '<div class="dividerPagine" style="margin:auto">';
    // Mostra i pulsanti per andare avanti e indietro di pagina
    echo '<nav aria-label="Page navigation example">';
    // Lista dei pulsanti
    echo '<ul class="pagination justify-content-center">';
    // Pulsante per andare alla prima pagina
    // Disabilitato se si è alla prima pagina
    echo '<li class="page-item' . ($pagina == 0 ? " disabled" : "") . '">';
    echo '<a class="page-link" href="?page=0">Prima</a>';
    echo '</li>';
    // Pulsante per andare alla pagina prima
    // Disabilitato se si è alla prima pagina
    echo '<li class="page-item' . ($pagina == 0 ? " disabled" : "") . '">';
    echo '<a class="page-link" href="?page=' . ($pagina - 1 > 0 ? $pagina - 1 : 0) . '">«</a>';
    echo '</li>';

    // Mostra le pagine vicine
    if ($totPagine <= 1) echo $pagina;
    else {
        // Calcolare quanto si può andare indietro
        $indietro = $pagina;
        // Calcolare quanto si può andare avanti
        $avanti  = $totPagine - $pagina;

        // Metti un tetto a 5 per ogni intervallo
        $indietro = $indietro > 5 ? 5 : $indietro;
        $avanti = $avanti > 5 ? 5 : $avanti;

        // Indietro + avanti non deve superare il 5
        // Rimuovi uno dall'intervallo più lungo finché la loro
        // somma non diventa minore o uguale a 5
        while ($avanti + $indietro > 5) {
            if ($avanti > $indietro) $avanti--;
            else $indietro--;
        }

        // Stampa i collegamenti
        for ($i = $pagina - $indietro; $i < $pagina + $avanti; $i++) {
            // Pulsanti per andare alle pagine vicine
            echo '<li class="page-item ' . ($i == $pagina ? "active" : "") . '">';
            echo '<a class="page-link" href="?page=' . $i . '">' . ($i + 1) . '</a>';
            echo '</li>';
        }
    }

    // Pulsante per andare alla pagina dopo
    echo '<li class="page-item' . ($pagina == $totPagine - 1 ? " disabled" : "") . '">';
    echo '<a class="page-link" href="?page=' . ($pagina + 1 < $totPagine ? $pagina + 1 : $totPagine - 1) . '">»</a>';
    echo '</li>';
    // Pulsante per andare all'ultima pagina
    echo '<li class="page-item' . ($pagina == $totPagine - 1 ? " disabled" : "") . '">';
    echo '<a class="page-link" href="?page=' . ($totPagine - 1) . '">Ultima</a>';
    echo '</li>';
    echo '</ul>';
    echo '</nav>';
    echo '</div>';
    echo '</div>';

    //
    // Stampa i risultati della ricerca
    //
    // Stampa una lista dei libri
    echo '<ul class="list-group">';
    // Titolo sezioni
    echo '<li class="list-group-item d-flex list-group-item-info justify-content-between align-items-center">';
    echo '<div class="col-sm">Titolo</div>';
    echo '<div class="col-sm">Editore</div>';
    echo '<div class="col-sm">Autori</div>';
    echo '</li>';
    while ($row = mysqli_fetch_assoc($res2)) {
        // Salva il valore dell'ISBN
        $isbn = $row["ISBN"];

        // Ottieni gli autori
        $qryAutori = "SELECT CONCAT(Autori.NomeAutore, ' ', Autori.CognomeAutore) AS Autore, Autori.idAutore
            FROM Autori, Autori_Libri, Libri
            WHERE Autori.idAutore = Autori_Libri.idAutore
            AND Autori_Libri.ISBNLibro = Libri.ISBN
            AND Libri.ISBN = '$isbn'";
        // Esegui la query
        $res3 = mysqli_query($conn, $qryAutori);

        // Componi il li
        echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
        echo '<a href="libro.php?ISBN='.$isbn.'">';
        // Dividi il tutto in colonne
        echo '<div class="col-sm">';
        echo $row["Titolo"];
        echo '</a>';
        echo '</div>';
        echo '<div class="col-sm">';
        echo $row["NomeEditore"];
        echo '</div>';
        // Ottieni i nomi degli autori
        $i = 0;
        while ($row2 = mysqli_fetch_row($res3)) {
            if ($i != 0) echo ", ";
            // Aggiungi il nome a un array
            echo !$row2[0] ? "<i>Nessun autore</i>" : $row2[0];
            $i++;
        }
        echo '<div class="col-sm">';

        echo '</div>';

        // Chiudi il li
        echo '</li>';
    }
    echo '</ul>';
    // Chiudi la connessione
    mysqli_close($conn);
    return 1;
}

// Funzione per stampare un libro, ottenendo la copertina online
function stampa_libro($queryRes)
{
    // Ottieni il titolo del libro
    $titolo = htmlspecialchars($queryRes["Titolo"]);
    // Ottieni l'ISBN del libro
    $ISBN = $queryRes["ISBN"];





    /*
    echo "<div class='col-md-3 col-sm-6 book-front'>
            <div class='product-grid'>
                <div class='product-image'>
                    <a href='libri.php?ISBN=$ISBN'></a>
                    <ul class='social'>
                        <li>
                            <a href='#' data-tip='Aggiungi'>
                                 <i class='fa fa-plus' style='font-size:36px;'></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class='product-content'>
                    <h3 class='title p-2'>$titolo</h3>
                    <span class='hidden-data'>
                    Autori<br>
                    Dati
                    </span>
                </div>

            </form>
        </div>
    </div>";*/
}

?> 