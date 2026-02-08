@extends('consulta.layouts.consulta')

@php
use App\Helpers\LgpdHelper;
@endphp

@section('title', 'Demandas - Consulta')

@section('content')
<!-- Alerta LGPD -->
<div class="mb-6 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 p-4">
    <div class="flex items-start gap-3">
        <div class="flex-shrink-0">
            <x-icon name="magnifying-glass" class="w-5 h-5" />
                    Filtrar
                </button>
                <a href="{{ route('consulta.demandas.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-slate-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600">
                    <x-icon name="rotate-right" class="w-5 h-5" />
                    Limpar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Tabela de Demandas -->
<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
    <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
        <h2 class="text-base md:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <x-icon name="eye" class="w-5 h-5" />
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center">
                        <div class="w-20 h-20 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Nenhuma demanda encontrada.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    @if($demandas->hasPages())
    <div class="px-4 md:px-6 py-4 border-t border-gray-200 dark:border-slate-700">
        {{ $demandas->links() }}
    </div>
    @endif
</div>
@endsection
