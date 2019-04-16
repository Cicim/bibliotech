<!-- Pagina scritta dal gruppo di lavoro 2 -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gestione utenti - Bibliotech</title>

    <!-- Inclusione librerie di Bootstrap -->
    <?php include "../php/imports.php"; ?>

</head>

<body>
    <!-- Pagina dell'header importata -->
    <?php include "../views/header.php"; ?>
    
    <!-- Rettangolo grigio per il titolo della sezione -->
    <div class="jumbotron" style="padding: 2rem 2rem">
        <h1 class="display-4 text-center">Gestione libri</h1>
    </div>

    <br><br>

    <div align = "center">
        <!-- Bottone per tornare alla pagina principale della sezione amministrativa -->
        <a class="btn btn-danger ml-2 block" id="btnSezioneAmministrativa" href="sezione-amministrativa.php"><i class="fa fa-arrow-left"></i> Torna a sezione amministrativa</a>

        <!-- Bottone per la pagina di aggiunta di un nuovo libro -->
        <a class="btn btn-info ml-2 block" id="btnAggiungiLibro" href="aggiungi-libro.php"><i class="fa fa-plus"></i> Aggiungi libro</a>
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
                    $query = "SELECT Libri.ISBN, Libri.Titolo, Libri.AnnoPubblicazione, Generi.Descrizione AS Genere, Tipologie.Descrizione AS Tipologia, Editori.Nome, Lingue.Abbreviazione
                        FROM Libri, Generi, Tipologie, Editori, Lingue 
                        WHERE Generi.idGenere = Libri.idGenere
                        AND Tipologie.idTipologia = Libri.idTipo
                        AND Editori.idEditore = Libri.idEditore
                        AND Lingue.idLingua = Libri.idLingua";
                    $risultato = mysqli_query($connessione, $query);
                    if(!$risultato){
                        echo "Errore nella query";
                    }
                    else{
                        echo 
                        "<tr><th>" .
                        "ISBN" . 
                        "</th><th>" . 
                        "Titolo" . 
                        "</th><th>" . 
                        "Anno" .
                        "</th><th>" .
                        "Genere" .
                        "</th><th>" . 
                        "Tipologia" .
                        "</th><th>" .
                        "Editore" . 
                        "</th><th>" . 
                        "Lingua" . 
                        "</th><th>" . 
                        "Modifica libro" . 
                        "</th></tr>";
                        while($riga = mysqli_fetch_assoc($risultato)){
                            echo 
                            '<tr><td>' . 
                            $riga['ISBN'] . 
                            '</td><td>' . 
                            $riga['Titolo'] . 
                            '</td><td>' . 
                            $riga['AnnoPubblicazione'] . 
                            '</td><td>' . 
                            $riga['Genere'] . 
                            '</td><td>' . 
                            $riga['Tipologia'] .
                            '</td><td>' . 
                            $riga['Nome'] .
                            '</td><td>' .
                            $riga['Abbreviazione'];
                        
                            #Pulsante per modificare un libro -->
                            #(Aggiungere il link alla pagina ModificaLibro.php)
                            echo "<td align=\"center\"><a class=\"btn btn-info ml-2\" id=\"btnModificaLibro\" href=\"#\"><i class=\"fa fa-edit\"></i> Modifica</a></td></tr>";               
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
    <?php include "../views/footer.php"; ?>

</body> 