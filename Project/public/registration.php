<?php

require_once __DIR__ . '/../src/Core/Autoloader.php';

use App\Controllers\AuthController;

//! The controller handles validation and user creation before the page is shown.
$auth = new AuthController();
$registration = $auth->register();

//! Send a correctly registered user to the login page.
if (!empty($registration['userId'])) {
    header('Location: login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 flex items-center justify-center px-4 py-10">


    <div class="w-full max-w-md">
        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-slate-200 p-8">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-semibold text-slate-800">KMC Buddies</h1>
                <p class="text-sm text-slate-500 mt-2">Create an Account</p>
            </div>

            <?php if (!empty($registration['errors'])) { ?>
                <?php foreach ($registration['errors'] as $error) { ?>
                    <p class="text-red-600"><?= htmlspecialchars($error) ?></p>
                <?php } ?>
            <?php } elseif (!empty($registration['userId'])) { ?>
                <p class="text-green-600">
                    Registration successful. User ID: <?= htmlspecialchars($registration['userId']) ?>
                </p>
            <?php } ?>

            <?php //! This form sends its values back to this same page. 
            ?>
            <form action="" method="POST" class="space-y-5">
                <div>
                    <label for="username" class="block text-sm font-medium text-slate-700 mb-2">Full Name</label>
                    <input type="text" id="username" name="username" placeholder="Enter your full name"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a strong password"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>
                <div>
                    <label for="confirmpass" class="block text-sm font-medium text-slate-700 mb-2">confirm password</label>
                    <input type="password" id="confirmpass" name="confirm_password" placeholder="Confirm your password "
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
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