<?php

class User
{
    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $params = array ($id);
        return $this->executeQuery($sql , $params);
    }


    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $params = array ($email);
        return $this->executeQuery($sql , $params);
    }

    /**
     * @return PDO
     */
    public function getPDO(): PDO
    {
        $db = new PDO('mysql:host=localhost;dbname=testdb' , 'root' , '');
        $db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
        return $db;
    }

    /**
     * @param $sql
     * @param array $params
     * @return mixed
     */
    public function executeQuery($sql , array $params = null)
    {
        $query = $this->getPDO()->prepare($sql);
        $query->execute($params);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
