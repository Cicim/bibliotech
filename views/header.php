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
            // Inizializza la sessione
            session_start();

            if (isset($_SESSION["user_id"])) {
                // Ottieni nome e cognome dell'utente
                $nome = $_SESSION["nome"];
                $cognome = $_SESSION["cognome"];
                $codfisc = $_SESSION["user_id"];

               


                    // Stampa il dropdown
                   echo " <div class='dropdown'>
                   <button class='btn btn-info ml2'>$nome $cognome</button>
                   <div class='dropdown-content'>
                     <a href='../pages/area_personale.php'>Pagina Utente</a>
                     <a href='../pages/lista_desideri.php'>Lista Desideri</a>
                     <a href='../pages/cronologia_prestiti.php'>Lista Prestiti</a>
                     <a href='../php/logout.php'>Esci</a>
                   </div>
                 </div> ";
            } 
            // Oppure stampa il pulsante accedi
            else
                echo "<a class='btn btn-info ml-2' id='btnAccedi' href='login.php'>Accedi</a>";

            ?>
        </div>
    </nav>
</header> 