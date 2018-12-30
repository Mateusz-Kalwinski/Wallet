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

        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

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
                    <a class="nav-link js-scroll-trigger link-hover" href="#" data-toggle="modal" data-target="#addExpense">Dodaj wydatek</a>
                </li>
                <li class="nav-item link-margin">
                    <a class="nav-link js-scroll-trigger link-hover" href="#" data-toggle="modal" data-target="#addCategory">Dodaj kategorie</a>
                </li>
                <li class="nav-item link-margin">
                    <a class="nav-link js-scroll-trigger link-hover" href="expenses.php" >Panel Administracyjny</a>
                </li>
                <li class="nav-item link-margin">
                    <a class="nav-link js-scroll-trigger link-hover" href="#" data-toggle="modal" data-target="#account">Konto</a>
                </li>
                <li class="nav-item link-margin">
                    <form class="logout-form" action="ajax/logout.php" method="post">
                        <button type="submit" class="logout-btn nav-link js-scroll-trigger link-hover">Wyloguj</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
