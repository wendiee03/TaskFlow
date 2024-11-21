<?php
class Task {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createTask($data) {
        $project_id = (int)$data['project_id'];
        $task = $this->db->escape_string($data['task']);
        $description = $this->db->escape_string($data['description']);
        $status = (int)$data['status'];

        $sql = "INSERT INTO task_list (project_id, task, description, status, date_created) 
                VALUES ($project_id, '$task', '$description', $status, NOW())";
        
        return $this->db->query($sql);
    }

    public function getProjectTasks($project_id) {
        $project_id = (int)$project_id;
        $sql = "SELECT * FROM task_list WHERE project_id = $project_id ORDER BY task ASC";
        return $this->db->query($sql);
    }

    public function updateTask($id, $data) {
        $id = (int)$id;
        $task = $this->db->escape_string($data['task']);
        $description = $this->db->escape_string($data['description']);
        $status = (int)$data['status'];

        $sql = "UPDATE task_list SET 
                task = '$task',
                description = '$description',
                status = $status
                WHERE id = $id";

        return $this->db->query($sql);
    }
} 