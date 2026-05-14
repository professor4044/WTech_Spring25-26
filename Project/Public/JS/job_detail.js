// clicking heart button save/unsave
function toggleSave(jobId) {
    const btn = document.getElementById('save-btn');

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
            btn.innerHTML = 'Saved';
            btn.classList.add('saved');
        } else {
            btn.innerHTML = 'Save Job';
            btn.classList.remove('saved');
        }
    })
    .catch(function(err) {
        console.error('Error:', err);
    });
}