<?php

class Application {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function hasApplied($job_id, $seeker_id) {
        $stmt = $this->pdo->prepare("
            SELECT id FROM applications
            WHERE job_id = ? AND seeker_id = ?
        ");
        $stmt->execute([$job_id, $seeker_id]);

        if ($stmt->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public function apply($job_id, $seeker_id, $cover_letter, $resume_path) {
        $stmt = $this->pdo->prepare("
            INSERT INTO applications 
                (job_id, seeker_id, cover_letter, resume_path, status, created_at)
            VALUES 
                (?, ?, ?, ?, 'Submitted', NOW())
        ");
        return $stmt->execute([$job_id, $seeker_id, $cover_letter, $resume_path]);
    }

    public function getMyApplications($seeker_id) {
        $stmt = $this->pdo->prepare("
            SELECT a.*,
                   j.title AS job_title,
                   j.location,
                   j.job_type,
                   ep.company_name,
                   a.created_at AS applied_at
            FROM applications a
            JOIN jobs j ON a.job_id = j.id
            JOIN employer_profiles ep ON j.employer_id = ep.user_id
            WHERE a.seeker_id = ?
            ORDER BY a.created_at DESC
        ");
        $stmt->execute([$seeker_id]);
        return $stmt->fetchAll();
    }

    public function getSeekerResume($seeker_id) {
        $stmt = $this->pdo->prepare("
            SELECT file_path FROM users
            WHERE id = ?
        ");
        $stmt->execute([$seeker_id]);
        $row = $stmt->fetch();

        if ($row) {
            return $row['file_path'];
        } else {
            return null;
        }
    }
}