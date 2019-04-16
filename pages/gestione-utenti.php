<!-- Pagina scritta dal gruppo di lavoro 2 -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gestione utenti - Bibliotech</title>

    <!-- Inclusione librerie di Bootstrap -->
    <?php include_once "../php/imports.php"; ?>

</head>

<body>
    <!-- Pagina dell'header importata -->
    <?php include_once "../views/header.php"; ?>
    
    <!-- Rettangolo grigio per il titolo della sezione -->
    <div class="jumbotron" style="padding: 2rem 2rem">
        <h1 class="display-4 text-center">Gestione utenti</h1>
    </div>

    <!-- Bottone per tornare alla pagina principale della sezione amministrativa -->
    <div align = "center">
        <a class="btn btn-danger ml-2 block" id="btnSezioneAmministrativa" href="sezione-amministrativa.php"><i class="fa fa-arrow-left"></i> Torna a sezione amministrativa</a>
    </div>

    <br><br>

    <!-- Lista utenti registrati -->
    <table border = "2" align = "center" class = "table">
        <?php
            $connessione = mysqli_connect("localhost", "root", "");
            if(!$connessione){
                echo "Impossibile connettersi al server DBMS";           
            }
            else{
                $selezione = mysqli_select_db($connessione, "biblioteca");
                if(!$selezione){
                    echo "Database non trovato";
                }
                else{
                    $query = "SELECT * FROM Utenti";
                    $risultato = mysqli_query($connessione, $query);
                    if(!$risultato){
                        echo "Errore nella query";
                    }
                    else{
                        echo 
                        "<tr><th>" .
                        "Codice fiscale" . 
                        "</th><th>" . 
                        "Nome" . 
                        "</th><th>" . 
                        "Cognome" . 
                        "</th><th>" . 
                        "Email" .
                        "</th><th>" .
                        "Telefono cellulare" .
                        "</th><th>" . 
                        "Telefono fisso" .
                        "</th><th>" .
                        "Validità account" . 
                        "</th><th>" . 
                        "Rendi bibliotecario" . 
                        "</th><th>" . 
                        "Modifica utente" . 
                        "</th></tr>";
                        while($riga = mysqli_fetch_assoc($risultato)){
                            echo 
                            '<tr><td>' . 
                            $riga['CodFiscale'] . 
                            '</td><td>' . 
                            $riga['Nome'] . 
                            '</td><td>' . 
                            $riga['Cognome'] . 
                            '</td><td>' . 
                            $riga['Email'] . 
                            '</td><td>' . 
                            $riga['TelefonoCellulare'] . 
                            '</td><td>' . 
                            $riga['TelefonoFisso'] .
                            '</td><td>';
                            if($riga['Validato'] == 1){
                                echo "Account confermato </td></td>";
                            }
                            else{
                                echo "Account non confermato </td></td>";
                            }
                            #Pulsante per aggiungere un nuovo bibliotecario
                            #(Aggiungere il link alla pagina NuovoBibliotecario.php)
                            echo "<td align=\"center\"><a class=\"btn btn-info ml-2\" id=\"btnNuovoBibliotecario\" href=\"#\"><i class=\"fa fa-plus\"></i> Rendi bibliotecario</a></td>";
                        
                            #Pulsante per modificare un utente -->
                            #(Aggiungere il link alla pagina ModificaUtente.php)
                            echo "<td align=\"center\"><a class=\"btn btn-info ml-2\" id=\"btnModificaUtente\" href=\"#\"><i class=\"fa fa-edit\"></i> Modifica utente</a></td>";               
                        }
                    }
                }            
            }
        
        ?>
    </table>

    <br>

    <!-- Bottone per tornare alla pagina principale della sezione amministrativa -->
    <div align = "center">
        <a class="btn btn-danger ml-2 block" id="btnSezioneAmministrativa" href="sezione-amministrativa.php"><i class="fa fa-arrow-left"></i> Torna a sezione amministrativa</a>
    </div>

    <br>

    <br><br>

    <!-- Pagina del footer importata -->
    <?php include_once "../views/footer.php"; ?>

</body> 