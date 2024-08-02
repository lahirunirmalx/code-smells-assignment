<?php
class User {
    private $name;
    private $email;


    public function __construct($name, $email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email address");
        }
        $this->name = $name;
        $this->email = $email;
    }
}
