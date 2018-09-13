<?php

session_name('user');
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 259200);
session_set_cookie_params(259200);
session_start();


if (file_exists(dirname(dirname(__FILE__).'/config.php'))) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['overwriteBudget']) OR isset($_POST['addToBudget']) && !empty($_POST['OverallBudget']) && $_POST['OverallBudget'] > 0) {

            require_once dirname(dirname(__FILE__)) . '/config.php';

            $OverallBudget = $_POST['OverallBudget'];

            $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->query('SET NAMES utf8');

            $userId = $_SESSION['id'];

            if (isset($_POST['overwriteBudget']) && $_POST['overwriteBudget'] == 'overwriteBudget'){

                $updateValue = $OverallBudget;

            } elseif (isset($_POST['addToBudget']) && $_POST['addToBudget'] == 'addToBudget'){

                $addToBudget = $_POST['addToBudget'];

                $selectBudgetSql = "SELECT `budget_start` FROM `user` WHERE `id` = '$userId'";
                $selectBudgetStmt = $conn->prepare($selectBudgetSql);
                $selectBudgetExec = $selectBudgetStmt->execute();
                $selectBudgetResult  = $selectBudgetStmt->fetchAll(PDO::FETCH_ASSOC);


                $startBudget = $selectBudgetResult[0]['budget_start'];

                $updateValue = $startBudget + $OverallBudget;

            }else{
                echo 'Ups! coś poszło nie tak.';
                exit();
            }
            $updateSql = "UPDATE `user` SET `budget_start` = '$updateValue' WHERE `id` = '$userId'";
            $updateStmt = $conn->prepare($updateSql);
            $updateExec = $updateStmt->execute();
            echo 'Twój budżet został zapisany';

        }else{
            echo 'Ups! coś poszło nie tak.';
        }
    }
}else{
    echo 'Ups! coś poszło nie tak.';
}