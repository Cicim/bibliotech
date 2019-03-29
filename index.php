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
    <!-- Homepage - Vetrina -->
    <div class="container books">
        <h3 class="h3 mb-3">Libri in Evidenza</h3>
        <div class="row">
            <?php
            $val = '<div class="col-md-3 col-sm-6 book-front">
            
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#">
                                <img src="http://covers.openlibrary.org/b/isbn/9780385533225-S.jpg" />
                            </a>    
                            <ul class="social">
                                <li>
                                    <a href="#" data-tip="Aggiungi">
                                        <i class="fa fa-plus" style="font-size:36px"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#">Harry Potter e la pietra qualcosa</a></h3>
                            <div class="hidden-data">
                            Titolo<br>
                            Dato
                            </div>
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