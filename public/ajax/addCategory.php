<?php

session_name('user');
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 259200);
session_set_cookie_params(259200);
session_start();

if (file_exists(dirname(dirname(__FILE__).'/config.php'))) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['categoryName'])) {

            require_once dirname(dirname(__FILE__)) . '/config.php';

            $categoryName = $_POST['categoryName'];


            $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->query('SET NAMES utf8');

            $userId = $_SESSION['id'];

            $addExpenseSql = "INSERT INTO `category` (`user_id`, `category_name`)
                              VALUES ('$userId', '$categoryName')";
            $addExpenseStmt = $conn->prepare($addExpenseSql);
            $addExpenseExec = $addExpenseStmt->execute();

            if ($addExpenseExec === true){
                echo 'Kategoria dodana.';
            }else{
                echo 'Ups! coś poszło nie tak.';
            }
        }else{
            echo 'Ups! coś poszło nie tak.';
        }
    }
}else{
    echo 'Ups! coś poszło nie tak.';
}