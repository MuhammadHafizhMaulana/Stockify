<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  @vite('resources/css/app.css')
</head>
<body class="h-full bg-gray-900 flex items-center justify-center">
  <div class="w-full max-w-md p-6 bg-white rounded-lg shadow dark:bg-gray-800 dark:border dark:border-gray-700">
    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white text-center">
      Login
    </h1>
    <form class="space-y-4 md:space-y-6 mt-6" action="{{ route('login') }}" method="POST">
        @csrf
      <div>
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
        <input type="email" id="email" class="block w-full p-2.5 rounded-lg border border-gray-300 bg-gray-50 text-gray-900 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500" name="email" required>
        @error('email') <div class="error">{{ $message }}</div> @enderror
      </div>
      <div>
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
        <input type="password" id="password" class="block w-full p-2.5 rounded-lg border border-gray-300 bg-gray-50 text-gray-900 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500" name="password" required>
        @error('password') <div class="error">{{ $message }}</div> @enderror
      </div>
      <button type="submit" class="w-full px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        Login
      </button>
      <p class="text-sm font-light text-gray-500 dark:text-gray-400 text-center">
        Dont have an account?
        <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-400">Register here</a>
      </p>
    </form>
    <a href="{{ route('home') }}" class=" font-light text-gray-500 dark:text-gray-400 hover:underline block mt-4 text-center text-sm">&laquo; Back to Home</a>
  </div>
</body>
</html>

