<header>
<link rel="stylesheet" type="text/css" href="../css/dropdown.css">
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
            // Inizializza la sessione
            session_start();

            if (isset($_SESSION["user_id"])) {
                // Ottieni nome e cognome dell'utente
                $nome = $_SESSION["nome"];
                $cognome = $_SESSION["cognome"];
            

               


                    // Stampa il dropdown
                   echo "<div class='wrapper'>
                    <li class='nav-item dropdown'>
                    <a class='button btn btn-info' id='navbarDropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                          <font color='white'>$nome $cognome</font>
                    </a>
                          <div class='dropdown-menu dropdown-menu-lg-right' aria-labelledby='navbarDropdownMenuLink'>
                            <a class='dropdown-item' href='../pages/area_personale.php'>Pagina Utente</a>
                            <a class='dropdown-item' href='#'>Lista dei desideri</a>
                            <a class='dropdown-item' href='#'>Lista dei prestiti</a>
                            <a class='dropdown-item' href='../php/logout.php'>Esci</a>
                        
                   
                    </li>
                    </div>";
            } 
            // Oppure stampa il pulsante accedi
            else
                echo "<a class='btn btn-info ml-2' id='btnAccedi' href='login.php'>Accedi</a>";

            ?>
        </div>
    </nav>
</header> 