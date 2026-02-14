🚀 LogLens AI

AI-Powered Log & Root Cause Analyzer (PHP + LAMP + AI APIs)

LogLens AI is a lightweight infrastructure debugging tool that uses Artificial Intelligence to analyze server logs and generate:

✅ Error pattern detection

✅ Plain-English explanations

✅ Root cause analysis

✅ Severity classification

✅ Clear remediation steps

Instead of manually grepping through thousands (or millions) of log lines, LogLens AI processes large volumes of logs in seconds and delivers actionable insights.

🎯 Why LogLens AI?

Modern DevOps / Cloud / SRE engineers should not waste hours manually parsing logs.

LogLens AI helps you:

✅ Automate log analysis

✅ Reduce MTTR (Mean Time To Resolution)

✅ Identify true root causes (not just symptoms)

✅ Receive suggested remediation actions instantly

✅ Improve operational efficiency

🧠 Supported Log Types

LogLens AI works with text-based logs including:

✅ Apache logs

✅ PHP error logs

✅ Nginx logs

✅ MySQL logs

✅ Docker logs

✅ Linux system logs

✅ CI/CD logs

✅ Kubernetes logs

Any structured text-based log output

⚙️ Core Features
📂 Secure Log Upload

Drag & drop upload support

MIME type validation

Restricted file types

File size limits

No execution of uploaded scripts

🔎 AI Analysis Engine

Detects recurring error patterns

Summarizes large log volumes

Identifies root cause

Assigns severity levels (Low / Medium / High / Critical)

Suggests remediation steps

🐳 Dockerized Deployment

Apache + PHP 8 containerized

Non-root execution

Production-safe PHP configs

One-command startup

🐳 Running with Docker (Recommended)

Build and run locally:

docker compose up --build


Or pull the pre-built image from Docker Hub and run instantly:

docker pull <your-dockerhub-username>/loglens-ai
docker run -p 8080:80 <your-dockerhub-username>/loglens-ai


Visit:

http://localhost:8080

🖥 Running with PHP-FPM + Nginx Container

If you prefer to store a local copy of the codebase on your machine and serve it using a lightweight PHP-FPM & Nginx container, run:

docker run -p 80:8080 -v ~/my-codebase:/var/www/html trafex/php-nginx


This will:

Mount your local project directory

Serve the application via Nginx

Use PHP-FPM internally

Then access:

http://localhost

🔐 AI Configuration

The application uses an AI endpoint to analyze logs.

You must update the ai.php file with your AI API endpoint and API key.

Inside ai.php, configure:

Your AI API URL

Your API key

Any required headers

Example (simplified):

$apiKey = "YOUR_API_KEY";
$endpoint = "https://your-ai-endpoint.com/v1/analyze";


⚠️ Do NOT commit your API keys to version control.
Use environment variables in production.
