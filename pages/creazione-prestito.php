<!-- Pagina scritta dal gruppo 2 -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gestione utenti - Bibliotech</title>

    <!-- Inclusione librerie di Bootstrap -->
    <?php include_once "../php/imports.php"; ?>

    <style>
        table, tr, td {
            
            border: none;

        }
    </style>

</head>

<body>
    <!-- Pagina dell'header importata -->
    <?php include_once "../views/header.php"; ?>
    
    <!-- Rettangolo grigio per il titolo della sezione -->
    <div class="jumbotron" style="padding: 2rem 2rem">
        <h1 class="display-4 text-center">Creazione nuovo prestito</h1>
    </div>
    <form method = POST action = "">
        <table align = center width = "66%">
            <tr align = center>
                <td>
                    <!-- Prima riga (3 caselle) -->
                    <div class="row">
                            <!-- IdPrestito -->
                            <div class="col-md-6 mb-3">
                                <label for="idPrestito">idPrestito</label>
                                <input type="text" class="form-control" name="idPrestito" placeholder="Es. 254123" value="" required="true">
                                <div class="invalid-feedback">Inserisci un id valido</div>
                            </div>
                            <!-- Codice Fiscale Utente -->
                            <div class="col-md-6 mb-3">
                                <label for="CodFisc">Codice Fiscale</label>
                                <input type="text" class="form-control" name="CodFisc" placeholder="Es. HPFMWS46H48G903E" value="" required="true">
                                <div class="invalid-feedback">Inserisci un codice fiscale valido.</div>
                            </div>
                    </div>
                </td>
            </tr>
            <tr align = center>
                <td>
                    <!-- Seconda riga (3 caselle) -->
                    <div class="row">
                        <!--Data consegna -->
                        <div class="col-md-6 mb-3">
                            <label for="dataRicons">Data Riconsegna</label>
                            <input class="form-control w-100" name="dataRicons" placeholder="Es. 21/2/2017" required="true">
                            <div class="invalid-feedback">Inserisci una data per la consegna valida</div>
                        </div>

                        <!--  -->
                        <div class="col-md-6 mb-3">
                            <label for="idCopia">idCopia</label>
                            <input class="form-control w-100" name="idCopia" placeholder="Es. 9000" required="true">
                            <div class="invalid-feedback">Inserisci un id valido.</div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

<!--working progress-->


<!--Script php per l'invio dei dati al database-->
<?php

    //recupero dati inseriti nel form
    if (isset($_POST["titolo"])) {
        //Connetto al DB


    }
    ?>

    <div align = center>

            <!-- Bottone per tornare alla pagina principale della sezione amministrativa -->
            <a class="btn btn-danger ml-2 block" id="btnAnnulla" href="sezione-amministrativa.php"><i class="fa fa-arrow-left"></i> Annulla</a>

            <!-- Conferma della creazione del prestito -->
            <input type = submit class="btn btn-success ml-2 block" name="btnConferma">
            <!-- Esecuzione della query -->
        </form>
        <?php 
            #include_once "connessione.php";
            #$conn = connettitiAlDb();

            $host = "localhost";
            $user = "root";
            $db = "biblioteca";

            $conn = mysqli_connect($host, $user, '');
            $sel = mysqli_select_db($conn, $db);



            //Se il telefono fisso non è stato inserito, allora settalo a NULL
            #if ($telFisso == "") $telFisso = "NULL";
            #else $telFisso = "'$telFisso'";

            
            //Esecuzione query
            if((isset($_POST['btnConferma'])))
            {
                
                if(!$_POST["idPrestito"]){
                    echo "idPrestito";
                }
                else{
                    $idPrestito = $_POST["idPrestito"];
                    if(!$_POST["CodFisc"]){
                        echo "CodFisc";
                    }
                    else{

                        $CodFisc = $_POST["CodFisc"];
                        if(!$_POST["dataRicons"]){
                            echo "dataRicons";
                        }
                        else{

                            $dataRicons = $_POST["dataRicons"];
                            if(!$_POST["idCopia"]){
                                echo "idCopia";
                            }
                            else{

                                $idCopia = $_POST["idCopia"]; 

                                //Query di inserimento campi nel database
                                $query =  "INSERT INTO Prestiti (idPrestito,  codFiscaleUtente, DataRiconsegna, idCopia) VALUES
                                ('$idPrestito', '$CodFisc', '$dataRicons', $idCopia')";

                                echo "Query in esecuzione";
                                $query_res = mysqli_query($conn, $query);
                                // Mostra l'errore
                                if (!$query_res) 
                                {
                                    echo ("ERROR: " . mysqli_error($conn));
                                    echo "Errore query";
                                }
                                else{
                                    echo "Query eseguita";
                                }
                            }
                        }
                    }        
                }
            }
            else{
                echo "Dati non completi";
            }

            //Chiudo la connessione
            mysqli_close($conn);

        ?>
    </div>
        <br>
        <br>
  

    <!-- Pagina del footer importata -->
    <?php include_once "../views/footer.php"; ?>

</body> 
