<?php

declare(strict_types=1);
require_once 'Database.php';
require_once 'Category.php';
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



    public function weeksInMonth()
    {
        $firstDay = 1;
        $lastDay = date('t');
        $weeksArray = [];

        while ($firstDay < $lastDay) {
            if ($lastDay < $firstDay + 6) {
                $endWeek = $lastDay - $firstDay;
            } else {
                $endWeek = 6;
            }
            $weeksArray[] = array('first_day' => date('Y-m-') . $firstDay , 'last_day' => date('Y-m-') . ($firstDay + $endWeek));
            $firstDay = $firstDay + 7;

        }

        return $weeksArray;

    }


    public function monthExpenses(){


        $monthExpensesSql = "SELECT *, category.id as id_from_category FROM `expenses`
                     INNER JOIN category ON expenses.category_id = category.id
                     WHERE `expense_date` BETWEEN ". "'" . date('Y-m-'). "1 00:00:00'" . " AND " . "'" . date('Y-m-t'). " 23:59:59'";

        $monthExpenses = $this->query($monthExpensesSql);

        return $monthExpenses;
    }


    public function sumByCategory($id){

        $expenseArray = [];


        $categoryObject = new Category();

        $categories = $categoryObject->categoryData($id);
        $expenses  = $this->monthExpenses();
        $weeks = $this->weeksInMonth();

        foreach ($categories as $category){
            $price = [];
            foreach ($weeks as $week){
                $sum =0;
                foreach ($expenses as $expense){



                    if (strtotime($week['first_day'] . ' 00:00:00') <= strtotime($expense['expense_date']) && strtotime($week['last_day'] . ' 23:59:59')>= strtotime($expense['expense_date'])) {



                        if ($category['category_name'] == $expense['category_name']){


                                $sum = $expense['expense_price'] + $sum;


                        }
                    }

                }
                $price[] = $sum;

            }

            $expenseArray[] = array('category_name' => $category['category_name'], 'category_color'=> $category['category_color'], 'week_expense' => $price);


        }

        return$expenseArray;

//        echo '<pre>';
//            print_r($expenseArray);
//        echo '</pre>';

    }


}
 $y = new Expenses();
$y->sumByCategory(1);

