<!-- Proseguimento della pagina del popup -->
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Seleziona copia di <?php echo $_GET['ISBN'] ?></title>

    <!-- Include le librerie comuni -->
    <?php include_once "../php/imports.php";
    // Includi il codice per la paginazione
    include_once "../php/paginazione.php";
    // Includi il codice per la connessione al database
    include '../php/connessione.php'; ?>

    <!-- Carica il css per il catalogo -->
    <link rel="stylesheet" type="text/css" href="../css/catalogo.css">
    <!-- Carica il js e il css per la combobox -->
    <script src="../js/combobox.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/combobox.css">
</head>

<body>
    <!-- Rettangolo grigio per il titolo della sezione -->
    <div class="jumbotron" style="padding: 2rem 2rem">
        <h1 class="display-4 text-center">
            <a href="catalogo.php?bibliotecario" title="Torna al catalogo"><i class="fa fa-undo text-info"></i></a>
            Seleziona copia&nbsp;&nbsp;
        </h1>
    </div>

    <?php
    // Connettiti al database
    include_once "../php/connessione.php";
    $conn = connettitiAlDb();

    // Ottieni il codice
    $isbn = $_GET['ISBN'];

    // Esegui la query per ottenere le copie
    $ris = mysqli_query($conn, "SELECT idCopia, ISBN, Prestato, NumeroRipiano, Armadi.Descrizione AS Armadio, ProprietaDi
                                    FROM Copie, Ripiani, Armadi
                                    WHERE ISBN = '$isbn'
                                      AND Ripiani.idArmadio = Armadi.idArmadio
                                      AND Copie.idRipiano = Ripiani.idRipiano
                                    ORDER BY Prestato ASC;");

    if (mysqli_num_rows($ris) == 0)
        die("<div class='text-center'>Nessuna copia per questo libro</div>");

    ?>

    <div class="container">
        <ul class="list-group">
            <?php
            // Per ogni riga
            while ($riga = mysqli_fetch_assoc($ris)) {
                // Salva l'id della copia
                $idCopia = $riga['idCopia'];
                $prestato = $riga['Prestato'] == 1;

                // Stampa il link
                echo '<span ' . ($prestato ? '' : 'style="cursor:pointer" onclick="seleziona(' . "'$idCopia'" . ')"') . '>';

                // Calcola i testi che variano se è prestato o meno
                $titolo = !$prestato ? "Copia non prestata" : "Copia prestata";
                $disabled = !$prestato ? '' : 'disabled\' style=\'background: lightgrey';
                // Salva i dati sulla posizione
                $rip = $riga['NumeroRipiano'];
                $arm = $riga['Armadio'];


                echo "<li class='list-group-item $disabled'>
                    <b>$titolo</b><br>
                    <b>Posizione</b>: $rip ($arm)
                  </li>
                </span>";
            }
            ?>
        </ul>
    </div>

    <!-- Script per la selezione -->
    <script>
        /**
         * @author Claudio Cicimurri, 5CI
         * Funzione per riportare alla finestra che ha aperto questa finestra
         * l'id della copia selezionata
         * @param number id L'id della copia
         */
        function seleziona(id) {
            // Ottieni l'opener della finestra
            var win = window.opener;

            if (win === null)
                alert("Devi aprire questa pagina da popup");

            // Ottieni l'elemento #idCopia del genitore
            var elemento = win.document.getElementById('idCopia');
            // E concatenagli il nuovo id
            elemento.value = elemento.value === '' ? id : elemento.value + ',' + id;

            // Chiudi la finestra
            window.close();
        }
    </script>

    <script>
        window.onkeydown = function(e) {
            if (e.key === 'Escape')
                window.location.href = 'catalogo.php?bibliotecario';
        }
    </script>
</body>

</html>