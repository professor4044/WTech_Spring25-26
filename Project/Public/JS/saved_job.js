function removeJob(jobId) {
    fetch('../api/saved_jobs.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ job_id: jobId })
    })
    .then(function(res) {
        return res.json();
    })
    .then(function(data) {
        if (data.status === 'unsaved') {
            const card = document.getElementById('card-' + jobId);
            card.remove();

            const list = document.getElementById('saved-list');
            if (list.children.length === 0) {
                list.innerHTML = '<p class="no-jobs">You dont save any job here.</p>';
            }
        }
    })
    .catch(function(err) {
        console.error('Error:', err);
    });
}