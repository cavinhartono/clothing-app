<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style/output.css">
  <title>Register | Clothing Shop</title>
</head>

<body class="bg-gray-200 flex justify-center items-center min-h-screen">
  <form action="../algoritma/auth/Register.php" method="POST" class="w-[400px] py-12 px-8 rounded-md bg-white shadow-sm">
    <h1 class="font-serif text-2xl text-black">Create an Account</h1>
    <div class="relative w-full mt-10 mb-6">
      <input type="text" id="email" name="email" class="peer w-full px-3 py-2 border placeholder:text-transparent" placeholder="Email">
      <label for="email" class="absolute left-0 ml-1 -translate-y-6 text-sm duration-100 ease-linear peer-placeholder-shown:translate-y-2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:-translate-y-6 peer-focus:text-sm">Email</label>
    </div>
    <div class="relative w-full my-6">
      <input type="text" id="name" name="name" class="peer w-full px-3 py-2 border placeholder:text-transparent" placeholder="Name">
      <label for="name" class="absolute left-0 ml-1 -translate-y-6 text-sm duration-100 ease-linear peer-placeholder-shown:translate-y-2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:-translate-y-6 peer-focus:text-sm">Name</label>
    </div>
    <div class="relative w-full my-6">
      <input id="password" type="password" name="password" class="peer w-full px-3 py-2 border placeholder:text-transparent" placeholder="Password">
      <label for="password" class="absolute left-0 ml-1 -translate-y-6 text-sm duration-100 ease-linear peer-placeholder-shown:translate-y-2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:-translate-y-6 peer-focus:text-sm">Password</label>
    </div>
    <div class="relative w-full my-6">
      <input type="text" name="address" id="address" class="peer w-full px-3 py-2 border placeholder:text-transparent" placeholder="Address" />
      <label for="address" class="absolute left-0 ml-1 -translate-y-6 text-sm duration-100 ease-linear peer-placeholder-shown:translate-y-2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:-translate-y-6 peer-focus:text-sm">Address</label>
    </div>
    <button type="submit" name="submit" class="bg-blue-500 w-full py-2 text-md text-white rounded-sm">Continue</button>
    <p class="my-4 text-sm">Do you have account? <a href="./login.php" class="text-blue-500">Login</a>.</p>
  </form>
</body>

</html>