<?php

namespace App\Http\Controllers\Syarikat;

use App\Http\Controllers\Controller;
use App\Models\Permohonan58A;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Permohonan58AController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:syarikat');
    }

    public function create()
    {
        return view('syarikat.permohonan-58a');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'nullable|string|max:255',
            'no_telefon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'no_kp' => 'nullable|string|max:50',
            'jawatan' => 'nullable|string|max:255',
            'nama_syarikat' => 'nullable|string|max:255',
            'no_pendaftaran_cukai' => 'nullable|string|max:255',
            'tarikh_permohonan' => 'nullable|date',
            'no_kelulusan' => 'nullable|string|max:255',
            'no_pesanan_belian' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'negeri' => 'nullable|string|max:255',

            'tandatangan_nama' => 'nullable|string|max:255',
            'tandatangan_no_kp' => 'nullable|string|max:50',
            'tandatangan_jawatan' => 'nullable|string|max:255',

            'pembekal_nama' => 'nullable|string|max:255',
            'pembekal_alamat' => 'nullable|string',

            // items arrays are optional
            'kod_tarif' => 'array',
            'kod_tarif.*' => 'nullable|string',
            'perihal_barang' => 'array',
            'perihal_barang.*' => 'nullable|string',
            'unit' => 'array',
            'unit.*' => 'nullable|string',
            'deskripsi' => 'array',
            'deskripsi.*' => 'nullable|string',
            'kuantiti' => 'array',
            'kuantiti.*' => 'nullable|numeric',
            'nilai' => 'array',
            'nilai.*' => 'nullable|numeric',
            'kawasan' => 'array',
            'kawasan.*' => 'nullable|string',

            'attachments.*' => 'nullable|file|max:5120',
        ]);

        // build items
        $barangs = [];
        $kod_tarifs = $request->input('kod_tarif', []);
        foreach ($kod_tarifs as $i => $kod) {
            if (empty($kod) && empty($request->input('perihal_barang')[$i] ?? null)) {
                continue;
            }

            $barangs[] = [
                'kod_tarif' => $kod,
                'perihal' => $request->input('perihal_barang')[$i] ?? null,
                'unit' => $request->input('unit')[$i] ?? null,
                'deskripsi' => $request->input('deskripsi')[$i] ?? null,
                'kuantiti' => $request->input('kuantiti')[$i] ?? null,
                'nilai' => $request->input('nilai')[$i] ?? null,
                'kawasan' => $request->input('kawasan')[$i] ?? null,
            ];
        }

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('permohonan58a', 'public');
                    $attachments[] = $path;
                }
            }
        }

        $permohonan = Permohonan58A::create([
            'user_id' => $request->user()->id,
            'nama' => $request->input('nama'),
            'no_telefon' => $request->input('no_telefon'),
            'email' => $request->input('email'),
            'no_kp' => $request->input('no_kp'),
            'jawatan' => $request->input('jawatan'),
            'nama_syarikat' => $request->input('nama_syarikat'),
            'no_pendaftaran_cukai' => $request->input('no_pendaftaran_cukai'),
            'tarikh_permohonan' => $request->input('tarikh_permohonan'),
            'no_kelulusan' => $request->input('no_kelulusan'),
            'no_pesanan_belian' => $request->input('no_pesanan_belian'),
            'alamat' => $request->input('alamat'),
            'negeri' => $request->input('negeri'),

            'tandatangan_nama' => $request->input('tandatangan_nama'),
            'tandatangan_no_kp' => $request->input('tandatangan_no_kp'),
            'tandatangan_jawatan' => $request->input('tandatangan_jawatan'),

            'pembekal_nama' => $request->input('pembekal_nama'),
            'pembekal_alamat' => $request->input('pembekal_alamat'),

            'barangs' => $barangs,
            'attachments' => $attachments,
        ]);

        return redirect()->route('syarikat.senaraipermohonan')->with('success', 'Permohonan berjaya disimpan.');
    }

    public function index(Request $request)
    {
        $query = trim((string) $request->query('q', ''));

        $permohonans = Permohonan58A::where('user_id', $request->user()->id)
            ->when($query !== '', function ($builder) use ($query) {
                $builder->where(function ($search) use ($query) {
                    $search->where('nama_syarikat', 'like', '%'.$query.'%')
                        ->orWhere('negeri', 'like', '%'.$query.'%')
                        ->orWhere('status', 'like', '%'.$query.'%')
                        ->orWhere('no_sijil_pengecualian', 'like', '%'.$query.'%');

                    if (preg_match('/^\d{4}$/', $query) === 1) {
                        $search->orWhereYear('tarikh_permohonan', (int) $query);
                    }

                    if (preg_match('/^(0?[1-9]|1[0-2])$/', $query) === 1) {
                        $search->orWhereMonth('tarikh_permohonan', (int) $query);
                    }
                });
            })
            ->latest()
            ->get();

        return view('syarikat.senaraipermohonan', compact('permohonans'));
    }

    public function downloadAttachment($id, $index = 0)
    {
        $perm = Permohonan58A::findOrFail($id);
        abort_unless((int) $perm->user_id === auth()->id(), 403);

        $attachments = $perm->attachments ?? [];
        if (! isset($attachments[$index])) {
            abort(404);
        }
        $path = $attachments[$index];

        return Storage::disk('public')->download($path);
    }
}
