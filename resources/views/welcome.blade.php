<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Content Scheduler</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        fadeIn: 'fadeIn 1.2s ease-out forwards',
                        bounceIn: 'bounceIn 0.8s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: 0 },
                            '100%': { opacity: 1 }
                        },
                        bounceIn: {
                            '0%': { transform: 'scale(0.9)', opacity: 0 },
                            '60%': { transform: 'scale(1.05)', opacity: 1 },
                            '100%': { transform: 'scale(1)', opacity: 1 },
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-blue-100 to-white text-gray-800">
    <div class="min-h-screen flex flex-col items-center justify-center text-center p-6 animate-fadeIn">
        <h1 class="text-5xl font-extrabold text-blue-800 mb-4 animate-bounceIn">🚀 Content Scheduler</h1>
        <p class="text-xl text-gray-700 mb-8 max-w-xl">Plan, schedule, and manage your social media content effortlessly across platforms.</p>

        <div class="flex gap-6">
            @auth
                <a href="/admin" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl shadow-lg text-lg transition transform hover:-translate-y-1 hover:scale-105">
                    Admin Dashboard
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-xl shadow-lg text-lg transition transform hover:-translate-y-1 hover:scale-105">
                        Logout
                    </button>
                </form>
            @else
                {{-- <a href="/admin/register"
                   class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl shadow-lg text-lg transition transform hover:-translate-y-1 hover:scale-105">
                    Register
                </a> --}}
                <a href="/admin/login"
                   class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-xl shadow-lg text-lg transition transform hover:-translate-y-1 hover:scale-105">
                    Login
                </a>
            @endauth
        </div>

        <p class="text-sm text-gray-500 mt-10">
            Built with ❤️ using Laravel, Sanctum & Filament
        </p>
    </div>
</body>
</html>
