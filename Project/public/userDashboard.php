<?php
//! Resume the session created by the login page.
session_start();

if (isset($_GET['logout'])) {
    //! Clear the session before sending the user back to the login page.
    $_SESSION = [];
    session_destroy();
    header('Location: login.php');
    exit;
}

//! Do not show dashboard data to users who have not logged in.
if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

//? Escape session values before displaying them in HTML.
$user = $_SESSION['user'];
$username = htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-100 text-slate-800">
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-6 py-5">
            <div>
                <p class="text-sm font-medium uppercase tracking-wide text-blue-600">KMC Buddies</p>
                <h1 class="text-2xl font-semibold">User Dashboard</h1>
            </div>
            <a href="userDashboard.php?logout=1" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">
                Log out
            </a>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-6 py-10">
        <section class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-medium text-slate-500">Welcome back</p>
            <h2 class="mt-2 text-3xl font-semibold text-slate-900"><?= $username ?></h2>
            <p class="mt-3 text-slate-600">You are logged in successfully.</p>

            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-5">
                    <p class="text-sm font-medium text-slate-500">Username</p>
                    <p class="mt-2 break-words text-lg font-semibold text-slate-900"><?= $username ?></p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-5">
                    <p class="text-sm font-medium text-slate-500">Email</p>
                    <p class="mt-2 break-words text-lg font-semibold text-slate-900"><?= $email ?></p>
                </div>
            </div>
        </section>
    </main>
</body>

</html>