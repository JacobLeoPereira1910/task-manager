<?php
// TaskController.class.php

require_once './model/TaskModel.class.php';

class TaskController {
    private $model;

    public function __construct() {
        $this->model = new TaskModel();
    }

    public function getAll() {
        try {
            $tasks = $this->model->getAll();
            return ['success' => true, 'data' => $tasks];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function get($id) {
        if (!is_numeric($id)) return ['success' => false, 'error' => 'Invalid ID'];
        try {
            $task = $this->model->getById($id);
            return ['success' => true, 'data' => $task];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function create($data) {
        if (empty($data['title']) || empty($data['status'])) {
            return ['success' => false, 'error' => 'Missing required fields'];
        }
        try {
            $id = $this->model->create($data);
            return ['success' => true, 'id' => $id];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function update($id, $data) {
        if (!is_numeric($id)) return ['success' => false, 'error' => 'Invalid ID'];
        try {
            $updated = $this->model->update($id, $data);
            return ['success' => true, 'updated' => $updated];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function delete($id) {
        if (!is_numeric($id)) return ['success' => false, 'error' => 'Invalid ID'];
        try {
            $deleted = $this->model->delete($id);
            return ['success' => true, 'deleted' => $deleted];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
