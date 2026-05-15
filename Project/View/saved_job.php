<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Saved Jobs</title>
    <link rel="stylesheet" href="../Public/CSS/style.css">
    <link rel="stylesheet" href="../Public/CSS/saved_job.css">
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

    <h2 style="margin-bottom:20px;">Saved Jobs</h2>

    <!-- if no saved job -->
    <?php if (empty($savedJobs)): ?>
        <p class="no-jobs">You dont save any job here.</p>

    <?php else: ?>
        <div id="saved-list">
            <?php foreach ($savedJobs as $job):
                $title   = htmlspecialchars($job['title']);
                $company = htmlspecialchars($job['company_name'] ?? 'N/A');
                $location = htmlspecialchars($job['location']);
                $type    = htmlspecialchars($job['job_type']);
                $salary  = htmlspecialchars($job['salary_range']);
                $id      = $job['id'];
            ?>
                <div class="saved-card" id="card-<?= $id ?>">

                    <!-- Job Info -->
                    <div class="saved-info">
                        <h3><?= $title ?></h3>
                        <p class="company"><?= $company ?></p>
                        <p class="meta">
                            <?= $location ?> &nbsp;
                            <?= $type ?> &nbsp;
                            <?= $salary ?>
                        </p>
                    </div>

                    <!-- Buttons -->
                    <div class="saved-actions">
                        <a class="btn-view"
                           href="../Controller/JobController.php?action=show&id=<?= $id ?>">
                            View Details
                        </a>
                        <button class="btn-remove"
                                onclick="removeJob(<?= $id ?>)">
                            Remove
                        </button>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<script src="../Public/JS/saved_job.js"></script>

</body>
</html>