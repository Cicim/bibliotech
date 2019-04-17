<!-- Aggiungi gli stili -->
<link rel="stylesheet" href="../css/paginazione.css">

<!-- Codice per la stampa di un libro e per la paginazione -->
<?php
// Includo la funzione per il controllo del login
include_once "login-utils.php";

/**
 * @author Claudio Cicimurri 5CI
 * Riporta l'url meno la query inserita
 * @param $tranne la query che non deve ristampare
 * @return Il nuovo URL da mettere in un tag a
 */
function ristampaQueryTranne($tranne)
{
    // Crea stringa
    $nuovoUrl = '?';
    // Ottieni una stringa di tutte le query get tranne quella cercata
    foreach ($_GET as $key => $param) {
        if ($key != $tranne)
            $nuovoUrl .= $key . '=' . $param . '&';
    }
    return $nuovoUrl;
}

/**
 * @author Andrea Cicimurri, 5CI
 * Funzione per creare una lista numerata di libri
 * @param Query per decidere quali libri andare ad impaginare
 * @return 1
 */
function paginazione($query)
{
    // Se la query risulta vuota
    if ($query === "") {
        echo '<div class="jumbotron" style="padding: 2rem 2rem">';
        echo '    <h1 class="display-4 text-center">La query eseguita è vuota!</h1>';
        echo '    <h5 class="text-center">Non sappiamo cosa fare per aiutarti... Questo non è previsto!</h5>';
        echo '</div>';
        return;
    }
    // Connettiti al db
    $conn = connettitiAlDb();
    // Esegui la query
    $res = mysqli_query($conn, $query);

    // Pagina corrente
    $pagina = 0;

    // Ottieni il numero massimo di libri
    $totLibri = mysqli_num_rows($res);

    // Controlla se ha trovato libri
    if ($totLibri == 0) {
        // Stampa messaggio "nessun risultato"
        echo '<div class="jumbotron" style="padding: 2rem 2rem">';
        echo '    <h1 class="display-4 text-center text-muted">Nessun risultato</h1>';
        echo '    <h5 class="text-center text-muted">La ricerca non ha prodotto risulati</h5>';
        echo '</div>';

        return 0;
    }

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

    // Stampa la lista dei libri
    while ($libro = mysqli_fetch_assoc($res2)) {
        // Chiama la funzione stampa_libro
        stampaLibro($libro, $conn);
    }

    mysqli_close($conn);

    stampaBarra($pagina, $totPagine);
    return 1;
}


/**
 * @author Andrea Cicimurri, 5CI
 * Funzione per stampare la barra di navigazione
 * @param $pagina La pagina del catalogo corrente
 * @param $totPagine Il numero totale di pagine del catalogo
 * @return
 */
function stampaBarra($pagina, $totPagine)
{
    // Stringa comune nell'href di tutti i pulsanti della navigazione
    $urlComune = ristampaQueryTranne('page');

    // Classi comune a tutti gli elementi
    $classi = "navbar-font-size";
    echo "<style>.navbar-font-size { font-size: 0.8em }</style>";
    //
    // Stampa i pulsanti per spostarsi tra le pagine
    //

    // Stampa solo se c'è almeno una pagina
    if ($totPagine > 1) {
        // Centra tutto
        echo '<div class="dividerPagine" style="margin:auto">';
        // Mostra i pulsanti per andare avanti e indietro di pagina
        echo '<nav aria-label="Page navigation example">';
        // Lista dei pulsanti
        echo '<ul class="pagination justify-content-center">';
        // Pulsante per andare alla prima pagina
        // Disabilitato se si è alla prima pagina
        echo '<li class="' . $classi . ' page-item' . ($pagina == 0 ? " disabled" : "") . '">';
        echo '<a class="page-link" href="' . $urlComune . 'page=0">Prima</a>';
        echo '</li>';
        // Pulsante per andare alla pagina prima
        // Disabilitato se si è alla prima pagina
        echo '<li class="page-item' . ($pagina == 0 ? " disabled" : "") . '">';
        echo '<a class="' . $classi . ' page-link" href="' . $urlComune . 'page=' . ($pagina - 1 > 0 ? $pagina - 1 : 0) . '">«</a>';
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
                echo '<a class="' . $classi . ' page-link" href="' . $urlComune . 'page=' . $i . '">' . ($i + 1) . '</a>';
                echo '</li>';
            }
        }

        // Pulsante per andare alla pagina dopo
        echo '<li class="' . $classi . ' page-item' . ($pagina == $totPagine - 1 ? " disabled" : "") . '">';
        echo '<a class="page-link" href="' . $urlComune . 'page=' . ($pagina + 1 < $totPagine ? $pagina + 1 : $totPagine - 1) . '">»</a>';
        echo '</li>';
        // Pulsante per andare all'ultima pagina
        echo '<li class="' . $classi . ' page-item' . ($pagina == $totPagine - 1 ? " disabled" : "") . '">';
        echo '<a class="page-link" href="' . $urlComune . 'page=' . ($totPagine - 1) . '">Ultima</a>';
        // Chiudi i tag restanti
        echo '</li></ul></nav></div></div>';
    } else {
        echo "<br><br><br>";
    }
}


/**
 * @author Andrea Cicimurri, 5CI
 * Funzione per stampare un libro
 * @param $libro (associativo) una riga della query che ottiene i libri
 * @param sessione di connessione al database
 * @return
 */
function stampaLibro($libro, $conn)
{
    $isbn = $libro["ISBN"];

    // Aggiungi la query bibliotecario se sei un bibliotecario
    $bibliotecario = "";
    if (isset($_GET['bibliotecario']))
        $bibliotecario = '&bibliotecario';

    // Controlla se il login è stato effettuato
    $userid = logged();
    // Href del pulsante lista dei desideri
    $linklista = "";

    // Se non sei loggato imposta a login.php
    if (!$userid) {
    } else {
    }

    // Crea il container che conterrà
    // tutte le informazione del libro importanti

    // Pulsante da cliccare per aprile le info del libro
    echo '<button onClick="location.href=' . "'libro.php?ISBN=" . $libro["ISBN"] . "'" . '" class="pl-4 margin-auto text-left container-fluid bg-light mb-2 border border-info">';
    // Stampa il titolo del libro
    echo "  <b style='font-size:1.2em;'>" . $libro["Titolo"] . "</b>";
    // Riga contenente il pulsante e autore/editore
    echo "  <div class='row'>";
    // Riga che contiene le colonne che vengono dopo
    echo '      <div class="col-10">';
    // Inserisci uno span contenente l'autore
    echo "          <span>" . creaListaAutori($libro["ISBN"], $conn) . "</span>";
    // Inserisci uno span contenente l'editore
    echo "          <br><span><i><a class='text-secondary' href='catalogo.php?titolo=&cerca=1&autore=&editore=" . $libro["nomeEditore"] . "&collana=&tipologia=&genere=$bibliotecario'> " . $libro["nomeEditore"] . "</a></i></span>";
    echo "      </div>";

    // Colonna contenente il pulsante per la prenotazione
    echo "      <div class='col text-right p-1'>";

    // Se lo sta selezionando un bibliotecario per selezionare la copia
    // Non mostrare il pulsante aggiungi alla lista
    if (!isset($_GET['bibliotecario'])) {
        // ANCHOR Stampa pulsanti dei aggiunta o rimozione o niente
        // Se sei loggato stampa i pulsanti per la prenotatione
        // if (0) {
        if ($userid != "") {
            // Controlla se il libro è già stato1 aggiunto
            $qc = "SELECT * 
                    FROM lista_interessi
                    WHERE ISBNLibro = '$isbn'
                    AND codFiscaleUtente = '$userid'";
            // Esegui la query
            $qcres = mysqli_query($conn, $qc) or die(mysqli_error($conn));
            echo "<form method=GET action=''>";

            // Se la query riporta risultati
            if (mysqli_num_rows($qcres) > 0) 
            {
                // Il libro è già stato aggiunto
                // Stampa pulsanti per cancellare
                // On Mobile
                echo "<a name='rimuovi' value='$isbn' type=submit href='" . $linklista . "' class='fa fa-trash add-to-list short-text btn btn-danger btn-sm'></a>";
                // On Desktop
                echo "<a name='rimuovi' value='$isbn' type=submit href='" . $linklista . "' class='add-to-list full-text btn btn-danger btn-sm'>Rimuovi dalla Lista</a>";
            } else 
            {
                // Il libro non è ancora stato aggiunto
                // Stampa i pulsanti per aggiungere
                // On Mobile
                echo "<a name='aggiungi' value='$isbn' type='submit' href='" . $linklista . "' class='fa fa-plus add-to-list short-text btn btn-info btn-sm'></a>";
                // On Desktop
                echo "<a name='aggiungi' value='$isbn' type='submit' href='" . $linklista . "' class='add-to-list full-text btn btn-info btn-sm'>Aggiungi alla Lista</a>";
            }
        } else {
            // La lista porta a login
            $linklista = "../pages/login.php";
            // Stampa i pulsanti per portare al login
            // On Mobile
            echo "<a href='" . $linklista . "' style='' class='fa fa-plus add-to-list short-text btn btn-info btn-sm'></a>";
            // On Desktop
            echo "<a href='" . $linklista . "' style='' class='add-to-list full-text btn btn-info btn-sm'>Aggiungi alla Lista</a>";
        }
    }
    echo "          </form>";
    echo "      </div>";
    // Chiusura row
    echo "</div>";
    // Chiusura button    
    echo "</button>";
}

/**
 * @author Andrea Cicimurri, 5CI
 * Funzione per ottenere una string composta dalla lista
 * degli autori di un libro separati da virgola
 * @param $isbnLibro int libro da cui prendere gli autori
 * @param $conn sessione di connessione al db
 * @return $lista String lista degli autori
 */
function creaListaAutori($isbnLibro, $conn)
{
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
            // Aggiungi la query bibliotecario se sei un bibliotecario
            $bibliotecario = "";
            if (isset($_GET['bibliotecario']))
                $bibliotecario = '&bibliotecario';

            // Aggiungi una virgola se non si tratta del primo elemento
            if ($i != 0)
                $la .= ", ";

            // Aggiungi un link alla pagina dell'autore
            $la .= '<a class="text-info" href="catalogo.php?titolo=&cerca=1&autore=' . $row[0] . '&editore=&collana=&tipologia=&genere=' . $bibliotecario . '">' . $row[0] . '</a>';

            $i++;
        }
    }
    return $la;
}
