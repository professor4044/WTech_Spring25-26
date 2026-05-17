<?php

class Job {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getActiveJobs() {
        $sql  = "
            SELECT j.*, 
                   c.name AS category_name,
                   ep.company_name
            FROM jobs j
            LEFT JOIN categories c ON j.category_id = c.id
            LEFT JOIN employer_profiles ep ON j.employer_id = ep.user_id
            WHERE j.status = 'active'
            AND j.deadline >= CURDATE()
            ORDER BY j.created_at DESC
        ";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getJobById($id) {
        $stmt = $this->conn->prepare("
            SELECT j.*, 
                   c.name AS category_name,
                   ep.company_name,
                   ep.industry,
                   ep.description AS company_description,
                   ep.website
            FROM jobs j
            LEFT JOIN categories c ON j.category_id = c.id
            LEFT JOIN employer_profiles ep ON j.employer_id = ep.user_id
            WHERE j.id = ?
        ");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function searchJobs($q) {
        $keyword = '%' . $q . '%';
        $stmt    = $this->conn->prepare("
            SELECT j.*, 
                   c.name AS category_name,
                   ep.company_name
            FROM jobs j
            LEFT JOIN categories c ON j.category_id = c.id
            LEFT JOIN employer_profiles ep ON j.employer_id = ep.user_id
            WHERE j.status = 'active'
            AND j.deadline >= CURDATE()
            AND (
                j.title LIKE ? OR
                j.description LIKE ? OR
                ep.company_name LIKE ?
            )
            ORDER BY j.created_at DESC
        ");
        $stmt->bind_param('sss', $keyword, $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function filterJobs($q, $category_id, $location, $job_type, $salary) {
    $sql = "
        SELECT j.*, 
               c.name AS category_name,
               ep.company_name
        FROM jobs j
        LEFT JOIN categories c ON j.category_id = c.id
        LEFT JOIN employer_profiles ep ON j.employer_id = ep.user_id
        WHERE j.status = 'active'
        AND j.deadline >= CURDATE()
    ";
    $params = [];
    $types  = '';

    if (!empty($q)) {
        $keyword  = '%' . $q . '%';
        $sql     .= " AND (j.title LIKE ? OR j.description LIKE ? OR ep.company_name LIKE ?)";
        $types   .= 'sss';
        $params[] = $keyword;
        $params[] = $keyword;
        $params[] = $keyword;
    }

    if (!empty($category_id)) {
        $sql     .= " AND j.category_id = ?";
        $types   .= 'i';
        $params[] = $category_id;
    }

    if (!empty($location)) {
        $sql     .= " AND j.location LIKE ?";
        $types   .= 's';
        $params[] = '%' . $location . '%';
    }

    if (!empty($job_type)) {
        $sql     .= " AND j.job_type = ?";
        $types   .= 's';
        $params[] = $job_type;
    }

    if (!empty($salary)) {
        $sql     .= " AND j.salary_range LIKE ?";
        $types   .= 's';
        $params[] = '%' . $salary . '%';
    }

    $sql .= " ORDER BY j.created_at DESC";

    $stmt = $this->conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

    public function getCategories() {
        $result = $this->conn->query("SELECT * FROM categories ORDER BY name");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}