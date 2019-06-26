<header>
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    
    <nav class="navbar navbar-expand-lg navbar-dark light bg-dark">
        <a class="navbar-brand" href="../index.php">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <!--<li class="nav-item <?php echo $seiNellIndex ? 'active' : '' ?>">
                    <a class="nav-link" href="index.php">Home</a>
                </li>-->
                <li class="nav-item <?php echo $seiNelCatalogo ? 'active' : '' ?>">
                    <a class="nav-link" href="catalogo.php">Catalogo</a>
                </li>
            </ul>


            <?php
            // Ottieni il livello di permessi dell'account
            include_once '../php/access-denied.php';
            $permessi = ottieniLivelloDiAccesso();
            // Per il controllo di stato del cambiamento dei dati in area personale.
            $controllo = 0;
            $_SESSION["controllo"] = $controllo;

            // Controlla che l'utente sia loggato
            if ($permessi < 3) {
                // Ottieni nome e cognome dell'utente
                $nome = $_SESSION["nome"];
                $cognome = $_SESSION["cognome"];
                $codfisc = $_SESSION["user_id"];
                

                // Stampa il dropdown
                echo "<div class='btn-group'>
                        <a class='button btn btn-info' href='area-personale.php'>$nome $cognome</a>
                        <button type='button' class='btn btn-info dropdown-toggle dropdown-toggle-split' data-toggle='dropdown'></button>
                        <div class='dropdown-menu dropdown-menu-lg-right'>";

                // Se l'utente è bibliotecario
                if ($permessi < 2)
                    echo "<a class='dropdown-item' href='sezione-amministrativa.php'>Sezione amministrativa</a>";

                // Stampa la parte finale
                echo "<a class='dropdown-item' href='area-personale.php'>Pagina utente</a>
                            <a class='dropdown-item' href='lista-desideri.php'>Lista dei desideri</a>
                            <a class='dropdown-item' href='cronologia-prestiti.php'>Cronologia prestiti</a>
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
