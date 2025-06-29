<?php
class TaskController {
    private $taskModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->taskModel = new Task($db);
        $this->taskModel->user_id = $_SESSION['user_id'];
    }

    public function index() {
        $stmt = $this->taskModel->read();
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once 'views/tasks/index.php';
    }

    public function filter($priority) {
        if (!in_array($priority, ['low', 'medium', 'high'])) {
            header('Location: /tasks');
            exit;
        }

        $stmt = $this->taskModel->readByPriority($priority);
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once 'views/tasks/index.php';
    }

    public function create() {
        require_once 'views/tasks/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->taskModel->title = $_POST['title'];
            $this->taskModel->description = $_POST['description'];
            $this->taskModel->priority = $_POST['priority'];
            $this->taskModel->due_date = $_POST['due_date'];

            // Validate
            $errors = [];
            if (empty($this->taskModel->title)) {
                $errors[] = "Title is required";
            }
            if (empty($this->taskModel->priority)) {
                $errors[] = "Priority is required";
            }
            if (!empty($this->taskModel->due_date)) {
                $due_date = DateTime::createFromFormat('Y-m-d', $this->taskModel->due_date);
                if (!$due_date) {
                    $errors[] = "Invalid due date format";
                }
            }

            if (empty($errors)) {
                if ($this->taskModel->create()) {
                    $_SESSION['success_message'] = "Task created successfully";
                    header('Location: /tasks');
                    exit;
                } else {
                    $errors[] = "Task creation failed";
                }
            }

            require_once 'views/tasks/create.php';
        } else {
            header('Location: /tasks/create');
            exit;
        }
    }

    public function edit($id) {
        $this->taskModel->id = $id;
        $task = $this->taskModel->readOne();

        if (!$task) {
            header('Location: /tasks');
            exit;
        }

        require_once 'views/tasks/edit.php';
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->taskModel->id = $id;
            $this->taskModel->title = $_POST['title'];
            $this->taskModel->description = $_POST['description'];
            $this->taskModel->priority = $_POST['priority'];
            $this->taskModel->due_date = $_POST['due_date'];
            $this->taskModel->status = $_POST['status'];

            // Validate
            $errors = [];
            if (empty($this->taskModel->title)) {
                $errors[] = "Title is required";
            }
            if (empty($this->taskModel->priority)) {
                $errors[] = "Priority is required";
            }
            if (!empty($this->taskModel->due_date)) {
                $due_date = DateTime::createFromFormat('Y-m-d', $this->taskModel->due_date);
                if (!$due_date) {
                    $errors[] = "Invalid due date format";
                }
            }

            if (empty($errors)) {
                if ($this->taskModel->update()) {
                    $_SESSION['success_message'] = "Task updated successfully";
                    header('Location: /tasks');
                    exit;
                } else {
                    $errors[] = "Task update failed";
                }
            }

            $task = $this->taskModel->readOne();
            require_once 'views/tasks/edit.php';
        } else {
            header('Location: /tasks');
            exit;
        }
    }

    public function delete($id) {
        $this->taskModel->id = $id;
        if ($this->taskModel->delete()) {
            $_SESSION['success_message'] = "Task deleted successfully";
        } else {
            $_SESSION['error_message'] = "Task deletion failed";
        }
        header('Location: /tasks');
        exit;
    }
}
?>