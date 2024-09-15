# flight_log_management_system

### This web application is designed to meet all of the project's needs, both mandatory and optional requirements.

---

The Flight Log Management System is a web application that allows user to securely manage and store flight logs. 

The project employs the MVC (Model-View-Controller) architecture pattern to segregate concerns and organise the coding. It enables user authentication, role-based access, and a wide range of CRUD (Create, Read, Update, Delete) activities for flight log management. This software is developed with PHP, MySQL, HTML, CSS, and jQuery. It can offer user-friendly interface and robust backend for managing flight log information.

The deployed application can be found at heroku:
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

- Register: New users can register for an account to access the system.
- Login: Secure login system with hashed passwords for user authentication.
- Forgot Password: Reset password functionality for users who have forgotten their credentials.
- Logout: Users can securely log out of the system.
- Delete Account: Users have the option to delete their accounts permanently.

#### Flight Log Management:

- View Flight Logs: Display all flight logs in a sortable table format.
- Create Flight Log: Add new flight log entries with details such as Tail Number, Flight ID, Takeoff, Landing, and Duration.
- Edit Flight Log: Modify existing flight log entries.
- Delete Flight Log: Remove flight log entries from the system.
- Search Flight Logs: Search for specific flight logs using Flight ID.

#### Interactive User Interface:

- Dynamic form submissions and updates using AJAX without refreshing the page.
- Responsive design using HTML, CSS, and JavaScript for a seamless user experience.

#### Security Features:

- Password hashing for secure user authentication.
- Input validation to prevent SQL injection and other vulnerabilities.
- Session management to protect user sessions.
