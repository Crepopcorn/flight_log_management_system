# flight_log_management_system

### This web application is designed to meet all of the project's needs, both mandatory and optional requirements.

---

The Flight Log Management System is a web application that allows user to securely manage and store flight logs. 

The project uses the MVC (Model-View-Controller) design to keep code organized. It supports user login, roles, and CRUD (Create, Read, Update, Delete) actions for managing flight logs. It is developed with PHP, MySQL, HTML, CSS, and javascript (jQuery), and it provides an easy-to-use interface and strong backend for handling flight log data.

The deployed application can be found at heroku:<br />
https://flight-log-app-73904c16f867.herokuapp.com/

---

#### Languages used: &ensp; PHP, HTML, CSS, JavaScript
#### Libraries used: &ensp; jQuery
#### Database used: &ensp; MySQL

---

## Web Page Layout


#### Login Page
![login_page](https://github.com/Crepopcorn/flight_log_management_system/blob/main/layout_image/loginpage.jpg)

#### Flight Log Entry Form Page
![table_page](https://github.com/Crepopcorn/flight_log_management_system/blob/main/layout_image/tablepage.jpg)

## Features

#### User Management:
- Register: New user signup.
- Login: Secure login with hashes.
- Forgot Password: Reset passwords.
- Logout: Securely log out.
- Delete Account: Permanent deletion.

#### Flight Log Management:
- View Logs: Sortable table display.
- Create Log: Add flight entries.
- Edit Log: Modify flight entries.
- Delete Log: Remove entries.
- Search Logs: Search by Flight ID.

#### Interactive UI:
- AJAX: Dynamic form updates.
- Responsive: HTML/CSS/JS design.

#### Security Features:
- Hashing: Secure passwords.
- Validation: Prevent SQL injection.
- Sessions: Manage user sessions.

## Getting Started

Follow these steps to setup the project on your computer if you want to run in your local machine for development and testing:

#### Prerequisites
- Web server with PHP support (XAMPP/WAMP/MAMP).
- MySQL database server.
- Composer (optional) for dependency management.

#### Installation
##### 1) Clone the Repository:

```
git clone https://github.com/yourusername/flight-log-management-system.git
```

##### 2) Navigate to the project directory:

```
cd flight-log-management-system
```
##### 3) Copy the project directory into the htdocs of your PHP support (e.g. C:\xampp\htdocs)

##### 4) Set Up the Database:

Create a MySQL database.
Import the database.session.sql file located in the root directory into the database database.

##### 5) SQL Table Creation:

Use the created database, execute the following MySQL commands:
```
USE {Database Name};

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE flight_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tailNumber VARCHAR(50) NOT NULL,
    flightID VARCHAR(50) NOT NULL,
    takeoff DATETIME NOT NULL,
    landing DATETIME NOT NULL,
    duration TIME NOT NULL,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

##### 6) Configure Database Connection:

Open config/db.php and and configure the database settings:

```
$servername = "localhost";
$username = "root";
$password = "your_password";
$dbname = "your_database";
```

##### 7) Run the Application.

Start your web server and navigate to http://localhost/flight-log-management-system/index.php in your browser.

## Usage

- Register: Click "Create New Account" to sign up.
- Login: Enter your details to access and manage flight logs.
- Manage Logs: Create, edit, delete, or search flight logs once logged in.
- Logout: Click "Logout" to safely end your session.

## File and Directory Structure

- index.php: Main app entry point.
- config/db.php: Database setup file.
- controllers/: PHP files for handling actions and operations.
- models/: PHP files for user and flight log data.
- views/: PHP files for the UI (login, register, manage logs).
- assets/: Images and static files.
- css/styles.css: Main CSS file.
- js/scripts.js: JavaScript for AJAX and dynamic actions.

## Acknowledgments
- PHP and MySQL for backend.
- jQuery for interactive UI.
- Bootstrap for responsive design.
  
