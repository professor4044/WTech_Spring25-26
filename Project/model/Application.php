<?php

class Application {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function hasApplied($job_id, $seeker_id) {
        $stmt = $this->conn->prepare("
            SELECT id FROM applications
            WHERE job_id = ? AND seeker_id = ?
        ");
        $stmt->bind_param('ii', $job_id, $seeker_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function apply($job_id, $seeker_id, $cover_letter, $resume_path) {
        $stmt = $this->conn->prepare("
            INSERT INTO applications
                (job_id, seeker_id, cover_letter, resume_path, status, created_at)
            VALUES
                (?, ?, ?, ?, 'Submitted', NOW())
        ");
        $stmt->bind_param('iiss', $job_id, $seeker_id, $cover_letter, $resume_path);
        return $stmt->execute();
    }

    public function getMyApplications($seeker_id) {
        $stmt = $this->conn->prepare("
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
        $stmt->bind_param('i', $seeker_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSeekerResume($seeker_id) {
        $stmt = $this->conn->prepare("
            SELECT file_path FROM users
            WHERE id = ?
        ");
        $stmt->bind_param('i', $seeker_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row    = $result->fetch_assoc();

        if ($row) {
            return $row['file_path'];
        } else {
            return null;
        }
    }
}