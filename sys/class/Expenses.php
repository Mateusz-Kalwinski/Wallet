<?php

declare(strict_types=1);
require_once 'Database.php';

class Expenses extends Database{
    //argument: type: INT, the limit of results

    public function lastExpenses($id, $limit){
        $lastExpensesSql = "SELECT *, category.id as id_from_category FROM `expenses`
                INNER JOIN category ON expenses.category_id = category.id
                WHERE `expenses`.`user_id` = '$id'
                ORDER BY `expense_date` DESC LIMIT $limit";
        $lastExpenses = $this->query($lastExpensesSql);
        return $lastExpenses;
    }

    public function allExpensesMonth($id, $backMonth){

        $month = date('m')-$backMonth;

        $monthStart =  date('Y') .'-'.$month.'-'.'01 00:00:00';
        $monthEnd = date('Y') . '-' . $month . '-' . date('t'). ' 23:59:59';


        $allExpensesMonthSql = "SELECT `expense_price`
                                FROM `expenses`
                                WHERE `expense_date` BETWEEN '$monthStart' AND '$monthEnd' AND `user_id` = '$id';";
        $allExpensesMonth = $this->query($allExpensesMonthSql);
        $sum  = 0;
        foreach ($allExpensesMonth as $price){
            $sum+=$price['expense_price'];
        }
        return $sum;
    }

}

