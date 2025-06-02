<?php

class TaskModel
{
    private $db;

    public function __construct()
    {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM tasks ORDER BY id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM tasks WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public function create($data)
    {
        $sql = "INSERT INTO tasks (title, description, status, created_at, updated_at)
                VALUES (:title, :description, :status, NOW(), NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':status' => $data['status']
        ]);

        if ($stmt->rowCount() > 0) {
            $result = $this->getById($this->db->lastInsertId());
            return $result;
        }
    }

    public function update($id, $data)
    {
        $sql = "UPDATE tasks SET title = :title, description = :description, status = :status, updated_at = NOW()
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':status' => $data['status'],
            ':id' => $id
        ]);

        if ($stmt->rowCount() > 0) {
            $result = $this->getById($this->db->lastInsertId());
            return $result;
        }
    }

    public function delete($id)
    {
        $sql = "DELETE FROM tasks WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->rowCount();
            return $result;
        }
    }
}
