@extends('Co-Admin.layouts.app')

@section('title', 'Detalhes da Pessoa')

@section('content')
@php
    use App\Helpers\LgpdHelper;
    $canViewSensitiveData = LgpdHelper::canViewSensitiveData();
@endphp
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-icon module="pessoas" class="w-6 h-6" />
                {{ $pessoa->nom_pessoa ?? 'Pessoa' }}
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Detalhes do cadastro</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <x-pessoas::button href="{{ route('pessoas.edit', $pessoa) }}" variant="primary">
                <x-icon name="eye" class="w-5 h-5" />
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-pessoas::card>
    @endif

    <!-- Observações -->
    @if($pessoa->observacoes)
    <x-pessoas::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                </svg>
                Observações
            </h3>
        </x-slot>

        <p class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $pessoa->observacoes }}</p>
    </x-pessoas::card>
    @endif
</div>
@endsection
