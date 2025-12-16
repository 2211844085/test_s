<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profile Settings - FundRaiser</title>
    
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <x-alt-navigation />

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Profile Settings</h1>
            <p class="text-gray-600">Manage your account information and preferences.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Settings Navigation -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Settings</h3>
                    <nav class="space-y-2">
                        <button onclick="showSection('profile')" class="w-full text-left px-3 py-2 rounded-lg bg-primary text-white" id="nav-profile">
                            Profile Information
                        </button>
                        <button onclick="showSection('account')" class="w-full text-left px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100" id="nav-account">
                            Account Settings
                        </button>
                        <button onclick="showSection('privacy')" class="w-full text-left px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100" id="nav-privacy">
                            Privacy & Security
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Settings Content -->
            <div class="lg:col-span-3">
                <!-- Profile Information -->
                <div id="section-profile" class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-6">Profile Information</h2>
                    
                    <form class="space-y-6" method="POST" action="/profile-info">
                        @csrf
                        <!-- Basic Information -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input id="email" name="email" type="email" value="{{ auth()->user()->email }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        @error('email')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Account Settings -->
                <div id="section-account" class="hidden bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-6">Account Settings</h2>
                    
                    <form class="space-y-6" action="/account-settings" method="POST">
                        @csrf
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                            <input id="username" name="username" type="text" value="{{ auth()->user()->username }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <p class="text-sm text-gray-500 mt-1">This is your public username on FundRaiser</p>
                        </div>
                        @error('username')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                        
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-medium mb-4">Change Password</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                    <input id="current_password" name="current_password" type="password" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                                @error('current_password')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                    <input id="password" name="password" type="password" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                                @error('password')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                    <input id="password_confirmation" name="password_confirmation" type="password" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                                @error('password_confirmation')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Privacy & Security -->
                <div id="section-privacy" class="hidden bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-6">Privacy & Security</h2>
                        <h3 class="text-lg font-medium mb-4 text-red-600">Danger Zone</h3>
                        <form class="space-y-3" action="/delete-account" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left p-4 border border-red-200 rounded-lg hover:bg-red-50 cursor-pointer">
                                <p class="font-medium text-red-600">Delete your account</p>
                                <p class="text-sm text-red-500">Permanently delete your account and all data</p>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showSection(sectionName) {
            localStorage.setItem('activeSettingsSection', sectionName);

            const sections = ['profile', 'account', 'privacy'];
            sections.forEach(section => {
                document.getElementById(`section-${section}`).classList.add('hidden');
                document.getElementById(`nav-${section}`).className = 'w-full text-left px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100';
            });

            document.getElementById(`section-${sectionName}`).classList.remove('hidden');
            document.getElementById(`nav-${sectionName}`).className = 'w-full text-left px-3 py-2 rounded-lg bg-primary text-white';
        }

        document.addEventListener('DOMContentLoaded', () => {
            const savedSection = localStorage.getItem('activeSettingsSection') || 'profile';
            showSection(savedSection);
        });
    </script>
</body>
</html>