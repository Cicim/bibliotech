<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Crea autore - Bibliotech</title>

    <!-- Include le librerie comuni -->
    <?php 
        include_once "../php/imports.php";
        include_once "../php/connessione.php";
        $conn = connettitiAlDb();
    ?>

    <!-- Carica il css per il catalogo -->
    <link rel="stylesheet" type="text/css" href="../css/catalogo.css">
    <!-- Carica il js e il css per la combobox -->
    <script src="../js/combobox.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/combobox.css">
</head>

<body>
    <!-- Contenuto principale della pagina -->
    <div>
        <!-- Rettangolo grigio per il titolo della sezione -->
        <div class="jumbotron" style="padding: 2rem 2rem">
            <h1 class="display-4 text-center">
                <a href="autori.php" title="Torna alla lista degli autori"><i class="fa fa-undo text-info"></i></a>
                Crea un autore&nbsp;&nbsp;
            </h1>
        </div>

        <!-- idAutore INT NOT NULL,
             NomeAutore VARCHAR(45) NOT NULL,
             CognomeAutore VARCHAR(45) NOT NULL,
             DataNascita DATE NOT NULL,
             DataMorte DATE NULL,
             Descrizione VARCHAR(200) NULL,
             NomeArte VARCHAR(45) NULL,
             idNazionalita INT NOT NULL,
             idCittaNascita INT NOT NULL,
             idCittaMorte INT NULL, -->

        <div class="col-md-12 mb-3">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" name="nome" placeholder="Es. Mario" value="" required="true">
            <div class="invalid-feedback">Inserisci un nome valido</div>
        </div>

        <!-- Cognome -->
        <div class="col-md-12 mb-3">
            <label for="cognome">Cognome</label>
            <input type="text" class="form-control" name="cognome" placeholder="Es. Rossi" value="" required="true">
            <div class="invalid-feedback">Inserisci un cognome valido.</div>
        </div>

        <!-- Data di Nascita -->
        <div class="container col-md-12 mb-3">
            <label for="datetimepicker">Data di Nascita </label>
            <div class="form-group">
                <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" name="dataNascita" data-target="#datetimepicker" />
                    <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                        <div class="input-group-text">
                            <i class="fa fa-calendar" style="font-size:24px"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data di Morte -->
        <div class="container col-md-12 mb-3">
            <label for="datetimepicker">Data di Morte </label>
            <div class="form-group">
                <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" name="dataNascita" data-target="#datetimepicker" />
                    <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                        <div class="input-group-text">
                            <i class="fa fa-calendar" style="font-size:24px"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Descrizione del libro-->
        <div class="col-md-12 mb-3">
            <label for="descrizione">Descrizione dell'autore</label>
            <textarea class="form-control" name="descrizione" placeholder="Es. Descrizione dell'autore"></textarea>
        </div>

        <!-- Nome d'arte -->
        <div class="col-md-12 mb-3">
            <label for="nomeArte">Nome d'arte</label>
            <input type="text" class="form-control" name="nomeArte" placeholder="Es. Mario" value="" required="true">
            <div class="invalid-feedback">Inserisci un nome valido</div>
        </div>

        <!-- Nazionalità -->
        <div class="col-md-12 mb-3">
            <label for="nazionalita">Nazionalità</label>
            <div class="input-group" id="comboboxNazionalita">
                <input type="text" class="form-control" placeholder="Cerca nazionalità...">
                <div class="input-group-prepend" data-toggle="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown"></button>
                    <div class="dropdown-menu dropdown-menu-right combobox-content">
                        <!-- Script per importare tutte le opzioni -->
                        <?php
                        $query = "SELECT * FROM Nazionalita";

                        // Esegui la query
                        $qres = mysqli_query($conn, $query);

                        // Stampa i link
                        while ($row = mysqli_fetch_assoc($qres))
                            // Stampa gli a href
                            echo "<a class=dropdown-item href='#' value='" . $row["idNazionalita"] . "'>" . $row["Descrizione"] . "</a>";
                        ?>
                    </div>
                </div>
                <input name="nazionalita" id="nazionalita" type="text" class="d-none">
            </div>
            <script>
                $(function() {
                    combobox($('#comboboxNazionalita'), $('#nazionalita'));
                });
            </script>
        </div>

        <!-- Città di Nascita -->
        <div class="col-md-12 mb-3">
            <label for="cittaNascita">Città di Nascita</label>
            <div class="input-group" id="comboboxCittaNascita">
                <input type="text" class="form-control" placeholder="Cerca città...">
                <div class="input-group-prepend" data-toggle="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown"></button>
                    <div class="dropdown-menu dropdown-menu-right combobox-content">
                        <!-- Script per importare tutte le opzioni -->
                        <?php
                        $query = "SELECT * FROM Citta";

                        // Esegui la query
                        $qres = mysqli_query($conn, $query);

                        // Stampa i link
                        while ($row = mysqli_fetch_assoc($qres))
                            // Stampa gli a href
                            echo "<a class=dropdown-item href='#' value='" . $row["idCitta"] . "'>" . $row["Nome"] . "</a>";
                        ?>
                    </div>
                </div>
                <input name="cittaNascita" id="cittaNascita" type="text" class="d-none">
            </div>
            <script>
                $(function() {
                    combobox($('#comboboxCittaNascita'), $('#cittaNascita'));
                });
            </script>
        </div>

        <!-- Città di Morte -->
        <div class="col-md-12 mb-3">
            <label for="cittaMorte">Città di Morte</label>
            <div class="input-group" id="comboboxCittaMorte">
                <input type="text" class="form-control" placeholder="Cerca città...">
                <div class="input-group-prepend" data-toggle="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown"></button>
                    <div class="dropdown-menu dropdown-menu-right combobox-content">
                        <!-- Script per importare tutte le opzioni -->
                        <?php
                        $query = "SELECT * FROM Citta";

                        // Esegui la query
                        $qres = mysqli_query($conn, $query);

                        // Stampa i link
                        while ($row = mysqli_fetch_assoc($qres))
                            // Stampa gli a href
                            echo "<a class=dropdown-item href='#' value='" . $row["idCitta"] . "'>" . $row["Nome"] . "</a>";
                        ?>
                    </div>
                </div>
                <input name="cittaMorte" id="cittaMorte" type="text" class="d-none">
            </div>
            <script>
                $(function() {
                    combobox($('#comboboxCittaMorte'), $('#cittaMorte'));
                });
            </script>
        </div>

    </div>
</body>

</html>