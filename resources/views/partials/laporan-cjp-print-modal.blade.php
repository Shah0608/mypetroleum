@php
    $modalId = $modalId ?? 'laporan-cjp-preview-modal';
    $frameId = $frameId ?? 'laporan-cjp-preview-frame';
@endphp

<div id="{{ $modalId }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/90 px-4 py-4" aria-hidden="true">
    <div class="flex h-[calc(100vh-2rem)] w-full max-w-6xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4"><div><h3 class="text-lg font-bold text-slate-900">Preview Laporan CJ(P)</h3><p class="text-sm text-slate-500">Semak laporan sebelum cetak atau simpan sebagai PDF.</p></div><button type="button" onclick="closeLaporanCjpPreview('{{ $modalId }}', '{{ $frameId }}')" class="rounded-lg bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200">Tutup</button></div>
        <iframe id="{{ $frameId }}" class="min-h-0 flex-1 border-0 bg-slate-200" title="Preview Laporan CJ(P)"></iframe>
        <div class="flex shrink-0 flex-wrap gap-3 border-t border-slate-200 px-5 py-4"><button type="button" onclick="printLaporanCjpPreview('{{ $frameId }}')" class="rounded-lg bg-red-600 px-6 py-2.5 font-bold text-white shadow hover:bg-red-700">Cetak / Simpan PDF</button><button type="button" onclick="closeLaporanCjpPreview('{{ $modalId }}', '{{ $frameId }}')" class="rounded-lg bg-blue-500 px-6 py-2.5 font-bold text-white shadow hover:bg-blue-600">Tutup</button></div>
    </div>
</div>
<script>
    function openLaporanCjpPreview(url, modalId = '{{ $modalId }}', frameId = '{{ $frameId }}') { const modal = document.getElementById(modalId); const frame = document.getElementById(frameId); frame.src = url; modal.classList.remove('hidden'); modal.classList.add('flex'); modal.setAttribute('aria-hidden', 'false'); }
    function closeLaporanCjpPreview(modalId = '{{ $modalId }}', frameId = '{{ $frameId }}') { const modal = document.getElementById(modalId); const frame = document.getElementById(frameId); modal.classList.add('hidden'); modal.classList.remove('flex'); modal.setAttribute('aria-hidden', 'true'); frame.src = 'about:blank'; }
    function printLaporanCjpPreview(frameId = '{{ $frameId }}') { const frame = document.getElementById(frameId); frame.contentWindow?.focus(); frame.contentWindow?.print(); }
</script>
