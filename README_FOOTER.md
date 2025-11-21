Footer MVC for CASDO - Setup Guide

Overview
--------
This adds a dynamic footer built with PHP + MySQL in an MVC-style layout.

Files added (paths relative to project root)
- `config/db.php` - PDO connection (creates `$pdo` if not exists)
- `models/FooterModel.php` - data access for footer
- `controllers/FooterController.php` - controller wrapper
- `views/footer.php` - include this in pages with `include "views/footer.php";`
- `assets/css/footer.css` - footer styles
- `sql/footer.sql` - SQL dump to create tables + sample data
- `admin/*` - admin pages to manage footer content

Database setup
--------------
1. Create a database named `casdo` (or update credentials in `config/db.php`).
2. Import the SQL file `sql/footer.sql` into your MySQL server. Example using mysql client:

```powershell
mysql -u root -p casdo < sql/footer.sql
```

Notes: If your XAMPP MySQL user is different, adjust the command.

Usage
-----
1. Ensure `config/db.php` has correct DB credentials.
2. Include the footer on any page by adding:

```php
<?php include "views/footer.php"; ?>
```

3. Admin panel:
   - Visit `admin/admin-login.php` to login (uses existing `users` table; create an admin user manually or via `admin/admin-register.php`).
   - After login, go to `admin/index.php` to manage footer content.

Security & Notes
----------------
- All DB operations use PDO prepared statements.
- Input is trimmed and escaped when rendering.
- This is a simple admin implementation; consider adding CSRF protection and stronger authentication for production.

Customization
-------------
- Change colors in `assets/css/footer.css`.
- Add more sections by inserting rows into `footer_links` with a new `section` name and updating `views/footer.php` to render them.

If you want, I can:
- Add CSRF tokens to admin forms.
- Add inline JS for nicer UX (AJAX add/delete).
- Run a scan to modify other pages to include `views/footer.php` automatically.
