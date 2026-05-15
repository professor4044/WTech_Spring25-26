<?php
session_start();

require_once '../config/database.php';
require_once '../model/SavedJob.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seeker') {
    header('Location: ../View/login.php');
    exit;
}

$savedJobModel = new SavedJob($conn);

$savedJobs = $savedJobModel->getSavedJobs($_SESSION['user_id']);

require_once '../View/saved_job.php';