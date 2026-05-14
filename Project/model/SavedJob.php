<?php

class SavedJob {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function isSaved($user_id, $job_id) {
        $stmt = $this->pdo->prepare("
            SELECT id FROM saved_jobs
            WHERE user_id = ? AND job_id = ?
        ");
        $stmt->execute([$user_id, $job_id]);

        if ($stmt->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public function toggle($user_id, $job_id) {
        if ($this->isSaved($user_id, $job_id)) {
            $stmt = $this->pdo->prepare("
                DELETE FROM saved_jobs
                WHERE user_id = ? AND job_id = ?
            ");
            $stmt->execute([$user_id, $job_id]);
            return 'unsaved';
        } else {
            $stmt = $this->pdo->prepare("
                INSERT INTO saved_jobs (user_id, job_id, created_at)
                VALUES (?, ?, NOW())
            ");
            $stmt->execute([$user_id, $job_id]);
            return 'saved';
        }
    }

    public function getSavedJobs($user_id) {
        $stmt = $this->pdo->prepare("
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
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }

    public function getSavedJobIds($user_id) {
        $stmt = $this->pdo->prepare("
            SELECT job_id FROM saved_jobs
            WHERE user_id = ?
        ");
        $stmt->execute([$user_id]);
        $rows = $stmt->fetchAll();

        $ids = [];
        foreach ($rows as $row) {
            $ids[] = $row['job_id'];
        }
        return $ids;
    }
}