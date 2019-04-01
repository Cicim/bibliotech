<!-- Codice per la stampa di un libro e per la paginazione -->
<?php
function paginazione($conn, $query)
{
    // Ottieni i dati in utf-8
    mysqli_query($conn, "set names 'utf8'");

    // Limita la query
    $query .= "\nLIMIT 12";

    // Esegui la query nella paginazione
    $ris = mysqli_query($conn, $query)
        or die("Impossibile eseguire la query per ottenere i libri");

    // Stampa i libri
    while ($libro = mysqli_fetch_assoc($ris))
        stampa_libro($libro);

     return true;
}

// Funzione per stampare un libro, ottenendo la copertina online
function stampa_libro($queryRes)
{
    // Ottieni il titolo del libro
    $titolo = htmlspecialchars($queryRes["Titolo"]);
    // Ottieni l'ISBN del libro
    $ISBN = $queryRes["ISBN"];
    
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
    </div>";
}

?> 