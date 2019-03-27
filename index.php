<!-- File creato inizialmente da Claudio Cicimurri -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Homepage - Bibliotech</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php include "php/imports.php"; ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="css/catalogo.css">
</head>

<body>
    <!-- Pagina dell'header importata -->
    <?php include "php/header.php"; ?>
    <!-- Homepage - Vetrina -->
    <div class="container">
        <h3 class="h3">Libri in Evidenza</h3>
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="product-grid">
                    <div class="product-image">
                        <a href="#">
                            <img class="pic-1" src="https://imgc.allpostersimages.com/img/print/u-g-F8PQ9I0.jpg?w=550&h=550&p=0">
                        </a>
                        <ul class="social">
                            <li><a href="" data-tip="Occhiata Veloce"><i class="fa fa-search" style="font-size:36px"></i></a></li>
                            <li><a href="" data-tip="Aggiungi a Lista Desideri"><i class="fa fa-shopping-bag " style="font-size:36px"></i></a></li>
                            <li><a href="" data-tip="Aggiungi al Carrello"><i class="fa fa-shopping-cart" style="font-size:36px"></i></a></li>
                        </ul>
                    </div>
                    <ul class="rating">
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star disable"></li>
                    </ul>
                    <div class="product-content">
                        <h3 class="title"><a href="#">Libro Harry Potter</a></h3>
                        <a class="add-to-cart" href="">Aggiungi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagina del footer importata -->
    <?php include "php/footer.php"; ?>

</body> 