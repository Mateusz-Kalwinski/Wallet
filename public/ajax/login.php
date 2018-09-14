<?php

if (file_exists(dirname(dirname(__FILE__).'/config.php'))) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['emailLogin']) && !empty($_POST['passwordLogin'])) {

            require_once dirname(dirname(__FILE__)) . '/config.php';

            $emailLogin = $_POST['emailLogin'];
            $passwordLogin = $_POST['passwordLogin'];

            $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->query('SET NAMES utf8');



            $verificationSql = "SELECT `id`, `email`, `password` FROM `user` WHERE `email` = '$emailLogin'";
            $verificationStmt = $conn->prepare($verificationSql);
            $verificationExec = $verificationStmt->execute();
            $verificationResult = $verificationStmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($verificationResult[0]['password']) && !empty($verificationResult[0]['email'])) {

                if (password_verify($passwordLogin, $verificationResult[0]['password']) && $emailLogin == $verificationResult[0]['email']) {
                    session_name('user');
                    ini_set('session.gc_probability', 1);
                    ini_set('session.gc_divisor', 100);
                    ini_set('session.gc_maxlifetime', 259200);
                    session_set_cookie_params(259200);
                    session_start();

                    $_SESSION['id'] = $verificationResult[0]['id'];
                    header('Location: ../');

                } else {
                    echo 'Podano niewłaściwy login lub hasło.';
                }
            } else {
                echo 'Podano niewłaściwy login lub hasło.';
            }
        } else {
            echo 'Ups! coś poszło nie tak.';
        }
    } else {
        echo 'Ups! coś poszło nie tak.';
    }
}else{
    echo 'Ups! coś poszło nie tak.';
}
