<?php

use Laravolt\Avatar\Facade as Avatar;

?>
<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-primary">FundRaiser</a>
                @auth
                    @if (auth()->user()->role == 'admin')
                        <span class="ml-4 bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Admin</span>
                    @endif
                @endauth
            </div>
            <div class="hidden md:flex items-center space-x-8">
                {{ $slot }}
            </div>
            <div class="flex items-center space-x-4">
                @auth
                    <div class="relative">
                        <button onclick="toggleUserMenu()" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition-colors">
                            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->username }}&background=random" alt="Profile" class="w-8 h-8 rounded-full">
                            <span>{{ auth()->user()->username }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2">
                            <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile Settings</a>
                            <a href="{{ route('notifs') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Notifications</a>
                            @if (auth()->user()->role == 'backer')
                                <a href="{{ route('backer') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                                <a href="{{ route('contributions') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">My Contributions</a>
                            @elseif (auth()->user()->role == 'admin')
                                <a href="{{ route('admin') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                                <a href="{{ route('create-admin') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Create Admin</a>
                            @else
                                <a href="{{ route('creator') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                                <a href="{{ route('my-projects') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">My Projects</a>
                                <a href="{{ route('analytics') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">View Analytics</a>
                            @endif
                            <hr class="my-2">
                            <a href="{{ route('logout') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Sign Out</a>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">Sign Up</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
<script>
    function toggleUserMenu() {
        const menu = document.getElementById('userMenu');
        menu.classList.toggle('hidden');
    }

    document.addEventListener('click', function(event) {
        const menu = document.getElementById('userMenu');
        const button = event.target.closest('button');
        if (!button || !button.onclick || button.onclick.toString().indexOf('toggleUserMenu') === -1) {
            menu.classList.add('hidden');
        }
    });
</script>