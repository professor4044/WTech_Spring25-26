<?php
session_start();

header('Content-Type: application/json');

// Authorization check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seeker') {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

require_once '../config/database.php';
require_once '../model/SavedJob.php';

$savedJobModel = new SavedJob($conn);

$data   = json_decode(file_get_contents('php://input'), true);
$job_id = $data['job_id'] ?? '';

if (empty($job_id)) {
    echo json_encode(['error' => 'Job ID missing']);
    exit;
}

$status = $savedJobModel->toggle($_SESSION['user_id'], $job_id);

echo json_encode(['status' => $status]);