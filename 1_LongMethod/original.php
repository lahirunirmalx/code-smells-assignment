<?php
class User {
    public function createUser($name, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $db = new PDO('mysql:host=localhost;dbname=testdb', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $query->execute([$name, $email, $hashedPassword]);
        echo "User created successfully.";
    }
}
