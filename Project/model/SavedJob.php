<?php

class SavedJob {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function isSaved($user_id, $job_id) {
        $stmt = $this->conn->prepare("
            SELECT id FROM saved_jobs
            WHERE user_id = ? AND job_id = ?
        ");
        $stmt->bind_param('ii', $user_id, $job_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function toggle($user_id, $job_id) {
        if ($this->isSaved($user_id, $job_id)) {
            $stmt = $this->conn->prepare("
                DELETE FROM saved_jobs
                WHERE user_id = ? AND job_id = ?
            ");
            $stmt->bind_param('ii', $user_id, $job_id);
            $stmt->execute();
            return 'unsaved';
        } else {
            $stmt = $this->conn->prepare("
                INSERT INTO saved_jobs (user_id, job_id, created_at)
                VALUES (?, ?, NOW())
            ");
            $stmt->bind_param('ii', $user_id, $job_id);
            $stmt->execute();
            return 'saved';
        }
    }

    public function getSavedJobs($user_id) {
        $stmt = $this->conn->prepare("
            SELECT j.*,
                   c.name AS category_name,
                   ep.company_name
            FROM saved_jobs sj
            JOIN jobs j ON sj.job_id = j.id
            LEFT JOIN categories c ON j.category_id = c.id
            LEFT JOIN employer_profiles ep ON j.employer_id = ep.user_id
            WHERE sj.user_id = ?
            AND j.status = 'active'
            AND j.deadline >= CURDATE()
            ORDER BY sj.created_at DESC
        ");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSavedJobIds($user_id) {
        $stmt = $this->conn->prepare("
            SELECT job_id FROM saved_jobs
            WHERE user_id = ?
        ");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows   = $result->fetch_all(MYSQLI_ASSOC);

        $ids = [];
        foreach ($rows as $row) {
            $ids[] = $row['job_id'];
        }
        return $ids;
    }
}