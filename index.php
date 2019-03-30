<!-- File creato inizialmente da Claudio Cicimurri -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Homepage - Bibliotech</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php include "php/imports.php"; ?>
    <link rel="stylesheet" type="text/css" href="css/catalogo.css">
</head>

<body>
    <!-- Pagina dell'header importata -->
    <?php include "php/header.php"; ?>
    
    <!-- Jumbotron -->
    <div class="jumbotron" style="padding: 2rem 2rem">
        <h1 class="display-4 text-center">Vetrina</h1>
    </div>
    <!-- Homepage - Vetrina -->
    <div class="container books">
        <!-- <h3 class="h3 mb-3">Libri in Evidenza</h3> -->
        <div class="row">
            <?php
            $val = '<div class="col-md-3 col-sm-6 book-front">
            
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#">
                                <img src="http://covers.openlibrary.org/b/isbn/9780385533225-L.jpg" />
                            </a>    
                            <ul class="social">
                                <li>
                                    <a href="#" data-tip="Aggiungi">
                                        <i class="fa fa-plus" style="font-size:36px;"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <h3 class="title">Harry Potter e la pietra qualcosa</h3>
                            <span class="hidden-data">
                            Autori<br>
                            Dati
                            </span>
                        </div>
                    </div>
                </div>';

            for ($i = 0; $i < 12; $i++) echo $val;
            ?>
        </div>
    </div>

    <!-- Pagina del footer importata -->
    <?php include "php/footer.php"; ?>

</body> 