<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tailwind Login Template by David Grzyb</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <link href="css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .body-bg {
            background-color: #0067FF;
            background-image: linear-gradient(-315deg, #0067FF 0%, #008FFD 30%);
        }
    </style>
</head>

<body class="body-bg min-h-screen pt-12 md:pt-20 pb-6 px-2 md:px-0" style="font-family:'Arial',sans-serif;">
    <header class="max-w-lg mx-auto">
        <a href="#">
            <h1 class="text-4xl font-bold text-white text-center">LOGIN</h1>
        </a>
    </header>

    <main class="bg-white max-w-lg mx-auto p-8 md:p-12 my-10 rounded-xl shadow-2xl">
        <section>
            <h3 class="font-bold text-2xl">Welcome to Admin</h3>
            <p class="text-gray-600 pt-2">Sign in to your account.</p>
        </section>

        <section class="mt-10">
            <form class="flex flex-col" method="POST" action="/api/login">
                {{ csrf_field() }}
                <div class="mb-6 pt-3 rounded bg-gray-200" style="background-color: #f4f7ff;">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="email">Email</label>
                    <input type="text" name="email" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-200 focus:border-blue-600 transition duration-500 px-3 pb-3" style="background-color: #f4f7ff;">
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200" style="background-color: #f4f7ff;" style="background-color: #f4f7ff;">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="password">Password</label>
                    <input type="password" name="password" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-200 focus:border-blue-600 transition duration-500 px-3 pb-3" style="background-color: #f4f7ff;">
                </div>
                <div class="flex justify-end">
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 hover:underline mb-6">Forgot your password?</a>
                </div>
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded shadow-lg hover:shadow-xl transition duration-200" type="submit">Sign In</button>
            </form>
        </section>
    </main>


</body>

</html>