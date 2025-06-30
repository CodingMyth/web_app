//use supperglobal (array=session) to store information


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
                require_once __DIR__ . '/../Views/auth/login.php';
            }
        } else {
            require_once __DIR__ . '/../Views/auth/login.php';
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
            } elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', subject: $this->userModel->username)) {
                $errors[] = "Username must be 3-20 characters and contain only letters, numbers, and underscores";
            }
            if (empty($this->userModel->email)) {
                $errors[] = "Email is required";
            } elseif (!preg_match('/^[\w\.-]+@[\w\.-]+\.\w{2,}$/', subject: $this->userModel->email)) {
                $errors[] = "Invalid email format";
            }
            if (empty($this->userModel->password)) {
                $errors[] = "Password is required";
            } elseif (!preg_match(pattern: '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*()_+\-=\[\]{};\'\\:"|,.<>\/?]{6,}$/', subject: $this->userModel->password)) {
                $errors[] = "Password must be at least 6 characters and contain at least one letter and one number";
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

        
            require_once __DIR__ . '/../Views/auth/register.php';
        } else {
            require_once __DIR__ . '/../Views/auth/register.php';
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