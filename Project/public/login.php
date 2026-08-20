<?php

require_once __DIR__ . '/../src/Core/Autoloader.php';

use App\Controllers\AuthController;

//! The controller handles validation and authentication before the page is shown.
$auth = new AuthController();
$login = $auth->login();
$errors = $login['errors'];
$email = $login['email'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-md">
        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-slate-200 p-8">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-semibold text-slate-800">KMC Buddies</h1>
                <p class="text-sm text-slate-500 mt-2">Sign in to your account</p>
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
            <?php //! This form sends the login values back to this same page. 
            ?>
            <form action="" method="POST" class="space-y-5">
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email"
                        value="<?= htmlspecialchars($email ?? '') ?>"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
                </div>

                <button type="submit"
                    class="w-full rounded-lg bg-blue-600 px-4 py-3 font-semibold text-white shadow-md transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Sign In
                </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-6">
                Don’t have an account?
                <a href="registration.php" class="text-blue-600 font-medium hover:underline">Create one</a>
            </p>
        </div>
    </div>
</body>

</html>