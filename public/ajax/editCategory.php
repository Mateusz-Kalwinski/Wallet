<?php

session_name('user');
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 259200);
session_set_cookie_params(259200);
session_start();

if (file_exists(dirname(dirname(__FILE__).'/config.php'))) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['categoryID'])
            && !empty($_POST['categoryName'])
            && !empty($_POST['categoryColor'])
        ) {



            require_once dirname(dirname(__FILE__)) . '/config.php';


            $categoryID = $_POST['categoryID'];
            $categoryName = $_POST['categoryName'];
            $categoryColor = $_POST['categoryColor'];

            $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->query('SET NAMES utf8');



            $userId = $_SESSION['id'];

            $editExpenseSql = "UPDATE `category`
                               SET `user_id` = '$userId', `category_name` = '$categoryName', `category_color` = '$categoryColor'
                               WHERE `id` = '$categoryID'";
            $editExpenseStmt = $conn->prepare($editExpenseSql);
            $editExpenseExec = $editExpenseStmt->execute();

            if ($editExpenseExec === true){

                $arr = ['msg' => 'Edytowano kategorie', 'id' => $categoryID, 'name'=>$categoryName, 'color' => $categoryColor];


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