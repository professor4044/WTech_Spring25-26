<?php

class Job {
    private $pdo;

    public function __construct($pdo) {
        $this ->pdo = $pdo;
    }
    public function getActiveJobs() {
        $stmt = $this->pdo->prepare("SELECT j.*,
                                            c.name AS category_name,
                                            ep.company_name
                                    FROM jobs j
                                    LEFT JOIN categories c ON j. category_id = c.id
                                    LEFT JOIN employer_profiles ep ON j.employer_id = ep.user_id
                                    WHERE j.status = 'active' 
                                    AND j.deadline >= CURDATE()
                                    ORDER BY j.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getJobById($id) {
        $stmt = $this->pdo->prepare("
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
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function searchJobs($q) {
        $keyword = '%' . $q . '%';
        $stmt = $this->pdo->prepare("
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
        $stmt->execute([$keyword, $keyword, $keyword]);
        return $stmt->fetchAll();
    }

     public function filterJobs($category_id, $location, $job_type, $salary) {
        // Base query
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

        if (!empty($category_id)) {
            $sql .= " AND j.category_id = ?";
            $params[] = $category_id;
        }

        if (!empty($location)) {
            $sql .= " AND j.location LIKE ?";
            $params[] = '%' . $location . '%';
        }

        if (!empty($job_type)) {
            $sql .= " AND j.job_type = ?";
            $params[] = $job_type;
        }

        if (!empty($salary)) {
            $sql .= " AND j.salary_range LIKE ?";
            $params[] = '%' . $salary . '%';
        }

        $sql .= " ORDER BY j.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
     }

    public function getCategories() {
        $stmt = $this->pdo->prepare("
            SELECT * FROM categories ORDER BY name
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

?>