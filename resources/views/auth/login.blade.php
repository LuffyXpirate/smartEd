<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Login Page - Student Progress Tracker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-indigo-700 to-teal-600 flex items-center justify-center h-screen">

  <div class="login-box w-full max-w-sm p-8 bg-opacity-75 bg-black rounded-lg shadow-xl">
    <div class="text-center mb-6">
      <h1 class="text-3xl text-white font-semibold">SmartEdu</h1>
    </div>

    <div class="card-body">
      <p class="text-center text-white mb-4">Please sign in to access your dashboard</p>

      <!-- Form -->
      <form action="{{ url('login') }}" method="post">
        @csrf
        <div class="mb-4">
          <label for="loginEmail" class="block text-white font-medium">Email</label>
          <input id="loginEmail" type="email" class="w-full p-3 mt-2 rounded-md border border-gray-300 bg-gray-800 text-white focus:ring-2 focus:ring-indigo-500" name="email" placeholder="Enter your email" required>
        </div>

        <div class="mb-4">
          <label for="loginPassword" class="block text-white font-medium">Password</label>
          <input id="loginPassword" type="password" name="password" class="w-full p-3 mt-2 rounded-md border border-gray-300 bg-gray-800 text-white focus:ring-2 focus:ring-indigo-500" placeholder="Enter your password" required>
        </div>

        <div class="flex items-center justify-between mb-6">
          <div class="flex items-center">
            <input class="mr-2" type="checkbox" name="remember" id="flexCheckDefault">
            <label for="flexCheckDefault" class="text-white">Remember Me</label>
          </div>
          <a href="{{ url('forget') }}" class="text-white text-sm hover:underline">Forgot Password?</a>
        </div>

        <div>
          <button type="submit" class="w-full bg-teal-600 text-white py-3 rounded-md font-semibold hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500">
            Sign In
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Tailwind JS and Bootstrap Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
