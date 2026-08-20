<?php

namespace App\Controllers;

use App\Models\User;

class AuthController
{
    private array $errors = [];
    private string $username = '';
    private string $email = '';

    public function register(): array
    {
        //! Only process the form after the user presses the Register button.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //! Read the values sent by the registration form.
            $this->username = trim($_POST['username'] ?? '');
            $this->email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            //! Check the username rules.
            if (empty($this->username)) {
                $this->errors[] = 'Username should not be empty';
            } elseif (strlen($this->username) < 3 || strlen($this->username) > 30) {
                $this->errors[] = 'Username should contain 3-30 characters';
            } elseif (!preg_match('/^[a-zA-Z0-9_. ]+$/', $this->username)) {
                $this->errors[] = 'Username should only have letters, numbers, spaces, periods and underscores';
            } elseif (User::findByUsername($this->username)) {
                $this->errors[] = 'Username is already taken';
            }

            //! Check the email rules.
            if (empty($this->email)) {
                $this->errors[] = 'Email should not be empty';
            } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $this->errors[] = 'Email is not valid';
            } elseif (User::findByEmail($this->email)) {
                $this->errors[] = 'Email is already registered';
            }

            //! Check the password rules.
            if (strlen($password) < 6) {
                $this->errors[] = 'Password should contain at least 6 characters';
            }

            if ($password !== $confirmPassword) {
                $this->errors[] = 'Passwords do not match';
            }

            //! Create the user only when there are no validation errors.
            if (empty($this->errors)) {
                $userId = User::create($this->username, $this->email, $password);

                if (!$userId) {
                    $this->errors[] = 'User could not be registered';
                }

                if (empty($this->errors)) {
                    return [
                        'errors' => [],
                        'username' => $this->username,
                        'email' => $this->email,
                        'userId' => $userId,
                    ];
                }
            }
        }

        return [
            'errors' => $this->errors,
            'username' => $this->username,
            'email' => $this->email,
        ];
    }



    //! Authenticate a user submitted by the login form.
    public function login(): array
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($this->email)) {
                $this->errors[] = 'Email cannot be empty';
            } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $this->errors[] = 'The email must be a valid email address';
            }

            if (empty($password)) {
                $this->errors[] = 'Password cannot be empty';
            } elseif (strlen($password) < 6) {
                $this->errors[] = 'The password must be at least 6 characters';
            }

            if (empty($this->errors)) {
                $user = User::authenticate($this->email, $password);

                if ($user === null) {
                    $this->errors[] = 'The email or password is incorrect';
                } else {
                    session_start();
                    session_regenerate_id(true);
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                    ];
                    header('Location: userDashboard.php');
                    exit;
                }
            }
        }

        return [
            'errors' => $this->errors,
            'email' => $this->email,
        ];
    }
}
