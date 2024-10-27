<?php
namespace Controller;
use PDO;
use PDOException;
include __DIR__ . '/../../includes/con.php';

class TasksController
{
    private $con; 

    public function __construct($con)
    {
        $this->con = $con;
        if (!$this->con) {
            throw new Exception("Database connection not established");
        }
    }

    public function view_tasks()
    {
        try {
            $query = "SELECT * FROM tasks";
            $result = $this->con->query($query);
            return json_encode($result->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            return json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function create_task($inputData = null)
    {
        $data = $inputData ?? json_decode(file_get_contents('php://input'), true);        $title = $data['title'] ?? null;
        $completed = isset($data['completed']) && $data['completed'] ? 1 : 0;

        if ($title) {
            try {
                $query = "INSERT INTO tasks(title, completed) VALUES (:title, :completed);";
                $stmt = $this->con->prepare($query);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':completed', $completed, PDO::PARAM_INT);
                $stmt->execute();
                return json_encode(['status' => 'success']);
            } catch (PDOException $e) {
                return json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }

        return json_encode(['status' => 'error', 'message' => 'Title is required']);
    }

    public function update_task($id, $inputData = null)
    {
        $data = $inputData ?? json_decode(file_get_contents('php://input'), true);        $title = $data['title'] ?? null;
        $completed = $data['completed'] ?? null;

        $fields = [];
        if (!empty($title)) {
            $fields[] = "title = :title";
        }

        if ($completed !== null) {
            $fields[] = "completed = :completed";
        }

        if (empty($fields)) {
            return json_encode(['status' => 'error', 'message' => 'No fields to update']);
        }

        $query = "UPDATE tasks SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->con->prepare($query);

        if (!empty($title)) {
            $stmt->bindParam(':title', $title);
        }

        if ($completed !== null) {
            $stmt->bindParam(':completed', $completed, PDO::PARAM_INT);
        }

        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
            return json_encode(['status' => 'success']);
        } catch (PDOException $e) {
            return json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function delete_task($id)
    {
        $query = "DELETE FROM tasks WHERE id = :id;";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
            return json_encode(['status' => 'success']);
        } catch (PDOException $e) {
            return json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
