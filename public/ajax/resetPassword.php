<?php

session_name('user');
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 259200);
session_set_cookie_params(259200);
session_start();

if (file_exists(dirname(dirname(__FILE__).'/config.php'))) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['emailAddress']) && !empty($_POST['curentPassword']) && !empty($_POST['newPassword'])){
            $email = $_POST['emailAddress'];
            $curentPassword = $_POST['curentPassword'];
            $newPassword =  password_hash($_POST['newPassword'], PASSWORD_DEFAULT);

            require_once dirname(dirname(__FILE__)) . '/config.php';

            $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->query('SET NAMES utf8');

            $userId = $_SESSION['id'];

            $verificationSql = "SELECT `email`, `password` FROM `user` WHERE `id` = '$userId'";
            $verificationStmt = $conn->prepare($verificationSql);
            $verificationExec = $verificationStmt->execute();
            $verificationResult  = $verificationStmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($verificationExec)){

                $passwordFromDatabase = $verificationResult[0]['password'];
                $emailFromDatabase = $verificationResult[0]['email'];

                if (password_verify($curentPassword, $passwordFromDatabase) && $email == $emailFromDatabase) {
                    $updatePasswordSql = "UPDATE `user` SET `password` = '$newPassword' WHERE `email` = '$email'";
                    $updatePasswordStmt = $conn->prepare($updatePasswordSql);
                    $updatePasswordExec = $updatePasswordStmt->execute();
                    echo 'Twoje hasło zostało zmienione.';
                }else {
                    echo 'Ups! coś poszło nie tak.';
                }
            }else{
                echo 'Ups! coś poszło nie tak.';
            }
        }else {
            echo 'Ups! coś poszło nie tak.';
        }

    }else{
        echo 'Ups! coś poszło nie tak.';
    }

}else{
    echo 'Ups! coś poszło nie tak.';
}