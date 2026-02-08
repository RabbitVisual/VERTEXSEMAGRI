@extends('admin.layouts.admin')

@section('title', 'Perfil: ' . $funcionario->nome)

@section('content')
<div class="space-y-6">
    <!-- Header Simples e Elegante -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-gray-200 dark:border-slate-700">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-200 dark:shadow-none">
                <x-module-icon module="Funcionarios" class="w-7 h-7" />
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Perfil do Funcionário</h1>
                <nav class="flex items-center gap-2 text-xs font-medium text-gray-500 mt-1 uppercase tracking-wider">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 transition-colors">Admin</a>
                    <span class="text-gray-300">/</span>
                    <a href="{{ route('admin.funcionarios.index') }}" class="hover:text-emerald-600 transition-colors">Funcionários</a>
                    <span class="text-gray-300">/</span>
                    <span class="text-emerald-600">{{ $funcionario->nome }}</span>
                </nav>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.funcionarios.index') }}" class="inline-flex items-center justify-center w-10 h-10 text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors dark:bg-slate-800 dark:border-slate-700 dark:text-gray-400" title="Voltar">
                <x-icon name="eye" class="w-5 h-5" />
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Histórico de Ordens -->
            @if(isset($ordensServico) && $ordensServico->count() > 0)
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden shadow-sm transition-all hover:shadow-md">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between bg-emerald-500/5 dark:bg-transparent">
                    <h3 class="text-sm font-black uppercase tracking-widest text-emerald-600 dark:text-emerald-400">Ordens em Execução / Recentes</h3>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-[10px] text-emerald-600 dark:text-emerald-400 font-black uppercase tracking-wider">Tempo Real</span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-separate border-spacing-0">
                        <thead class="bg-gray-50/50 dark:bg-slate-900/50 text-gray-400 text-[10px] font-black uppercase tracking-widest">
                            <tr>
                                <th class="px-6 py-4">O.S #</th>
                                <th class="px-6 py-4">Equipe Responsável</th>
                                <th class="px-6 py-4">Status Atual</th>
                                <th class="px-6 py-4">Data Registro</th>
                                <th class="px-6 py-4 text-right">Ver</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-slate-700">
                            @foreach($ordensServico as $ordem)
                            <tr class="group hover:bg-emerald-50/30 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-black text-gray-900 dark:text-white">#{{ $ordem->numero }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-xs text-gray-600 dark:text-gray-400 font-medium">{{ $ordem->equipe->nome ?? '-' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusStyles = [
                                            'pendente' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400',
                                            'em_execucao' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400',
                                            'concluida' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400',
                                            'cancelada' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400'
                                        ];
                                        $currentStyle = $statusStyles[$ordem->status] ?? 'bg-gray-100 text-gray-700';
                                    @endphp
                                    <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-tight {{ $currentStyle }}">
                                        {{ str_replace('_', ' ', $ordem->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-xs text-gray-500 font-medium">{{ $ordem->data_abertura ? $ordem->data_abertura->format('d/m/Y') : '-' }}</p>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.ordens.show', $ordem->id) }}" class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-emerald-600 hover:bg-emerald-100 rounded-lg transition-all dark:hover:bg-emerald-900/30">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
