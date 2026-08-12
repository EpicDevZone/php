<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 flex items-center justify-center px-4 py-10">


    <?php

    $errors = [];
    $successMessage = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = $_POST["username"] ?? "";
        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";
        $confirmPass = $_POST["confirmPass"] ?? "";

        if (strlen($username) < 3) {
            $errors[] = "The username must be at least 3 characters";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "The email must be a valid email address";
        }
        if ($password !== $confirmPass) {
            $errors[] = "The password do not match";
        }

        if (empty($errors)) {
            try {
                $dsn = "mysql:host=localhost;port=3306;dbname=php_workshop;charset=utf8mb4";
                $pdo = new PDO($dsn, "root", "");
            } catch (PDOException $e) {
                die("Connection failed" . $e->getMessage());
            }

            try {
                // $sql_query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
                // $pdo->exec($sql_query);

                $sql_query = "INSERT INTO usersN(username , eamil , password) VALUES (:username , :email , :password)";

                $statement = $pdo->prepare($sql_query);
                $data = [
                    'username' => $username,
                    'email' => $email,
                    'password' => $password,
                ];

                $statement->execute($data);
                $userId = $pdo->lastInsertId();

                $successMessage = "User Registered with userID " . $userId;
            } catch (PDOException $e) {
                $errors[] = "Data could not be inserted: " . $e->getMessage();
            }
        }
    }







    ?>









    <div class="w-full max-w-md">
        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-slate-200 p-8">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-semibold text-slate-800">Create an Account</h1>
                <p class="text-sm text-slate-500 mt-2">Join our platform and get started in minutes.</p>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="mb-5 rounded-xl border border-red-300 bg-red-100 p-4 text-base font-semibold text-red-800 shadow-sm">
                    <div class="mb-2 font-bold uppercase tracking-wide">Please fix the following:</div>
                    <ul class="list-disc pl-5 space-y-1">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="mb-5 rounded-xl border border-green-300 bg-green-600 p-4 text-base font-semibold text-white shadow-md">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">✓</span>
                        <span><?= htmlspecialchars($successMessage) ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-5">
                <div>
                    <label for="username" class="block text-sm font-medium text-slate-700 mb-2">Full Name</label>
                    <input type="text" id="username" name="username" placeholder="Enter your full name"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a strong password"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
                </div>
                <div>
                    <label for="confirmpass" class="block text-sm font-medium text-slate-700 mb-2">confirm password</label>
                    <input type="password" id="confirmpass" name="confirmPass" placeholder="Confirm your password "
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
                </div>

                <button type="submit"
                    class="w-full rounded-lg bg-blue-600 px-4 py-3 font-semibold text-white shadow-md transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Create Account
                </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-6">
                Already have an account?
                <a href="login.php" class="text-blue-600 font-medium hover:underline">Sign in</a>
            </p>
        </div>
    </div>
</body>

</html>