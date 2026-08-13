<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User form</title>
</head>

<body>
    <form action="process.php" method="POST">
        <div>
            <label for="username">Username</label>
            <input type="text " name="username" id="username">

        </div>
        <br>
        <div>
            <label for="email">Email</label>
            <input type="text" name="email" , id="email">

        </div>
        <br>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">

        </div>
        <br>

        <button type="submit">
            Submit
        </button>

    </form>
</body>

</html>