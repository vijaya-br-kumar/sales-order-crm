Requirements
============
1) PHP >= 7.2
2) MySQL >=5.7
3) Composer
4) Apache2

Follow the below steps to run.
==============================
1) Download the project or clone (C:/xampp/htdocs/ => In Windows) or (/var/www/html/ => In Linux)
2) Run 'composer install' inside the project folder
3) Create new table in MySQL and update the username, password, and DB name in '.env' file
4) Run the migration command 'bin/console doctrine:migrations:migrate' to create the schema
5) Run the migration command 'bin/console doctrine:fixtures:load --append' to generate the list item
6) To generate the sales order for previous year run the mysql command
7) Create the new user using the below URL
8) URL
    a) http://localhost/<project-folder>/public/index.php/      ===> Admin home page
    b) http://localhost/<project-folder>/public/index.php/login ===> Admin Login page
    c) http://localhost/<project-folder>/public/index.php/register ===> Admin Register page
