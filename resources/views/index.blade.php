<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link Shortener</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .red {
            color: #ff0000;
            /* Red shade of Tailwind */
        }

        .black {
            background-color: #000000;
            /* Black of Tailwind */
        }
    </style>
</head>

<body class="black text-white min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md mx-auto">
        <div class="bg-white p-6 rounded shadow-md">
            <h1 class="text-center text-3xl mb-4 red">Link Shortener</h1>
            <form action="/shorten" method="POST" class="space-y-6">
                <div>
                    <label for="url" class="sr-only">URL to shorten</label>
                    <input type="url" id="url" name="url" required
                        class="w-full p-3 border border-gray-300 rounded" placeholder="Enter URL to shorten">
                </div>
                <div>
                    <button type="submit" class="w-full p-3 bg-red-600 text-white rounded">Shorten</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
