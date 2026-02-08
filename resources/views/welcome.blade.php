<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniMedi - Hospital Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container { text-align: center; color: white; padding: 40px; max-width: 800px; }
        h1 { font-size: 3.5rem; margin-bottom: 20px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); }
        .subtitle { font-size: 1.3rem; margin-bottom: 40px; opacity: 0.9; }
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        .feature-card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 15px;
            border: 1px solid rgba(255,255,255,0.2);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .feature-card h3 { font-size: 1.4rem; margin-bottom: 15px; }
        .feature-card p { font-size: 1rem; opacity: 0.9; line-height: 1.6; }
        .actions { display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; }
        .btn {
            padding: 15px 35px;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }
        .btn-primary {
            background: white;
            color: #667eea;
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .btn-secondary {
            background: transparent;
            border: 2px solid white;
            color: white;
        }
        .btn-secondary:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-3px);
        }
        .api-link {
            margin-top: 40px;
            padding: 20px;
            background: rgba(0,0,0,0.2);
            border-radius: 10px;
        }
        .api-link code {
            background: rgba(255,255,255,0.2);
            padding: 3px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🏥 MiniMedi</h1>
        <p class="subtitle">Simple Hospital Management System - Built with Laravel 12</p>

        <div class="features">
            <div class="feature-card">
                <h3>👨‍⚕️ For Patients</h3>
                <p>Register and login via REST API. Book appointments with doctors, view your appointment history, and cancel pending appointments.</p>
            </div>
            <div class="feature-card">
                <h3>👨‍⚕️ For Doctors</h3>
                <p>Access your assigned appointments, add medical notes with diagnoses and prescriptions, and manage patient care.</p>
            </div>
            <div class="feature-card">
                <h3>⚙️ For Administrators</h3>
                <p>Complete system control: manage doctors and patients, view all appointments, assign roles and permissions.</p>
            </div>
            <div class="feature-card">
                <h3>🔗 REST API</h3>
                <p>Full API for patient operations: authentication, appointment booking, profile management - all with proper validation.</p>
            </div>
            <div class="feature-card">
                <h3>🌐 Localization</h3>
                <p>Support for English and Arabic interfaces. All labels, messages, and statuses are localized.</p>
            </div>
            <div class="feature-card">
                <h3>📁 Media Library</h3>
                <p>Upload medical reports, lab results, and prescriptions using Spatie Media Library with file validation.</p>
            </div>
        </div>

        <div class="actions">
            <a href="/login" class="btn btn-primary">🚀 Access Dashboard</a>
            <a href="/api/v1/auth/register" class="btn btn-secondary">📡 API Registration</a>
        </div>

        <div class="api-link">
            <p>📡 <strong>API Base URL:</strong> <code>http://127.0.0.1:8000/api/v1</code></p>
            <p>📖 <strong>API Documentation:</strong> See <code>docs/API_TESTING.md</code></p>
        </div>
    </div>
</body>
</html>
