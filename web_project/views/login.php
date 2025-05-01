<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Đăng nhập</title>
  <!-- Link Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center">
  <div class="w-full max-w-6xl mx-auto px-4 py-10">
    <div class="grid md:grid-cols-2 gap-10 items-center">

     <!-- Form đăng nhập -->
<div class="bg-white border border-gray-200 p-12 rounded-lg shadow-md max-w-xl w-full mx-auto">
  <h2 class="text-4xl font-bold text-gray-800 mb-4">Đăng nhập</h2>
  <p class="text-gray-500 text-base mb-6">
    Đăng nhập tài khoản để tiếp tục trải nghiệm mua sách tại BookStore.
  </p>

  <form class="space-y-6">
    <div>
      <label for="username" class="block text-base font-medium text-gray-700 mb-1">Tên đăng nhập</label>
      <input type="text" id="username" name="username" required
        class="w-full px-5 py-4 border border-gray-300 rounded-md text-base focus:outline-none focus:ring-2 focus:ring-blue-500"
        placeholder="Nhập tên đăng nhập">
    </div>

    <div>
      <label for="password" class="block text-base font-medium text-gray-700 mb-1">Mật khẩu</label>
      <input type="password" id="password" name="password" required
        class="w-full px-5 py-4 border border-gray-300 rounded-md text-base focus:outline-none focus:ring-2 focus:ring-blue-500"
        placeholder="Nhập mật khẩu">
    </div>

    <div class="flex items-center justify-between text-sm">
      <label class="flex items-center">
        <input type="checkbox" class="mr-2 rounded border-gray-300 text-blue-600" />
        Ghi nhớ tôi
      </label>
      <a href="#" class="text-blue-600 hover:underline">Quên mật khẩu?</a>
    </div>

    <button type="submit"
      class="w-full bg-blue-600 text-white py-3.5 rounded-md text-base font-semibold hover:bg-blue-700 transition">
      Đăng nhập
    </button>

    <p class="text-center text-base text-gray-500">
      Chưa có tài khoản? <a href="#" class="text-blue-600 hover:underline font-medium">Đăng ký ngay</a>
    </p>
  </form>
</div>


      <!-- Hình minh họa -->
      <div class="hidden md:block">
        <img src="https://readymadeui.com/login-image.webp" alt="Login Illustration" class="w-full h-auto rounded-lg object-cover" />
      </div>
    </div>
  </div>
</body>
</html>
