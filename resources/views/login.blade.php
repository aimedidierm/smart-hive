<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Smart Hive</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-100 flex items-center justify-center h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-green-600 text-center mb-6">🐝 Smart Hive Login</h2>
        @if($errors->any())
        <span style="color: red;">{{$errors->first()}}</span>
        @endif
        <form action="/auth/login" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="email">Email</label>
                <input type="email" id="email" name="email"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
                    placeholder="Enter your email" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2" for="password">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
                    placeholder="Enter your password" required>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="w-full bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600">
                    Login
                </button>
            </div>
        </form>

    </div>

</body>

</html>