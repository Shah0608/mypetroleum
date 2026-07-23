<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermohonan58ARequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to this request.
     *
     * @return array<string, array<int, string>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'no_telefon' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'no_kp' => ['required', 'string', 'max:50'],
            'jawatan' => ['required', 'string', 'max:255'],
            'nama_syarikat' => ['required', 'string', 'max:255'],
            'no_pendaftaran_cukai' => ['nullable', 'string', 'max:255'],
            'tarikh_permohonan' => ['required', 'date'],
            'no_kelulusan' => ['required', 'string', 'max:255'],
            'no_pesanan_belian' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'negeri' => ['required', 'string', 'max:255'],
            'tandatangan_nama' => ['required', 'string', 'max:255'],
            'tandatangan_no_kp' => ['required', 'string', 'max:50'],
            'tandatangan_jawatan' => ['required', 'string', 'max:255'],
            'pembekal_nama' => ['required', 'string', 'max:255'],
            'pembekal_alamat' => ['required', 'string'],
            'kod_tarif' => ['required', 'array', 'min:1'],
            'perihal_barang' => ['required', 'array', 'min:1'],
            'unit' => ['required', 'array', 'min:1'],
            'deskripsi' => ['required', 'array', 'min:1'],
            'kuantiti' => ['required', 'array', 'min:1'],
            'nilai' => ['required', 'array', 'min:1'],
            'kawasan' => ['required', 'array', 'min:1'],
            'kod_tarif.*' => ['required', 'string'],
            'perihal_barang.*' => ['required', 'string'],
            'unit.*' => ['required', 'string'],
            'deskripsi.*' => ['required', 'string'],
            'kuantiti.*' => ['required', 'numeric'],
            'nilai.*' => ['required', 'numeric'],
            'kawasan.*' => ['required', 'string'],
            'attachments' => ['required', 'array', 'min:1'],
            'attachments.*' => ['required', 'file', 'max:5120'],
        ];
    }
}
