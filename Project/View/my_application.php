<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Applications</title>
    <link rel="stylesheet" href="../Public/CSS/style.css">
    <link rel="stylesheet" href="../Public/CSS/my_application.css">
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
    <h2 style="margin-bottom:20px;">My Applications</h2>

    <!--if no application-->
    <?php if (empty($applications)): ?>
        <p class="no-jobs">You are not apply any job here.</p>

    <?php else: ?>
        <table class="app-table">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Company</th>
                    <th>Location</th>
                    <th>Job Type</th>
                    <th>Applied Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                 <?php foreach ($applications as $app):
                    $title      = htmlspecialchars($app['job_title']);
                    $company    = htmlspecialchars($app['company_name']);
                    $location   = htmlspecialchars($app['location']);
                    $type       = htmlspecialchars($app['job_type']);
                    $date       = date('d M Y', strtotime($app['applied_at']));
                    $status     = htmlspecialchars($app['status']);

                    if ($status === 'Submitted')   $badge = 'badge-submitted';
                    elseif ($status === 'Reviewed')    $badge = 'badge-reviewed';
                    elseif ($status === 'Shortlisted') $badge = 'badge-shortlisted';
                    elseif ($status === 'Rejected')    $badge = 'badge-rejected';
                    else $badge = 'badge-submitted';
                ?>
                    <tr>
                        <td><?= $title ?></td>
                        <td><?= $company ?></td>
                        <td><?= $location ?></td>
                        <td><?= $type ?></td>
                        <td><?= $date ?></td>
                        <td><span class="badge <?= $badge ?>"><?= $status ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>



</body>
</html>