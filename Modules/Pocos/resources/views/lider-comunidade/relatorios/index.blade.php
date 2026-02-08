@extends('pocos::lider-comunidade.layouts.app')

@section('title', 'Relatórios')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 md:pb-8 border-b border-gray-200 dark:border-slate-700">
        <div class="flex items-center gap-4">
            <a href="{{ route('lider-comunidade.dashboard') }}" class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 flex items-center justify-center text-gray-400 hover:text-blue-600 transition-all active:scale-95 shadow-sm">
                <x-icon name="arrow-left" class="w-5 h-5" />
            </a>
            <div>
                <h1 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Análise Fiscal</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Consolidado de arrecadação e movimentação da comunidade</p>
            </div>
        </div>
    </div>

    <!-- Filtros Inteligentes -->
    <form method="GET" action="{{ route('lider-comunidade.relatorios.index') }}" class="premium-card p-5">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Data de Início</label>
                <input type="date" name="data_inicio" value="{{ $dataInicio }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>
            <div>
                <label class="block text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Data de Término</label>
                <input type="date" name="data_fim" value="{{ $dataFim }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-5 py-2.5 text-sm font-bold text-white bg-slate-900 dark:bg-blue-600 rounded-xl hover:bg-slate-800 dark:hover:bg-blue-700 transition-all shadow-lg active:scale-95">
                    Atualizar Relatório
                </button>
            </div>
        </div>
    </form>

    <!-- Cards de Resumo Modernos -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="premium-card p-6 border-l-4 border-l-emerald-500">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">Total Arrecadado</p>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-600">
                    <x-icon name="file-pdf" class="w-5 h-5" />
                                <p class="text-sm font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest">Nenhuma movimentação no período</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
