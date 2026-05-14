//upload area
function toggleUpload(radio) {
    const uploadArea = document.getElementById('upload-area');

    if (radio.value === '0') {
        // new upload selected see file input
        uploadArea.style.display = 'block';
    } else {
        // Profile resume select
        uploadArea.style.display = 'none';
    }
}