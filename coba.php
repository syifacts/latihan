<?php

class UserRegistration
{
    private $koneksi;
    private $username;
    private $password;
    private $err;
    private $message;

    public function __construct($koneksi)
    {
        $this->koneksi = $koneksi;
        $this->username = "";
        $this->password = "";
        $this->err = "";
        $this->message = "";
    }

    public function registerUser($username, $password)
    {
        $this->username = $username;
        $this->password = $password;

        $this->validateInput();
        if (empty($this->err)) {
            $this->checkUsernameAvailability();
            if (empty($this->err)) {
                $this->insertUser();
            }
        }
    }

    private function validateInput()
    {
        // Validation logic for username and password
        // ...

        // Set errors if validation fails
        // $this->err .= "<li>Validation error message</li>";
    }

    private function checkUsernameAvailability()
    {
        // Check if the username is already in the database
        // ...

        // Set error if the username is not available
        // $this->err = "Username sudah digunakan. Silakan gunakan username lain.";
    }

    private function insertUser()
    {
        // Insert user into the database
        // ...

        // Set success message or error message
        // $this->message = "Registrasi berhasil!";
        // $this->err = "Registrasi gagal: " . mysqli_error($this->koneksi);
    }

    public function getErrors()
    {
        return $this->err;
    }

    public function getMessage()
    {
        return $this->message;
    }
}

// Usage example:

include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Register'])) {
    $registration = new UserRegistration($koneksi);
    $registration->registerUser($_POST['username'], $_POST['password']);

    $err = $registration->getErrors();
    $message = $registration->getMessage();
}

?>