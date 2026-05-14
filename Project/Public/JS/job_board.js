//search box
document.getElementById('search-input').addEventListener('input', function() {
    delayFetch();
});

//category dropdown
document.getElementById('filter-category').addEventListener('change', function() {
    fetchJobs();
});

//job type dropdown
document.getElementById('filter-type').addEventListener('change', function() {
    fetchJobs();
});

//location
document.getElementById('filter-location').addEventListener('input', function() {
    delayFetch();
});

//salary
document.getElementById('filter-salary').addEventListener('input', function() {
    delayFetch();
});

//set delay
let timer;
function delayFetch() {
    clearTimeout(timer);
    timer = setTimeout(function() {
        fetchJobs();
    }, 400);
}

//clear filter
function clearFilters() {
    document.getElementById('search-input').value    = '';
    document.getElementById('filter-category').value = '';
    document.getElementById('filter-type').value     = '';
    document.getElementById('filter-location').value = '';
    document.getElementById('filter-salary').value   = '';
    fetchJobs();
}

function fetchJobs() {
    const q           = document.getElementById('search-input').value;
    const category_id = document.getElementById('filter-category').value;
    const job_type    = document.getElementById('filter-type').value;
    const location    = document.getElementById('filter-location').value;
    const salary      = document.getElementById('filter-salary').value;

    const url = '../api/jobs.php'
              + '?q='           + q
              + '&category_id=' + category_id
              + '&job_type='    + job_type
              + '&location='    + location
              + '&salary='      + salary;

    fetch(url)
        .then(function(res) {
            return res.json();
        })
        .then(function(data) {
            showJobs(data.jobs);
        })
        .catch(function(err) {
            console.error('Error:', err);
        });
}

//show in page
function showJobs(jobs) {
    const list = document.getElementById('job-list');

    if (!jobs || jobs.length === 0) {
        list.innerHTML = '<p class="no-jobs">কোনো job পাওয়া যায়নি।</p>';
        return;
    }

    let html = '';

    for (let i = 0; i < jobs.length; i++) {
        const job     = jobs[i];
        const isSaved = savedJobIds.indexOf(parseInt(job.id)) !== -1;
        const heart = isSaved ? "\u2764" : "\u1F90D";
        const saved   = isSaved ? 'saved' : '';

        html += '<div class="job-card">';
        html +=   '<h3>' + job.title + '</h3>';
        html +=   '<div class="company">' + (job.company_name || 'N/A') + '</div>';
        html +=   '<div class="meta">';
        html +=      + job.location + ' &nbsp; ';
        html +=      + job.job_type  + ' &nbsp; ';
        html +=      + job.salary_range;
        html +=   '</div>';
        html +=   '<div class="actions">';
        html +=     '<a class="btn-view" href="JobController.php?action=show&id=' + job.id + '">View Details</a>';
        html +=     '<button class="heart-btn ' + saved + '" data-job-id="' + job.id + '" onclick="toggleSave(this)">' + heart + '</button>';
        html +=   '</div>';
        html += '</div>';
    }

    list.innerHTML = html;
}

//save/unsave by clicking heart button
function toggleSave(btn) {
    const jobId = btn.getAttribute('data-job-id');

    fetch('../api/saved_jobs.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ job_id: jobId })
    })
    .then(function(res) {
        return res.json();
    })
    .then(function(data) {
        if (data.status === 'saved') {
            btn.innerHTML = '❤️';
            btn.classList.add('saved');
            savedJobIds.push(parseInt(jobId));
        } else {
            btn.innerHTML = '🤍';
            btn.classList.remove('saved');
            savedJobIds.splice(savedJobIds.indexOf(parseInt(jobId)), 1);
        }
    })
    .catch(function(err) {
        console.error('Error:', err);
    });
}