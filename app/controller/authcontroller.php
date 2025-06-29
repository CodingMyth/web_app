<?php
class AuthController {
    private $userModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->userModel = new User($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!validateCsrfToken($_POST['csrf_token'])) {
            die('Invalid CSRF token');}
            $this->userModel->username = $_POST['username'];
            $this->userModel->password = $_POST['password'];

            if ($this->userModel->login()) {
                $_SESSION['user_id'] = $this->userModel->id;
                $_SESSION['username'] = $this->userModel->username;
                header('Location: /tasks');
                exit;
            } else {
                $error = "Invalid username or password";
                require_once 'views/auth/login.php';
            }
        } else {
            require_once 'views/auth/login.php';
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->userModel->username = $_POST['username'];
            $this->userModel->email = $_POST['email'];
            $this->userModel->password = $_POST['password'];

            // Validate
            $errors = [];
            if (empty($this->userModel->username)) {
                $errors[] = "Username is required";
            }
            if (empty($this->userModel->email)) {
                $errors[] = "Email is required";
            } elseif (!filter_var($this->userModel->email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format";
            }
            if (empty($this->userModel->password)) {
                $errors[] = "Password is required";
            } elseif (strlen($this->userModel->password) < 6) {
                $errors[] = "Password must be at least 6 characters";
            }
            if ($this->userModel->usernameExists()) {
                $errors[] = "Username already taken";
            }
            if ($this->userModel->emailExists()) {
                $errors[] = "Email already registered";
            }

            if (empty($errors)) {
                if ($this->userModel->register()) {
                    $_SESSION['success_message'] = "Registration successful. Please login.";
                    header('Location: /login');
                    exit;
                } else {
                    $errors[] = "Registration failed. Please try again.";
                }
            }

            require_once 'views/auth/register.php';
        } else {
            require_once 'views/auth/register.php';
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: /login');
        exit;
    }
}
?>