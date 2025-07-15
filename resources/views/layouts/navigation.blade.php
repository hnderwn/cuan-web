<div x-data="{ dropdownOpen: false }" class="relative">
    <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 relative focus:outline-none">
        <h2 class="text-white text-sm font-semibold">{{ Auth::user()->name }}</h2>
        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </button>

    <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition class="absolute right-0 mt-2 w-48 bg-white text-grey-700 rounded-md overflow-hidden shadow-xl z-10" style="display: none;">
        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-grey-700 hover:bg-brand-darkest hover:text-white">Profile</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}"
                class="block px-4 py-2 text-sm text-grey-700 hover:bg-brand-darkest hover:text-gray-200"
                onclick="event.preventDefault(); this.closest('form').submit();">
                Log Out
            </a>
        </form>
    </div>
</div>