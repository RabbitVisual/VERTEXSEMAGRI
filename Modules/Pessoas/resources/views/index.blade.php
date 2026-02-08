@extends('Co-Admin.layouts.app')

@section('title', \App\Helpers\TranslationHelper::translateLabel('Pessoas'))

@section('content')
@php
    use App\Helpers\TranslationHelper;
@endphp
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Pessoas" class="w-6 h-6" />
                {{ TranslationHelper::translateLabel('Pessoas') }}
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ TranslationHelper::translateLabel('Gerenciamento de pessoas - Alguns dados são migrados do Cadastro Único e outros são manuais') }}</p>
        </div>
            <x-pessoas::button href="{{ route('pessoas.create') }}" variant="primary">
                <x-icon name="eye" class="w-5 h-5" />
                            </a>
                            <a href="{{ route('pessoas.edit', $pessoa->id) }}"
                               class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300"
                               title="Editar">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                            </a>
                        </div>
                    @else
                        <span class="text-gray-400 dark:text-gray-500">-</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">{{ TranslationHelper::translateLabel('Nenhuma pessoa encontrada') }}</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ TranslationHelper::translateLabel('Tente ajustar os filtros de busca.') }}</p>
                </td>
            </tr>
        @endforelse
        </x-pessoas::data-table>
    </div>
@endsection
