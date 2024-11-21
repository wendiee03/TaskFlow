<?php
class Project {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createProject($data) {
        $name = $this->db->escape_string($data['name']);
        $description = $this->db->escape_string($data['description']);
        $status = (int)$data['status'];
        $start_date = $this->db->escape_string($data['start_date']);
        $end_date = $this->db->escape_string($data['end_date']);
        $manager_id = (int)$data['manager_id'];
        $user_ids = $this->db->escape_string($data['user_ids']);

        $sql = "INSERT INTO project_list (name, description, status, start_date, end_date, manager_id, user_ids) 
                VALUES ('$name', '$description', $status, '$start_date', '$end_date', $manager_id, '$user_ids')";
        
        return $this->db->query($sql);
    }

    public function getProject($id) {
        $id = (int)$id;
        $result = $this->db->query("SELECT * FROM project_list WHERE id = $id");
        return $result->fetch_assoc();
    }

    public function getAllProjects($where = "") {
        $sql = "SELECT * FROM project_list $where ORDER BY name ASC";
        return $this->db->query($sql);
    }

    public function updateProject($id, $data) {
        $id = (int)$id;
        $name = $this->db->escape_string($data['name']);
        $description = $this->db->escape_string($data['description']);
        $status = (int)$data['status'];
        $start_date = $this->db->escape_string($data['start_date']);
        $end_date = $this->db->escape_string($data['end_date']);
        $manager_id = (int)$data['manager_id'];
        $user_ids = $this->db->escape_string($data['user_ids']);

        $sql = "UPDATE project_list SET 
                name = '$name',
                description = '$description',
                status = $status,
                start_date = '$start_date',
                end_date = '$end_date',
                manager_id = $manager_id,
                user_ids = '$user_ids'
                WHERE id = $id";

        return $this->db->query($sql);
    }
} 