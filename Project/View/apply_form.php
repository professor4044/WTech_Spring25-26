<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply Form</title>
    <link rel="stylesheet" href="../Public/CSS/style.css">
    <link rel="stylesheet" href="../Public/CSS/apply_form.css">
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
    <a href="../Controller/JobController.php?action=show&id=<?= $job['id'] ?>"
       style="display:inline-block; margin-bottom:20px; color:#2980b9;">
        Back to Job
    </a>
    <div class="form-card">

        <!-- Job Info -->
        <h2>Apply for: <?php echo htmlspecialchars($job['title']) ?></h2>
        <p class="sub"><?php echo htmlspecialchars($job['company_name'] ?? '') ?> · <?php echo htmlspecialchars($job['location']) ?></p>

        <!-- Error Messages -->
        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <?php foreach ($errors as $err): ?>
                    <p> <?php echo htmlspecialchars($err) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

         <!-- Apply Form -->
        <form method="POST" enctype="multipart/form-data">

            <!-- Cover Letter -->
            <div class="form-group">
                <label for="cover_letter">Cover Letter *</label>
                <textarea name="cover_letter" id="cover_letter"
                          placeholder="Wrote your cover letter..."><?= htmlspecialchars($_POST['cover_letter'] ?? '') ?></textarea>
            </div>

            <!-- Resume Options -->
            <div class="form-group">
                <label>Resume *</label>
                <div class="resume-box">

                      <!-- use profile resume  -->
                    <?php if ($profile_resume): ?>
                        <label class="radio-label">
                            <input type="radio" name="use_profile_resume" value="1"
                                   checked onchange="toggleUpload(this)">
                            Used Profile resume 
                            <small>(<?php echo htmlspecialchars(basename($profile_resume)) ?>)</small>
                        </label>
                    <?php endif; ?>

                    <!-- new resume upload -->
                    <label class="radio-label">
                        <input type="radio" name="use_profile_resume" value="0"
                               <?php echo empty($profile_resume) ? 'checked' : '' ?>
                               onchange="toggleUpload(this)">
                        New resume upload (PDF only, max 2MB)
                    </label>

                     <!-- File Upload Area -->
                    <div id="upload-area" style="<?= empty($profile_resume) ? 'display:block;' : 'display:none;' ?>">
                        <input type="file" name="resume" accept=".pdf">
                    </div>

                </div>
            </div>

            <button type="submit" class="btn-submit">Submit Application</button>

        </form>
    </div>
</div>

<script src="../Public/JS/apply_form.js"></script>

    
</body>
</html>