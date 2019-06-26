<!-- File creato inizialmente da Claudio Cicimuurri -->
<!DOCTYPE html>
<html>

<head>
	
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Homepage - Biblidotech</title>

    <!-- Include le librerie comuni -->
    <?php include_once "../php/imports.php";
    // Includi il codice per la paginazione
    include_once "../php/paginazione.php";
    // Includi il codice per la connessione al database
    include '../php/connessione.php'; ?>

    <!-- Carica il css per il catalogo -->
    <link rel="stylesheet" type="text/css" href="../css/catalogo.css">
    
<style type="text/css">
body { height: 100%; width:100%; margin: 0; padding: 0;}
#sfondo {position:fixed; top:0; left:0; width:100%; height:100%; z-index:-1;}
</style>
<!--[if IE ]>
<style type="text/css">
/* css per MIE browsers */
html {overflow-y:hidden;}
body {overflow-y:auto;}
#sfondo {position:absolute; z-index:-1;}
</style>
<![endif]-->
<link rel="stylesheet" href="../css/animate.min.css">
</head>

<body class="wrapper" data-spy="scroll" data-target=".navbar">
    <!-- Imposta la variabile seiNellIndex -->
    <?php $seiNellIndex = true ?>
    <!-- Pagina dell'header importata -->
    <?php include_once "../views/header.php"; ?>
	
	<!--<div class = "fc-page-loader" style = "top: 100%;">
		<div class="fc-spinner">
			<div class="fc-spinner-front"><img src="../php/favicon.ico" alt="Bibliotech"></div>
			<div class="fc-spinner-back"><img src="../php/favicon.ico" alt="Bibliotech"></div>
		</div>
	</div>-->

	
	


    <div>
        <!-- Rettangolo grigio per il titolo della sezione -->
         <div class="jumbotron" style="padding: 2rem 2rem">
            <h1 class="display-4 text-center"><b>Bibliotech</b></h1>
        </div>
	
	

        <!-- Homepage - Vetrina -->
         <div class="container books margin-auto">

<header class="text-white">
<?php
$num = rand(0, 2);
if ($num == 0){

?>
<h1 class="animated bounceInDown" class="text-white">"A robot must protect its own existence as long as such protection does not conflict with the First or Second Laws."</h1>
<h2 class="animated bounceInDown">Isaac Asimov</h2>

<?php
}
else if ($num == 1){


?>
<h1 class="animated bounceInDown" class="text-white">"Ogni lettore, quando legge, legge se stesso."</h1>
<h2 class="animated bounceInDown">Marcel Proust</h2>

<?php
}
else if ($num == 2)
{


?>
<h1 class="animated bounceInDown" class="text-white">"Nessun uomo &egrave; un&rsquo;isola, ogni libro &egrave; un mondo."</h1>
<h2 class="animated bounceInDown">Gabrielle Zevin</h2>
<?php
}
?>
<span class="animated bounce"></span>
</header>

           <!--<p><a href="#" class="text-white">White link</a></p>-->
	
		<div align ="center"><img src = "../pages/images/libro2.jpg" id="sfondo"></div>
	      	<p><br></p>
		<!--<?php
            // Crea la query per ottenere tutti i libri
            $query = 'SELECT Libri.ISBN, Libri.Titolo, Editori.idEditore AS idEditore, Editori.Nome AS "nomeEditore",
                    Generi.Descrizione AS "Genere",
                    Tipologie.Descrizione AS "Tipologia"
                    FROM Libri, Generi, Editori, Tipologie
                    WHERE Libri.idGenere = Generi.idGenere
                    AND Libri.idEditore = Editori.idEditore
                    AND Libri.idTipo = Tipologie.idTipologia
                    ORDER BY Libri.DataAggiunta ASC, Libri.Titolo ASC';

            // Stampa tutti i libri risultati dalla query
            paginazione($query);
            ?>-->

        </div>
    </div> 

    <!-- Pagina del footer importata -->
    <?php include_once "../views/footer.php"; ?>
    <script type="text/javascript" src="../js/cookie.min.js"></script>
</body>
