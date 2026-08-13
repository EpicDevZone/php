<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <title>PHP Calculator</title>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 flex items-center justify-center px-4 py-10">

    <?php

    $result = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $first_number = $_POST["first_number"];
        $second_number = $_POST["second_number"];
        $operation = $_POST["operation"];

        switch ($operation) {

            case "add":
                $result = $first_number + $second_number;
                break;

            case "subtract":
                $result = $first_number - $second_number;
                break;

            case "multiply":
                $result = $first_number * $second_number;
                break;

            case "division":
                $result = ($second_number != 0)
                    ? $first_number / $second_number
                    : "Can't divide by zero";
                break;

            default:
                $result = "Invalid operation";
        }
    }

    ?>

    <div class="w-full max-w-md">
        <div class="rounded-3xl border border-slate-200 bg-white/95 p-8 shadow-2xl backdrop-blur-md">
            <div class="mb-8 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-600 text-2xl font-semibold text-white shadow-lg">
                    +
                </div>
                <h1 class="text-2xl font-semibold text-slate-800">
                    PHP Calculator
                </h1>
                <p class="mt-2 text-sm text-slate-500">
                    Perform basic arithmetic operations in a clean, modern layout.
                </p>
            </div>

            <form action="" method="post" class="space-y-5">
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        First Number
                    </label>
                    <input
                        type="number"
                        name="first_number"
                        step="any"
                        placeholder="Enter first number"
                        required
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Operation
                    </label>
                    <select
                        name="operation"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="add">Addition (+)</option>
                        <option value="subtract">Subtraction (-)</option>
                        <option value="multiply">Multiplication (×)</option>
                        <option value="division">Division (÷)</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Second Number
                    </label>
                    <input
                        type="number"
                        name="second_number"
                        step="any"
                        placeholder="Enter second number"
                        required
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button
                    type="submit"
                    class="w-full rounded-lg bg-blue-600 py-3 font-semibold text-white transition duration-200 hover:bg-blue-700">
                    Calculate
                </button>
            </form>

            <?php if ($result !== ""): ?>
                <div class="mt-8 rounded-2xl border border-blue-100 bg-blue-50 p-5 text-center">
                    <p class="mb-1 text-sm font-medium text-slate-500">
                        Result
                    </p>
                    <p class="text-3xl font-bold text-blue-600">
                        <?= $result ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>