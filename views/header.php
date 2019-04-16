<header>
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <nav class="navbar navbar-expand-lg navbar-dark light bg-dark">
        <a class="navbar-brand" href="../index.php">Bibliotech</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="catalogo.php">Catalogo</a>
                </li>
            </ul>


            <?php
            session_start();
            // Controlla che l'utente sia loggato
            if (isset($_SESSION["user_id"])) {
                // Ottieni nome e cognome dell'utente
                $nome = $_SESSION["nome"];
                $cognome = $_SESSION["cognome"];

                // Stampa il dropdown
                echo "<div class='btn-group'>
                        <a class='button btn btn-info' href='#'>$nome $cognome</a>
                        <button type='button' class='btn btn-info dropdown-toggle dropdown-toggle-split' data-toggle='dropdown'></button>
                        <div class='dropdown-menu dropdown-menu-lg-right'>
                            <a class='dropdown-item' href='area-personale.php'>Pagina utente</a>
                            <a class='dropdown-item' href='lista-desideri.php'>Lista dei desideri</a>
                            <a class='dropdown-item' href='cronologia-prestiti.php'>Lista dei prestiti</a>
                            <div class='dropdown-divider'></div>
                            <a class='dropdown-item' href='../php/logout.php'>Esci</a>
                        </div>
                    </div>";
            }
            // Oppure stampa il pulsante accedi
            else
                echo "<a class='btn btn-info ml-2' id='btnAccedi' href='login.php'>Accedi</a>";

            ?>
        </div>
    </nav>
</header>