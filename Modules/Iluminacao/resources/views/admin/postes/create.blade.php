@extends('admin.layouts.admin')

@section('title', 'Novo Poste - Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-xl flex items-center justify-center shadow-lg text-white">
                    <x-icon name="plus" style="duotone" class="w-6 h-6" />
                </div>
                <span>Cadastrar Novo Poste</span>
            </h1>
        </div>
        <a href="{{ route('admin.iluminacao.postes.index') }}" class="text-sm font-medium text-gray-500 hover:text-indigo-600 dark:hover:text-indigo-400 flex items-center gap-1 transition-colors">
            <x-icon name="arrow-left" class="w-4 h-4" />
            Voltar para Lista
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
        <form action="{{ route('admin.iluminacao.postes.store') }}" method="POST" class="divide-y divide-gray-100 dark:divide-slate-700">
            @csrf

            <!-- Seção: Identificação -->
            <div class="p-6 md:p-8 space-y-6">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                        <x-icon name="id-card" style="duotone" class="w-5 h-5" />
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white">Identificação & Técnica</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Código (Neoenergia/Plaqueta) <span class="text-red-500">*</span></label>
                        <input type="text" name="codigo" required class="w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder-gray-400" placeholder="Ex: 123456">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Tipo de Lâmpada</label>
                        <select name="tipo_lampada" class="w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            <option value="">Selecione o tipo</option>
                            <option value="led">LED</option>
                            <option value="sodio">Vapor de Sódio</option>
                            <option value="mercurio">Vapor de Mercúrio</option>
                            <option value="vapor_metalico">Vapor Metálico</option>
                            <option value="mista">Mista</option>
                            <option value="outra">Outra</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Potência (Watts)</label>
                        <div class="relative">
                            <input type="number" name="potencia" class="w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 transition-all" placeholder="Ex: 150">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-xs uppercase">W</span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Transformador (Trafo)</label>
                        <input type="text" name="trafo" class="w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 transition-all" placeholder="ID do Trafo ou Localização">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Possui Barramento?</label>
                        <select name="barramento" class="w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Seção: Localização -->
            <div class="p-6 md:p-8 space-y-6 bg-gray-50/30 dark:bg-slate-900/10">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                        <x-icon name="location-dot" style="duotone" class="w-5 h-5" />
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white">Localização Geográfica</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Logradouro</label>
                        <input type="text" name="logradouro" class="w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 transition-all" placeholder="Nome da rua/estrada">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Bairro</label>
                        <input type="text" name="bairro" class="w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 transition-all" placeholder="Nome do bairro ou comunidade">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Latitude</label>
                        <input type="number" step="any" name="latitude" class="w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 transition-all" placeholder="-00.000000">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Longitude</label>
                        <input type="number" step="any" name="longitude" class="w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 transition-all" placeholder="-00.000000">
                    </div>
                </div>
            </div>

            <!-- Rodapé: Ações -->
            <div class="p-6 bg-gray-50 dark:bg-slate-900/50 flex justify-end gap-3">
                <a href="{{ route('admin.iluminacao.postes.index') }}" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 transition-all">
                    Cancelar
                </a>
                <button type="submit" class="px-8 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 transition-all shadow-lg shadow-indigo-200 dark:shadow-none">
                    Salvar Poste
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
