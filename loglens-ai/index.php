<?php// =====================================================
// Project: LogLens AI (PHP + AI Log Analyzer) by Eric Paatey
// Secure + Drag & Drop Edition
//Upload logs. Get instant root cause analysis and fixes.
// =====================================================

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LogLens AI • Log & Root Cause Analyzer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-RLHXT9D5YY"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-RLHXT9D5YY');
    </script>


</head>
<body class="bg-light">

<div class="container py-5">

    <div class="text-center mb-4">
        <h2 class="fw-bold">LogLens AI</h2>
        <p class="text-muted">Upload logs. Get instant root cause analysis and fixes.</p>
    </div>

    <div class="card shadow-lg p-4">

        <form id="analyzeForm" enctype="multipart/form-data">

            <!-- Drag & Drop Zone -->
            <div id="dropZone" class="drop-zone mb-3">
                <p class="mb-1">Drag & drop your log file here</p>
                <small class="text-muted">Allowed: .log .txt .csv (Max 15MB)</small>
                <input type="file" name="logfile" id="fileInput" hidden required>
            </div>

            <div class="mb-3">
                <label class="form-label">Environment</label>
                <select name="env" class="form-select">
                    <option>Apache</option>
                    <option>CI / CD</option>
                    <option>Firewall</option>
                    <option>Kubernetes (K8s)</option>
                    <option>Linux System</option>
                    <option>MySQL</option>
                    <option>Node.js</option>
                    <option>Nginx</option>
                    <option>PHP</option>
                    <option>Other</option>
                    
                   
                    
                   
                   
                </select>
            </div>

            <button class="btn btn-primary w-100" type="submit">Analyze Logs</button>
        </form>

        <div id="progress" class="mt-4 text-center d-none">
            <div class="spinner-border"></div>
            <p class="mt-2 text-muted">Analyzing logs with AI...</p>
        </div>

        <div id="results" class="mt-4"></div>

    </div>

</div>

<script src="assets/js/app.js"></script>
<hr width = 100%>
<h6 style="text-align: center;">&copy; 2026 Eric Paatey . All Rights Reserved</h6>
</body>
</html>

<style>
body {
    font-family: system-ui, sans-serif;
}

.card {
    border-radius: 20px;
}

.drop-zone {
    border: 2px dashed #cbd5e1;
    padding: 40px;
    text-align: center;
    border-radius: 16px;
    cursor: pointer;
    transition: 0.2s;
}

.drop-zone.dragover {
    background: #eef6ff;
    border-color: #0d6efd;
}

#results pre {
    white-space: pre-wrap;
}
</style>
<?php


/* =====================================================
   assets/js/app.js (Drag & Drop)
   ===================================================== */
?>
<script>
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('fileInput');
const form = document.getElementById('analyzeForm');
const progress = document.getElementById('progress');
const results = document.getElementById('results');

// open file picker
dropZone.onclick = () => fileInput.click();

// drag events
['dragenter','dragover'].forEach(e =>
  dropZone.addEventListener(e, ev => {
    ev.preventDefault();
    dropZone.classList.add('dragover');
  })
);

['dragleave','drop'].forEach(e =>
  dropZone.addEventListener(e, ev => {
    ev.preventDefault();
    dropZone.classList.remove('dragover');
  })
);

// handle drop

dropZone.addEventListener('drop', e => {
    fileInput.files = e.dataTransfer.files;
});

// submit
form.addEventListener('submit', async (e) => {
    e.preventDefault();

    progress.classList.remove('d-none');
    results.innerHTML = '';

    const formData = new FormData(form);

    const res = await fetch('analyze.php', {
        method: 'POST',
        body: formData
    });

    const data = await res.json();

    progress.classList.add('d-none');

    results.innerHTML = `<div class="card p-3 bg-dark text-white"><pre>${data.result || data.error}</pre></div>`;
});
</script>
