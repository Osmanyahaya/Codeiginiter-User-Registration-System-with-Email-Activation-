# Simple User Management System

1. Download or clone the repo to your desktop or www/htdocs folder.
2. Change directory to `cd the-app-directory` in your www/htdocs folder.
3. Import `the-app-directory/database.sql` to your MySQL or MariaDB Server, create a user and grant all rights to the imported `DB`
4. Rename `.env.example` to `.env`
5. Change the App URL to `app.baseURL = 'http://localhost/the-app-directory/public/'`
6. Update database config, change the lines where `database.default.database =`, `database.default.username =`, `database.default.password =`, and `database.default.hostname =` in .env file.
7. Browse the app using a web browser, by entering this URL address `http://localhost/the-app-directory/public`.

8. Login using default account username `admin@test.com`, password `password1234`


## Email Configurattion

  Navigate to app/Config/Email.php
  provide the following values to activate the email service
 'protocol' => '',
  'smtp_host' => '',
  'smtp_port' => ,
  'smtp_user' => '',
  'smtp_pass' => '',


System Requirements

1. `PHP` >= 7.1.3
2. `MySQL` 5.x or newer versions
3. `Nginx` or `Apache` (recommended) http server
4. Required PHP extensions: `OpenSSL`, `PDO`, `Mbstring`, `Tokenizer`, `Ctype`, `JSON`

## Thank you.
