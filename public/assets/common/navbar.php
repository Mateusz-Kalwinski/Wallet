<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        
        <title><?=$pageTitle?></title>
        <link rel="icon" href="assets/img/wallet LOGO.png">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <?php

        foreach ($css_files as $css){
            echo '<link rel="stylesheet" type="text/css" href=assets/css/'.$css.'>';
        }
        ?>
    </head>
<body>
<nav class="navbar navbar-expand-lg navbar-light fixed-top nav-shadow" id="mainNav">
    <div class="container-fluid">
        <a class="navbar-brand js-scroll-trigger brand-width" href="#">
            <img src="assets/img/wallet LOGO.png" alt="logo" class="logo-size">
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto links-margin">
                <li class="nav-item link-margin">
                    <a class="nav-link js-scroll-trigger link-hover" href="#design">Dodaj wydatek</a>
                </li>
                <li class="nav-item link-margin">
                    <a class="nav-link js-scroll-trigger link-hover" href="#features">Dodaj kategorie</a>
                </li>
                <li class="nav-item link-margin">
                    <a class="nav-link js-scroll-trigger link-hover" href="#responsive">Konto</a>
                </li>
                <li class="nav-item link-margin">
                    <a class="nav-link js-scroll-trigger link-hover" href="#clients">Wyloguj</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
