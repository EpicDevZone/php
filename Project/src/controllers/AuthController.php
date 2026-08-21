<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\User;

class AuthController
{
    private array $errors = [];
    private string $username = '';
    private string $email = '';

    //! Handle post creation, editing, deletion, and loading for the dashboard.
    public function dashboard(array $user): array
    {
        //? The user ID is used for both ownership checks and post lookup.
        $userId = (int) $user['id'];
        $postError = '';

        //! Process dashboard forms only when the user submits a POST request.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            $content = trim($_POST['content'] ?? '');
            $postId = (int) ($_POST['post_id'] ?? 0);

            //? Empty content is rejected before create or update reaches the model.
            if (in_array($action, ['create', 'update'], true) && $content === '') {
                $postError = 'A post cannot be empty.';
            } elseif ($action === 'create') {
                //! Create a new post for the currently logged-in user.
                Post::create($userId, $content);
                //? Redirect after success so refreshing the page does not submit the form again.
                header('Location: userDashboard.php');
                exit;
            } elseif ($action === 'update' && $postId > 0) {
                //! Update only the post identified by the submitted ID.
                Post::update($postId, $userId, $content);
                header('Location: userDashboard.php');
                exit;
            } elseif ($action === 'delete' && $postId > 0) {
                //! Delete only a post belonging to the currently logged-in user.
                Post::delete($postId, $userId);
                header('Location: userDashboard.php');
                exit;
            }
        }

        //! Return the user's posts and any validation message to the dashboard view.
        return [
            'posts' => Post::forUser($userId),
            'postError' => $postError,
        ];
    }
    //! user registration logic 
    public function register(): array
    {
        //? Validation errors are collected so the form can display them together.
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
        //? Login validates credentials here before creating an authenticated session.
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
                    //! Regenerate the session ID before storing the authenticated user.
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
