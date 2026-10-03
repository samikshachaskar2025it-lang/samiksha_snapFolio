# Samiksha Chaskar Portfolio

A personal portfolio for Samiksha Chaskar, featuring selected software projects, education, internships, technical skills, achievements, and contact information.

## Project contents

- `index.html` contains the portfolio and project showcase.
- `assets/css/main.css` contains the site styling.
- `assets/js/main.js` and `assets/vendor/` provide the page interactions and frontend libraries.
- `forms/contact.php` stores contact inquiries in MySQL/MariaDB when the host is configured.
- `forms/schema.sql` defines the contact-message table.

## Preview

Open `index.html` in a browser to preview the static portfolio. The contact form requires a PHP host with PDO MySQL enabled and the database setup below.

## Contact form database

1. Create a MySQL or MariaDB database and user on the hosting provider.
2. Run `forms/schema.sql` in that database.
3. Configure `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASSWORD` as private environment variables for the PHP site.

See `forms/database-setup.txt` for details. Never commit database credentials.

## Template credit

The portfolio is based on the SnapFolio template by [BootstrapMade](https://bootstrapmade.com/snapfolio-bootstrap-portfolio-template/). The required BootstrapMade footer credit is retained. Review the [BootstrapMade license](https://bootstrapmade.com/license/) before sharing or redistributing source files.