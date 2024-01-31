<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style/output.css">
  <title>Change Password</title>
</head>

<body class="h-screen flex justify-center items-center bg-[#f5f5f5]">
  <main class="relative w-full p-[100px]">
    <header class="fixed top-0 left-0 w-full px-32 py-10 flex justify-between items-center shadow-none transition-all -translate-y-0 z-10">
      <a href="./edit_profile.php" class="relative flex gap-2 items-center">
        <span class="w-4 h-4">
          <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
            <polyline points="244 400 100 256 244 112" style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:48px" />
            <line x1="120" y1="256" x2="412" y2="256" style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:48px" />
          </svg>
        </span>
        Back
      </a>
      <a href="./cart.php" class="relative flex gap-2 items-center">
        Cart
        <span class="w-4 h-4">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M4.00488 16V4H2.00488V2H5.00488C5.55717 2 6.00488 2.44772 6.00488 3V15H18.4433L20.4433 7H8.00488V5H21.7241C22.2764 5 22.7241 5.44772 22.7241 6C22.7241 6.08176 22.7141 6.16322 22.6942 6.24254L20.1942 16.2425C20.083 16.6877 19.683 17 19.2241 17H5.00488C4.4526 17 4.00488 16.5523 4.00488 16ZM6.00488 23C4.90031 23 4.00488 22.1046 4.00488 21C4.00488 19.8954 4.90031 19 6.00488 19C7.10945 19 8.00488 19.8954 8.00488 21C8.00488 22.1046 7.10945 23 6.00488 23ZM18.0049 23C16.9003 23 16.0049 22.1046 16.0049 21C16.0049 19.8954 16.9003 19 18.0049 19C19.1095 19 20.0049 19.8954 20.0049 21C20.0049 22.1046 19.1095 23 18.0049 23Z"></path>
          </svg>
        </span>
      </a>
    </header>
    <form action="../algoritma/auth/ChangePassword.php" method="POST" class="p-8 bg-white shadow-md">
      <h1 class="font-serif text-2xl text-black">Change Password</h1>
      <div class="relative w-full mt-10 mb-6">
        <input type="password" name="password" id="password" placeholder="Password" required class="peer w-full px-3 py-2 border placeholder:text-transparent">
        <label for="password" class="absolute left-0 ml-1 -translate-y-6 text-sm duration-100 ease-linear peer-placeholder-shown:translate-y-2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:-translate-y-6 peer-focus:text-sm">Password</label>
      </div>
      <button type="submit" class="bg-blue-500 w-full py-2 text-md text-white rounded-sm">Continue</button>
    </form>
  </main>
</body>

</html>