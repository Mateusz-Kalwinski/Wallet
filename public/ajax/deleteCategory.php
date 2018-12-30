<?php

session_name('user');
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 259200);
session_set_cookie_params(259200);
session_start();

if (file_exists(dirname(dirname(__FILE__).'/config.php'))) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['categoryID'])) {



            require_once dirname(dirname(__FILE__)) . '/config.php';

            $categoryID = $_POST['categoryID'];


            $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->query('SET NAMES utf8');



            $userId = $_SESSION['id'];

            $deleteExpenseSql = "DELETE FROM `category` WHERE `id` = $categoryID";

            $deleteExpenseStmt = $conn->prepare($deleteExpenseSql);
            $deleteExpenseExec = $deleteExpenseStmt->execute();

            if ($deleteExpenseExec === true){

                $arr = ['id' => $categoryID];


                echo json_encode($arr);

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