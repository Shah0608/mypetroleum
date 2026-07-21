<x-role-dashboard-layout
    role="admin"
    title="{{ isset($user) ? 'KEMASKINI PENGGUNA' : 'TAMBAH PENGGUNA' }}"
    subtitle="Borang pengguna sistem MyPetroleum."
    :nav-items="[
        ['label' => 'UTAMA', 'url' => route('admin.utama'), 'active' => '/admin/utama'],
        ['label' => 'URUS PENGGUNA', 'url' => route('admin.uruspengguna'), 'active' => '/admin/uruspengguna'],
        ['label' => 'TAMBAH PENGGUNA', 'url' => route('admin.tambahpengguna'), 'active' => '/admin/tambahpengguna'],
        ['label' => 'SENARAI LAPORAN', 'url' => route('admin.senarailaporan'), 'active' => '/admin/senarailaporan'],
        ['label' => 'SENARAI PERMOHONAN', 'url' => route('admin.senaraipermohonan'), 'active' => '/admin/senaraipermohonan'],
    ]"
>
    <div class="rounded-2xl bg-white/95 p-6 shadow-lg shadow-slate-950/10">
        @php($isEdit = isset($user))

        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                Sila semak semula maklumat pengguna.
            </div>
        @endif

        <form action="{{ $isEdit ? route('admin.pengguna.update', $user) : route('admin.pengguna.store') }}" method="POST" class="space-y-5">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <label class="block">
                <span class="text-sm font-semibold text-slate-700">Nama</span>
                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none" required>
                @error('name')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
            </label>

            <label class="block">
                <span class="text-sm font-semibold text-slate-700">Login ID</span>
                <input type="text" name="login_id" value="{{ old('login_id', $user->login_id ?? '') }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none" required>
                @error('login_id')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
            </label>

            <label class="block">
                <span class="text-sm font-semibold text-slate-700">Role</span>
                <select name="role" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none" required>
                    @foreach(['syarikat' => 'Syarikat', 'jkdm' => 'JKDM', 'admin' => 'Admin'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('role', $user->role ?? '') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('role')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
            </label>

            <div class="grid gap-5 md:grid-cols-2">
                <label class="block">
                    <span class="text-sm font-semibold text-slate-700">Kata Laluan {{ $isEdit ? '(biarkan kosong jika tidak mahu tukar)' : '' }}</span>
                    <input type="password" name="password" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none" @required(!$isEdit)>
                    @error('password')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
                </label>
                <label class="block">
                    <span class="text-sm font-semibold text-slate-700">Sahkan Kata Laluan</span>
                    <input type="password" name="password_confirmation" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none" @required(!$isEdit)>
                </label>
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit" class="rounded-lg bg-emerald-600 px-8 py-2.5 font-semibold text-white shadow hover:bg-emerald-700">{{ $isEdit ? 'Kemaskini' : 'Tambah' }}</button>
                <a href="{{ route('admin.uruspengguna') }}" class="rounded-lg bg-blue-500 px-8 py-2.5 font-semibold text-white shadow hover:bg-blue-600">Kembali</a>
            </div>
        </form>
    </div>
</x-role-dashboard-layout>
