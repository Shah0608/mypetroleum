<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and avatar.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="flex items-center gap-4">
            <div class="relative h-24 w-24 shrink-0">
                <img
                    src="{{ $user->avatarUrl() }}"
                    alt="Avatar pengguna"
                    class="h-24 w-24 rounded-full border border-gray-200 object-cover shadow-sm"
                >

                <label
                    for="avatar"
                    class="absolute inset-0 flex cursor-pointer items-center justify-center rounded-full bg-black/0 text-center text-xs font-semibold text-white opacity-0 transition hover:bg-black/55 hover:opacity-100"
                >
                    Hover untuk<br>tukar gambar
                </label>
            </div>

            <div class="min-w-0">
                <x-input-label for="avatar" :value="__('Gambar Profil')" />
                <input
                    id="avatar"
                    name="avatar"
                    type="file"
                    accept="image/*"
                    class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-slate-700"
                />
                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                <p class="mt-2 text-sm text-gray-600">Jika tiada gambar dipilih, avatar lalai akan digunakan.</p>
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
