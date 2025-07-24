<div x-data="{ dropdownOpen: false }" class="relative">
    <button @click="dropdownOpen = !dropdownOpen"
        class="flex items-center space-x-2 relative focus:outline-none p-2 group
                   transition duration-200 ease-in-out
                   hover:rounded-lg hover:text-brand-dark
                   hover:scale-[1.05] transform hover:-translate-y-0.5 
                   active:bg-brand-dark active:rounded-lg">
        <h2 class="text-brand-darkest text-sm font-semibold group-active:text-white">{{ Auth::user()->name }}</h2>
        <svg class="h-5 w-5 text-brand-darkest transition-transform duration-200 group-active:text-white"
            :class="{ 'rotate-180': dropdownOpen }"
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </button>

    <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition
        class="absolute right-0 mt-2 w-48 bg-white text-gray-700 rounded-lg overflow-hidden shadow-xl z-10 border border-brand-dark"
        style="display: none;">
        <a href="{{ route('profile.edit') }}"
            class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-dark hover:text-white
                  transition duration-150 ease-in-out">Profile</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-dark hover:text-white
                      transition duration-150 ease-in-out"
                onclick="event.preventDefault(); this.closest('form').submit();">
                Log Out
            </a>
        </form>
    </div>
</div>