<?php
require_once './model/TaskModel.class.php';

class TaskController
{
    private $model;

    public function __construct()
    {
        $this->model = new TaskModel();
    }

    public function getAll()
    {
        try {
            $itens = $this->model->getAll();
            return ['response' => true, 'data' => $itens];
        } catch (Exception $e) {
            return ['response' => false, 'error' => $e->getMessage()];
        }
    }

    public function get($id)
    {
        if (!isset($id)) {
            throw new Exception("ID não fornecido");
        }
        try {
            $itens = $this->model->getById($id);
            return ['response' => true, 'data' => $itens];
        } catch (Exception $e) {
            return ['response' => false, 'error' => $e->getMessage()];
        }
    }

    public function create($data)
    {
        if (empty($data['title']) || empty($data['description']) || empty($data['status'])) {
            return ['response' => false, 'error' => 'Campos não fornecidos'];
        }
        try {
            $itens = $this->model->create($data);
            return ['response' => true, 'data' => $itens];
        } catch (Exception $e) {
            return ['response' => false, 'error' => $e->getMessage()];
        }
    }

    public function update($id, $data)
    {
        if (!isset($id)) {
            throw new Exception("ID não fornecido");
        }

        if (empty($data['title']) || empty($data['description']) || empty($data['status'])) {
            return ['response' => false, 'error' => 'Campos não fornecidos'];
        }
        try {
            $updated = $this->model->update($id, $data);
            return ['response' => true, 'updated' => $updated];
        } catch (Exception $e) {
            return ['response' => false, 'error' => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        if (!isset($id)) {
            throw new Exception("ID não fornecido");
        }
        try {
            $itens = $this->model->delete($id);
            return ['response' => true, 'data' => $itens];
        } catch (Exception $e) {
            return ['response' => false, 'error' => $e->getMessage()];
        }
    }
}
