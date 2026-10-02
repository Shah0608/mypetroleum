<?php

namespace App\Http\Controllers\Syarikat;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLaporanCjpRequest;
use App\Models\LaporanCjp;
use App\Models\Permohonan58A;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class LaporanCjpController extends Controller
{
    public function create(): mixed
    {
        $permohonans = Permohonan58A::query()
            ->where('user_id', auth()->id())
            ->where('status', 'Diluluskan')
            ->whereNotNull('no_sijil_pengecualian')
            ->whereNotNull('tarikh_diluluskan')
            ->whereNotNull('tarikh_tamat')
            ->latest('tarikh_diluluskan')
            ->get()
            ->filter(fn (Permohonan58A $permohonan): bool => filled($permohonan->barangs))
            ->values();

        return view('syarikat.laporan-cj', compact('permohonans'));
    }

    public function store(StoreLaporanCjpRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $permohonan = Permohonan58A::query()
            ->where('user_id', $request->user()->id)
            ->where('status', 'Diluluskan')
            ->whereNotNull('no_sijil_pengecualian')
            ->findOrFail($data['permohonan_58a_id']);

        $barang = $permohonan->barangs[$data['barang_index']] ?? null;
        abort_if(! is_array($barang), 422, 'Barang yang dipilih tidak sah.');

        $pembelians = $this->filledRows($data['pembelians'] ?? []);
        $penjualans = $this->filledRows($data['penjualans'] ?? []);
        $kuantitiDiluluskan = (float) ($barang['kuantiti'] ?? 0);
        $jumlahPembelian = $this->sumQuantity($pembelians);
        $jumlahPenjualan = $this->sumQuantity($penjualans);
        $bakiAwal = (float) ($data['baki_awal'] ?? 0);

        LaporanCjp::create([
            'user_id' => $request->user()->id,
            'permohonan_58a_id' => $permohonan->id,
            'negeri' => $data['negeri'],
            'nama_syarikat' => $permohonan->nama_syarikat,
            'tahun' => $data['tahun'],
            'bulan' => $data['bulan'],
            'no_sijil_pengecualian' => $permohonan->no_sijil_pengecualian,
            'tarikh_sah_laku_sijil' => $permohonan->tarikh_diluluskan,
            'tarikh_tamat_sijil' => $permohonan->tarikh_tamat,
            'pembekal_nama' => $permohonan->pembekal_nama,
            'kod_tarif_barang' => $barang['kod_tarif'] ?? null,
            'perihal_barang' => $barang['perihal'] ?? null,
            'unit' => $barang['unit'] ?? 'Ltr',
            'kuantiti_diluluskan' => $kuantitiDiluluskan,
            'baki_kuantiti_diluluskan' => max(0, $kuantitiDiluluskan - $jumlahPembelian),
            'baki_awal' => $bakiAwal,
            'baki_akhir' => $bakiAwal + $jumlahPembelian - $jumlahPenjualan,
            'pembelians' => $pembelians,
            'penjualans' => $penjualans,
            'nama_penuh' => $data['nama_penuh'],
            'jawatan' => $data['jawatan'],
            'no_telefon' => $data['no_telefon'],
        ]);

        return to_route('syarikat.senarailaporan')->with('success', 'Laporan berjaya dihantar.');
    }

    public function preview(LaporanCjp $laporan): mixed
    {
        abort_unless((int) $laporan->user_id === (int) auth()->id(), 403);

        return view('pdf.laporan-cjp', ['laporan' => $laporan, 'previewMode' => true]);
    }

    public function print(LaporanCjp $laporan): Response
    {
        abort_unless((int) $laporan->user_id === (int) auth()->id(), 403);

        return response()->view('pdf.laporan-cjp', ['laporan' => $laporan, 'printMode' => true]);
    }

    /**
     * @param  array<int, array<string, mixed>>  $rows
     * @return array<int, array<string, mixed>>
     */
    private function filledRows(array $rows): array
    {
        return collect($rows)
            ->filter(fn (array $row): bool => collect($row)->filter(fn ($value): bool => filled($value))->isNotEmpty())
            ->values()
            ->all();
    }

    /**
     * @param  array<int, array<string, mixed>>  $rows
     */
    private function sumQuantity(array $rows): float
    {
        return (float) collect($rows)->sum(fn (array $row): float => (float) ($row['kuantiti'] ?? 0));
    }
}
