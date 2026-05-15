<?php
session_start();

require_once '../config/database.php';
require_once '../models/Application.php';
require_once '../models/Job.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seeker') {
    header('Location: ../views/login.php');
    exit;
}

$appModel = new Application($pdo);
$jobModel = new Job($pdo);

$action = $_GET['action'] ?? 'myApplications';

if ($action === 'apply') {
    $job_id = $_GET['job_id'];
    $job    = $jobModel->getJobById($job_id);

    if (!$job) {
        die('No job found.');
    }

    if ($appModel->hasApplied($job_id, $_SESSION['user_id'])) {
        $_SESSION['error'] = 'You applied this job before.';
        header('Location: ../controllers/JobController.php?action=show&id=' . $job_id);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cover_letter = trim($_POST['cover_letter'] ?? '');
        $errors       = [];

        if (empty($cover_letter)) {
            $errors[] = 'Write the cover letter.';
        }

        $resume_path = '';
        $use_profile = $_POST['use_profile_resume'] ?? '0';

        if ($use_profile === '1') {
            $profile_resume = $appModel->getSeekerResume($_SESSION['user_id']);

            if ($profile_resume) {
                $resume_path = $profile_resume;
            } else {
                $errors[] = 'No resume in profile. Upload a new one.';
            }
        } else {
            if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
                $file  = $_FILES['resume'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime  = finfo_file($finfo, $file['tmp_name']);
                finfo_close($finfo);

                if ($mime !== 'application/pdf') {
                    $errors[] = 'Upload only PDF files.';
                } elseif ($file['size'] > 2 * 1024 * 1024) {
                    $errors[] = 'File size should not over 2 MB';
                } else {
                    $filename    = uniqid('resume_') . '.pdf';
                    $upload_path = '../public/uploads/' . $filename;
                    move_uploaded_file($file['tmp_name'], $upload_path);
                    $resume_path = 'public/uploads/' . $filename;
                }
            } else {
                $errors[] = 'Upload a Resume.';
            }
        }

        if (empty($errors)) {
            $appModel->apply($job_id, $_SESSION['user_id'], $cover_letter, $resume_path);
            $_SESSION['success'] = 'Applied Successfully.';
            header('Location: ../controllers/ApplicationController.php?action=myApplications');
            exit;
        }

        $profile_resume = $appModel->getSeekerResume($_SESSION['user_id']);
        require_once '../views/apply-form.php';

    } else {
        $errors         = [];
        $profile_resume = $appModel->getSeekerResume($_SESSION['user_id']);
        require_once '../views/apply-form.php';
    }

} elseif ($action === 'myApplications') {
    $applications = $appModel->getMyApplications($_SESSION['user_id']);
    require_once '../views/my-applications.php';

} else {
    header('Location: ?action=myApplications');
    exit;
}
?>