<?php

namespace App\Http\Controllers;

use App\Models\Permohonan58A;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class PelulusController extends Controller
{
    /**
     * @return array<string, string>
     */
    private function stationOptions(): array
    {
        return [
            'M10' => 'M10 - Melaka',
            'N10' => 'N10 - Seremban',
            'N11' => 'N11 - Port Dickson',
            'P11' => 'P11 - Georgetown',
            'P13' => 'P13 - Seberang Jaya',
            'R10' => 'R10 - Kangar',
            'S10' => 'S10 - Kota Kinabalu',
            'T10' => 'T10 - Kuala Terengganu',
            'T13' => 'T13 - Kemaman',
            'W10' => 'W10 - Kuala Lumpur',
            'W24' => 'W24 - KLIA CD',
            'A10' => 'A10 - Ipoh',
            'A11' => 'A11 - Taiping',
            'B10' => 'B10 - Port Klang',
            'B16' => 'B16 - Subang (OPA)',
            'C10' => 'C10 - Kuantan',
            'C11' => 'C11 - Bentong',
            'D10' => 'D10 - Kota Bahru',
            'E10' => 'E10 - Labuan',
            'J11' => 'J11 - Batu Pahat',
            'J12' => 'J12 - Kluang',
            'J13' => 'J13 - Muar',
            'J31' => 'J31 - Johor Bahru',
            'K10' => 'K10 - Alor Setar',
            'Y58' => 'Y58 - Bintulu',
            'Y60' => 'Y60 - Kuching',
        ];
    }

    public function users(): mixed
    {
        $query = trim((string) request()->query('q', ''));

        $allPermohonans = Permohonan58A::query()
            ->select(['id', 'user_id', 'nama_syarikat', 'alamat'])
            ->orderBy('created_at')
            ->orderBy('id')
            ->get();

        $penggunas = $allPermohonans
            ->groupBy(function (Permohonan58A $permohonan): string {
                return mb_strtolower(trim((string) $permohonan->nama_syarikat));
            })
            ->map(function ($companyPermohonans): object {
                $firstPermohonan = $companyPermohonans->first();

                return (object) [
                    'nama_syarikat' => $firstPermohonan?->nama_syarikat,
                    'alamat' => $firstPermohonan?->alamat,
                    'bilangan_permohonan' => $companyPermohonans->count(),
                    'first_created_at' => $companyPermohonans->min('created_at'),
                ];
            })
            ->sortBy('first_created_at')
            ->values()
            ->when($query !== '', function ($collection) use ($query) {
                return $collection->filter(function ($company) use ($query): bool {
                    return str_contains(strtolower((string) $company->nama_syarikat), strtolower($query))
                        || str_contains(strtolower((string) $company->alamat), strtolower($query));
                })->values();
            });

        return view('pelulus.senarai-pengguna', compact('penggunas', 'query'));
    }

    public function applications(): mixed
    {
        $query = trim((string) request()->query('q', ''));
        $status = trim((string) request()->query('status', 'semua'));
        $permohonans = $this->filteredApplications($query, $status);

        return view('pelulus.senaraipermohonan', compact('permohonans', 'query', 'status'));
    }

    public function exportApplications(Request $request): Response
    {
        $query = trim((string) $request->query('q', ''));
        $status = trim((string) $request->query('status', 'semua'));
        $permohonans = $this->filteredApplications($query, $status);
        $filename = 'senarai-permohonan-58a-'.now()->format('Ymd-His').'.xls';

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $columns = [
            'Tarikh Permohonan',
            'Negeri',
            'Nama Syarikat',
            'Perihal Barangan',
            'Unit',
            'Kuantiti',
            'Kawasan',
            'Status',
            'No. Sijil Pengecualian',
            'Tarikh Diluluskan',
            'Tarikh Tamat',
            'Jumlah Hari Diluluskan',
            'Indicator',
        ];

        $rows = $permohonans->map(function (Permohonan58A $permohonan): array {
            $barangs = collect($permohonan->barangs);

            return [
                $this->formatDateCell($permohonan->tarikh_permohonan),
                (string) ($permohonan->negeri ?? '-'),
                (string) ($permohonan->nama_syarikat ?? '-'),
                $barangs->pluck('perihal')->filter()->join(', ') ?: '-',
                $barangs->pluck('unit')->filter()->join(', ') ?: '-',
                $barangs->pluck('kuantiti')->filter()->join(', ') ?: '-',
                $barangs->pluck('kawasan')->filter()->join(', ') ?: '-',
                (string) ($permohonan->status ?? '-'),
                (string) ($permohonan->no_sijil_pengecualian ?? '-'),
                $this->formatDateCell($permohonan->tarikh_diluluskan),
                $this->formatDateCell($permohonan->tarikh_tamat),
                $permohonan->status === 'Diluluskan' && $permohonan->tarikh_diluluskan && $permohonan->tarikh_tamat
                    ? $permohonan->tempoh_hari_label
                    : '-',
                $permohonan->status === 'Diluluskan' && $permohonan->tarikh_diluluskan && $permohonan->tarikh_tamat
                    ? $permohonan->tempoh_hari_indicator_label
                    : '-',
            ];
        });

        $output = $this->buildExcelTable($columns, $rows->all(), $query, $status);

        return response($output, 200, $headers);
    }

    public function printApplications(Request $request): Response
    {
        $query = trim((string) $request->query('q', ''));
        $status = trim((string) $request->query('status', 'semua'));
        $statusFilter = $this->normalizeApplicationStatusFilter($status);

        $permohonans = Permohonan58A::with('user')
            ->when($statusFilter !== null, function ($builder) use ($statusFilter): void {
                $builder->where('status', $statusFilter);
            })
            ->when($query !== '', function ($builder) use ($query): void {
                $builder->where(function ($search) use ($query): void {
                    $search->where('nama_syarikat', 'like', '%'.$query.'%')
                        ->orWhere('negeri', 'like', '%'.$query.'%')
                        ->orWhere('status', 'like', '%'.$query.'%')
                        ->orWhere('no_sijil_pengecualian', 'like', '%'.$query.'%')
                        ->orWhere('no_pesanan_belian', 'like', '%'.$query.'%');

                    if (preg_match('/^\d{4}$/', $query) === 1) {
                        $search->orWhereYear('tarikh_permohonan', (int) $query)
                            ->orWhereYear('tarikh_diluluskan', (int) $query);
                    }

                    if (preg_match('/^(0?[1-9]|1[0-2])$/', $query) === 1) {
                        $search->orWhereMonth('tarikh_permohonan', (int) $query)
                            ->orWhereMonth('tarikh_diluluskan', (int) $query);
                    }
                });
            })
            ->when($status === 'semua', function ($builder): void {
                $builder->orderByRaw("CASE status WHEN 'Diluluskan' THEN 1 WHEN 'Dalam tindakan' THEN 2 WHEN 'Tidak diluluskan' THEN 3 ELSE 4 END")
                    ->latest();
            }, function ($builder): void {
                $builder->latest();
            })
            ->get();

        return response()->view('pelulus.senaraipermohonan-print', [
            'permohonans' => $permohonans,
            'query' => $query,
            'status' => $status,
            'selectedStatusLabel' => $this->applicationStatusLabel($status),
        ]);
    }

    public function approvedApplications(): mixed
    {
        return $this->statusApplications('Diluluskan', 'Diluluskan');
    }

    public function pendingApplications(): mixed
    {
        return $this->statusApplications('Dalam tindakan', 'Pending');
    }

    public function failedApplications(): mixed
    {
        return $this->statusApplications('Tidak diluluskan', 'Gagal');
    }

    /**
     * @return View
     */
    private function statusApplications(string $status, string $label): mixed
    {
        $query = trim((string) request()->query('q', ''));

        $permohonans = Permohonan58A::with('user')
            ->where('status', $status)
            ->when($query !== '', function ($builder) use ($query): void {
                $builder->where(function ($search) use ($query): void {
                    $search->where('nama_syarikat', 'like', '%'.$query.'%')
                        ->orWhere('negeri', 'like', '%'.$query.'%')
                        ->orWhere('no_sijil_pengecualian', 'like', '%'.$query.'%')
                        ->orWhere('no_pesanan_belian', 'like', '%'.$query.'%');

                    if (preg_match('/^\d{4}$/', $query) === 1) {
                        $search->orWhereYear('tarikh_permohonan', (int) $query)
                            ->orWhereYear('tarikh_diluluskan', (int) $query);
                    }

                    if (preg_match('/^(0?[1-9]|1[0-2])$/', $query) === 1) {
                        $search->orWhereMonth('tarikh_permohonan', (int) $query)
                            ->orWhereMonth('tarikh_diluluskan', (int) $query);
                    }
                });
            })
            ->latest()
            ->get();

        return view('pelulus.status-permohonan', compact('permohonans', 'query', 'status', 'label'));
    }

    private function normalizeApplicationStatusFilter(string $status): ?string
    {
        return match ($status) {
            'diluluskan' => 'Diluluskan',
            'dalam_tindakan' => 'Dalam tindakan',
            'tidak_diluluskan' => 'Tidak diluluskan',
            default => null,
        };
    }

    private function applicationStatusLabel(string $status): string
    {
        return match ($status) {
            'diluluskan' => 'Diluluskan',
            'dalam_tindakan' => 'Dalam Tindakan',
            'tidak_diluluskan' => 'Tidak Diluluskan',
            default => 'Semua',
        };
    }

    /**
     * @return Collection<int, Permohonan58A>
     */
    private function filteredApplications(string $query, string $status): Collection
    {
        $statusFilter = $this->normalizeApplicationStatusFilter($status);

        return Permohonan58A::with('user')
            ->when($statusFilter !== null, function ($builder) use ($statusFilter): void {
                $builder->where('status', $statusFilter);
            })
            ->when($query !== '', function ($builder) use ($query): void {
                $builder->where(function ($search) use ($query): void {
                    $search->where('nama_syarikat', 'like', '%'.$query.'%')
                        ->orWhere('negeri', 'like', '%'.$query.'%')
                        ->orWhere('status', 'like', '%'.$query.'%')
                        ->orWhere('no_sijil_pengecualian', 'like', '%'.$query.'%')
                        ->orWhere('no_pesanan_belian', 'like', '%'.$query.'%');

                    if (preg_match('/^\d{4}$/', $query) === 1) {
                        $search->orWhereYear('tarikh_permohonan', (int) $query)
                            ->orWhereYear('tarikh_diluluskan', (int) $query);
                    }

                    if (preg_match('/^(0?[1-9]|1[0-2])$/', $query) === 1) {
                        $search->orWhereMonth('tarikh_permohonan', (int) $query)
                            ->orWhereMonth('tarikh_diluluskan', (int) $query);
                    }
                });
            })
            ->latest()
            ->get();
    }

    private function formatDateCell(?Carbon $date): string
    {
        return $date?->format('d/m/Y') ?? '-';
    }

    /**
     * @param  array<int, string>  $columns
     * @param  array<int, array<int, string>>  $rows
     */
    private function buildExcelTable(array $columns, array $rows, string $query, string $status): string
    {
        $html = '<html><head><meta charset="UTF-8"></head><body>';
        $html .= '<table border="1">';
        $html .= '<tr><th colspan="'.count($columns).'">Senarai Permohonan Pengecualian Butiran 58A</th></tr>';
        $html .= '<tr><th colspan="'.count($columns).'">Status: '.$this->applicationStatusLabel($status).($query !== '' ? ' | Carian: '.$query : '').'</th></tr>';
        $html .= '<tr>';

        foreach ($columns as $column) {
            $html .= '<th>'.$this->escapeExcelValue($column).'</th>';
        }

        $html .= '</tr>';

        foreach ($rows as $row) {
            $html .= '<tr>';

            foreach ($row as $cell) {
                $html .= '<td>'.$this->escapeExcelValue($cell).'</td>';
            }

            $html .= '</tr>';
        }

        $html .= '</table></body></html>';

        return $html;
    }

    private function escapeExcelValue(string $value): string
    {
        return e($value);
    }

    public function review(Permohonan58A $permohonan): mixed
    {
        return view('pelulus.semakan-permohonan', compact('permohonan'));
    }

    public function previewApplication(Permohonan58A $permohonan): mixed
    {
        return view('pdf.permohonan-58a', [
            'permohonan' => $permohonan,
            'previewMode' => true,
            'downloadUrl' => route('pelulus.permohonan.pdf', $permohonan),
            'backUrl' => route('pelulus.permohonan.semak', $permohonan),
        ]);
    }

    public function update(Request $request, Permohonan58A $permohonan): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:Dalam tindakan,Diluluskan,Tidak diluluskan'],
            'tarikh_diluluskan' => ['nullable', 'date'],
            'kod_stesen' => ['nullable', 'string', 'in:'.implode(',', array_keys($this->stationOptions()))],
            'no_daftar_sijil' => ['nullable', 'string', 'max:20'],
        ]);

        $wasApproved = $permohonan->status === 'Diluluskan';
        $data['tarikh_tamat'] = $permohonan->tarikh_tamat_cga;
        $data['no_sijil_pengecualian'] = $this->formatCertificateNumber($permohonan, $data);

        if (! $wasApproved && $data['status'] === 'Diluluskan') {
            $data['jkdm_notified_at'] = null;
        }

        unset($data['kod_stesen'], $data['no_daftar_sijil']);
        $permohonan->update($data);

        return to_route('pelulus.senaraipermohonan')->with('success', 'Keputusan berjaya disimpan.');
    }

    public function printApplication(Permohonan58A $permohonan): Response
    {
        return Pdf::loadView('pdf.permohonan-58a', [
            'permohonan' => $permohonan,
        ])->setPaper('a4')->download('permohonan-58a-'.$permohonan->id.'.pdf');
    }

    /**
     * @param  array{tarikh_diluluskan?: string|null, kod_stesen?: string|null, no_daftar_sijil?: string|null}  $data
     */
    private function formatCertificateNumber(Permohonan58A $permohonan, array $data): ?string
    {
        if (blank($data['kod_stesen'] ?? null) && blank($data['no_daftar_sijil'] ?? null)) {
            return $permohonan->no_sijil_pengecualian;
        }

        $yearMonth = filled($data['tarikh_diluluskan'] ?? null)
            ? date('ym', strtotime((string) $data['tarikh_diluluskan']))
            : now()->format('ym');

        $registrationNumber = filled($data['no_daftar_sijil'] ?? null)
            ? str_pad((string) $data['no_daftar_sijil'], 4, '0', STR_PAD_LEFT)
            : str_pad((string) $permohonan->id, 4, '0', STR_PAD_LEFT);

        return strtoupper((string) $data['kod_stesen']).'-58A-'.$yearMonth.'-'.$registrationNumber;
    }
}
