<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900">
    <!-- Primary Navigation Menu -->
    @php
        $user = Auth::user();
        $homeRoute = match ($user?->role) {
            'admin' => 'admin.utama',
            'jkdm' => 'jkdm.utama',
            default => 'syarikat.utama',
        };
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Top row: logo and settings -->
        <div class="flex items-center justify-between gap-4 py-3">
            <div class="shrink-0 flex items-center">
                <a href="{{ route($homeRoute) }}">
                    <x-application-logo class="block h-6 w-auto fill-current text-gray-800 dark:text-gray-100" />
                </a>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden items-center gap-3 sm:flex sm:ms-6">
                <button
                    type="button"
                    data-theme-toggle
                    class="inline-flex items-center gap-2 rounded-full bg-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-white shadow-md transition hover:bg-slate-600"
                    aria-label="Tukar mod tema"
                >
                    <span data-theme-icon>☀</span>
                    <span data-theme-label>Light</span>
                </button>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:text-white">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Navigation Links Below Logo -->
        <div class="border-t border-gray-100 dark:border-slate-800">
            <div class="py-2">
                <div class="w-full flex items-center justify-start space-x-8">
                    <x-nav-link :href="route($homeRoute)" :active="request()->routeIs('admin.utama', 'jkdm.utama', 'syarikat.utama')">
                        {{ __('Utama') }}
                    </x-nav-link>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route($homeRoute)" :active="request()->routeIs('admin.utama', 'jkdm.utama', 'syarikat.utama')">
                {{ __('Utama') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="border-t border-gray-200 pt-4 pb-1 dark:border-slate-800">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-100">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1 px-4">
                <button
                    type="button"
                    data-theme-toggle-mobile
                    class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-white shadow-md transition hover:bg-slate-600"
                    aria-label="Tukar mod tema"
                >
                    <span data-theme-icon-mobile>☀</span>
                    <span data-theme-label-mobile>Light</span>
                </button>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    (() => {
        const storageKey = 'mypetroleum-theme';
        const toggle = document.querySelector('[data-theme-toggle]');
        const mobileToggle = document.querySelector('[data-theme-toggle-mobile]');
        const icon = document.querySelector('[data-theme-icon]');
        const mobileIcon = document.querySelector('[data-theme-icon-mobile]');
        const label = document.querySelector('[data-theme-label]');
        const mobileLabel = document.querySelector('[data-theme-label-mobile]');

        const sync = () => {
            const isDark = document.documentElement.classList.contains('dark');
            if (icon) {
                icon.textContent = isDark ? '☾' : '☀';
            }
            if (mobileIcon) {
                mobileIcon.textContent = isDark ? '☾' : '☀';
            }
            if (label) {
                label.textContent = isDark ? 'Dark' : 'Light';
            }
            if (mobileLabel) {
                mobileLabel.textContent = isDark ? 'Dark' : 'Light';
            }
        };

        const toggleTheme = () => {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem(storageKey, isDark ? 'dark' : 'light');
            sync();
        };

        if (toggle) {
            toggle.addEventListener('click', toggleTheme);
        }

        if (mobileToggle) {
            mobileToggle.addEventListener('click', toggleTheme);
        }

        sync();
    })();
</script>
