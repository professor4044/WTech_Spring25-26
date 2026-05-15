<?php
session_start();

require_once '../config/database.php';
require_once '../model/job.php';
require_once '../model/SavedJob.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seeker') {
    header('Location: ../View/login.php');
    exit;
}

$jobModel      = new Job($conn);
$savedJobModel = new SavedJob($conn);

$action = $_GET['action'] ?? 'index';

if ($action === 'index') {
    $jobs       = $jobModel->getActiveJobs();
    $categories = $jobModel->getCategories();
    $savedIds   = $savedJobModel->getSavedJobIds($_SESSION['user_id']);

    require_once '../View/job_board.php';
}

elseif ($action==='show') {
    $job_id = $_GET['id'];
    $job    = $jobModel->getJobById($job_id);

    if (!$job) {
        die ('No job found.');
    }

    require_once '../model/Application.php';
    $appModel = new Application($conn);

    $hasApplied = $appModel->hasApplied($job_id, $_SESSION['user_id']);

    $isSaved = $savedJobModel->isSaved($_SESSION['user_id'], $job_id);

    require_once '../View/job_detail.php';
}
else{
    header('Location: ?action=index');
    exit;
}
?>

