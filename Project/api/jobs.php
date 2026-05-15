<?php
session_start();

header('Content-Type: application/json');

// Authorization  check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seeker') {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

require_once '../config/database.php';
require_once '../model/job.php';

$jobModel = new Job($conn);

$q           = $_GET['q']           ?? '';
$category_id = $_GET['category_id'] ?? '';
$job_type    = $_GET['job_type']    ?? '';
$location    = $_GET['location']    ?? '';
$salary      = $_GET['salary']      ?? '';

if (!empty($q)) {
    $jobs = $jobModel->searchJobs($q);
} else {
    $jobs = $jobModel->filterJobs($category_id, $location, $job_type, $salary);
}

echo json_encode(['jobs' => $jobs]);