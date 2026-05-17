<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Board</title>
    <link rel="stylesheet" href="../Public/CSS/style.css">
</head>
<body>

<nav>
    <span class="brand">Job Board</span>
    <div>
        <a href="../Controller/JobController.php?action=index">Job Board</a>
        <a href="../Controller/ApplicationController.php?action=myApplications">My Applications</a>
        <a href="../Controller/SavedJobController.php">Saved Jobs</a>
        <a href="../View/logout.php">Logout</a> 
    </div>
</nav>   

<div class="container">
    <?php if (isset ($_SESSION['success'])): ?>
        <div class="alert-success">
            <?php 
            echo $_SESSION['success']; 
            unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>
    <h2>Available Jobs</h2>

<!-- Search Job -->
    <div class="search-bar"> 
        <input type="text" id="search-input" placeholder="Search by company title...">
    </div>

<!-- filter Job --> 
    <div class="filters">
        <select id="filter-category">
            <option value="">All Categories</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>">
                    <?php echo htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select id="filter-type">
            <option value="">All Job Types</option>
            <option value="Full-time">Full-time</option>
            <option value="Part-time">Part-time</option>
            <option value="Remote">Remote</option>
        </select>
        <input type="text" id="filter-location" placeholder="Location...">
        <input type="text" id="filter-salary" placeholder="Salary keyword...">
        <button onclick="clearFilters()">Clear</button>
    </div>

    <div id="job-list">
        <?php if (empty($jobs)): ?>
            <p class="no-jobs">No job founded.</p>
        <?php else: ?>
              <?php foreach ($jobs as $job):
                $isSaved  = in_array($job['id'], $savedIds);
                $heart    = $isSaved ? '&#10084;' : '&#129293;' ;
                $saved    = $isSaved ? 'saved' : '';
                $title    = htmlspecialchars($job['title']);
                $company  = htmlspecialchars($job['company_name'] ?? 'N/A');
                $location = htmlspecialchars($job['location']);
                $type     = htmlspecialchars($job['job_type']);
                $salary   = htmlspecialchars($job['salary_range']);
                $id       = $job['id'];
            ?>

            <div class="job-card">
                    <h3><?php echo $title ?></h3>
                    <div class="company"><?= $company ?></div>
                    <div class="meta">
                        <?php echo $location ?> &nbsp;
                        <?php echo $type ?> &nbsp;
                        <?php echo $salary ?>
                    </div>

                    <div class="actions">
                        <a class="btn-view" href="../Controller/JobController.php?action=show&id=<?= $id ?>">
                            View Details
                        </a>

                        <button class="heart-btn <?= $saved ?>"
                                data-job-id="<?= $id ?>"
                                onclick="toggleSave(this)">
                            <?php echo $heart ?>
                        </button>
                    </div>
            </div>
           <?php endforeach; ?>
           <?php endif; ?>
    </div>
</div>

<script>
  const savedJobIds = <?= json_encode($savedIds) ?>;
</script>
<script src="../Public/JS/job_board.js"></script>
</body>
</html>