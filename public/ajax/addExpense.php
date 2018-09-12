<?php

session_name('user');
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 259200);
session_set_cookie_params(259200);
session_start();

if (file_exists(dirname(dirname(__FILE__).'/config.php'))) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['expenseCategory']) && !empty($_POST['expensePrice']) && $_POST['expensePrice'] > 0 && !empty($_POST['expenseDate'])) {

            require_once dirname(dirname(__FILE__)) . '/config.php';

            if (!empty($_POST['expenseName'])){
                $expenseName = $_POST['expenseName'];
            }else{
                $expenseName = '';
            }
            $expenseCategory = $_POST['expenseCategory'];
            $expensePrice = $_POST['expensePrice'];
            $expenseDate = $_POST['expenseDate'] .' '. date('H:i:s');

            $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->query('SET NAMES utf8');

            $userId = $_SESSION['id'];

            $addExpenseSql = "INSERT INTO `expenses` (`user_id`, `category_id`,`expense_price`, `expense_name`, `expense_date`)
                              VALUES ('$userId','$expenseCategory','$expensePrice', '$expenseName', '$expenseDate')";
            $addExpenseStmt = $conn->prepare($addExpenseSql);
            $addExpenseExec = $addExpenseStmt->execute();

            if ($addExpenseExec === true){
                echo 'Wydatek dodany.';
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