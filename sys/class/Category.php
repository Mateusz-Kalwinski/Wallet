<?php

declare(strict_types=1);
require_once 'Database.php';

class Category extends Database{

    public function categoryData(){
        $categoryDataSql = "SELECT * FROM `category`";

        $categoryData = $this->query($categoryDataSql);
        return $categoryData;

    }

}