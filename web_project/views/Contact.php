<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liên hệ</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <div class="mt-10 px-4">
    <div class="grid sm:grid-cols-2 items-start gap-16 p-12 mx-auto max-w-6xl bg-white shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] rounded-lg">
      
      <!-- Thông tin liên hệ bên trái -->
      <div>
        <h1 class="text-slate-900 text-4xl font-bold">Liên hệ với chúng tôi</h1>
        <p class="text-base text-slate-500 mt-5 leading-relaxed">
          Bạn có ý tưởng dự án, cần tư vấn hoặc muốn hợp tác? Hãy gửi tin nhắn cho chúng tôi — chúng tôi sẽ phản hồi sớm nhất!
        </p>

        <div class="mt-10">
          <h2 class="text-slate-900 text-lg font-semibold">Email</h2>
          <p class="text-blue-600 font-medium mt-2">info@example.com</p>
        </div>

        <div class="mt-10">
          <h2 class="text-slate-900 text-lg font-semibold">Mạng xã hội</h2>
          <div class="flex space-x-4 mt-3">
            <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" class="h-8 w-8" alt="Facebook"></a>
            <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733579.png" class="h-8 w-8" alt="Twitter"></a>
            <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" class="h-8 w-8" alt="Instagram"></a>
          </div>
        </div>
      </div>

      <!-- Form bên phải -->
      <form class="space-y-5 w-full bg-white">
        <input type="text" name="name" placeholder="Họ và tên" required
          class="w-full rounded-md py-4 px-5 border border-gray-300 text-base text-gray-800 outline-none focus:ring-2 focus:ring-blue-500" />
        <input type="email" name="email" placeholder="Email của bạn" required
          class="w-full rounded-md py-4 px-5 border border-gray-300 text-base text-gray-800 outline-none focus:ring-2 focus:ring-blue-500" />
        <input type="text" name="subject" placeholder="Tiêu đề"
          class="w-full rounded-md py-4 px-5 border border-gray-300 text-base text-gray-800 outline-none focus:ring-2 focus:ring-blue-500" />
        <textarea name="message" rows="6" placeholder="Nội dung tin nhắn" required
          class="w-full rounded-md py-4 px-5 border border-gray-300 text-base text-gray-800 outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
        <button type="submit"
          class="w-full py-3 text-base font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition">
          Gửi tin nhắn
        </button>
      </form>
    </div>
  </div>

</body>
</html>
