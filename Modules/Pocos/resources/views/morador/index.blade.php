@extends('pocos::morador.layouts.app')

@section('title', 'Consulta de Faturas')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-950 py-12 md:py-24">
    <div class="container mx-auto px-4">
        <div class="max-w-xl mx-auto">
            <!-- Header Institucional -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2.5 bg-blue-50/50 dark:bg-blue-900/10 text-blue-600 dark:text-blue-400 px-5 py-2.5 rounded-full text-[10px] font-black uppercase tracking-[0.2em] mb-8 border border-blue-100 dark:border-blue-800/30 backdrop-blur-sm">
                    <x-icon name="arrow-left" class="w-5 h-5" />
                    Página Inicial
                </a>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('acessoForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const loadingSpinner = document.getElementById('loadingSpinner');

    if (form && submitBtn) {
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitText.textContent = 'Acessando...';
            loadingSpinner.classList.remove('hidden');
        });
    }

    // Auto-uppercase no código
    const codigoInput = document.getElementById('codigo_acesso');
    if (codigoInput) {
        codigoInput.addEventListener('input', function(e) {
            e.target.value = e.target.value.toUpperCase();
        });
    }
});
</script>
@endpush
@endsection
