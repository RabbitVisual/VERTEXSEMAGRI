@extends('admin.layouts.admin')

@section('title', 'Gerenciar Módulos')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="magnifying-glass" class="w-5 h-5" />
                        </div>
                        <input 
                            type="text" 
                            id="search" 
                            name="search" 
                            value="{{ $search }}"
                            placeholder="Buscar por nome ou descrição..." 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                        />
                    </div>
                </div>

                <!-- Filtro de Status -->
                <div class="sm:w-48">
                    <label for="filter" class="sr-only">Filtrar por status</label>
                    <select 
                        id="filter" 
                        name="filter" 
                        onchange="this.form.submit()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                    >
                        <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Todos os Módulos</option>
                        <option value="enabled" {{ $filter === 'enabled' ? 'selected' : '' }}>Habilitados</option>
                        <option value="disabled" {{ $filter === 'disabled' ? 'selected' : '' }}>Desabilitados</option>
                    </select>
                </div>

                <!-- Botão Buscar -->
                <button 
                    type="submit" 
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-medium text-center text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800 transition-colors"
                >
                    <x-icon name="magnifying-glass" class="w-5 h-5" />
                    <span class="hidden sm:inline">Buscar</span>
                </button>

                @if($search || $filter !== 'all')
                    <a 
                        href="{{ route('admin.modules.index') }}" 
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-slate-800 dark:text-white dark:border-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-700 transition-colors"
                    >
                        <x-icon name="eye" class="w-5 h-5" />
                                <span class="hidden sm:inline">Detalhes</span>
                            </a>
                            
                            @if($module['enabled'])
                                <button 
                                    type="button" 
                                    data-modal-target="disable-{{ $moduleId }}" 
                                    data-modal-toggle="disable-{{ $moduleId }}"
                                    class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-yellow-700 bg-yellow-50 border border-yellow-200 rounded-lg hover:bg-yellow-100 focus:ring-4 focus:ring-yellow-200 dark:bg-yellow-900/20 dark:text-yellow-300 dark:border-yellow-800 dark:hover:bg-yellow-900/30 dark:focus:ring-yellow-800 transition-colors flex-1 sm:flex-none"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="hidden sm:inline">Desabilitar</span>
                                    <span class="sm:hidden">Off</span>
                                </button>
                            @else
                                <button 
                                    type="button" 
                                    data-modal-target="enable-{{ $moduleId }}" 
                                    data-modal-toggle="enable-{{ $moduleId }}"
                                    class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800 transition-colors flex-1 sm:flex-none"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="hidden sm:inline">Habilitar</span>
                                    <span class="sm:hidden">On</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                @if(!$module['enabled'])
                <!-- Enable Modal -->
                <div id="enable-{{ $moduleId }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-slate-800">
                            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-600 dark:hover:text-white" data-modal-hide="enable-{{ $moduleId }}">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Fechar</span>
                            </button>
                            <div class="p-4 md:p-5 text-center">
                                <svg class="mx-auto mb-4 w-12 h-12 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Deseja habilitar o módulo <strong class="text-gray-900 dark:text-white">{{ $module['name'] }}</strong>?</h3>
                                <form action="{{ route('admin.modules.enable', $module['name']) }}" method="POST" class="inline">
                                    @csrf
                                    <button data-modal-hide="enable-{{ $moduleId }}" type="submit" class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">
                                        Sim, habilitar
                                    </button>
                                </form>
                                <button data-modal-hide="enable-{{ $moduleId }}" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-indigo-600 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-slate-800 dark:text-gray-400 dark:border-slate-600 dark:hover:text-white dark:hover:bg-slate-700">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($module['enabled'])
                <!-- Disable Modal -->
                <div id="disable-{{ $moduleId }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-slate-800">
                            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-600 dark:hover:text-white" data-modal-hide="disable-{{ $moduleId }}">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Fechar</span>
                            </button>
                            <div class="p-4 md:p-5 text-center">
                                <svg class="mx-auto mb-4 w-12 h-12 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">⚠️ ATENÇÃO: Tem certeza que deseja desabilitar o módulo <strong class="text-gray-900 dark:text-white">{{ $module['name'] }}</strong>?</h3>
                                <p class="mb-5 text-sm text-gray-500 dark:text-gray-400">Isso pode afetar funcionalidades do sistema que dependem deste módulo.</p>
                                <form action="{{ route('admin.modules.disable', $module['name']) }}" method="POST" class="inline">
                                    @csrf
                                    <button data-modal-hide="disable-{{ $moduleId }}" type="submit" class="text-white bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                        Sim, desabilitar
                                    </button>
                                </form>
                                <button data-modal-hide="disable-{{ $moduleId }}" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-indigo-600 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-slate-800 dark:text-gray-400 dark:border-slate-600 dark:hover:text-white dark:hover:bg-slate-700">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    @else
        <!-- Estado Vazio - Flowbite Card -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
            <div class="p-12 text-center">
                <div class="w-20 h-20 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Nenhum módulo encontrado</h3>
                <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">
                    @if($search || $filter !== 'all')
                        Tente ajustar os filtros de busca.
                    @else
                        Não há módulos instalados no sistema.
                    @endif
                </p>
                @if($search || $filter !== 'all')
                    <a 
                        href="{{ route('admin.modules.index') }}" 
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-center text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800 transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Limpar Filtros
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection
