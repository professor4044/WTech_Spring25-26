<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Detail</title>
    <link rel="stylesheet" href="../Public/CSS/style.css">
    <link rel="stylesheet" href="../Public/CSS/job_detail.css">
</head>
<body>

<nav>
    <span class="brand">JobPortal</span>
    <div>
        <a href="../Controller/JobController.php?action=index">Job Board</a>
        <a href="../Controller/ApplicationController.php?action=myApplications">My Applications</a>
        <a href="../Controller/SavedJobController.php">Saved Jobs</a>
        <a href="../View/logout.php">Logout</a>
    </div>
</nav>

<div class="container">

    <!-- Back Button -->
    <a href="../Controller/JobController.php?action=index" style="display:inline-block; margin-bottom:20px; color:#2980b9;">
        Back to Job Board
    </a>

    <div class="detail-card">

        <!-- Job Title -->
        <h1><?php echo htmlspecialchars($job['title']) ?></h1>

        <!-- Company Name -->
        <p class="company-name"><?php echo htmlspecialchars($job['company_name'] ?? 'N/A') ?></p>

         <!-- Job Meta Info -->
        <div class="meta-box">
            <span> <?php echo htmlspecialchars($job['location']) ?></span>
            <span> <?php echo htmlspecialchars($job['job_type']) ?></span>
            <span> <?php echo htmlspecialchars($job['salary_range']) ?></span>
            <span> <?php echo htmlspecialchars($job['category_name'] ?? '') ?></span>
        </div>

        <!-- Deadline -->
        <p class="deadline"> Deadline: <?php echo htmlspecialchars($job['deadline']) ?></p>

        <!-- Company Info -->
        <div class="section">
            <h3>About Company</h3>
            <p><?php echo htmlspecialchars($job['company_description'] ?? 'No description available.') ?></p>
            <?php if (!empty($job['website'])): ?>
                <a href="<?php echo htmlspecialchars($job['website']) ?>" target="_blank">
                    <?php echo htmlspecialchars($job['website']) ?>
                </a>
            <?php endif; ?>
        </div>

         <!-- Job Description -->
        <div class="section">
            <h3>Job Description</h3>
            <p><?php echo htmlspecialchars($job['description']) ?></p>
        </div>

        <!-- Requirements -->
        <div class="section">
            <h3>Requirements</h3>
            <p><?php echo htmlspecialchars($job['requirements']) ?></p>
        </div>

         <!-- Action Buttons -->
        <div class="actions">

        <!--check applied-->
         <?php if ($hasApplied): ?>
                <button class="btn-applied" disabled>Applied </button>
            <?php else: ?>
                <a class="btn-apply"
                   href="../Controller/ApplicationController.php?action=apply&job_id=<?= $job['id'] ?>">
                    Apply Now
                </a>
            <?php endif; ?>

            <!-- Save/Unsave button -->
            <button id="save-btn"
                    class="heart-btn <?= $isSaved ? 'saved' : '' ?>"
                    onclick="toggleSave(<?= $job['id'] ?>)">
                <?php echo $isSaved ? 'Saved' : 'Save Job' ?>
            </button>
        </div>
    </div>
</div>

<script src="../Public/JS/job_detail.js"></script>


    
</body>
</html>