<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Socialite application</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        tailwind.config = {
            mode: 'jit'
        }
    </script>
</head>
<body class="antialiased">
    <div class="h-screen grid place-items-center content-center">
        @if (config('services.google.client_id'))
            <a href="auth/google" class="bg-[#50c7c7] text-white px-4 py-4 mt-2 flex rounded-full">
                <i class="fa-brands fa-google mt-1"></i>
                <span class="inline-block ml-[4px]">Login with Google</span>
            </a>
        @endif
        @if (config('services.facebook.client_id'))
            <a href="auth/facebook" class="bg-[#3b5998] text-white px-4 py-4 mt-2 flex rounded-full">
                <i class="fa-brands fa-facebook mt-1"></i>
                <span class="inline-block ml-[4px]">Login with Facebook</span>
            </a>
        @endif
        @if (config('services.twitter.client_id'))
            <a href="auth/twitter" class="bg-[#00acee] text-white px-4 py-4 mt-2 flex rounded-full">
                <i class="fa-brands fa-twitter mt-1"></i>
                <span class="inline-block ml-[4px]">Login with Twitters</span>
            </a>
        @endif
        @if (config('services.tiktok.client_id'))
            <a href="auth/tiktok" class="bg-[#ff0050] text-white px-4 py-4 mt-2 flex rounded-full">
                <i class="fa-brands fa-tiktok mt-1"></i>
                <span class="inline-block ml-[4px]">Login with Tiktok</span>
            </a>
        @endif
    </div>
</body>
</html>
