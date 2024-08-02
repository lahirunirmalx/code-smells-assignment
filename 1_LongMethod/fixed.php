<?php
class User {
    public function createUser($name, $email, $password) {
        $params = array($name, $email,  password_hash($password, PASSWORD_BCRYPT));
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        echo $this->executeSql($sql , $params) ? "User created successfully." : "";

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
     * @param string $sql
     * @param array $params
     * @return boolean
     */
    public function executeSql(string $sql , array $params)
    {
        $db = $this->getPDO();
        $query = $db->prepare($sql);
        return $query->execute($params);
    }
}
