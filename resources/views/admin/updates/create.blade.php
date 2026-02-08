@extends('admin.layouts.admin')

@section('title', 'Enviar Atualização')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="arrow-left" class="w-5 h-5" />
            Voltar
        </a>
    </div>

    <!-- Flash Messages - Flowbite Alerts -->
    @if(session('success'))
        <div id="alert-success" class="flex items-center p-4 mb-4 text-emerald-800 border border-emerald-300 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800" role="alert">
            <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
            </svg>
            <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-emerald-50 text-emerald-500 rounded-lg focus:ring-2 focus:ring-emerald-400 p-1.5 hover:bg-emerald-200 inline-flex h-8 w-8 dark:bg-emerald-900/20 dark:text-emerald-400 dark:hover:bg-emerald-900/30" data-dismiss-target="#alert-success" aria-label="Close" onclick="this.parentElement.remove()">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div id="alert-error" class="flex items-center p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800" role="alert">
            <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
            </svg>
            <div class="ml-3 text-sm font-medium">{{ session('error') }}</div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/30" data-dismiss-target="#alert-error" aria-label="Close" onclick="this.parentElement.remove()">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div id="alert-errors" class="flex items-start p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800" role="alert">
            <svg class="flex-shrink-0 w-5 h-5 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
            </svg>
            <div class="ml-3 flex-1">
                <h3 class="text-sm font-semibold mb-2">Erros encontrados:</h3>
                <ul class="space-y-1 text-sm">
                    @foreach($errors->all() as $error)
                        <li class="flex items-start gap-2">
                            <span class="text-red-500 mt-0.5">•</span>
                            <span>{{ $error }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/30" data-dismiss-target="#alert-errors" aria-label="Close" onclick="this.parentElement.remove()">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    <!-- Upload Form - Flowbite Card -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Enviar Atualização</h2>
        </div>
        <div class="p-6 md:p-8">
        <form action="{{ route('admin.updates.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- File Upload -->
            <div>
                <label for="update_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Arquivo ZIP de Atualização <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-xl hover:border-indigo-400 dark:hover:border-indigo-500 transition-colors">
                    <div class="space-y-1 text-center w-full">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 dark:text-gray-400">
                            <label for="update_file" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span>Selecione um arquivo</span>
                                <input id="update_file" name="update_file" type="file" accept=".zip" required class="sr-only" onchange="updateFileName(this)">
                            </label>
                            <p class="pl-1">ou arraste e solte</p>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400" id="file-name">Nenhum arquivo selecionado</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Tamanho máximo: 100MB</p>
                    </div>
                </div>
                @error('update_file')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Options -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Opções de Atualização</h3>
                
                <div class="flex items-start gap-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-600">
                    <input type="checkbox" name="create_backup" id="create_backup" value="1" checked class="mt-1 w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600" onchange="updateBackupStatus(this)">
                    <div class="flex-1">
                        <label for="create_backup" class="text-sm font-medium text-gray-900 dark:text-white cursor-pointer">
                            Criar backup antes de aplicar
                        </label>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" id="backup-description">
                            <span class="font-semibold text-emerald-600 dark:text-emerald-400">✓ Ativo:</span> Um backup completo do sistema será criado antes de aplicar a atualização. Isso permite reverter mudanças se necessário.
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-600">
                    <input type="checkbox" name="auto_apply" id="auto_apply" value="1" class="mt-1 w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600" onchange="updateAutoApplyStatus(this)">
                    <div class="flex-1">
                        <label for="auto_apply" class="text-sm font-medium text-gray-900 dark:text-white cursor-pointer">
                            Aplicar automaticamente após upload
                        </label>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" id="auto-apply-description">
                            <span class="font-semibold text-gray-600 dark:text-gray-400">ℹ️ Inativo:</span> A atualização será enviada e você precisará aplicar manualmente na página de detalhes.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    <div class="flex-1">
                        <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-1">Informações Importantes</h4>
                        <ul class="text-xs text-blue-800 dark:text-blue-300 space-y-1 list-disc list-inside">
                            <li>O arquivo ZIP deve conter apenas arquivos de atualização (views, controllers, etc.)</li>
                            <li>Arquivos perigosos como .env, composer.json, package.json são bloqueados automaticamente</li>
                            <li>Recomendamos criar um backup antes de aplicar atualizações em produção</li>
                            <li>Após o upload, você pode revisar os detalhes antes de aplicar</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200 dark:border-slate-700">
                <button type="submit" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                    Enviar Atualização
                </button>
                <a href="{{ route('admin.updates.index') }}" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                    Cancelar
                </a>
            </div>
        </form>
        </div>
    </div>
</div>

<script>
function updateFileName(input) {
    const fileName = input.files[0]?.name || 'Nenhum arquivo selecionado';
    document.getElementById('file-name').textContent = fileName;
    
    // Adicionar classe visual quando arquivo selecionado
    const dropZone = input.closest('.border-dashed').parentElement;
    if (input.files[0]) {
        dropZone.querySelector('.border-dashed').classList.add('border-indigo-400', 'bg-indigo-50', 'dark:bg-indigo-900/10');
    }
}

function updateBackupStatus(checkbox) {
    const description = document.getElementById('backup-description');
    if (checkbox.checked) {
        description.innerHTML = '<span class="font-semibold text-emerald-600 dark:text-emerald-400">✓ Ativo:</span> Um backup completo do sistema será criado antes de aplicar a atualização. Isso permite reverter mudanças se necessário.';
    } else {
        description.innerHTML = '<span class="font-semibold text-amber-600 dark:text-amber-400">⚠️ Desativado:</span> Nenhum backup será criado. Você não poderá reverter esta atualização se algo der errado.';
    }
}

function updateAutoApplyStatus(checkbox) {
    const description = document.getElementById('auto-apply-description');
    if (checkbox.checked) {
        description.innerHTML = '<span class="font-semibold text-indigo-600 dark:text-indigo-400">✓ Ativo:</span> A atualização será aplicada imediatamente após o upload. Certifique-se de que o arquivo está correto antes de enviar.';
    } else {
        description.innerHTML = '<span class="font-semibold text-gray-600 dark:text-gray-400">ℹ️ Inativo:</span> A atualização será enviada e você precisará aplicar manualmente na página de detalhes.';
    }
}
</script>
@endsection

