# Expense-Tracker

An Expense Tracker built using a headless Laravel backend and React frontend to learn and practice the basics of full-stack web development. This project demonstrates user authentication, state management, and real-time tracking of expenses, with JWT-based authentication, OTP email verification during registration, and advanced data visualization using React Chart.js.

## Features

* **User Authentication:** Secure authentication using JWT (JSON Web Tokens).
* **OTP Email Verification:** Users verify their email with an OTP during registration.
* **Expense Management:** Track and categorize expenses.
* **Income Tracking:** Record and manage income sources.
* **Visual Data Representation:** Interactive charts powered by React Chart.js to visualize expenses and income.
* **Error Logging:** Laravel logs are used for server-side error logging.
* **React Context API:** Manage global state throughout the app with the Context API.
* **API Integration:** Axios is used to communicate with the back-end API.

## Functionality

* **Registration**: Users can create an account by providing an email and password. An OTP is sent to the email for verification. A JWT is generated upon successful registration for authentication.
* **Login**: Users can log in with their registered email and password. The JWT is stored locally for session management.
* **Logout**: Logged-in users can log out and are redirected to the login page.
* **Expense Management**: Users can add, update, and delete expenses. Each expense includes details like amount, category, and date.
* **Income Management**: Users can add, update, and delete income sources.
* **Expense Visualization**: React Chart.js is used to display the user's expenses and income in bar charts, pie charts, and other visual formats.

## Security

* **Password Strength:** Passwords must be at least 8 characters long, with a combination of uppercase letters, lowercase letters, numbers, and special characters.
* **Hashing and Salting:** Passwords are securely hashed using bcrypt before storing them in the database.
* **JWT Authentication:** JWTs are used for authentication, with tokens stored in localStorage for session persistence.
* **OTP Verification:** Email OTP verification is used during registration to validate users' email addresses.

## Built With

[![My Skills](https://skillicons.dev/icons?i=laravel,php,mysql,react,js,scss)](https://skillicons.dev)

## Usage

To use this Expense Tracker app, follow these steps:

1. Clone the repository:

   ```bash
   git clone https://github.com/DikshaGowda007/expense-tracker.git
   cd expense-tracker
   ```

2. Set up the frontend:

   ```bash
   cd frontend
   npm install
   ```

3. Set up the backend:

   ```bash
   cd ../backend
   composer install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate
   ```

4. Start the server:

   ```bash
   php artisan serve
   ```

5. Start the frontend:

   ```bash
   cd ../frontend
   npm start
   ```

## What Did I Learn

* **Context API:** Learned how to use the React Context API to manage global state in a React application. This allowed for sharing state between components without passing props manually.
* **JWT Authentication:** Gained experience implementing JWT authentication to securely log users in and manage their sessions.
* **OTP Email Verification:** Learned to implement OTP-based email verification during user registration.
* **Chart.js in React:** Learned to use React Chart.js to visualize data in an interactive and user-friendly way.
* **Axios for API Calls:** Used Axios to make asynchronous API calls to the Laravel backend.
* **React Component Design:** Improved skills in organizing React components efficiently and breaking down complex features into reusable components.
* **SCSS for Styling:** Learned to structure and manage component-level SCSS for styling React components.
* **Laravel API Development:** Practiced building RESTful API endpoints with Laravel for a headless backend setup.
