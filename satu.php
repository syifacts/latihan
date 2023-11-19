<?php
include("connect.php");

class UserRegistration {
    private $username;
    private $password;
    private $err;
    private $message;
    private $koneksi;

    public function __construct($koneksi) {
        $this->koneksi = $koneksi;
        $this->username = "";
        $this->password = "";
        $this->err = "";
        $this->message = "";
    }

    public function registerUser() {
        if (isset($_POST['Register'])) {
            $this->username = $_POST['username'];
            $this->password = $_POST['password'];

            if ($this->username == '' or $this->password == '') {
                $this->err .= "<li>Silakan masukkan username dan password</li>";
            }

            if (empty($this->err)) {
                $sql1 = "SELECT * FROM user WHERE username = '$this->username'";
                $q1 = mysqli_query($this->koneksi, $sql1);
                $r1 = mysqli_fetch_array($q1);

                if (!$r1) {
                    $hashedPassword = md5($this->password);

                    $query = "INSERT INTO user (username, password) VALUES ('$this->username', '$hashedPassword')";

                    if (mysqli_query($this->koneksi, $query)) {
                        $this->message = "Registrasi berhasil!";
                    } else {
                        $this->err = "Registrasi gagal: " . mysqli_error($this->koneksi);
                    }
                } else {
                    $this->err = "Username sudah digunakan. Silakan gunakan username lain.";
                }
            }
        }
    }

    public function displayForm() {
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Register - Smart AC</title>
            <link rel='stylesheet' href='css/bootstrap.min.css'>
            <link rel='stylesheet' href='css/style.css'>
            <link rel='shortcut icon' href='img/ac.png' type='image/x-icon'>
        </head>
        <body>
            <div class='container-fluid mt-5'>
                <div class='container bg-light rounded-4 p-4'>
                <h3>Tambah user admin</h3>";

        if ($this->err) {
            echo "<ul>$this->err</ul>";
        }

        if ($this->message) {
            echo "<div class='alert alert-success'>$this->message</div>";
        }

        echo "
                <form method='post'>
                    <div class='mb-3'>
                        <label for='username' class='form-label'>Username</label>
                        <input type='text' name='username' value='{$this->username}' class='form-control' placeholder='Masukkan Username'>
                    </div>
                    <div class='mb-3'>
                        <label for='password' class='form-label'>Password</label>
                        <input type='password' name='password' class='form-control' placeholder='Masukkan Password'>
                    </div>
                    <p>Back to <a href='data.php'>admin page</a></p>
                    <button type='submit' class='btn btn-primary' name='Register'>Daftar</button>
                </form>
                </div>
            </div>

            <div class='container-fluid mt-5 text-center'>
                <div class='row'>
                    <div class='col-md'>
                        <a href='registrasi.php'><img src='img/logo-smart.png' alt='Logo Smart AC' width='300px' class='pt-3'></a>
                    </div>
                </div>
            </div>";

        include("login_footer.php");

        echo "
        </body>
        </html>";
    }
}

$userRegistration = new UserRegistration($koneksi);
$userRegistration->registerUser();
$userRegistration->displayForm();
?>
