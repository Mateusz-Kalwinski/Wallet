<?php

declare(strict_types=1);
require_once 'Database.php';

class User extends Database{

    public function userData($id){
        $userDataSql = "SELECT `name`, `email`, `budget`, `budget_start`
                        FROM `user`
                        WHERE `id` = $id";

        $userData = $this->query($userDataSql);
        return $userData;

    }

}