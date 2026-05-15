<?php
session_start();

require_once '../config/database.php';
require_once '../models/SavedJob.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seeker') {
    header('Location: ../views/login.php');
    exit;
}

$savedJobModel = new SavedJob($pdo);

$savedJobs = $savedJobModel->getSavedJobs($_SESSION['user_id']);

require_once '../views/saved-jobs.php';