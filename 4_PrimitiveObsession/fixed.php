<?php
class User {
    private $name;
    private $email;


    public function __construct($name, Email $email) {

        $this->name = $name;
        $this->email = $email->getEmail();
    }
}

class Email{
    private $email;

    /**
     * @return mixed
     */
    public function __construct($email)
    {
        $this->setEmail($email);
    }
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email address");
        }
        $this->email = $email;
    }

}