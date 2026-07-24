<x-guest-layout>
    <div class="space-y-8">
        <div class="text-center">
            <div class="mx-auto flex flex-wrap items-center justify-center gap-6">
                <img src="{{ asset('images/kastam-diraja-malaysia-seeklogo.png') }}" alt="Kastam Diraja Malaysia" class="h-20 w-auto object-contain" />
                <img src="{{ asset('images/logo_mypetroleum-removebg-preview.png') }}" alt="MyPetroleum" class="h-24 w-auto object-contain" />
            </div>

            <div class="mt-6">
                <h1 class="text-2xl font-semibold tracking-tight text-slate-900 sm:text-3xl">MyPetroleum JKDM</h1>
                <p class="mt-2 text-sm text-slate-500">Sistem Maklumat Bunker Petroleum</p>
            </div>
        </div>

        <div class="rounded-[28px] border border-slate-200 bg-slate-50 p-6 shadow-sm shadow-slate-900/5">
            <div class="text-center">
                <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">
                    <span class="text-lg">🔒</span>
                    Log Masuk
                </span>
            </div>

            <x-auth-session-status class="mt-6" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
                @csrf

                <div>
                    <x-input-label for="login_id" :value="__('ID Pengguna')" />
                    <x-text-input id="login_id" class="mt-1 block w-full" type="text" name="login_id" :value="old('login_id')" required autofocus />
                    <x-input-error :messages="$errors->get('login_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Kata Laluan')" />
                    <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="user_type" :value="__('Pengguna')" />
                    <select id="user_type" name="user_type" class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm outline-none ring-1 ring-slate-200 transition focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20">
                        <option value="syarikat">SYARIKAT/PEMILIK</option>
                        <option value="jkdm">PEGAWAI JKDM</option>
                        <option value="pelulus">PELULUS</option>
                        <option value="admin">ADMIN</option>
                    </select>
                </div>

                <div>
                    <x-primary-button class="w-full rounded-xl bg-amber-400 px-4 py-2 text-slate-900 hover:bg-amber-500 focus:ring-amber-500">
                        {{ __('Log Masuk') }}
                    </x-primary-button>
                </div>

                @php
                    $returnUrl = url()->previous();
                    if (blank($returnUrl) || $returnUrl === route('login')) {
                        $returnUrl = url('/');
                    }
                @endphp

                <div>
                    <a href="{{ $returnUrl }}" class="flex w-full items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                        Return
                    </a>
                </div>
            </form>
        </div>

        <p class="text-center text-sm leading-6 text-slate-500">
            Sistem Maklumat Pembekal Kapal Petroleum<br>
            Jabatan Kastam Diraja Malaysia. Melaka
        </p>
    </div>
</x-guest-layout>
