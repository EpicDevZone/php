<?php
//! Resume the session created by the login page.
session_start();

require_once __DIR__ . '/../src/Core/Autoloader.php';

use App\Controllers\AuthController;

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
$username = htmlspecialchars($user['username']);
$email = htmlspecialchars($user['email']);
$avatarLetter = htmlspecialchars(strtoupper(substr($user['email'], 0, 1)));
$dashboard = (new AuthController())->dashboard($user);
$posts = $dashboard['posts'];
$postError = $dashboard['postError'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-100 text-slate-800 ">
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-6 py-5">
            <div class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-600 text-xl font-bold text-white">
                    <?= $avatarLetter ?>
                </div>
                <div>
                    <p class="text-sm font-medium uppercase tracking-wide text-blue-600">KMC Buddies</p>
                    <h1 class="text-2xl font-semibold">User Dashboard</h1>
                </div>
            </div>
            <a href="userDashboard.php?logout=1" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">
                Log out
            </a>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-6 py-10">
        <section class=" overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="h-32 bg-gradient-to-r from-yellow-700 to-cyan-500"></div>
            <div class="   px-6 pb-8 sm:px-8  ">
                <div class="-mt-12 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div class="flex items-end mt-6 gap-8">
                        <div class="   flex h-24 w-24 items-center justify-center rounded-full border-4 border-white bg-red-600 text-4xl font-bold text-white shadow-md">
                            <?= $avatarLetter ?>
                        </div>
                        <div class="pb-1   ">
                            <h2 class="  text-3xl font-semibold text-slate-900"><?= $username ?></h2>
                            <p class="text-slate-500"><?= $email ?></p>
                        </div>
                    </div>
                </div>

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
            </div>
        </section>


        <section class="mt-8">
            <h2 class="mb-4 text-2xl font-semibold text-slate-900">Create a post!</h2>
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <?php if ($postError) { ?>
                    <p class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700"><?= htmlspecialchars($postError) ?></p>
                <?php } ?>
                <form action="" method="post">
                    <input type="hidden" name="action" value="create">
                    <div>
                        <label for="content" class="sr-only">Post content</label>
                        <textarea
                            name="content"
                            id="content"
                            rows="5"
                            placeholder="What's on your mind, <?= $username ?>?"
                            class="w-full resize-y rounded-lg border border-slate-300 px-4 py-3 text-slate-900 outline-none placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"></textarea>
                    </div>
                    <input type="submit" value="Post" class="mt-4 cursor-pointer rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                </form>
            </div>
        </section>

        <section class="mt-8">
            <h2 class="mb-4 text-2xl font-semibold text-slate-900">Your posts</h2>
            <div class="space-y-4">
                <?php if (empty($posts)) { ?>
                    <div class="rounded-2xl bg-white p-6 text-slate-500 shadow-sm ring-1 ring-slate-200">You have not created any posts yet.</div>
                <?php } else { ?>
                    <?php foreach ($posts as $post) { ?>
                        <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-600 font-bold text-white">
                                    <?= $avatarLetter ?>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center justify-between gap-2">
                                        <div>
                                            <h3 class="font-semibold text-slate-900"><?= $username ?></h3>
                                            <p class="text-xs text-slate-500"><?= htmlspecialchars($post['created_at']) ?></p>
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="button" onclick="document.getElementById('edit-<?= (int) $post['id'] ?>').classList.toggle('hidden')" class=" px-4 py-3 rounded-3xl bg-blue-600 hover:bg-blue-700  text-white  hover:font-semibold transition duration-500 text-sm font-medium text-blue-600  ">Edit</button>
                                            <form action="" method="post" onsubmit="return confirm('Delete this post?');">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="post_id" value="<?= (int) $post['id'] ?>">
                                                <button type="submit" class="  px-4 py-3 rounded-3xl bg-red-600 hover:bg-red-700  text-white hover:font-semibold transition duration-500  text-sm font-medium text-red-600   ">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                    <p class="mt-4 whitespace-pre-wrap break-words text-slate-700"><?= htmlspecialchars($post['content']) ?></p>
                                    <form id="edit-<?= (int) $post['id'] ?>" action="" method="post" class="mt-4 hidden">
                                        <input type="hidden" name="action" value="update">
                                        <input type="hidden" name="post_id" value="<?= (int) $post['id'] ?>">
                                        <textarea name="content" rows="4" class="w-full rounded-lg border border-slate-300 px-4 py-3 text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"><?= htmlspecialchars($post['content']) ?></textarea>
                                        <button type="submit" class="mt-3 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Save changes</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    <?php } ?>
                <?php } ?>
            </div>
        </section>
    </main>

</body>

</html>