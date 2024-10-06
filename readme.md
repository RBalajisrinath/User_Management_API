# User Management API

## Overview
The User Management API is a RESTful API that allows for the management of user accounts. It supports CRUD (Create, Read, Update, Delete) operations and is built using PHP and MySQL. This API can be used to create new users, retrieve user information, update existing users, and delete users.

## Features
- Create new user accounts
- Retrieve user information (single and all users)
- Update user details, including username, email, and password
- Delete user accounts

## Technologies Used
- PHP
- MySQL
- HTML/CSS
- JavaScript (with Fetch API)

## Getting Started

### Prerequisites
- A local server environment (e.g., XAMPP, WAMP, or MAMP) to run PHP and MySQL.
- A web browser to access the frontend.

### Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/RBalajisrinath/User_Management_API
   cd user_management_api
   ```

2. **Set Up the Database**
   - Open phpMyAdmin (usually accessible at `http://localhost/phpmyadmin`).
   - Create a new database named `user_management`.
   - Run the following SQL command to create the `users` table:
     ```sql
     CREATE TABLE users (
         id INT AUTO_INCREMENT PRIMARY KEY,
         username VARCHAR(50) NOT NULL,
         email VARCHAR(100) NOT NULL,
         password VARCHAR(255) NOT NULL
     );
     ```

3. **Configure the API**
   - Open `src/backend/api.php` and ensure the database connection parameters are correct:
     ```php
     $mysqli = new mysqli("localhost", "root", "", "user_management");
     ```

4. **Start the Local Server**
   - Start your local server (e.g., XAMPP, WAMP, or MAMP) and ensure Apache and MySQL services are running.

5. **Access the Application**
   - Open your web browser and navigate to `http://localhost/user_management_api/frontend/index.html`.

## API Endpoints

### 1. Get All Users
- **Method**: GET
- **URL**: `http://localhost/user_management_api/src/backend/api.php`
- **Response**: JSON array of all users.

### 2. Get a Single User
- **Method**: GET
- **URL**: `http://localhost/user_management_api/src/backend/api.php?id={user_id}`
- **Response**: JSON object of the user with the specified ID.

### 3. Create a New User
- **Method**: POST
- **URL**: `http://localhost/user_management_api/src/backend/api.php`
- **Body**: JSON object
  ```json
  {
      "username": "newuser",
      "email": "newuser@example.com",
      "password": "password123"
  }
  ```
- **Response**: JSON message indicating success.

### 4. Update an Existing User
- **Method**: PUT
- **URL**: `http://localhost/user_management_api/src/backend/api.php?id={user_id}`
- **Body**: JSON object
  ```json
  {
      "username": "updateduser",
      "email": "updateduser@example.com",
      "password": "newpassword123"
  }
  ```
- **Response**: JSON message indicating success.

### 5. Delete a User
- **Method**: DELETE
- **URL**: `http://localhost/user_management_api/src/backend/api.php?id={user_id}`
- **Response**: JSON message indicating success.

## Usage
You can use tools like Postman to interact with the API endpoints. Follow the instructions in the "Connect it with Postman" section to test the API.
