<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLaporanCjpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->role === 'syarikat';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'permohonan_58a_id' => [
                'required',
                'integer',
                Rule::exists('permohonan_58a', 'id')->where(fn ($query) => $query
                    ->where('user_id', $this->user()?->id)
                    ->where('status', 'Diluluskan')
                    ->whereNotNull('no_sijil_pengecualian')),
            ],
            'barang_index' => ['required', 'integer', 'min:0'],
            'negeri' => ['required', 'string', 'max:100'],
            'tahun' => ['required', 'integer', 'between:2000,2100'],
            'bulan' => ['required', 'string', 'max:30'],
            'baki_awal' => ['nullable', 'integer', 'min:0'],
            'pembelians' => ['nullable', 'array'],
            'pembelians.*.tarikh' => ['nullable', 'date'],
            'pembelians.*.no_invois' => ['nullable', 'string', 'max:255'],
            'pembelians.*.no_k9' => ['nullable', 'string', 'max:255'],
            'pembelians.*.kuantiti' => ['nullable', 'integer', 'min:0'],
            'pembelians.*.nilai' => ['nullable', 'numeric', 'min:0'],
            'penjualans' => ['nullable', 'array'],
            'penjualans.*.tarikh' => ['nullable', 'date'],
            'penjualans.*.nama_kapal' => ['nullable', 'string', 'max:255'],
            'penjualans.*.pelabuhan' => ['nullable', 'string', 'max:255'],
            'penjualans.*.no_invois' => ['nullable', 'string', 'max:255'],
            'penjualans.*.kuantiti' => ['nullable', 'integer', 'min:0'],
            'penjualans.*.nilai' => ['nullable', 'numeric', 'min:0'],
            'nama_penuh' => ['required', 'string', 'max:255'],
            'jawatan' => ['required', 'string', 'max:255'],
            'no_telefon' => ['required', 'string', 'max:50'],
        ];
    }
}
