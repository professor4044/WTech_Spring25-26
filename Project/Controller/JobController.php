<?php
session_start();

require_once '../config/database.php';
require_once '../models/Job.php';
require_once '../models/SavedJob.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seeker') {
    header('Location: ../views/login.php');
    exit;
}

$jobModel      = new Job($pdo);
$savedJobModel = new SavedJob($pdo);

$action = $_GET['action'] ?? 'index';

if ($action === 'index') {
    $jobs       = $jobModel->getActiveJobs();
    $categories = $jobModel->getCategories();
    $savedIds   = $savedJobModel->getSavedJobIds($_SESSION['user_id']);

    require_once '../views/job-board.php';
}

elseif ($action==='show') {
    $job_id = $_GET['id'];
    $job    = $jobModel->getJobById($job_id);

    if (!$job) {
        die ('No job found.');
    }

    require_once '../models/Application.php';
    $appModel = new Application($pdo);

    $hasApplied = $appModel->hasApplied($job_id, $_SESSION['user_id']);

    $isSaved = $savedJobModel->isSaved($_SESSION['user_id'], $job_id);

    require_once '../views/job-detail.php';
}
else{
    header('Location: ?action=index');
    exit;
}
?>

