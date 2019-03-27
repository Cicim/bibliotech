<header>
    <nav class="navbar navbar-expand-lg navbar-dark light bg-dark">
        <a class="navbar-brand" href="#">Bibliotech</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Catalogo</a>
                </li>

                <div class="dropdown">
                    <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Accedi
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu px-3" style="width: 20em">
                        <form action="php/controllalogin.php" method="post">
                            <span >Email:</span>
                            <input class="form-control" type="text" name="email" size="40" />
                            <span>Password:</span>
                            <input class="form-control" type="password" name="password" size="40" /><br />
                            <div class="text-center">
                                <input type="submit" class="btn btn-info w-100" name="invio" value="Accedi" />
                            </div>
                        </form>
                    </ul>
                </div>

            </ul>
            <a class="btn btn-info ml-2" href="login.php">Accedi</a>
        </div>
    </nav>
</header> 