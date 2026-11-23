# CakePHP Student Information System

CakePHP 5 student CRUD portfolio application using JSON file storage (no database server required).

## Features
- Student listing, search, and pagination
- Add, view, edit, and delete student records
- JSON data file at \`storage/students.json\`
- Responsive Bootstrap 5 interface

## Local setup
Requirements: PHP 8.2+, Composer 2, and PHP extensions required by CakePHP (including intl and mbstring).

\`\`\`powershell
Copy-Item .env.example .env
composer install
php bin/cake.php server
\`\`\`
Open http://localhost:8765.

## Deploy to Render
1. Push this repository to GitHub.
2. In Render choose New > Web Service and connect this repository.
3. Choose Docker runtime and Free instance.
4. Set \`APP_ENV=production\`, \`APP_DEBUG=false\`, \`APP_URL=https://YOUR-SERVICE.onrender.com\`, and a long random \`SECURITY_SALT\`.
5. Deploy. No database URL or migration step is needed.

## Important: JSON storage and Render free tier
The app reads and writes \`storage/students.json\`. Render free web services have an ephemeral filesystem. Records added or changed at runtime can be lost when the service is redeployed, restarted, or replaced. This JSON mode is intended as a temporary diagnostic/demo configuration, not durable production storage. Keep backups and use fictional data only. For permanent data, switch back to PostgreSQL or another persistent database.

## Security
This beginner portfolio application has no login or role-based access. Anyone who can access the public app may view and change student records. Use fictional data only until authentication and authorization are added.
