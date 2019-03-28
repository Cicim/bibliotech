<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Bibliotech - Registrazione</title>

    <!-- Bootstrap core CSS -->
    <?php include "../php/imports.php" ?>

    <!-- Custom styles for this template -->
    <link href="../css/login.css" rel="stylesheet">

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />

</head>

<body class="text-center">
    <?php include "header.php" ?>

    <form class="form-signin mt-5" style="max-width: 700px" novalidation="" method="post" action="">
        <h1>Bibliotech</h1>
        <h1 class="h3 mb-3 font-weight-normal">Registrati</h1>

        <div class="row">
            <!-- Nome -->
            <div class="col-md-5 mb-3">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" placeholder="Es. Mario" value="" required="true">
                <div class="invalid-feedback">Inserisci un nome valido</div>
            </div>
            <!-- Cognome -->
            <div class="col-md-5 mb-3">
                <label for="cognome">Cognome</label>
                <input type="text" class="form-control" id="cognome" placeholder="Es. Rossi" value="" required="true">
                <div class="invalid-feedback">Inserisci un cognome valido.</div>
            </div>
            <!-- Selezione Sesso -->
            <div class="col-md-2 mb-3">
                <label for="sesso">Sesso</label>
                <select type="text" class="form-control" id="sesso" value="" required="true">
                    <option>M</option>
                    <option>F</option>
                    <option>Altro</option>
                </select>
            </div>
        </div>

        <div class="row">
            <!-- Via / Piazza-->
            <div class="col-md-6 mb-3">
                <label for="viaPzz">Via / Piazza</label>
                <input class="form-control w-100" id="viaPzz" placeholder="Es. Via Garibaldi / Piazza Verdi" required="true">
                <div class="invalid-feedback">Inserisci una via valida</div>
            </div>

            <!-- Città -->
            <div class="col-md-4 mb-3">
                <label for="citta">Città</label>
                <input class="form-control w-100" id="citta" placeholder="Es. Torino" required="true">
                <div class="invalid-feedback">Inserisci una città valida.</div>
            </div>

            <!-- Numero Civico -->
            <div class="col-md-2 mb-3">
                <label for="numeroCivico"># Civico</label>
                <input type="text" class="form-control" id="numeroCivico" placeholder="Es. 20">
            </div>
        </div>

        <div class="row">
            <!-- Codice Fiscale -->
            <div class="col-md-6 mb-3">
                <label for="codFiscale">Codice Fiscale</label>
                <input type="text" class="form-control" id="codFiscale" placeholder="Es. RSSMRO25R12R657K" required="true">
                <div class="invalid-feedback">Inserisci un codice fiscale valido</div>
            </div>
            <!-- Data di Nascita -->
            <div class="container col-md-6 mb-3">
                <label for="datetimepicker">Data di Nascita </label>
                <div class="form-group">
                    <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker" />
                        <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                            <div class="input-group-text">
                                <i class="fa fa-calendar" style="font-size:24px"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(function() {
                $('#datetimepicker').datetimepicker({
                    format: 'DD/MM/YYYY',
                    locale: 'it',
                });
            });
        </script>

        <div class="row">
            <!-- Telefono Cellulare -->
            <div class="col-md-6 mb-3">
                <label for="telCellulare">Telefono Cellulare</label>
                <input type="text" class="form-control" id="telCellulare" placeholder="Cellulare" required="true">
                <div class="invalid-feedback">Inserisci il numero di telefono.</div>
            </div>
            <!-- Telefono Fisso -->
            <div class="col-md-6 mb-3">
                <label for="telFisso">Telefono Fisso</label>
                <input type="text" class="form-control" id="telFisso" placeholder="Fisso">
            </div>
        </div>

        <!-- Indirizzo Email -->
        <div class="mb-3">
            <label for="email">Indirizzo Email</label>
            <input type="email" class="form-control" id="email" placeholder="Es. mario.rossi@gmail.com" required="true">
            <div class="invalid-feedback">Inserisci un'email valida.</div>
        </div>

        <script type="text/javascript">
            var controllo_password = function() {
                if (document.getElementById('password').value ==
                    document.getElementById('confermaPassword').value) {
                    document.getElementById('message').style.color = 'green';
                } else {
                    document.getElementById('confermaPassword').style.color = 'red';
                    document.getElementById('message').innerHTML = 'Le due password non combaciano.';
                }
            }
        </script>

        <div class="row">
            <!-- Password -->
            <div class="col-md-6 mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="" required="true">
                <div class="invalid-feedback">Inserisci una password valida.</div>
            </div>

            <!-- Conferma Password -->
            <div class="col-md-6 mb-3">
                <label for="confermaPassword">Conferma Password</label>
                <input type="password" class="form-control" id="confermaPassword" placeholder="" required="true">
                <div class="invalid-feedback">Inserisci una password valida.</div>
            </div>
        </div>


        <button class="btn btn-primary btn-lg btn-info w-100 mt-5" type="submit">Registrati</button>
        <p class="mt-5 mb-3 text-muted">
            Sei già registrato? Torna al <a href="/bib2/login.php">login</a>
        </p>

        <p class="mt-5 mb-3 text-muted">&copy; Bibliotech, 2019 </p>
    </form>

</body>

</html> 