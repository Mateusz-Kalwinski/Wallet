<?php

session_name('user');
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 259200);
session_set_cookie_params(259200);
session_start();

if (file_exists(dirname(dirname(__FILE__).'/config.php'))) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['expenseCategory'])
            && !empty($_POST['expensePrice'])
            && $_POST['expensePrice'] > 0
            && !empty($_POST['expenseDate'])
            && !empty($_POST['expenseId'])
            && !empty($_POST['expenseTime'])
        ) {



            require_once dirname(dirname(__FILE__)) . '/config.php';

            if (!empty($_POST['expenseName'])){
                $expenseName = $_POST['expenseName'];
            }else{
                $expenseName = '';
            }
            $expenseId = $_POST['expenseId'];
            $expenseCategory = $_POST['expenseCategory'];
            $expensePrice = $_POST['expensePrice'];
            $expenseDate = $_POST['expenseDate'] .' '. $_POST['expenseTime'];

            $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->query('SET NAMES utf8');



            $userId = $_SESSION['id'];

            $editExpenseSql = "UPDATE `expenses`
                               SET `user_id` = '$userId', `category_id` = '$expenseCategory', `expense_price` = '$expensePrice', `expense_name` = '$expenseName', `expense_date` = '$expenseDate'
                               WHERE `id` = '$expenseId'";
            $editExpenseStmt = $conn->prepare($editExpenseSql);
            $editExpenseExec = $editExpenseStmt->execute();

            if ($editExpenseExec === true){

                $arr = ['msg' => 'Edytowano wydatek', 'id' => $expenseId, 'name'=>$expenseName, 'price' => $expensePrice, 'date' =>$expenseDate];


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