<!-- Codice per la stampa di un libro e per la paginazione -->
<?php
/**
 * Funzione per creare una lista numerata di libri
 * @param Query per decidere quali libri andare ad impaginare
 * @return
 */
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

    // Impaginazione vera e propria

    // Stampa la lista dei libri
    while ($libro = mysqli_fetch_assoc($res2)) {
        // Chiama la funzione stampa_libro
        stampa_libro($libro, $conn);
    }

    mysqli_close($conn);

    stampa_barra($pagina, $totPagine);
    return 1;
}

/**
 * Funzione per stampare la barra di navigazione
 * @param $pagina La pagina del catalogo corrente
 * @param $totPagine Il numero totale di pagine del catalogo
 * @return
 */
function stampa_barra($pagina, $totPagine)
{
    // Classi comune a tutti gli elementi
    $classi = "";
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
    echo '<li class="'.$classi.' page-item' . ($pagina == 0 ? " disabled" : "") . '">';
    echo '<a class="page-link" href="?page=0">Prima</a>';
    echo '</li>';
    // Pulsante per andare alla pagina prima
    // Disabilitato se si è alla prima pagina
    echo '<li class="page-item' . ($pagina == 0 ? " disabled" : "") . '">';
    echo '<a class="'.$classi.' page-link" href="?page=' . ($pagina - 1 > 0 ? $pagina - 1 : 0) . '">«</a>';
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
            echo '<a class="'.$classi.' page-link" href="?page=' . $i . '">' . ($i + 1) . '</a>';
            echo '</li>';
        }
    }

    // Pulsante per andare alla pagina dopo
    echo '<li class="'.$classi.' page-item' . ($pagina == $totPagine - 1 ? " disabled" : "") . '">';
    echo '<a class="page-link" href="?page=' . ($pagina + 1 < $totPagine ? $pagina + 1 : $totPagine - 1) . '">»</a>';
    echo '</li>';
    // Pulsante per andare all'ultima pagina
    echo '<li class="'.$classi.' page-item' . ($pagina == $totPagine - 1 ? " disabled" : "") . '">';
    echo '<a class="page-link" href="?page=' . ($totPagine - 1) . '">Ultima</a>';
    // Chiudi i tag restanti
    echo '</li></ul></nav></div></div>';
}


/**
 * Funzione per stampare un libro
 * @param $libro (associativo) una riga della query che ottiene i libri
 * @param sessione di connessione al database
 * @return
 */
function stampa_libro($libro, $conn)
{

    // Crea il container che conterrà
    // tutte le informazione del libro importanti
    echo '<button onClick="location.href='."'libro.php?ISBN=".$libro["ISBN"]."'".'" class="margin-auto row text-left container-fluid bg-light w-100 mb-2 border border-info">';
    // Colonna delle informazioni sul libro
    echo "<div class='col'>";
    // Stampa il titolo del libro
    echo "<b style='font-size:1.2em;'>" . $libro["Titolo"] . "</b>";
    // Inserisci uno span contenente l'autore
    echo "<br><span>" . crea_lista_autori($libro["ISBN"], $conn) . "</span>";
    // Inserisci uno span contenente l'editore
    echo "<br><span><i><a class='text-secondary' href=editore.php?idEditore='".$libro["idEditore"]."'> "
         .$libro["nomeEditore"]."</a></i></span>";
    echo "</div>";
    // Colonna contenente i pulsanti per la prenotazione
    echo "<div style='height:100%' class='col text-right align-middle'>";

    echo "<a href='#' style='width:30%' class='btn btn-info btn-sm mt-1 mb-1'>Prenota</a><br>";
    echo "<a href='#' style='width:30%' class='btn btn-info btn-sm'>Lista</a>";
    
    

    echo "</div>";
    echo "</button>";


}

/**
 * Funzione per ottenere una string composta dalla lista
 * degli autori di un libro separati da virgola
 * @param $isbnLibro int libro da cui prendere gli autori
 * @param $conn sessione di connessione al db
 * @return $lista String lista degli autori
 */
function crea_lista_autori($isbnLibro, $conn)
{
    // Ottieni i dati in utf-8
    mysqli_query($conn, "set names 'utf8'");
    // Lista degli autori
    $la = "";
    // Query per eseguire la ricerca
    $query = "SELECT CONCAT(Autori.NomeAutore, ' ', Autori.CognomeAutore) AS Autore, Autori.idAutore
              FROM Autori, Autori_Libri, Libri
              WHERE Autori.idAutore = Autori_Libri.idAutore
              AND Autori_Libri.ISBNLibro = Libri.ISBN
              AND Libri.ISBN = '$isbnLibro'";
    // Esegui la query
    $res = mysqli_query($conn, $query) or die("Errore nell'esecuzione della query: " . mysqli_error($conn));
    // Crea la stringa degli autori

    $i = 0;
    while ($row = mysqli_fetch_row($res)) {
        // Controlla se la prima riga esiste
        if (!$row) {
            return "Nessun autore";
        } else {
            // Aggiungi una virgola se non si tratta del primo elemento
            if ($i != 0)
                $la .= ", ";

            // Aggiungi un link alla pagina dell'autore
            $la .= '<a class="text-info" href="autore.php?idAutore='.$row[1].'">'.$row[0].'</a>';

            $i++;
        }
    }
    return $la;
}
