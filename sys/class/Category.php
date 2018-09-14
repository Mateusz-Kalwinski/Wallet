<?php

declare(strict_types=1);
require_once 'Database.php';

class Category extends Database{

    public function categoryData($id){
        $categoryDataSql = "SELECT * FROM `category`
                            WHERE `user_id` = '$id'";

        $categoryData = $this->query($categoryDataSql);
        return $categoryData;

    }

}