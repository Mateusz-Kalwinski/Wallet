<?php
session_name('user');
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 259200);
session_set_cookie_params(259200);
session_start();

    if (!empty($_SESSION['id'])){
        header('Location: index.php');
    }
//    echo password_hash('PoPuP5unixW2', PASSWORD_DEFAULT);
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>Wallet - Panel logowania</title>
        <link rel="icon" href="assets/img/wallet LOGO.png">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


        <link rel="stylesheet" href="assets/css/style.css">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </head>
    <body>
    <div class="login-bg">

    <div class="container-fluid h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <form class="col-lg-4 col-md-6 col-sm-8" action="ajax/login.php" method="post" id="loginForm">
                    <h4 class="text-white text-uppercase" id="addCategoryLabel">Formularz logowania</h4>
                    <div class="form-group">
                        <label for="emailLogin" class="text-white">Email</label>
                        <input type="email" name="emailLogin" class="form-control" id="emailLogin" placeholder="Podaj email">
                    </div>
                    <div class="form-group">
                        <label for="passwordLogin" class="text-white">Hasło</label>
                        <input type="password" name="passwordLogin" class="form-control" id="passwordLogin" placeholder="Podaj hasło">
                    </div>
                    <button type="submit" class="btn btn-primary">Zaloguj</button>
                    <h4 class="text-purple" id="server-results-login"></h4>
                </form>
            </div>
        </div>
    </div>
    </body>
    <script>
        $("#loginForm").submit(function(event){
            event.preventDefault();
            var post_url = $(this).attr("action");
            var request_method = $(this).attr("method");
            var form_data = $(this).serialize();

            $.ajax({
                url : post_url,
                type: request_method,
                data : form_data
            }).done(function(response){
                if (response == 'login'){
                    window.location = 'index.php';
                }else {
                    $("#server-results-login").html(response);
                }

            });
        });
    </script>
</html>


