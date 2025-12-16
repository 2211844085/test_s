<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - FundRaiser</title>
    
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center py-12">
    <div class="max-w-md w-full space-y-8 p-8">
        <div class="text-center">
            <a href="/" class="text-3xl font-bold text-primary">FundRaiser</a>
            <h2 class="mt-6 text-3xl font-bold text-gray-900">Create your account</h2>
            <p class="mt-2 text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="font-medium text-primary hover:text-blue-500">Sign in</a>
            </p>
        </div>
        
        <form class="mt-8 space-y-6" action="/register" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input id="username" name="username" type="text" required 
                            class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-primary focus:border-primary sm:text-sm" 
                            placeholder="Username">
                </div>
                @error('username')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <input id="email" name="email" type="email" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-primary focus:border-primary sm:text-sm" 
                           placeholder="Enter your email">
                </div>
                @error('email')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-primary focus:border-primary sm:text-sm" 
                           placeholder="Create a password">
                </div>
                @error('password')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-primary focus:border-primary sm:text-sm" 
                           placeholder="Confirm your password">
                </div>
                @error('password_confirmation')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
                
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">I want to</label>
                    <select id="role" name="role" required 
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-lg focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                            onchange="handleRoleSelect(this)">
                        <option value="">Select your role</option>
                        <option value="backer">Support projects (Backer)</option>
                        <option value="creator">Create projects (Creator)</option>
                    </select>
                </div>
                @error('role')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div id="creator-fields" class="grid grid-cols-2 gap-4 hidden">
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input id="phone" name="phone" type="tel" 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-primary focus:border-primary sm:text-sm" 
                           placeholder="Phone Number">
                </div>
                @error('phone')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror

                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                    <input id="company_name" name="company_name" type="text" 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-primary focus:border-primary sm:text-sm" 
                           placeholder="Enter Your Company Name">
                </div>
                @error('company_name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                    Create Account
                </button>
            </div>
        </form>
    </div>

    <script>
        const fields = document.getElementById("creator-fields");

        function showCreator() {    
            fields.classList.toggle('hidden', false);
        }
        function hideCreator() {
            fields.classList.toggle('hidden', true);
        }

        function handleRoleSelect(element) {
            const selected = element.value;
            if (selected == "creator") showCreator();
            else hideCreator();
        }
    </script>
</body>
</html>