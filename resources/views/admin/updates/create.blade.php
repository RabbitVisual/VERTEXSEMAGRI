@extends('admin.layouts.admin')

@section('title', 'Enviar Atualização')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12 font-sans">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="cloud-arrow-up" class="w-6 h-6 md:w-7 md:h-7 text-white" style="duotone" />
                </div>
                <span>Nova <span class="text-indigo-600 dark:text-indigo-400">Atualização</span></span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                <a href="{{ route('admin.updates.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Atualizações</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                <span class="text-gray-900 dark:text-white font-medium">Upload</span>
            </nav>
        </div>
        <a href="{{ route('admin.updates.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-gray-700 dark:text-gray-200 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700 focus:ring-4 focus:ring-gray-100 dark:focus:ring-slate-700 transition-all shadow-sm">
            <x-icon name="arrow-left" class="w-5 h-5" />
            Voltar
        </a>
    </div>

    <!-- Flash Messages (Uses existing logic but styled consistently if not global already) -->
    <!-- Usually handled by global layout or components, but kept here for specific context if needed -->

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between bg-gray-50/50 dark:bg-slate-900/50">
                    <h2 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider flex items-center gap-2">
                        <x-icon name="upload" style="duotone" class="w-5 h-5 text-indigo-500" />
                        Pacote de Atualização
                    </h2>
                </div>
                <div class="p-6 md:p-8">
                    <form action="{{ route('admin.updates.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- File Upload Zone -->
                        <div>
                            <label class="block mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Arquivo ZIP (.zip) <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-10 pb-10 border-2 border-slate-200 dark:border-slate-600 border-dashed rounded-2xl hover:border-indigo-400 dark:hover:border-indigo-500 hover:bg-indigo-50/30 dark:hover:bg-indigo-900/10 transition-all group cursor-pointer relative">
                                <input id="update_file" name="update_file" type="file" accept=".zip" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="updateFileName(this)">
                                <div class="space-y-2 text-center pointer-events-none">
                                    <div class="w-16 h-16 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-500 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                        <x-icon name="cloud-arrow-up" style="duotone" class="w-8 h-8" />
                                    </div>
                                    <div class="flex flex-col items-center text-sm text-gray-600 dark:text-gray-400">
                                        <span class="font-bold text-indigo-600 dark:text-indigo-400 text-lg">Clique para upload</span>
                                        <span class="text-slate-500">ou arraste e solte o arquivo aqui</span>
                                    </div>
                                    <p class="text-xs text-slate-400 pt-2" id="file-name">Nenhum arquivo selecionado</p>
                                    <p class="text-[10px] text-slate-400 uppercase tracking-wide">Tamanho máximo: 100MB</p>
                                </div>
                            </div>
                            @error('update_file')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 font-medium flex items-center gap-1">
                                    <x-icon name="circle-exclamation" class="w-4 h-4" />
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Options -->
                        <div class="space-y-4 pt-4">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-4 border-b border-gray-100 dark:border-slate-700 pb-2">Opções de Instalação</h3>

                            <!-- Backup Option -->
                            <label class="relative flex items-start gap-4 p-4 rounded-xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/30 cursor-pointer hover:border-indigo-300 dark:hover:border-indigo-700 transition-colors">
                                <div class="flex h-6 items-center">
                                    <input type="checkbox" name="create_backup" id="create_backup" value="1" checked class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-600 dark:bg-slate-700 dark:border-slate-600" onchange="updateBackupStatus(this)">
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">Criar Backup de Segurança</span>
                                        <span id="backup-badge" class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">Recomendado</span>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1" id="backup-description">
                                        Cria um ponto de restauração completo antes de aplicar as mudanças.
                                    </p>
                                </div>
                            </label>

                            <!-- Auto Apply Option -->
                            <label class="relative flex items-start gap-4 p-4 rounded-xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/30 cursor-pointer hover:border-indigo-300 dark:hover:border-indigo-700 transition-colors">
                                <div class="flex h-6 items-center">
                                    <input type="checkbox" name="auto_apply" id="auto_apply" value="1" class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-600 dark:bg-slate-700 dark:border-slate-600" onchange="updateAutoApplyStatus(this)">
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">Instalação Automática</span>
                                        <span id="auto-apply-badge" class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-500 dark:bg-slate-700 dark:text-slate-400">Manual</span>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1" id="auto-apply-description">
                                        Se marcado, a atualização será aplicada imediatamente após o upload.
                                    </p>
                                </div>
                            </label>
                        </div>

                        <div class="pt-6 border-t border-gray-100 dark:border-slate-700 flex items-center gap-3">
                             <a href="{{ route('admin.updates.index') }}" class="px-6 py-3.5 text-sm font-bold uppercase tracking-wider text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white transition-colors">
                                Cancelar
                            </a>
                            <button type="submit" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-8 py-3.5 text-sm font-bold uppercase tracking-wider text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/30 active:scale-95 group">
                                <x-icon name="cloud-arrow-up" class="w-5 h-5 group-hover:-translate-y-1 transition-transform" />
                                Iniciar Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-3xl p-6 border border-indigo-100 dark:border-indigo-900/30">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-indigo-100 dark:bg-indigo-900/40 rounded-lg text-indigo-600 dark:text-indigo-400">
                        <x-icon name="circle-info" class="w-5 h-5" />
                    </div>
                    <h3 class="font-bold text-indigo-900 dark:text-indigo-200">Recomendações</h3>
                </div>
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="w-6 h-6 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center text-xs font-bold text-indigo-600 border border-indigo-100 dark:border-indigo-900 shrink-0">1</div>
                        <p class="text-sm text-indigo-800 dark:text-indigo-300">Verifique se o arquivo possui a extensão <strong>.zip</strong> oficial.</p>
                    </div>
                     <div class="flex gap-3">
                        <div class="w-6 h-6 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center text-xs font-bold text-indigo-600 border border-indigo-100 dark:border-indigo-900 shrink-0">2</div>
                        <p class="text-sm text-indigo-800 dark:text-indigo-300">Sempre mantenha a opção de <strong>Backup</strong> ativada para segurança.</p>
                    </div>
                     <div class="flex gap-3">
                        <div class="w-6 h-6 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center text-xs font-bold text-indigo-600 border border-indigo-100 dark:border-indigo-900 shrink-0">3</div>
                        <p class="text-sm text-indigo-800 dark:text-indigo-300">Evite realizar atualizações durante horários de pico de uso.</p>
                    </div>
                </div>
            </div>

             <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
                 <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Versão Atual</h3>
                 <p class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    App v{{ config('app.version', '1.0.0') }}
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                 </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateFileName(input) {
    const fileName = input.files[0]?.name || 'Nenhum arquivo selecionado';
    document.getElementById('file-name').textContent = fileName;
    document.getElementById('file-name').classList.add('text-indigo-600', 'font-medium');
}

function updateBackupStatus(checkbox) {
    const description = document.getElementById('backup-description');
    const badge = document.getElementById('backup-badge');

    if (checkbox.checked) {
        description.textContent = 'Cria um ponto de restauração completo antes de aplicar as mudanças.';
        badge.className = 'inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400';
        badge.textContent = 'Recomendado';
    } else {
        description.textContent = 'Atenção: Você não poderá reverter as alterações automaticamente.';
        badge.className = 'inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400';
        badge.textContent = 'Não Recomendado';
    }
}

function updateAutoApplyStatus(checkbox) {
    const description = document.getElementById('auto-apply-description');
    const badge = document.getElementById('auto-apply-badge');

    if (checkbox.checked) {
        description.textContent = 'O sistema aplicará as mudanças imediatamente. Certifique-se da integridade do arquivo.';
        badge.className = 'inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400';
        badge.textContent = 'Automático';
    } else {
        description.textContent = 'Se marcado, a atualização será aplicada imediatamente após o upload.';
        badge.className = 'inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-500 dark:bg-slate-700 dark:text-slate-400';
        badge.textContent = 'Manual';
    }
}
</script>
@endpush
@endsection
