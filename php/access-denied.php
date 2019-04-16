<?php
    // Imports
    include_once "login-utils.php";
    include_once "connessione.php";

    // Tipi di utente
    const SUPERAMMINISTRATORE_IPERGALATTICO = 0;
    const BIBLIOTECARIO = 1;
    const UTENTE_REGISTRATO = 2;
    const UTENTE_NON_REGISTRATO = 3;


    /**
     * @author Claudio Cicimurri, 5CI
     * Funzione per ottenere il livello di accesso corrente
     * @return int Livello di accesso
     */
    function ottieniLivelloDiAccesso() {
        // Controlla se sei loggato
        if ($codFiscale = logged()) {
            // Connettiti al database
            $conn = connettitiAlDb();
            // Esegui una query per ottenere i permessi
            $ris = mysqli_query($conn, "SELECT Permessi FROM Utenti WHERE CodFiscale = '$codFiscale'");
            
            // Ottieni i permessi
            return (int) mysqli_fetch_row($ris)[0];
        }
        // Se non sei loggato
        else return UTENTE_NON_REGISTRATO;
    }

    /**
     * @author Claudio Cicimurri, 5CI
     * Funzione per stampare accesso negato in caso di accesso negato
     * @param int $richiesto Livello di accesso richiesto
     */
    function livelloRichiesto($richiesto) {
        // Ottieni il livello di accesso corrente
        $corrente = ottieniLivelloDiAccesso();

        // Confrontalo con quello richiesto
        if ($corrente > $richiesto) {
            // (Sembra il contrario ma funziona così)
            // Devi bloccare l'accesso alla pagina
            echo "<body class='bg-danger text-light pt-5 mt-5'>
                    <h1 class='display-1 text-center pt-5 mt-5'>
                        Accesso negato
                    </h1>
                    <div class='text-center mt-4' style='font-size: 16pt'>
                        Non possiedi le autorizzazioni necessare a visualizzare questa pagina<br>

                        <a href='index.php' class='btn btn-warning mt-5' style='font-size: 14pt'>
                            Torna all'homepage
                        </a>
                    </div>
                  </body>
                </html>";

            die();
        }
    }
?>