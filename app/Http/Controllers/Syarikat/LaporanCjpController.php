<?php

namespace App\Http\Controllers\Syarikat;

use App\Http\Controllers\Controller;
use App\Models\LaporanCjp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LaporanCjpController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $companyName = $request->user()?->nama_syarikat ?: $request->user()?->name;

        $data = $request->validate([
            'negeri' => ['required', 'string', 'max:100'],
            'tahun' => ['required', 'integer', 'between:2000,2100'],
            'bulan' => ['required', 'string', 'max:30'],
            'fail' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $data['nama_syarikat'] = $companyName;

        if ($request->hasFile('fail')) {
            $data['fail_path'] = $request->file('fail')->store('laporan-cjp', 'public');
        }

        LaporanCjp::create([...$data, 'user_id' => $request->user()->id]);

        return to_route('syarikat.senarailaporan')->with('success', 'Laporan berjaya dihantar.');
    }
}
